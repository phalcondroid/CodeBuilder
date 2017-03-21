<?php

namespace CodeBuilder\Statements;

use CodeBuilder\Builder\Base;
use CodeBuilder\Expressions\Literals\Literal;

class SwitchStatement extends Base
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * @param Literal $conditional
     */
    public function __construct(Base $conditional)
    {
        $this->struct['conditional'] = $conditional;
        $this->semicolon = false;
        $this->identation = false;
    }

    /**
     * Add case statement.
     *
     * @param  $obj
     */
    public function add(CaseStatement $case)
    {
        $this->struct['content'][] = $case;
    }

    /**
     * @return [type] [description]
     */
    private function compileContent()
    {
        if (isset($this->struct['content'])) {
            $contents = '';
            $i = 0;
            foreach ($this->struct['content'] as $content) {
                if ($i == 0) {
                    $contents = ltrim($contents);
                }

                if ($content instanceof Base and !$content instanceof Comment) {
                    $content->setLevel($this->getLevel() + 1);
                    $contents .= $content->resolve();
                } elseif ($content instanceof Comment) {
                    $this->struct['comment'] = $content;
                } else {
                    $contents .= $content;
                }
                ++$i;
            }

            return $contents;
        }
    }

    public function getSign()
    {
        $condition = $this->struct['conditional']->resolve();
        $head = 'switch ('.ltrim($condition).') ';

        return $this->getNewLine().$this->getTab().$head;
    }

    /**
     * Get final string with all statements and contenrt.
     *
     * @return string
     */
    public function resolve()
    {
        $semicolon = '';
        if ($this->semicolon) {
            $semicolon = ';';
        }

        if ($this->identation) {
            return $this->getTab().$this->getNewLine().$this->compileContent;
        } else {
            return $this->compileContent();
        }
    }
}

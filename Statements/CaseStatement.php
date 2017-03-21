<?php

namespace CodeBuilder\Statements;

use CodeBuilder\Builder\Base;
use CodeBuilder\Expressions\Literals\Literal;

class CaseStatement extends Statement
{
    /**
     * @var array
     */
    private $struct;

    /**
     * Set case head condition, should be class instance of Literal.
     *
     * @example case "condition":
     *
     * @param Literal $condition
     */
    public function __construct(Base $condition)
    {
        $this->struct['condition'] = $condition;
        $this->semicolon = false;
        $this->identation = false;
    }

    /**
     * @param Base $content [description]
     */
    public function add(Base $content)
    {
        $this->struct['content'][] = $content;

        return $this;
    }

    /**
     * Build method content and comments throught StatementBlock.
     *
     * @return string
     */
    private function compileContent()
    {
        if (isset($this->struct['content'])) {
            $contents = '';
            $i = 0;
            foreach ($this->struct['content'] as $content) {
                if ($content instanceof Base and !$content instanceof Comment) {
                    $content->setLevel($this->getLevel() + 1);
                    $content->setIdentation(true);
                    $content->setSemicolon(true);
                    $contents .= $content->resolve();
                } elseif ($content instanceof Comment) {
                    $this->struct['comment'] = $content;
                } else {
                    $contents .= $content;
                }
                ++$i;
            }

            return $this->getSign().$contents.$this->getBreak();
        }
    }

    /**
     * @return
     */
    public function getSign()
    {
        $condition = $this->struct['condition']->resolve();
        $head = 'case '.$condition.':';

        return $this->getNewLine().$this->getTab().$head;
    }

    /**
     * @return [type] [description]
     */
    private function getBreak()
    {
        $break = new BreakStatement();
        $break->setSemicolon(true);

        return $this->getNewLine().$this->getTab().$this->getTab().$break->resolve();
    }

    /**
     * @return
     */
    public function resolve()
    {
        $semicolon = '';
        if ($this->semicolon) {
            $semicolon = ';';
        }

        if ($this->identation) {
            return $this->getNewLine().
                $this->getTab().
                $this->compileContent().
                $semicolon;
        } else {
            return
                $this->compileContent().
                $semicolon;
        }
    }
}

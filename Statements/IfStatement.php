<?php

namespace CodeBuilder\Statements;

use CodeBuilder\Builder\Base;
use CodeBuilder\Expressions\Expression;

class IfStatement extends Statement
{
    const IDENTICAL = 1;

    /**
     * @var array
     */
    private $struct = array();

    public function __construct(Base $expre)
    {
        $this->struct['expr'] = $expre;
    }

    /**
     * @param Expression $expre [description]
     */
    public function add(Base $obj)
    {
        $this->struct['content'][] = $obj;
    }

    /**
     * @return [type] [description]
     */
    public function getSign()
    {
        $if = 'if ('.ltrim($this->struct['expr']->resolve()).') ';

        return $this->getNewLine().$this->getTab().$if;
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
            }

            return $contents;
        }
    }

    /**
     * [isControlStructure description].
     *
     * @return bool [description]
     */
    public function isControlStructure()
    {
        return true;
    }

    /**
     * @param Expression $expre
     *
     * @return
     */
    public function resolve()
    {
        return  $this->compileContent();
    }
}

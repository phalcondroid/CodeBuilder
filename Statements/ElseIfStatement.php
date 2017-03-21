<?php

namespace CodeBuilder\Statements;

use CodeBuilder\Builder\Base;
use CodeBuilder\Expressions\Expression;

class ElseIfStatement extends Base
{
    /**
     * @var [type]
     */
    private $struct;

    /**
     * @param StatementBlock $st [description]
     */
    public function __construct(Expression $exprs, StatementBlock $st)
    {
        $this->struct['exprs'] = $exprs;
        $this->struct['if'] = $st;
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
        $st = $this->struct['if'];
        $exprs = $this->struct['exprs'];

        return rtrim($st->resolve()).' elseif ('.ltrim($exprs->resolve()).')';
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
     * @return bool [description]
     */
    public function isControlStructure()
    {
        return true;
    }

    /**
     * @return [type] [description]
     */
    public function resolve()
    {
        return $this->compileContent();
    }
}

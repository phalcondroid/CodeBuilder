<?php

namespace CodeBuilder\Statements;

use CodeBuilder\Builder\Base;

class ElseStatement extends Statement
{
    /**
     * @var [type]
     */
    private $struct;

    /**
     * @param StatementBlock $st [description]
     */
    public function __construct(StatementBlock $st)
    {
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
        $this->struct['if']->setLevel($this->getLevel());
        $st = $this->struct['if'];

        return rtrim($st->resolve()).' else ';
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

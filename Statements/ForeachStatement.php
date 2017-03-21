<?php

namespace CodeBuilder\Statements;

use CodeBuilder\Builder\Base;

class ForeachStatement extends Statement
{
    /**
     * @var
     */
    private $struct;

    public function __construct(Base $source, Base $key = null, Base $value = null)
    {
        $this->struct['source'] = $source->resolve();
        $this->struct['key'] = $key ? $key->resolve() : false;
        $this->struct['value'] = $value ? $value->resolve() : false;
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
        $keyValue = '';
        $source = $this->struct['source'];

        if ($this->struct['key']) {
            $keyValue = 'as '.$this->struct['key'];
            if ($this->struct['value']) {
                $keyValue .= ' => '.$this->struct['value'];
            }
        } else {
            $keyValue = 'as $item';
        }

        $foreachStm = "foreach ($source $keyValue) ";

        return $this->getNewLine().$this->getTab().$foreachStm;
    }

    /**
     * @return bool [description]
     */
    public function isControlStructure()
    {
        return true;
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
     * @return
     */
    public function resolve()
    {
        return $this->compileContent();
    }
}

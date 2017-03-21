<?php

namespace CodeBuilder\Statements;

/**
 * CodeBuilder\Statements\BreakStatement
 */
class BreakStatement extends Statement
{
    /**
     * @var array
     */
    private $struct;

    public function __construct()
    {
        $this->struct['stm'] = 'break';
        $this->struct['semicolon'] = false;
        $this->struct['identation'] = false;
    }

    /**
     * @return string
     */
    private function compileContent()
    {
        return $this->struct['stm'];
    }

    /**
     * @return [type] [description]
     */
    public function resolve()
    {
        $semicolon = '';
        if ($this->semicolon) {
            $semicolon = ';';
        }

        if ($this->identation) {
            return $this->getNewLine().$this->getTab().$this->compileContent().$semicolon;
        } else {
            return $this->compileContent().$semicolon;
        }
    }
}

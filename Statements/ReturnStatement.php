<?php

namespace CodeBuilder\Statements;

use CodeBuilder\Builder\Base;
use CodeBuilder\Expressions\Literals\ArrayLiteral;

class ReturnStatement extends Base
{
    public function __construct($expr)
    {
        $this->struct['expr'] = $expr;
    }

    /**
     * @return [type] [description]
     */
    public function resolve()
    {
        if ($this->struct['expr'] instanceof Base) {
            if ($this->struct['expr'] instanceof ArrayLiteral) {
                $this->struct['expr']->setLevel($this->getLevel());
            }

            return $this->getNewLine().$this->getTab().'return '.$this->struct['expr']->resolve().';';
        } elseif (is_string($this->struct['expr'])) {
            return $this->getNewLine().$this->getTab().'return '.$this->struct['expr'].';';
        }
    }
}

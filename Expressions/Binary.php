<?php

namespace CodeBuilder\Expressions;

use CodeBuilder\Builder\Base;

/**
 * Brainztorm.
 *
 * LICENSE
 *
 * This source file is subject to license that is bundled
 * with this package in the file docs/LICENSE.txt.
 *
 * @author Brainz SAS. 2014-2017
 */
class Binary extends Expression
{
    /**
     * @var string | Base
     */
    private $firstVal;

    /**
     * @var Expressions\Operators
     */
    private $operator;

    /**
     * @var string | Base
     */
    private $seccondVal;

    /**
     * Initialize binary data.
     *
     * @param string | Base $val1     [description]
     * @param Base          $operator [description]
     * @param string | Base $val2     [description]
     */
    public function __construct($val1, $operator, $val2)
    {
        $this->firstVal = $val1;
        $this->operator = $operator;
        $this->seccondVal = $val2;
        $this->setIdentation(false);
        $this->setSemicolon(false);
    }

    /**
     * Build code.
     *
     * @return string
     */
    public function resolve()
    {
        $val1 = $this->firstVal;
        if ($this->firstVal instanceof Base) {
            $this->seccondVal->setLevel($this->getLevel());
            $val1 = $this->firstVal->resolve();
        }

        $val2 = $this->operator;
        if ($this->operator instanceof Base) {
            $val2 = $this->operator->resolve();
        }

        $val3 = $this->seccondVal;
        if ($this->seccondVal instanceof Base) {
            $this->seccondVal->setLevel($this->getLevel());
            $val3 = $this->seccondVal->resolve();
        }

        return $this->identation.
            $val1.' '.
            $val2.
            ' '.
            $val3.$this->semicolon;
    }
}

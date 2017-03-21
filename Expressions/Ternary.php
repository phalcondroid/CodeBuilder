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
class Ternary extends Expression
{
    /**
     * @var string
     */
    private $conditional;

    /**
     * @var Variable
     */
    private $trueCondition;

    /**
     * @var Variable
     */
    private $else = null;

    /**
     * Initialize ternary data.
     *
     * @param Base            $conditional
     * @param Variable        $var1
     * @param Variable | Null $val2
     */
    public function __construct(Base $conditional, Base $val1, Base $val2)
    {
        $this->conditional = $conditional;
        $this->trueCondition = $val1->resolve();
        $this->else = $val2->resolve();
        $this->setIdentation(false);
        $this->setSemicolon(false);
    }

    /**
     * Build ternary condition.
     *
     * @return string
     */
    public function resolve()
    {
        $conditional = $this->conditional->resolve();
        $else = $this->else ? " : {$this->else}" : '';

        return $this->identation."$conditional ? {$this->trueCondition}$else".$this->semicolon;
    }
}

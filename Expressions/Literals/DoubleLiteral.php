<?php

namespace CodeBuilder\Expressions\Literals;

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
class DoubleLiteral extends Literal
{
    /**
     * Initialize with double param.
     *
     * @param float $value
     */
    public function __construct($value)
    {
        $this->literal = $value;
    }

    /**
     * Build double data.
     *
     * @return string
     */
    public function resolve()
    {
        return (float) $this->literal;
    }
}

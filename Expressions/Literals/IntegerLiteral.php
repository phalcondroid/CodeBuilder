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
class IntegerLiteral extends Literal
{
    /**
     * Initialize with integer value.
     *
     * @param int $value
     */
    public function __construct($value)
    {
        $this->literal = $value;
    }

    /**
     * Build integer data.
     *
     * @return int | string
     */
    public function resolve()
    {
        return (int) $this->literal;
    }
}

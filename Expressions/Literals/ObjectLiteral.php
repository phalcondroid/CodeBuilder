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
class ObjectLiteral extends Literal
{
    /**
     * [__construct description].
     *
     * @param [type] $value [description]
     */
    public function __construct($value)
    {
        $this->literal = $value;
    }

    /**
     * @return [type] [description]
     */
    public function resolve()
    {
        return (object) $this->literal;
    }
}

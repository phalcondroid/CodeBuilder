<?php

namespace CodeBuilder\Expressions\Literals;

/**
 * Code Builder for php tool.
 *
 * LICENSE
 *
 * This source file is subject to license that is bundled
 * with this package in the file docs/LICENSE.txt.
 *
 * @author Julian Arturo Molina Castiblanco @phalcondroid
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

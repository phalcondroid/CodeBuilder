<?php

namespace CodeBuilder\Utils\Helpers;

use CodeBuilder\Builder\Base;
use CodeBuilder\Group\Parenthesis;
use CodeBuilder\Expressions\Unary;
use CodeBuilder\Expressions\Binary;
use CodeBuilder\Expressions\Literals\ConstantLiteral;
use CodeBuilder\Expressions\Operators\Comparison;

class BinaryHelper
{
    /**
     * Create assing binary expression.
     *
     * @param string $val1
     * @param string $val2
     *
     * @return Expressions\Binary
     */
    public function getAssingEqual(Base $variable, Base $variable2)
    {
        $assign = new Binary(
            $variable,
            Comparison::SET,
            $variable2
        );

        return $assign;
    }

    /**
     * Create assing binary expression with cast.
     *
     * @param string $val1
     * @param string $val2
     *
     * @return Expressions\Binary
     */
    public function getAssingEqualWithCast($cast, Base $variable, Base $variable2)
    {
        $binaryCast = new Unary(
            new Parenthesis(
                new ConstantLiteral('string')
            ),
            $variable2
        );

        $assign = new Binary(
            $variable,
            Comparison::SET,
            $binaryCast
        );

        return $assign;
    }

    /**
     * Create assing binary expression.
     *
     * @param string $val1
     * @param string $val2
     *
     * @return Expressions\Binary
     */
    public function getAssingIdentical(Base $variable, Base $variable2)
    {
        $assign = new Binary(
            $variable,
            Comparison::IDENTICAL,
            $variable2
        );

        return $assign;
    }
}

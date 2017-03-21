<?php

namespace CodeBuilder\Expressions\Literals;

use CodeBuilder\Builder\Base;

/**
 *
 */
class Manager
{
    /**
     *
     */
    public function getArray(Base $name = null)
    {
        $arrayLiteral = new \CodeBuilder\Expressions\Literals\ArrayLiteral($name);
        return $arrayLiteral;
    }

    /**
     *
     */
    public function getBoolean($value)
    {
        $booleanLiteral = new \CodeBuilder\Expressions\Literals\BooleanLiteral($value);
        return $booleanLiteral;
    }

    /**
     *
     */
    public function getChar()
    {
        $charLiteral = new \CodeBuilder\Expressions\Literals\CharLiteral($value);
        return $charLiteral;
    }

    /**
     *
     */
    public function getConstant($name)
    {
        $constantLiteral = new \CodeBuilder\Expressions\Literals\ConstantLiteral($name);
        return $constantLiteral;
    }

    /**
     *
     */
    public function getDouble($value)
    {
        $doubleLiteral = new \CodeBuilder\Expressions\Literals\DoubleLiteral($name);
        return $doubleLiteral;
    }

    /**
     *
     */
    public function getInteger($value)
    {
        $integerLiteral = new \CodeBuilder\Expressions\Literals\IntegerLiteral($name);
        return $integerLiteral;
    }

    /**
     *
     */
    public function getNull()
    {
        $nullLiteral = new \CodeBuilder\Expressions\Literals\NullLiteral();
        return $nullLiteral;
    }

    /**
     *
     */
    public function getObjectLiteral($value)
    {
        $objectLiteral = new \CodeBuilder\Expressions\Literals\ObjectLiteral($value);
        return $objectLiteral;
    }

    /**
     *
     */
    public function getStringLiteral($value)
    {
        $stringLiteral = new \CodeBuilder\Expressions\Literals\StringLiteral($value);
        return $stringLiteral;
    }
}

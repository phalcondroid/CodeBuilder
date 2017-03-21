<?php

namespace CodeBuilder\Expressions\Operators;

class Manager
{
    /**
     *
     */
    public function getArithmetic()
    {
        $arithmetic = new \CodeBuilder\Expressions\Operators\Arithmetic;
        return $arithmetic;
    }

    /**
     *
     */
    public function getCombined()
    {
        $combined = new \CodeBuilder\Expressions\Operators\Combined;
        return $combined;
    }

    /**
     *
     */
    public function getComparison()
    {
        $comparion = new \CodeBuilder\Expressions\Operators\Comparison;
        return $comparison;
    }

    /**
     *
     */
    public function getDecrement()
    {
        $decrement = new \CodeBuilder\Expressions\Operators\Decrement;
        return $decrement;
    }

    /**
     *
     */
    public function getIncrement()
    {
        $increment = new \CodeBuilder\Expressions\Operators\Increment;
        return $increment;
    }

    /**
     *
     */
    public function getLogical()
    {
        $logical = new \CodeBuilder\Expressions\Operators\Logical;
        return $logical;
    }
}

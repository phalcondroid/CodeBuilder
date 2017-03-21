<?php

namespace CodeBuilder\Statements;

use CodeBuilder\Builder\Base;
use CodeBuilder\Expressions\Expression;

class Manager
{
    public function getBreak()
    {
        $breakStatement = new \CodeBuilder\Statements\BreakStatement();
        return $breakStatement;
    }

    /**
     *
     */
    public function getCase(Base $condition)
    {
        $caseStatement = new \CodeBuilder\Statements\CaseStatement($condition);
        return $caseStatement;
    }

    /**
     *
     */
    public function getEcho($st)
    {
        $echoStatement = new \CodeBuilder\Statements\EchoStatement($st);
        return $echoStatement;
    }

    /**
     *
     */
    public function getElseIf(Expression $exprs, StatementBlock $st)
    {
        $elseIfStatement = new \CodeBuilder\Statements\ElseIfStatement($exprs, $st);
        return $elseIfStatement;
    }

    /**
     *
     */
    public function getElse(StatementBlock $st)
    {
        $elseStatement = new \CodeBuilder\Statements\ElseStatement($st);
        return $elseStatement;
    }

    /**
     *
     */
    public function getForeach(Base $source, Base $key = null, Base $value = null)
    {
        $foreachStatement = new \CodeBuilder\Statements\ForeachStatement($source, $key, $value);
        return $foreachStatement;
    }

    /**
     *
     */
    public function getFor()
    {
        $forStatement = new \CodeBuilder\Statements\ForStatement();
        return $forStatement;
    }

    /**
     *
     */
    public function getIf(Base $expression)
    {
        $ifStatement = new \CodeBuilder\Statements\IfStatement($expression);
        return $ifStatement;
    }

    /**
     *
     */
    public function getReturn($expression)
    {
        $returnStatement = new \CodeBuilder\Statements\ReturnStatement($expression);
        return $returnStatement;
    }

    /**
     *
     */
    public function getStatementBlock(Base $component)
    {
        $statement = new \CodeBuilder\Statements\StatementBlock($component);
        return $statement;
    }

    /**
     *
     */
    public function getSwitch(Base $conditional)
    {
        $switchStatement = new \CodeBuilder\Statements\SwitchStatement($conditional);
        return $switchStatement;
    }

    /**
     *
     */
    public function getThrow($class)
    {
        $throwStatement = new \CodeBuilder\Statements\ThrowStatement($class);
        return $throwStatement;
    }

    /**
     *
     */
    public function getWhile($while)
    {
        $whileStatement = new \CodeBuilder\Statements\WhileStatement($while);
        return $whileStatement;
    }
}

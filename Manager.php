<?php

/**
 * Brainztorm.
 *
 * LICENSE
 *
 * This source file is subject to license that is bundled
 * with this package in the file docs/LICENSE.txt.
 *
 * @author      Brainz SAS. 2014-2017
 */
namespace CodeBuilder;

use CodeBuilder\Builder\Base;

/**
 * CodeBuilder\Manager.
 */
class CodeBuilder
{
    /**
     *
     */
    public function getAnnotation($name)
    {
        $annotation = new \CodeBuilder\Annotations\Annotation($name);
        return $annotation;
    }

    /**
     *
     */
    public function getComment($comment = false)
    {
        $comment = new \CodeBuilder\Annotations\Comment($comment);
        return $comment;
    }

    /**
     *
     */
    public function getPHPDocs($name, $type = false, $variable = false, $description = false)
    {
        $phpdocs = new \CodeBuilder\Annotations\PHPDocs(
            $name,
            $type = false,
            $variable = false,
            $description = false
        );
        return $phpdocs;
    }

    /**
     *
     */
    public function getAttributeCaller($name)
    {
        $attribute = new \CodeBuilder\Classes\AttributeCall($name);
        return $attribute;
    }

    /**
     *
     */
    public function getAttributeClass(\CodeBuilder\Expressions\Variable $variable)
    {
        $attributeClass = new \CodeBuilder\Classes\ClassAttribute($variable);
        return $attributeClass;
    }

    /**
     *
     */
    public function getClassComponent($className)
    {
        $classComponent = new \CodeBuilder\Classes\ClassComponent($className);
        return $classComponent;
    }

    /**
     *
     */
    public function getClassMethod($name)
    {
        $classMethod = new \CodeBuilder\Classes\ClassMethod($name);
        return $classMethod;
    }

    /**
     *
     */
    public function getClassNamespace($name = "")
    {
        $classNamespace = new \CodeBuilder\Classes\ClassNamespace($name);
        return $classNamespace;
    }

    /**
     *
     */
    public function getClassTrait($name)
    {
        $classTrait = new \CodeBuilder\Classes\ClassTrait($name);
        return $classTrait;
    }

    /**
     *
     */
    public function getMethodCall($name, Base $class = null)
    {
        $methodCall = new \CodeBuilder\Classes\MethodCall($name, $class);
        return $methodCall;
    }

    /**
     *
     */
    public function getNewClass($name)
    {
        $newClass = new \CodeBuilder\Classes\NewClass($name);
        return $newClass;
    }

    /**
     *
     */
    public function getTags($content, $type = self::PHP, $close = false)
    {
        $tags = new \CodeBuilder\Classes\Tags($name, $type, $close);
        return $tags;
    }

    /**
     *
     */
    public function getBinary($val1, $condition, $val2)
    {
         $binary = new \CodeBuilder\Expressions\Binary($val1, $operator, $val2);
         return $binary;
    }

    /**
     *
     */
    public function getTernary(Base $conditional, Base $val1, Base $val2)
    {
        $ternary = new \CodeBuilder\Expressions\Ternary($conditional, $val1, $val2);
        return $ternary;
    }

    /**
     *
     */
    public function getUnary($any1, $any2)
    {
        $unary = new \CodeBuilder\Expressions\Unary($any1, $any2);
        return $unary;
    }

    /**
     *
     */
    public function getVariable($name)
    {
        $variable = new \CodeBuilder\Expressions\Variable($name);
        return $variable;
    }

    /**
     *
     */
    public function getLiteral()
    {
        $literal = new \CodeBuilder\Expressions\Literals\Manager();
        return $literal;
    }

    /**
     *
     */
    public function getOperator()
    {
        $operator = new \CodeBuilder\Expressions\Operators\Manager();
        return $operator;
    }

    /**
     *
     */
    public function getParenthesis(Base $content)
    {
        $parenthesis = new \CodeBuilder\Group\Parenthesis($content);
        return $parenthesis;
    }

    /**
     *
     */
    public function getSquareBrackets(Base $content)
    {
        $squareBrackets = new \CodeBuilder\Group\SquareBrackets($content);
        return $squareBrackets;
    }

    /**
     *
     */
    public function getStatements()
    {
        $manager = new \CodeBuilder\Statements\Manager();
        return $manager;
    }

    /**
     *
     */
    public function getStaticCall(Base $variable, Base $base)
    {
        $staticCall = new \CodeBuilder\Statics\StaticCall($variable, $base);
        return $staticCall;
    }

    /**
     *
     */
    public function getFunctionCall($name)
    {
        $functionCall = new \CodeBuilder\Structural($name);
        return $functionCall;
    }
}

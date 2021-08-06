<?php

namespace CodeBuilder\Expressions;

use CodeBuilder\Exception;
use CodeBuilder\Builder\Base;

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
class Unary extends Expression
{
    /**
     * @var array
     */
    private $struct;

    /**
     * Initialize unary values.
     *
     * @param string $var1
     * @param string $var2
     */
    public function __construct($any1, $any2)
    {
        $this->struct['values'][] = $any1;
        $this->struct['values'][] = $any2;
        $this->setIdentation(false);
        $this->setSemicolon(false);
    }

    /**
     * Add unary val.
     *
     * @param string $values
     *
     * @example !$variable
     */
    public function add($values)
    {
        $this->struct['values'][] = $values;
    }

    /**
     * Check content and build Unary.
     *
     * @param Base | string $content [description]
     *
     * @return string
     */
    private function checkContent($content)
    {
        if ($content instanceof Base) {
            return $content->resolve();
        } elseif (is_string($content)) {
            return $this->checkStr($content);
        } else {
            throw new Exception('Unrecognized value : '.print_r($content, true));
        }
    }

    /**
     * Check whether a string has not more than one variable.
     *
     * @return string
     */
    private function checkStr($str)
    {
        $position = strrpos($str, ' ');
        if ($position === false) {
            return $str;
        } else {
            throw new Exception(
                "The value : $str is not allowed in $position position, ".
                'should be a variable or operator.'
            );
        }
    }

    /**
     * Builder unary.
     *
     * @return string
     */
    private function compileValues()
    {
        $finally = '';
        foreach ($this->struct['values'] as $values) {
            $finally .= $this->checkContent($values);
        }

        return $finally;
    }

    /**
     * Return builder unary.
     *
     * @return string
     */
    public function resolve()
    {
        return $this->identation.$this->compileValues().$this->semicolon;
    }
}

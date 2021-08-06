<?php

namespace CodeBuilder\Classes;

use CodeBuilder\Builder\Base;
use CodeBuilder\Expressions\Variable;

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
class MethodCall extends Base
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * Initialize data for after resolve.
     *
     * @param string         $name
     * @param ClassComponent $class for get static class
     */
    public function __construct($name, Base $class = null)
    {
        $this->struct['name'] = $name;
        if ($name instanceof Base) {
            $this->struct['name'] = $name->resolve();
        }
        $this->struct['parent'] = '$this';
        if (!is_null($class)) {
            if ($class instanceof ClassComponent) {
                $this->struct['parent'] = (new Variable(
                    lcfirst($class->getName())
                ))->resolve();
            } else {
                if ($class instanceof Base) {
                    $this->struct['parent'] = $class->resolve();
                }
            }
        }
        $this->struct['params'] = '';
        $this->struct['static'] = false;
        $this->setSemicolon(false);
        $this->setIdentation(false);
    }

    /**
     * @param bool $static
     */
    public function setStatic($static = true)
    {
        $this->struct['static'] = $static;

        return $this;
    }

    /**
     * Add method params.
     *
     * @param array $params
     */
    public function addParams(array $params = array())
    {
        $this->struct['params'] = $this->treatParams($params);

        return $this;
    }

    /**
     * Create header with params.
     *
     * @return string
     */
    private function compileContent()
    {
        $operator = '->';
        if ($this->struct['static']) {
            $operator = '::';
        }
        $params = $this->struct['params'];
        $method = $this->struct['parent'].
                  $operator.
                  $this->struct['name'].
                  '('.$params.')'.
                  $this->resolveChilds();

        return $method;
    }

    /**
     * Add nested method calls.
     *
     * @param MethodCall $child
     */
    public function addChild(MethodCall $child)
    {
        $this->struct['childs'][] = $child;
    }

    /**
     * Return string with nested method calls.
     *
     * @return string
     */
    private function resolveChilds()
    {
        $childs = '';
        if (isset($this->struct['childs'])) {
            foreach ($this->struct['childs'] as $item) {
                $item->setIdentation(false);
                $childs .= $item->resolve(true);
            }
        }

        return $childs;
    }

    /**
     * Return all items of method calls.
     *
     * @return string
     */
    public function resolve($nested = false)
    {
        if ($nested) {
            $this->struct['parent'] = '';
        }

        return $this->identation.$this->compileContent().$this->semicolon;
    }
}

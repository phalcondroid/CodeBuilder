<?php

namespace CodeBuilder\Classes;

use CodeBuilder\Exception;
use CodeBuilder\Builder\Base;
use CodeBuilder\Annotations\Comment;
use CodeBuilder\Statements\StatementBlock;

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
class ClassComponent extends Base
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * @var string
     */
    private $className;

    /**
     * Initialize name and position level.
     *
     * @param string $className
     */
    public function __construct($className)
    {
        $this->struct['name'] = ucfirst($className);
        $this->setLevel(null);
    }

    /**
     * Get static class.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->struct['name'].'::class';
    }

    /**
     * Get class name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->struct['name'];
    }

    /**
     * Add extends name class.
     *
     * @param string $extends
     */
    public function addExtends($extends)
    {
        $this->struct['extends'] = $extends;
    }

    /**
     * Add implements interface, could be more than one.
     *
     * @param array $interfaces
     */
    public function addImplements($interfaces)
    {
        if ($interfaces) {
            $this->struct['implements'][] = $interfaces;
        }
    }

    /**
     * Add content items such as attributes, methods, comments, traits, namespaces, etc.
     *
     * @param Base $component
     */
    public function add(Base $component)
    {
        if ($component instanceof StatementBlock) {
            $component->setLevel(1);
            $this->struct['methods'][$component->getComponent()->getName()] = $component;
        } elseif ($component instanceof ClassTrait) {
            $component->setLevel(1);
            $this->struct['traits'] = $component;
        } elseif ($component instanceof ClassNamespace) {
            $component->setLevel(null);
            $this->struct['namespaces'][] = $component;
        } elseif ($component instanceof Comment) {
            $this->struct['comment'] = $component;
        } elseif ($component instanceof ClassAttribute) {
            $component->setLevel(1);
            $this->struct['attrs'][$component->getName()] = $component;
        } elseif ($component instanceof ClassMethod) {
            throw new Exception('The method should be content into statement block');
        }
    }

    /**
     * Builde traits.
     *
     * @return string
     */
    private function compileTraits()
    {
        if (isset($this->struct['traits'])) {
            return $this->struct['traits']->resolve().$this->getNewLine();
        }
    }

    /**
     * Builder attributes.
     *
     * @return string
     */
    private function compileAttrs()
    {
        if (isset($this->struct['attrs'])) {
            $attrs = '';
            $i = 0;
            foreach ($this->struct['attrs'] as $attr) {
                $attr->setLevel(1);
                if ($i == 0) {
                    $attrs .= $this->getNewLine().$attr->resolve().$this->getNewLine();
                } else {
                    $attrs .= $attr->resolve().$this->getNewLine();
                }
                ++$i;
            }

            return $attrs;
        }
    }

    /**
     * Builder methods.
     *
     * @return string
     */
    private function compileMethods()
    {
        if (isset($this->struct['methods'])) {
            $methods = '';
            foreach ($this->struct['methods'] as $method) {
                $methods .= $method->resolve();
            }

            return $methods;
        }
    }

    /**
     * Builder header class.
     *
     * @return string
     */
    public function createSign()
    {
        if (!empty($this->struct['name'])) {
            $sign = 'class '.$this->struct['name'];

            if (isset($this->struct['extends'])) {
                $sign .= ' extends '.$this->struct['extends'];
            }

            if (isset($this->struct['implements'])) {
                $sign .= ' implements '.implode(', ', $this->struct['implements']);
            }

            return $sign;
        } else {
            throw new Exception('Class name is empty');
        }
    }

    /**
     * Builder namespaces.
     *
     * @return string
     */
    private function compileNamespaces()
    {
        if (isset($this->struct['namespaces'])) {
            $namespaces = '';
            foreach ($this->struct['namespaces'] as $namespace) {
                $namespaces .= $namespace->resolve().$this->getNewLine();
            }

            return $namespaces;
        }
    }

    /**
     * Builder complete class component.
     *
     * @return string
     */
    public function resolve()
    {
        $comment = '';
        $sign = '';
        if (isset($this->struct['comment'])) {
            $clsComment = $this->struct['comment'];
            $clsComment->setLevel($this->getLevel());
            $comment = $clsComment->resolve();
            $sign .= $comment.$this->getNewLine().$this->createSign();
        } else {
            $sign .= $this->createSign();
        }
        $class = $this->compileNamespaces();
        $content = $this->compileTraits();
        $content .= $this->compileAttrs();
        $content .= $this->compileMethods();

        $lastEOL = '';
        if (empty($content)) {
            $lastEOL = PHP_EOL;
        }
        $class .= $sign.PHP_EOL.'{'.$content.$lastEOL.'}'.PHP_EOL;

        return $class;
    }
}

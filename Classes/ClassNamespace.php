<?php

namespace CodeBuilder\Classes;

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
class ClassNamespace extends Base
{
    /**
     * @var array
     */
    private $struct;

    /**
     * Initialize data and set as first namespace.
     *
     * @param string $name
     */
    public function __construct($name = '')
    {
        if (!empty($name)) {
            $this->struct['name'][] = $name;
            $this->struct['first'] = true;
        }
    }

    /**
     * Add first namespace, begins with namespace else begin with use
     * also check if $namespace is empty.
     *
     * @param string $namespace
     */
    public function add($component)
    {
        if (empty($component)) {
            throw new Exception('Namespace is empty');
        }
        if ($component instanceof Base) {
            $this->struct['comment'] = $component;
        } else {
            $this->struct['name'][] = $component;
        }
    }

    /**
     * Return all namespace items.
     *
     * @return string
     */
    public function resolve()
    {
        $namespaces = '';
        $first = true;
        foreach ($this->struct['name'] as $item) {
            if (isset($this->struct['first']) and $first) {
                $type = 'namespace ';
                $namespaces .= $type.$item.';'.$this->getNewLine();
                if (count($this->struct['name']) > 1) {
                    $namespaces .= $this->getNewLine();
                }
                $first = false;
            } else {
                $type = 'use ';
                $namespaces .= $type.$item.';'.$this->getNewLine();
            }
        }
        if (isset($this->struct['comment'])) {
            $clsComment = $this->struct['comment'];
            $clsComment->setLevel($this->getLevel());
            $comment = $clsComment->resolve();
            $namespaces = $comment.$this->getNewLine().$namespaces;
        }

        return $namespaces;
    }
}

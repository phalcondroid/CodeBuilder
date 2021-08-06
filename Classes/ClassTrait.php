<?php

namespace CodeBuilder\Classes;

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
class ClassTrait extends Base
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * Add traits.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->add($name);
    }

    /**
     * Add new trait in queue.
     *
     * @param string $name
     */
    public function add($name)
    {
        if (count($this->struct) == 0) {
            $this->struct[] = 'use '.$name;
        } else {
            $this->struct[] = $this->getTab().$name;
        }
    }

    /**
     * Return traits.
     *
     * @return string
     */
    public function resolve()
    {
        return $this->getNewLine().$this->getTab().implode(', ', $this->struct).';';
    }
}

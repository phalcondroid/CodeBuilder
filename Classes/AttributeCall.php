<?php

namespace CodeBuilder\Classes;

use CodeBuilder\Exception;
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
class AttributeCall extends Base
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * Initialize name attribute and check if is not empty.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        if (empty($name)) {
            throw new Exception('Name is mandatory');
        }
        $this->struct['name'] = $name;
    }

    /**
     * Build call attribute.
     *
     * @return string
     */
    public function resolve()
    {
        return $this->getTab().(new Variable('this'))->resolve().'->'.$this->struct['name'];
    }
}

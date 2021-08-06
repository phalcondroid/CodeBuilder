<?php

namespace CodeBuilder\Expressions\Literals;

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
class ConstantLiteral extends Literal
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * Set constant name.
     *
     * @param string $constantName
     */
    public function __construct($constantName)
    {
        $this->struct['name'] = $constantName;
    }

    /**
     * Get constant name.
     *
     * @return string
     */
    public function resolve()
    {
        return $this->struct['name'];
    }
}

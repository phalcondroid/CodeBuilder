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
class BooleanLiteral extends Literal
{
    /**
     * @var bool
     */
    private $getStatic = false;

    /**
     * Initialize with boolean data.
     *
     * @param bool $value
     */
    public function __construct($value)
    {
        $this->literal = $value;
    }

    /**
     * Build boolean.
     *
     * @return string
     */
    public function resolve()
    {
        if ($this->literal) {
            return 'true';
        } else {
            return 'false';
        }
    }
}

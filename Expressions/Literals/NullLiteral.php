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
class NullLiteral extends Literal
{
    /**
     * Get null type.
     *
     * @return string
     */
    public function resolve()
    {
        return 'null';
    }
}

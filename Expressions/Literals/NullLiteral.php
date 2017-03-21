<?php

namespace CodeBuilder\Expressions\Literals;

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

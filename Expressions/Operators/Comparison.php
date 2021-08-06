<?php

namespace CodeBuilder\Expressions\Operators;

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
class Comparison extends Operator
{
    const SET = '=';
    const ARRAY_ASSIGN = '=>';
    const EQUAL = '==';
    const LESS_THAN = '<';
    const NOT_EQUAL = '!=';
    const BLANK_SPACE = '=';
    const IDENTICAL = '===';
    const GREATER_THAN = '>';
    const STATIC_CLASS = '::';
    const NOT_IDENTICAL = '!==';
    const LESS_THAN_EQUAL = '<=';
    const GREATER_THAN_EQUAL = '>=';
    const _INSTANCEOF = 'instanceof';
}

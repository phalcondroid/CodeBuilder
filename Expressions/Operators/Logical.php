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
class Logical extends Operator
{
    const _AND_ = 'and';
    const _OR_ = 'or';
    const _AND = '&&';
    const _OR = '||';
    const _XOR = '!';
    const _AND_BIN = '&';
    const _OR_BIN = '|';
    const _XOR_BIN = '^';
    const _SR = '>>';
    const _SL = '<<';
    const _NOT_BIN = '~';
}

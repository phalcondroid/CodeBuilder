<?php
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
namespace CodeBuilder\Expressions;

/**
 * CodeBuilder\Expressions\Variable.
 */
class Variable extends Expression
{
    /**
     * @var array | string
     */
    private $struct;

    /**
     * Initialize name var.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->struct['name'] = $name;
        $this->struct['asArray'] = false;
        $this->setIdentation(false);
        $this->setSemicolon(false);
    }

    /**
     * Become variable in array.
     *
     * @param Base $index
     *
     * @return this
     */
    public function asArray(Base $index = null)
    {
        if (!is_null($index)) {
            $this->struct['asArray'] = '['.$index->resolve().']';
        }
        $this->struct['asArray'] = '[]';

        return $this;
    }

    /**
     * Builde Variable.
     *
     * @example $myVariable
     *
     * @return string
     */
    public function resolve()
    {
        $asArray = '';
        if ($this->struct['asArray']) {
            $asArray = '[]';
        }

        return  $this->identation.'$'.$this->struct['name'].$asArray.$this->semicolon;
    }
}

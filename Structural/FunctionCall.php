<?php

namespace CodeBuilder\Structural;

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
class FunctionCall extends Structural
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * Initialize data for after resolve.
     *
     * @param string         $name
     * @param ClassComponent $class for get static class
     */
    public function __construct($name)
    {
        $this->struct['name'] = $name;
        $this->semicolon = false;
        $this->identation = false;
    }

    /**
     * Add method params.
     *
     * @param array $params
     */
    public function addParams(array $params = array())
    {
        $this->struct['params'] = $this->treatParams($params);

        return $this;
    }

    /**
     * @return [type] [description]
     */
    public function compileContent()
    {
        $params = '';
        if (isset($this->struct['params'])) {
            $params = $this->struct['params'];
        }

        return $this->struct['name'].'('.$params.')';
    }

    /**
     * Return all items of method calls.
     *
     * @return string
     */
    public function resolve()
    {
        $semicolon = '';
        if ($this->semicolon) {
            $semicolon = ';';
        }

        if ($this->identation) {
            return $this->getNewLine().$this->getTab().$this->compileContent().$semicolon;
        } else {
            return $this->compileContent().$semicolon;
        }
    }
}

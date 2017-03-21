<?php

namespace CodeBuilder\Classes;

use CodeBuilder\Builder\Base;

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
class NewClass extends Base
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * Add name for new class.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->struct['name'] = ucfirst($name);
        $this->struct['params'] = '';

        $this->setSemicolon(false);
        $this->setIdentation(false);
    }

    /**
     * Get class name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->struct['name'];
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
     * Return traits.
     *
     * @return string
     */
    public function resolve()
    {
        return  $this->identation.
                'new '.
                $this->struct['name'].
                '('.
                $this->struct['params'].
                ')'.
                $this->semicolon;
    }
}

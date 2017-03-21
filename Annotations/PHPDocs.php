<?php

namespace CodeBuilder\Annotations;

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
class PHPDocs extends Base
{
    const _API = 'api';
    const _AUTHOR = 'author';
    const _CATEGORY = 'category';
    const _COPYRIGHT = 'copyright';
    const _DEPRECATED = 'deprecated';
    const _EXAMPLE = 'example';
    const _FILESOURCE = 'filesource';
    const _GLOBAL = 'global';
    const _IGNORE = 'ignore';
    const _INTERNAL = 'internal';
    const _LICENCE = 'licence';
    const _LINK = 'link';
    const _METHOD = 'method';
    const _PACKAGE = 'package';
    const _PARAM = 'param';
    const _PROPERTY = 'property';
    const _PROPERTY_READ = 'property-read';
    const _PROPERTY_WRITE = 'property-write';
    const _RETURN = 'return';
    const _SEE = 'see';
    const _SINCE = 'since';
    const _SOURCE = 'source';
    const _SUBPACKAGE = 'subpackage';
    const _THROWS = 'throws';
    const _TODO = 'todo';
    const _USES = 'uses';
    const _VAR = 'var';
    const _VERSION = 'version';

    /**
     * @var array
     */
    private $struct = array();

    /**
     * Create a phpdoc annotation.
     *
     * @param string        $name
     * @param string        $type
     * @param string | Base $variable
     * @param string        $description
     */
    public function __construct($name, $type = false, $variable = false, $description = false)
    {
        $phpdoc = '@'.$name;
        if ($type) {
            $phpdoc .= ' '.$type;
        }

        if ($variable) {
            if ($variable instanceof Base) {
                $phpdoc .= ' '.$variable->resolve();
            } else {
                $phpdoc .= ' '.$variable;
            }
        }

        if ($description) {
            $phpdoc .= ' '.$description;
        }
        $this->struct['phpdoc'] = $phpdoc;
    }

    /**
     * Get the Constants of class.
     *
     * @return array
     */
    public static function getConstants()
    {
        $oClass = new ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }

    /**
     * Return builded phpdoc.
     *
     * @return string
     */
    public function resolve()
    {
        return $this->struct['phpdoc'];
    }
}

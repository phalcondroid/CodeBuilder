<?php

namespace CodeBuilder\Annotations;

use CodeBuilder\Builder\Base;

define("DOCS_API", 'api');
define("DOCS_AUTHOR", 'author');
define("DOCS_CATEGORY", 'category');
define("DOCS_COPYRIGHT", 'copyright');
define("DOCS_DEPRECATED", 'deprecated');
define("DOCS_EXAMPLE", 'example');
define("DOCS_FILESOURCE", 'filesource');
define("DOCS_GLOBAL", 'global');
define("DOCS_IGNORE", 'ignore');
define("DOCS_INTERNAL", 'internal');
define("DOCS_LICENCE", 'licence');
define("DOCS_LINK", 'link');
define("DOCS_METHOD", 'method');
define("DOCS_PACKAGE", 'package');
define("DOCS_PARAM", 'param');
define("DOCS_PROPERTY", 'property');
define("DOCS_PROPERTY_READ", 'property-read');
define("DOCS_PROPERTY_WRITE", 'property-write');
define("DOCS_RETURN", 'return');
define("DOCS_SEE", 'see');
define("DOCS_SINCE", 'since');
define("DOCS_SOURCE", 'source');
define("DOCS_SUBPACKAGE", 'subpackage');
define("DOCS_THROWS", 'throws');
define("DOCS_TODO", 'todo');
define("DOCS_USES", 'uses');
define("DOCS_VAR", 'var');
define("DOCS_VERSION", 'version');

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
class PHPDocs extends Base
{
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
        $phpdoc = '@' . $name;
        if ($type) {
            $phpdoc .= ' ' . $type;
        }

        if ($variable) {
            if ($variable instanceof Base) {
                $phpdoc .= ' ' . $variable->resolve();
            } else {
                $phpdoc .= ' ' . $variable;
            }
        }

        if ($description) {
            $phpdoc .= ' ' . $description;
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

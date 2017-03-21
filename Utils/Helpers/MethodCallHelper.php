<?php

namespace CodeBuilder\Utils\Helpers;

use CodeBuilder\Classes\MethodCall;

class MethodCallHelper
{
    /**
     * Create call method from class.
     *
     * @param string $name
     * @param array  $arrayParams
     *
     * @return CodeBuilder\Classes\MethodCall
     */
    public function getMethodCall($name, $class)
    {
        $method = new MethodCall($name);
        $method->addParams($params);

        return $method;
    }
}

<?php

namespace CodeBuilder\Builder;

class Config
{
    /**
     * @var array
     */
    private $namespaces = array();

    /**
     * [__construct description].
     */
    public function __construct()
    {
    }

    /**
     * Get directory path.
     *
     * @return string
     */
    public function getDir()
    {
        return dirname(dirname(__DIR__));
    }

    /**
     * Get path of file by the namespace.
     *
     * @param string $namespace
     *
     * @return string
     */
    public function getPathByNamespace($namespace)
    {
        return $this->getBaseDir().'/'.str_replace('\\', '/', $namespace);
    }

    /**
     * Gte base dir.
     *
     * @return string
     */
    public function getBaseDir()
    {
        return dirname(dirname(dirname(__DIR__)));
    }
}

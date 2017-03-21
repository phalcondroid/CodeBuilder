<?php

namespace CodeBuilder\Builder;

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
class Base
{
    /**
     * @var int
     */
    private $tabLevel = 0;

    /**
     * @var string
     */
    protected $semicolon = '';

    /**
     * @var string
     */
    protected $identation = '';

    /**
     * Enable or disable semicolon.
     *
     * @param This class
     */
    public function setSemicolon($bool = true)
    {
        if ($bool) {
            $this->semicolon = ';';
        } else {
            $this->semicolon = '';
        }

        return $this;
    }

    /**
     * @return This class
     */
    public function setIdentation($identation = true)
    {
        if ($identation) {
            $this->identation = $this->getNewLine().$this->getTab();
        } else {
            $this->identation = '';
        }

        return $this;
    }

    /**
     * Get operative symtem new line.
     *
     * @return PHP_EOL
     */
    protected function getNewLine()
    {
        return PHP_EOL;
    }

    /**
     * get level attribute.
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->tabLevel;
    }

    /**
     * Set level attribute.
     *
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->tabLevel = $level;
    }

    /**
     * Treat params item depends the class type and
     * return string with all params joined.
     *
     * @param array $params
     *
     * @return string
     */
    protected function treatParams(array $params)
    {
        $aux = array();
        if ($params) {
            if (count($params) > 0) {
                foreach ($params as $key => $value) {
                    if (is_string($key)) {
                        if ($value instanceof self) {
                            $aux[] = "$key ".$value->resolve();
                        } else {
                            $aux[] = "$key $value";
                        }
                    } elseif ($value instanceof self) {
                        $aux[] = $value->resolve();
                    } else {
                        $aux[] = $value;
                    }
                }
            }
        }

        return implode(', ', $aux);
    }

    /**
     * Return tabs depends level number.
     *
     * @return string
     */
    protected function getTab($customTabs = false)
    {
        $tabs = '';
        $level = $this->tabLevel;
        if ($customTabs) {
            $level = $customTabs;
        }

        for ($i = 0; $i < $level; ++$i) {
            $tabs .= '    ';
        }

        return $tabs;
    }
}

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
 * @author      Brainz SAS. 2014-2017
 */
class Annotation extends Base
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * Constructor class.
     *
     * @param string $symbol
     */
    public function __construct($name)
    {
        $this->struct['name'] = $name;
        $this->struct['symbol'] = '@';
        $this->struct['index'] = 0;
    }

    /**
     * Annotation constructor.
     *
     * @param string $symbol
     */
    public function setSymbol($symbol)
    {
        $this->struct['symbol'] = $symbol;
    }

    /**
     * Getter for symbol attribute.
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->struct['symbol'];
    }

    /**
     * This method add attributes depends of your data type and parameters.
     *
     * @param string $name
     * @param string $value
     * @param string $type
     */
    public function addAttribute($name, $value = false)
    {
        if (is_string($name) and $value == false) {
            $this->struct['attributes'][] = $name;
        } elseif ($name instanceof Base and $value == false) {
            $this->struct['attributes'][] = $name->resolve();
        } elseif ($name instanceof Base and $value instanceof Base) {
            $this->struct['attributes'][] = array(
                'name' => $name->resolve(),
                'value' => $value->resolve(),
            );
        } elseif (is_string($name) and $value instanceof Base) {
            $this->struct['attributes'][] = array(
                'name' => $name,
                'value' => $value->resolve(),
            );
        } elseif (is_string($name) and is_string($value)) {
            $this->struct['attributes'][] = array(
                'name' => $name,
                'value' => $value,
            );
        }
    }

    /**
     * This method create header or sign for any annotation.
     *
     * @return string
     */
    private function createSign()
    {
        return $this->struct['symbol'].$this->struct['name'];
    }

    /**
     * This method binds each attribute and organize within annotation header
     * Check if each attribute is a instance of Base or is a string.
     *
     * @return string
     */
    private function compileAttr()
    {
        if (isset($this->struct['attributes'])) {
            $attributes = array();
            $value = '';
            foreach ($this->struct['attributes'] as $item) {
                if (is_array($item)) {
                    $value = $item['value'];
                    if ($value instanceof Base) {
                        $value = $item['value']->resolve();
                    }
                    $name = $item['name'];
                    if ($name instanceof Base) {
                        $name = $item['name']->resolve();
                    }
                    $attributes[] = "{$item['name']}={$value}";
                } else {
                    $value = $item;
                    $attributes[] = $value;
                }
            }

            return implode(', ', $attributes);
        }
    }

    /**
     * Return string with all assigned elements.
     *
     * @return string
     */
    public function resolve()
    {
        $annotation = $this->createSign();
        if (isset($this->struct['attributes'])) {
            $annotation .= '('.$this->compileAttr().')';
        }

        return $annotation;
    }
}

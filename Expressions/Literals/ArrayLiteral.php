<?php

namespace CodeBuilder\Expressions\Literals;

use CodeBuilder\Builder\Base;

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
class ArrayLiteral extends Literal
{
    /**
     * @var array
     */
    private $struct = false;

    /**
     * @var bool
     */
    private $getStatic = false;

    /**
     * Initialize with boolean data.
     *
     * @param bool $value
     */
    public function __construct(Base $name = null)
    {
        $this->struct['name'] = $name;
        $this->struct['function'] = false;
        $this->struct['content'] = array();
        $this->semicolon = false;
        $this->identation = false;
    }

    /**
     * Add item array.
     *
     * @param Base $content
     *
     * @return this
     */
    public function add(Base $content)
    {
        $this->struct['content'][] = $content;

        return $this;
    }

    /**
     * Return array type as function.
     *
     * @example array(
     *     "first content",
     *     "seccond content"
     * )
     */
    public function asFunction()
    {
        $this->struct['function'] = true;

        return $this;
    }

    /**
     * Set flag to get static classs.
     *
     * @return bool
     */
    public function getClass()
    {
        $this->getStatic = true;

        return $this;
    }

    /**
     * Join all items in array with identation.
     *
     * @return string
     */
    private function compileContent()
    {
        $content = array();
        $count = count($this->struct['content']);
        //throw new \Exception($this->getLevel());

        // $this->getTab(1) set a tab, $this->getTab() set tab class level
        if (isset($this->struct['content'])) {
            $i = 0;
            foreach ($this->struct['content'] as $item) {
                $tabs = '';
                if ($count > 1) {
                    $tabs = $this->getTab().$this->getTab(1);
                }
                if ($item instanceof Base) {
                    $content[] = $tabs.$item->resolve();
                } elseif (is_string($item)) {
                    $content[] = $tabs.$item;
                }
                ++$i;
            }
        }

        return $this->addBrackets(implode(','.$this->getNewLine(), $content), $count);
    }

    /**
     * Add brackets and assign identation array.
     *
     * @param string $content
     *
     * @return string
     */
    private function addBrackets($content, $count)
    {
        $openBracket = '[';
        $closeBracket = ']';
        if ($this->struct['function']) {
            $openBracket = 'array(';
            $closeBracket = ')';
        }

        $tabOpen = '';
        $tabClose = '';

        if ($count > 1) {
            $tabOpen = $this->getNewLine();
            $tabClose = $this->getNewLine().$this->getTab();
        }

        $name = '';
        if (!is_null($this->struct['name'])) {
            $name = $this->struct['name']->resolve();
        }
        $name .= $openBracket.$tabOpen;
        $name .= $content;
        $name .= $tabClose.$closeBracket;

        return $name;
    }

    /**
     * Build boolean.
     *
     * @return string
     */
    public function resolve()
    {
        if ($this->getStatic) {
            return 'Array::class';
        }

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

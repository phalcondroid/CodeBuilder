<?php

namespace CodeBuilder\Expressions\Literals;

use CodeBuilder\Builder\Base;
use CodeBuilder\Expressions\Operators\Combined;

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
class StringLiteral extends Literal
{
    /**
     * Set flag to print single quotes.
     */
    const SINGLE_QUOTES = 1;

    private $quotes = '"';

    /**
     * Initialize flags and string data.
     *
     * @param string $value
     * @param int    $type  this shoudl be set with some flag
     */
    public function __construct($value, $type = 0)
    {
        if ($type == 1) {
            $this->quotes = '\'';
        }
        $this->literal = $this->quotes.$value.$this->quotes;
        $this->semicolon = false;
        $this->identation = false;
    }

    /**
     * @param string | Base $content
     */
    private function addContact($content)
    {
        $str = '';
        if ($content instanceof Base) {
            $contentVal = $content->resolve();
            $str = $this->quotes.' '.Combined::CONCAT.' '.$contentVal.' '.Combined::CONCAT.' '.$this->quotes;
        } elseif (is_string($content)) {
            $contentVal = $content;
            $str = $this->quotes.' '.Combined::CONCAT.' '.$contentVal.' '.Combined::CONCAT.' '.$this->quotes;
        }

        return $str;
    }

    /**
     * @return [type] [description]
     */
    public function concat(array $content)
    {
        $strSplited = str_split($this->literal);
        $interrogations = array();

        for ($i = 0; $i < count($strSplited); ++$i) {
            if ($strSplited[$i] == '?') {
                $interrogations[] = $i;
            }
        }

        for ($i = 0; $i < count($content); ++$i) {
            $strSplited[$interrogations[$i]] = $this->addContact($content[$i]);
        }

        if ($strSplited[$i] != '?') {
            $interrogations[] = $i;
        }

        $this->literal = implode('', $strSplited);
    }

    /**
     * @return [description]
     */
    private function compileContent()
    {
        return $this->literal;
    }

    /**
     * Build string data.
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

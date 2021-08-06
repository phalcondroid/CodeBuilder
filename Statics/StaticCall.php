<?php

namespace CodeBuilder\Statics;

use CodeBuilder\Exception;
use CodeBuilder\Builder\Base;
use CodeBuilder\Expressions\Variable;

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
class StaticCall extends Base
{
    /**
     * @var array
     */
    private $struct = array();

    public function __construct(Base $variable, Base $base = null)
    {
        $this->struct['base'] = $base;
        $this->struct['content'] = $variable;
        $this->setIdentation(false);
        $this->setSemicolon(false);
    }

    /**
     * Build content depends of params.
     *
     * @return string
     */
    private function compileContent()
    {
        $result = '';
        $base = $this->buildBase();
        if ($this->struct['content'] instanceof Base) {
            $result = $base.$this->struct['content']->resolve();
        } else {
            throw new Exception('Should be FunctionCall or Variable instance');
        }

        return $result;
    }

    /**
     * Build base depends of params.
     *
     * @return string
     */
    private function buildBase()
    {
        $base = '';
        if (is_null($this->struct['base'])) {
            $base = 'self::';
        } else {
            $base = $this->struct['base']->resolve().'::';
        }

        return $base;
    }

    /**
     * Get method static call result as string.
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

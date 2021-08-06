<?php

namespace CodeBuilder\Statements;

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
class StatementBlock extends Base
{
    /**
     * @var array
     */
    private $struct;

    /**
     * Initialize content with some Base object.
     *
     * @param Base $type
     */
    public function __construct(Base $component)
    {
        $this->struct['component'] = $component;
    }

    /**
     * Get component offset.
     *
     * @return array
     */
    public function getComponent()
    {
        return $this->struct['component'];
    }

    /**
     * Build statement block with Base content.
     *
     * @example {
     *  $variable = "content";
     * }
     *
     * @return string
     */
    public function resolve()
    {
        $this->struct['component']->setLevel($this->getLevel());

        $firstLine = '';
        $resolve = $this->struct['component']->resolve();

        if ($this->struct['component'] instanceof Statement) {
            $firstLine = '{';
            $resolve = rtrim($resolve);
        } else {
            $firstLine = $this->getNewLine().$this->getTab().'{';
        }

        $arr = [
            $firstLine,
            $resolve,
            $this->getNewLine().$this->getTab().'}'.$this->getNewLine(),
        ];

        return $this->struct['component']->getSign().implode('', $arr);
    }
}

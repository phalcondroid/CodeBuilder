<?php

namespace CodeBuilder\Statements;

use CodeBuilder\Builder\Base;

class EchoStatement extends Base
{
    /**
     * [$struct description].
     *
     * @var [type]
     */
    private $struct;

    /**
     * [__construct description].
     */
    public function __construct($st)
    {
        $this->struct['st'][] = $st;
    }

    /**
     * [add description].
     */
    public function add($st)
    {
        $this->struct['st'][] = $st;
    }

    /**
     * @return [type] [description]
     */
    public function resolve()
    {
        $forPrint = '';
        if (isset($this->struct['st'])) {
            foreach ($this->struct['st'] as $item) {
                if ($item instanceof Base) {
                    $forPrint .= $item->resolve();
                } elseif (is_string($item)) {
                    $forPrint .= $item;
                }
            }
        }

        return $this->getNewLine() . $this->getTab() . 'echo ' . $forPrint . ';';
    }
}

<?php

namespace CodeBuilder\Statements;

use CodeBuilder\Builder\Base;

class ThrowStatement extends Base
{
    /**
     * @var [type]
     */
    private $struct;

    /**
     * @param string $class [description]
     */
    public function __construct($class = "\Exception")
    {
        $this->struct['class'] = $class;
        $this->struct['identation'] = false;
    }

    /**
     * [add description].
     */
    public function add(Base $content)
    {
        $this->struct['content'] = $content;

        return $this;
    }

    /**
     * @return [type] [description]
     */
    public function resolve()
    {
        if (isset($this->struct['content'])) {
            $content = $this->struct['content'];
            if ($this->struct['content'] instanceof Base) {
                $content = $this->struct['content']->resolve();
            }
            $throwStatement = 'throw new '.$this->struct['class'].'('.$content.')'.';';
        } else {
            throw new \Exception('Should be add a content, could use add method');
        }

        $throwStr = $this->getNewLine().$this->getTab().$throwStatement;

        return $throwStr;
    }
}

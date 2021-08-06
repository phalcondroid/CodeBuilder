<?php

namespace CodeBuilder\Group;

use CodeBuilder\Builder\Base;
use CodeBuilder\Expressions\Expression;

class Parenthesis extends Group
{
    /**
     * @var [type]
     */
    private $struct;

    public function __construct(Base $content)
    {
        $this->struct['content'] = $content;
    }

    /**
     * @return [type] [description]
     */
    public function resolve()
    {
        $content = $this->struct['content'];
        $finally = '';
        if ($content instanceof Expression) {
            $finally = ltrim($content->resolve());
        } else {
            $finally = $content->resolve();
        }

        return '(' . $finally . ')';
    }
}

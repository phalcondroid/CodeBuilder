<?php

namespace CodeBuilder\Group;

class Brackets extends SquareBrackets
{
    /**
     * @var array
     */
    private $struct = "";

    /**
     * @param String $content
     */
    public function __construct(Base $content)
    {
        $this->struct["content"] = $content->resolve();
    }

    /**
     * [resolve description]
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

        return '{' . $finally . '}';
    }
}

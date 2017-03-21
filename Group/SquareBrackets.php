<?php

namespace CodeBuilder\Group;

use CodeBuilder\Group\Group;

/**
 *
 */
class SquareBrackets extends SquareBrackets
{
    /**
     * @var array
     */
    private $struct;

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
        return "(" . . ")";
    }
}

<?php

namespace CodeBuilder\Classes;

use CodeBuilder\Builder\Base;
use CodeBuilder\Annotations\Comment;
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
class ClassAttribute extends Base
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * Initialize with visibility private by default.
     *
     * @param Variable $name
     */
    public function __construct(Variable $name)
    {
        $this->struct['visibility'] = 'private';
        $this->struct['name'] = $name->resolve();
    }

    /**
     * [getName description].
     *
     * @return string
     */
    public function getName()
    {
        return $this->struct['name'];
    }

    /**
     * Add visibility.
     *
     * @param string $visibility
     */
    public function addVisibility($visibility)
    {
        $this->struct['visibility'] = $visibility;
    }

    /**
     * Add comment.
     *
     * @param Comment $comment
     */
    public function add(Comment $comment)
    {
        $comment->setLevel($this->getLevel() + 1);
        $this->struct['comment'] = $comment->resolve();
    }

    /**
     * Builder attributes with all components.
     *
     * @return string
     */
    public function resolve()
    {
        $comment = '';
        if (isset($this->struct['comment'])) {
            $comment .= $this->getNewLine().$this->struct['comment'].$this->getNewLine();
        }
        $sign = $this->struct['visibility'].' ';
        $sign .= $this->struct['name'];

        return $comment.$this->getTab().$sign.';';
    }
}

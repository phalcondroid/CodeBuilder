<?php

namespace CodeBuilder\Annotations;

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
class Comment extends Base
{
    /**
     * @var array
     */
    private $struct;

    /**
     * This method when has parameters call to add method
     * and assign the comment param.
     *
     * @param $comment Base | String Optional Parameter
     */
    public function __construct($comment = false)
    {
        if ($comment != false) {
            $this->add($comment);
        }
    }

    /**
     * Crete comment with all content and attributes added.
     *
     * @return string
     */
    private function createComment($content)
    {
        return $this->getTab()."/**\n"."$content".$this->getTab().' */';
    }

    /**
     * This method add attributes in a queues.
     *
     * @param $obj
     */
    public function add($obj)
    {
        if ($obj instanceof Base) {
            $this->struct['bases'][] = $obj;
        } elseif (is_string($obj)) {
            $this->struct['messages'][] = $obj;
        }
    }

    /**
     * Join all text messages added separated by new line.
     *
     * @return string
     */
    private function compileMessages()
    {
        if (isset($this->struct['messages'])) {
            $messages = '';
            foreach ($this->struct['messages'] as $item) {
                $messages .= $this->getTab().' * '.$item.$this->getNewLine();
            }
            $messages .= $this->getTab().' *'.$this->getNewLine();

            return $messages;
        } else {
            return '';
        }
    }

    /**
     * Resolve each base instances and return string with
     * your own resolve method.
     *
     * @return string
     */
    private function compileBases()
    {
        if (isset($this->struct['bases'])) {
            $bases = '';
            foreach ($this->struct['bases'] as $item) {
                $bases .= $this->getTab().' * '.$item->resolve().$this->getNewLine();
            }

            return $bases;
        } else {
            return '';
        }
    }

    /**
     * Return all items of this comment added, join and return the created comment.
     *
     * @return string
     */
    public function resolve()
    {
        $bases = $this->compileBases();
        $messages = $this->compileMessages();
        $comment = $this->createComment($messages.$bases);

        return $comment;
    }
}

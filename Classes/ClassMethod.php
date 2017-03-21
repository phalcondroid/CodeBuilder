<?php

namespace CodeBuilder\Classes;

use CodeBuilder\Builder\Base;
use CodeBuilder\Annotations\Comment;

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
class ClassMethod extends Base
{
    /**
     * @var string
     */
    private $visibility = 'public';

    /**
     * @var string
     */
    private $struct;

    /**
     * Initialize method with name and position level.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->struct['params'] = '';
        $this->struct['static'] = false;
        $this->setLevel(0);
    }

    /**
     * [getName description].
     *
     * @return [type] [description]
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Assign when this method is static type.
     *
     * @return bool
     */
    public function setStatic($stack = true)
    {
        $this->struct['static'] = $stack;

        return $this;
    }

    /**
     * Add header visibility.
     *
     * @param string $visibility
     *
     * @example public
     * @example protected
     * @example private
     */
    public function addVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * Add method params.
     *
     * @param array $params
     */
    public function addParams(array $params = array())
    {
        $this->struct['params'] = $this->treatParams($params);
    }

    /**
     * Add any content instance of base or string.
     *
     * @param string | Base $content
     */
    public function add($content)
    {
        $this->struct['content'][] = $content;
    }

    /**
     * Build method content and comments throught StatementBlock.
     *
     * @return string
     */
    private function compileContent()
    {
        if (isset($this->struct['content'])) {
            $contents = '';
            foreach ($this->struct['content'] as $content) {
                if ($content instanceof Base and !$content instanceof Comment) {
                    $content->setLevel($this->getLevel() + 1);
                    $content->setIdentation(true);
                    $content->setSemicolon(true);
                    $contents .= $content->resolve();
                } elseif ($content instanceof Comment) {
                    $this->struct['comment'] = $content;
                } else {
                    $contents .= $content;
                }
            }

            return $contents;
        }
    }

    /**
     * Build header information with visibility, name and params.
     *
     * @return string
     */
    public function getSign()
    {
        $comment = '';
        if (isset($this->struct['comment'])) {
            $clsComment = $this->struct['comment'];
            $clsComment->setLevel($this->getLevel());
            $comment = $this->getNewLine().$clsComment->resolve();
        }

        $static = '';
        if ($this->struct['static']) {
            $static = ' static';
        }

        $sign = $this->getNewLine().
                $this->getTab().
                $this->visibility.
                $static.
                ' function '.
                $this->name.
                '('.
                $this->struct['params'].
                ')';

        $header = $comment.$sign;

        return $header;
    }

    /**
     * Builder method with private compileContent().
     *
     * @return string
     */
    public function resolve()
    {
        return $this->compileContent();
    }
}

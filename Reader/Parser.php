<?php

namespace CodeBuilder\Reader;

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
class Parser
{
    /**
     * @var array
     */
    private $struct = array();

    /**
     * Initialize name attribute and check if is not empty.
     *
     * @param string $name
     */
    public function __construct($cls)
    {
        $this->setFile($cls);
    }

    /**
     * Set file content.
     *
     * @param string $cls
     */
    private function setFile($cls)
    {
        $reflector = new \ReflectionClass($cls);
        $this->struct['absolutPath'] = $reflector->getFileName();
        $this->struct['file'] = file($this->struct['absolutPath']);
    }

    /**
     * Create syntax tree structure.
     *
     * @return array
     */
    private function createSyntaxTree()
    {
        $treeSyntax = array();
        foreach ($this->struct['file'] as $key => $value) {
            if (!empty($value)) {
                $trim = trim($value);
                $arrayItem = explode(' ', $trim);
                if ($arrayItem[0] == 'namespace') {
                    $ns = [];
                    $ns['namespace'] = $arrayItem[1];
                    $comment = $this->ifHasComment($key);
                    if ($comment) {
                        $ns['comment'] = $comment;
                    }
                    $treeSyntax['namespace'] = $ns;
                } elseif ($arrayItem[0] == 'use') {
                    $use = [];
                    $use['use'] = $arrayItem[1];
                    $comment = $this->ifHasComment($key);
                    if ($comment) {
                        $use['comment'] = $comment;
                    }
                    $treeSyntax['use'][] = $use;
                } elseif ($arrayItem[0] == 'class') {
                    $class = [];
                    $class['class'] = $arrayItem;
                    $comment = $this->ifHasComment($key);
                    if ($comment) {
                        $class['comment'] = $comment;
                    }
                    $treeSyntax['class'] = $class;
                } elseif ($this->knowWhatIs($arrayItem) == 'func') {
                    $method = array(
                        'exprs' => $arrayItem,
                    );
                    $comment = $this->ifHasComment($key);
                    if ($comment) {
                        $method['comment'] = $comment;
                    }
                    $treeSyntax['method'][] = $method;
                } elseif ($this->knowWhatIs($arrayItem) == 'attr') {
                    $attr = array(
                        'exprs' => $arrayItem,
                    );
                    $comment = $this->ifHasComment($key);
                    if ($comment) {
                        $attr['comment'] = $comment;
                    }
                    $treeSyntax['attr'][] = $attr;
                }
            }
        }

        return $treeSyntax;
    }

    /**
     * Know the type of the attribute.
     *
     * @param array $item
     *
     * @return string
     */
    private function knowWhatIs($item)
    {
        if (count($item) > 1) {
            $isAccess = ($item[0] == 'public' or
                         $item[0] == 'private' or
                         $item[0] == 'protected');

            if ($isAccess and $item[1] == 'function') {
                return 'func';
            } elseif ($isAccess and $item[1] != 'function') {
                return 'attr';
            } else {
                return 'unrecognized';
            }
        } else {
            return 'unrecognized';
        }
    }

    /**
     * Validate if the attribute has a comment.
     *
     * @param string $key
     *
     * @return bool
     */
    public function ifHasComment($key)
    {
        $before = trim($this->struct['file'][$key - 1]);
        if (isset($before)) {
            if ($before == '*/') {
                return array_reverse(
                    $this->analizeComment(
                        $key - 1,
                        $this->struct['file']
                    )
                );
            }
        }

        return false;
    }

    /**
     * Analize comment.
     *
     * @param string $key
     * @param array  $arr
     *
     * @return array
     */
    private function analizeComment($key, $arr)
    {
        $comment = array();

        for ($i = $key; $i < count($arr); --$i) {
            if (!empty(str_replace('*', '', trim($arr[$i])))) {
                $comment[] = trim($arr[$i]);
            }
            if (trim($arr[$i]) == '/**') {
                break;
            }
        }

        return $comment;
    }

    /**
     * Get absolute path.
     *
     * @return string
     */
    public function getAbsolutPath()
    {
        return $this->struct['absolutPath'];
    }

    /**
     * Build call attribute.
     *
     * @return string
     */
    public function getSyntaxArray()
    {
        return $this->createSyntaxTree();
    }
}

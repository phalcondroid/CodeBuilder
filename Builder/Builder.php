<?php

namespace CodeBuilder\Builder;

use CodeBuilder\Exception;
use CodeBuilder\Annotations\PHPDoc;
use CodeBuilder\Annotations\Comment;
use CodeBuilder\Classes\BuilderClass;
use CodeBuilder\Classes\BuilderTrait;
use CodeBuilder\Classes\BuilderMethod;
use CodeBuilder\Annotations\Annotation;
use CodeBuilder\Classes\BuilderNamespace;
use CodeBuilder\ControlStructure\StatementBlock;

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
class Builder
{
    /**
     * @var array
     */
    private $code = array();

    public function __construct(array $arrayCode)
    {
        return $this->categorizeProperty($arrayCode);
    }

    /**
     * [setPath description].
     */
    public function setPath()
    {
    }

    /**
     * @param array $content
     *
     * @return string
     */
    public function categorizeProperty($content)
    {
        $everything = [];
        foreach ($content as $key => $value) {
            switch ($key) {
                case 'class':
                    $everything .= $this->classInterpreter($value);
                    break;
                case 'method':
                    //$everything .= $this->methodInterpreter($value);
                    break;
                case 'object':
                    //$everything .= $this->objectInterpreter($value);
                    break;
                case 'variable':
                    //$everything .= $this->variableInterpreter($value);
                    break;
            }
        }
        //throw new \Exception(print_r([$everything], true));
        return $everything;
    }

    /**
     * [classInterpreter description].
     *
     * @param array $data [description]
     *
     * @return [type] [description]
     */
    public function classInterpreter($data)
    {
        $_class = new BuilderClass($data['name']);
        //$_class->addComment($this->getGeneralComment());

        if (isset($data['traits'])) {
            if (is_array($data['traits'])) {
                foreach ($data['traits'] as $item) {
                    $_class->add(new BuilderTrait($item));
                }
            }
        }

        if (isset($data['extends'])) {
            $_class->addExtends($data['extends']);
        }

        if (isset($data['implements'])) {
            if (is_array($data['implements'])) {
                foreach ($data['traits'] as $item) {
                    $_class->addImplements($item);
                }
            } else {
            }
        }

        if (isset($data['namespaces'])) {
            if (is_array($data['namespaces'])) {
                $i = 0;
                $namespaces = null;
                foreach ($data['namespaces'] as $item) {
                    if ($i == 0) {
                        $namespaces = new BuilderNamespace($item);
                    } else {
                        $namespaces->add($item);
                    }
                    ++$i;
                }
                $_class->add($namespaces);
            } else {
                throw new Exception('Namespaces key in class should have at less the base namespace.');
            }
        }

        if (isset($data['content'])) {
            if (is_array($data['content'])) {
                $_class->add(
                    $this->categorizeProperty($data['content'])
                );
            } else {
                throw new Exception('Content class should be array');
            }
        }
        $st = new StatementBlock($_class);

        return $st->build();
    }

    /**
     * @return [type] [description]
     */
    public function methodInterpreter(array $data)
    {
        $_method = new BuilderMethod($data['name']);

        if (isset($data['visibility'])) {
            $visibility = strtolower($data['visibility']);
            if ($visibility == 'public' or $visibility == 'private' or $visibility == 'protected') {
                $_method->addVisibility($data['visibility']);
            } else {
                throw new Exception('Visibility is wrong');
            }
        }

        if (isset($data['comment'])) {
            $_method->addComment(
                $this->commentInterpreter($data['comment'])
            );
        }

        if (isset($data['content'])) {
            if (is_array($data['content'])) {
                $_method->add($this->categorizeProperty($data['content']));
            }
        }

        $st = new StatementBlock($_method);

        return $st->build();
    }

    /**
     * [commentInterpreter description].
     *
     * @param array $comment [description]
     *
     * @return [type] [description]
     */
    public function commentInterpreter(array $comment)
    {
        $comment = new Comment();
        if (is_array($data['comment']['message'])) {
            foreach ($data['comment']['message'] as $message) {
                $comment->add($message);
            }
        } else {
            throw new Exception("Comment['message'] : should be array and each item an string");
        }

        if (is_array($data['comment']['phpdoc'])) {
            foreach ($data['comment']['phpdoc'] as $phpdoc) {
                if (is_array($phpdoc)) {
                    foreach ($phpdoc as $phpDocName => $itemPhpdoc) {
                        if (is_array($itemPhpdoc)) {
                            if (array_key_exists('type', $itemPhpdoc)) {
                                $comment->add(
                                    new PHPDoc($phpDocName, $itemPhpdoc['type'])
                                );
                            }
                            if (array_key_exists('type', $itemPhpdoc) and array_key_exists('variable', $itemPhpdoc)) {
                                $comment->add(
                                    new PHPDoc($phpDocName, $itemPhpdoc['type'], $itemPhpdoc['variable'])
                                );
                            }
                            if (array_key_exists('type', $itemPhpdoc) and
                                array_key_exists('variable', $itemPhpdoc) and
                                array_key_exists('description', $itemPhpdoc)) {
                                $comment->add(
                                    new PHPDoc(
                                        $phpDocName,
                                        $itemPhpdoc['type'],
                                        $itemPhpdoc['variable'],
                                        $itemPhpdoc['description']
                                    )
                                );
                            }
                        }
                        if (is_string($phpDocName) and is_string($itemPhpdoc)) {
                            $comment->add(
                                new PHPDoc($phpDocName, $itemPhpdoc)
                            );
                        } else {
                            $comment->add(
                                new PHPDoc($phpDocName)
                            );
                        }
                    }
                } else {
                    throw new Exception('PHPDoc item should be array');
                }
            }
        } else {
            throw new Exception("Comment['phpdocs'] should be array");
        }

        if (is_array($data['comment']['annotation'])) {
            foreach ($data['comment']['annotation'] as $kAnnotation => $vAnnotation) {
                if (is_int($kAnnotation) and is_string($vAnnotation)) {
                    $comment->add(new Annotation($vAnnotation));
                } elseif (is_string($kAnnotation) and is_array($vAnnotation)) {
                    $annotation = new Annotation($kAnnotation);
                    foreach ($vAnnotation as $kAnnComponent => $vAnnComponent) {
                        switch ($kAnnComponent) {
                            case 'symbol':
                                $annotation->setSymbol($vAnnComponent);
                                break;
                            case 'attributes':
                                if (is_array($vAnnComponent)) {
                                    foreach ($vAnnComponent as $kAttr => $vAttr) {
                                        if (is_int($kAttr) and is_string($vAttr)) {
                                            $annotation->addAttribute($vAttr);
                                        } elseif (is_string($kAttr) and is_string($vAttr)) {
                                            $annotation->addAttribute($kAttr, $vAttr);
                                        } elseif (is_string($kAttr) and is_array($vAttr)) {
                                            $annotation->addAttribute($vAttr[0], $vAttr[1], $vAttr[2]);
                                        }
                                    }
                                } else {
                                    throw new Exception('Attributes for annotation class are not array');
                                }
                                break;
                        }
                    }
                }
                $comment->add($annotation);
            }
        } else {
            throw new Exception("Comment['message'] : should be array and each item an string");
        }

        return $comment->build();
    }

    /**
     * [variableInterpreter description].
     *
     * @return [type] [description]
     */
    public function variableInterpreter()
    {
    }

    /**
     * [objectInterpreter description].
     *
     * @return [type] [description]
     */
    public function objectInterpreter()
    {
    }
}

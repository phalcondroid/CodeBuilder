<?php

namespace CodeBuilder\Reader;

use CodeBuilder\Expressions\Binary;
use CodeBuilder\Annotations\PHPDocs;
use CodeBuilder\Classes\ClassMethod;
use CodeBuilder\Annotations\Comment;
use CodeBuilder\Expressions\Variable;
use CodeBuilder\Classes\AttributeCall;
use CodeBuilder\Classes\ClassAttribute;
use CodeBuilder\Classes\ClassComponent;
use CodeBuilder\Classes\ClassNamespace;
use CodeBuilder\Statements\StatementBlock;
use CodeBuilder\Statements\ReturnStatement;
use CodeBuilder\Expressions\Operators\Comparison;
use PhpParser\Node\Name;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use PhpParser\Node\Expr\ClassConstFetch;

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
class Factory
{
    const SETTER = 1;

    const GETTER = 2;

    /**
     * @var array
     */
    private $syntaxTree;

    /**
     * @var [type]
     */
    private $classObj;

    private $usesObj;

    private $types = array();

    public function __construct(array $syntaxTree)
    {
        $this->syntaxTree = $syntaxTree;
    }

    /**
     * Add attribute.
     *
     * @param string $attr
     * @param array  $comment
     */
    public function addAttr($attr, $comment = array())
    {
        $this->syntaxTree['attr'] = array(
            'exprs' => array(
                'private',
                $attr,
            ),
            'comment' => array(),
         );
    }

    /**
     * Analize tree class structure.
     *
     * @return ClassComponent
     */
    private function treeAnalizer()
    {
        $clsComponent = $this->classFactory($this->syntaxTree['class']['class']);
        $ns = new ClassNamespace(rtrim($this->syntaxTree['namespace']['namespace'], ';'));

        if (isset($this->syntaxTree['namespace']['comment'])) {
            $ns->add(
                $this->commentAnalizer($this->syntaxTree['namespace']['comment'])
            );
        }

        if (isset($this->syntaxTree['use'])) {
            foreach ($this->syntaxTree['use'] as $uses) {
                if (!empty($uses)) {
                    $ns->add(rtrim($uses['use'], ';'));
                }
            }
        }

        if (isset($this->syntaxTree['class']['comment'])) {
            $clsComponent->add(
                $this->commentAnalizer($this->syntaxTree['class']['comment'])
            );
        }
        $clsComponent->add($ns);

        $attrMethod = array();
        foreach ($this->syntaxTree['attr'] as $item) {
            $attrName = str_replace('$', '', str_replace(';', '', $item['exprs'][1]));
            $attrMethod[] = $attrName;

            $attribute = new ClassAttribute(new Variable($attrName));
            if (isset($item['comment'])) {
                $attribute->add(
                    $this->commentAnalizer($item['comment'])
                );
            }

            $clsComponent->add(
                $attribute
            );
        }

        foreach ($attrMethod as $attr) {
            $clsComponent->add($this->createSetterByAttr($attr));
            $clsComponent->add($this->createGetterByAttr($attr));
        }

        return $clsComponent;
    }

    /**
     * Class factory of ClassComponent.
     *
     * @param array $classArray
     *
     * @return ClassComponent
     */
    private function classFactory(array $classArray)
    {
        $cls = new ClassComponent($classArray[1]);

        if (in_array('implements', $classArray)) {
            $key = array_search('implements', $classArray);
            $cls->addImplements($classArray[$key + 1]);
        }

        if (in_array('extends', $classArray)) {
            $key = array_search('extends', $classArray);
            $cls->addExtends($classArray[$key + 1]);
        }

        return $cls;
    }

    /**
     * Comment analizer.
     *
     * @param array $commentArr
     *
     * @return Comment
     */
    private function commentAnalizer(array $commentArr)
    {
        $commentArr = array_filter($commentArr, function ($item) {
            return $item != '/**';
        });

        $commentArr = array_filter($commentArr, function ($item) {
            return $item != '*/';
        });

        $comment = new Comment();
        foreach ($commentArr as $item) {
            $rowMsj = $this->filterCommentItem($item);
            if (!empty($rowMsj)) {
                $comment->add($rowMsj);
            }
        }

        return $comment;
    }

    /**
     * Filter comments of item.
     *
     * @param string $str
     *
     * @return string
     */
    private function filterCommentItem($str)
    {
        $str = str_replace('*', '', $str);

        return trim($str);
    }

    /**
     * Create setter by attribute.
     *
     * @param string $attr
     *
     * @return StatementBlock
     */
    public function createSetterByAttr($attr)
    {
        $method = new ClassMethod('set'.ucfirst(str_replace('_', '', $attr)));
        $method->add($this->getGenericMethodComment($attr, self::SETTER));
        $varValue = new Variable('value');
        $method->addParams(array(
            $varValue,
        ));

        //Content attribute for method $this->value = $value;
        $assignment = new AttributeCall($attr);
        $binExpr = new Binary($assignment, Comparison::SET, $varValue);
        $binExpr->setSemicolon();
        $method->add($binExpr);

        //statement block set block -> {}
        $st = new StatementBlock($method);

        return $st;
    }

    /**
     * Create getter by attribute.
     *
     * @param string $attr
     *
     * @return StatementBlock
     */
    public function createGetterByAttr($attr)
    {
        $method = new ClassMethod('get'.ucfirst(str_replace('_', '', $attr)));
        $method->add($this->getGenericMethodComment($attr, self::GETTER));
        $method->add(new ReturnStatement(new AttributeCall($attr)));
        $st = new StatementBlock($method);

        return $st;
    }

    /**
     * Get generic method comment.
     *
     * @param string $attr
     * @param int    $setOrGet
     *
     * @return Comment
     */
    public function getGenericMethodComment($attr, $setOrGet)
    {
        $comment = new Comment();
        $comment->add("$setOrGet action for \$this->$attr attribute");
        $comment->add('Powered by Code Builder for php tool code generator');

        if ($setOrGet == 1) {
            $comment->add(new PHPDocs(PHPDocs::_PARAM, 'String', new Variable('value')));
        } elseif ($setOrGet == 2) {
            $comment->add(new PHPDocs(PHPDocs::_RETURN, 'String'));
        }

        return $comment;
    }

    /**
     * Analize tree class structure.
     *
     * @return ClassComponent
     */
    public function getClassComponent()
    {
        return $this->treeAnalizer();
    }

    public function editSchema($path, $attr, $method, $value)
    {
        $nikiParser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $stmts = $nikiParser->parse(file_get_contents($path, FILE_USE_INCLUDE_PATH));

        foreach ($stmts as &$item) {
            $this->setTreeToIterate($item, $attr, $method, $value);
        }

        $prettyPrinter = new Standard();
        $code = $prettyPrinter->prettyPrint($stmts);

        $psr = new \CodeBuilder\Utils\PsrAnalizer($code);

        file_put_contents($path, '<?php'.PHP_EOL.$psr->get().PHP_EOL);
    }

    /**
     * @return ClassNamespace
     */
    public function setTreeToIterate(&$tree, $attr, $method, $value)
    {
        $this->readTreeArray($tree, function ($key, &$item) use ($attr, $method, $value) {
            if ($key == 'stmts') {
                $this->changeInitialize($item, $attr, $method, $value);
            }
        });
    }

    /**
     * @param  $stmts
     *
     * @return array
     */
    public function changeInitialize(&$stmts, $attr, $method, $value)
    {
        $this->changeProperties($stmts, $method, $attr, $value);
    }

    /**
     * @param [type] $stmts  [description]
     * @param [type] $method [description]
     * @param [type] $attr   [description]
     * @param [type] $value  [description]
     *
     * @return [type] [description]
     */
    public function changeProperties(&$stmts, $method, $attr, $value)
    {
        foreach ($stmts as $key => &$item) {
            if ($item instanceof \PhpParser\Node\Stmt\ClassMethod) {
                $this->analizeProperties($item, $method, $attr, $value);
            }
        }
    }

    /**
     * @return [type] [description]
     */
    public function analizeProperties(&$item, $method, $attr, $value)
    {
        foreach ($item->stmts as $key => &$methodContent) {
            if ($methodContent instanceof \PhpParser\Node\Expr\Assign) {
                $this->analizeMethods($item, $methodContent, $method, $attr, $value);
            }
        }
    }

    /**
     * [analizeMethods description].
     *
     * @return [type] [description]
     */
    public function analizeMethods(&$item, $methodContent, $method, $attr, $value)
    {
        $name = '';
        foreach ($methodContent as $key2 => $itemMethods) {
            if ($itemMethods instanceof \PhpParser\Node\Expr\MethodCall) {
                $mName = $itemMethods->name;
                if (is_array($itemMethods->args) and count($itemMethods->args) > 0) {
                    $mValue = $itemMethods->args[0]->value->value;
                    if ($mName == 'getItem' and $mValue == $attr) {
                        $name = $methodContent->var->name;
                        $this->editAttributes($item, $method, $attr, $value, $name);
                    }
                }
            }
        }
    }

    /**
     * @return [type] [description]
     */
    public function editAttributes(&$item, $method, $attr, $value, $name)
    {
        foreach ($item->stmts as $key => &$methodContent2) {
            if ($methodContent2 instanceof \PhpParser\Node\Expr\MethodCall) {
                $varName = $methodContent2->var->name;
                $nMethod = $methodContent2->name;

                if ($nMethod == $method and $varName == $name) {
                    $changed = false;
                    $valueDos = '';

                    switch ($nMethod) {
                        case 'setLabel':
                                $methodContent2->args[0]->value = new StringLiteral_($value);
                            break;
                        case 'setType':
                                $valueDos = new ClassConstFetch(
                                    new Name('\\\Data\\Types\\'.$value),
                                    'class'
                                );
                                $methodContent2->args[0]->value = $valueDos;
                            break;
                    }
                }
            }
        }
    }

    /**
     * @return [type] [description]
     */
    public function readTreeArray(&$tree, $func)
    {
        $result = null;
        foreach ($tree->stmts as &$item) {
            foreach ($item as $key => &$classItem) {
                $resFunc = $func($key, $classItem);
                if ($resFunc) {
                    $result = $resFunc;
                }
            }
        }

        return $result;
    }
}

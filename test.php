<?php

//Define autoloader
spl_autoload_register(function ($classPath) {
    include dirname(__DIR__) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

use CodeBuilder\Classes\Tags;
use CodeBuilder\Annotations\Comment;
use CodeBuilder\Annotations\PHPDocs;
use CodeBuilder\Classes\ClassMethod;
use CodeBuilder\Expressions\Variable;
use CodeBuilder\Classes\ClassComponent;
use CodeBuilder\Statements\StatementBlock;

$comment = new Comment("This is a comment for class method");
$comment->add(new PHPDocs(
    DOCS_API,
    "string",
    new Variable("comemntParam")
));

$method  = new ClassMethod("methodoDeClase");
$method->add($comment);

$classes = new ClassComponent("ClassName");
$classes->add(new StatementBlock($method));
$tag = new Tags($classes);

file_put_contents("arvhico.php", $tag->resolve());
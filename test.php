<?php

//Define autoloader
spl_autoload_register(function ($classPath) {
    include dirname(__DIR__) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

use CodeBuilder\Classes;
use CodeBuilder\Statements;
use CodeBuilder\Expressions;
use CodeBuilder\Annotations;

// You can create the last dependencias at beggining, for example a comment of class method.
$comment = new Comment("This is a comment for class method");
$comment->add(new PHPDocs(
    DOCS_API,
    "string",
    new Variable("comemntParam")
));

// This is the class method.
$method  = new ClassMethod("methodoDeClase");
$method->add($comment);

// The class with a Statementblock, that means a { } curly braces when the code is included.
$classes = new ClassComponent("ClassName");
$classes->add(new StatementBlock($method));

// Finally the php tags.
$tag = new Tags($classes);

file_put_contents("arvhico.php", $tag->resolve());
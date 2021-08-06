<?php

//Define autoloader
spl_autoload_register(function ($classPath) {
    include dirname(dirname(__DIR__)) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

use CodeBuilder\Classes;
use CodeBuilder\Statements;
use CodeBuilder\Expressions;
use CodeBuilder\Annotations;

// You can create the last dependencias at beggining, for example a comment of class method.
$comment = new Annotations\Comment("This is a comment for class method");
$comment->add(new Annotations\PHPDocs(
    DOCS_PARAM,
    "string",
    new Expressions\Variable("comemntParam")
));

// This is the class method.
$method  = new Classes\ClassMethod("methodoDeClase");
$method->add($comment);

// The class with a Statementblock, that means a { } curly braces when the code is included.
$classes = new Classes\ClassComponent("ClassName");
$classes->add(new Statements\StatementBlock($method));

// Finally the php tags.
$tag = new Classes\Tags($classes);

file_put_contents("outputs/class.output.php", $tag->resolve());

echo "File was created successfully!";
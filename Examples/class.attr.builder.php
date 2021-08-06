<?php

//Define autoloader
spl_autoload_register(function ($classPath) {
    include dirname(dirname(__DIR__)) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

//Define autoloader
use CodeBuilder\Classes;
use CodeBuilder\Annotations;
use CodeBuilder\Expressions;

// Comment for attribute.
$comment = new Annotations\Comment("This is a comment for a class attribute.");
$comment->add(new Annotations\PHPDocs(
    DOCS_VAR,
    "string",
    new Expressions\Variable("attr")
));

// Creates an attribute object.
$attr = new Classes\ClassAttribute(
    new Expressions\Variable("attributeClass")
);
$attr->addVisibility("protected");
$attr->add($comment);

// The class with a Statementblock, that means a { } curly braces when the code is included.
$classes = new Classes\ClassComponent("ClassName");
$classes->add($attr);

// Finally the php tags.
$tag = new Classes\Tags($classes);

file_put_contents("outputs/class.attr.output.php", $tag->resolve());

echo "File was created successfully!";
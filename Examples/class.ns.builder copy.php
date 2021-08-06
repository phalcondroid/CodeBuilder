<?php

//Define autoloader
spl_autoload_register(function ($classPath) {
    include dirname(dirname(__DIR__)) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

//Define autoloader
use CodeBuilder\Classes;
use CodeBuilder\Annotations;
use CodeBuilder\Expressions;

// Comment for ns.
$comment = new Annotations\Comment("This is a comment for a namespace class.");
$comment->add(new Annotations\PHPDocs(
    DOCS_AUTHOR,
    "",
    "phalcondroid"
));

// Creates an ns object.
$ns = new Classes\ClassNamespace("BaseNamespace\Created\FromPHP");
$ns->add($comment);
$ns->add("\BaseNamespace\Test");

// Class receives an ns builded.
$classes = new Classes\ClassComponent("ClassName");
$classes->add($ns);

// Finally the php tags.
$tag = new Classes\Tags($classes);

file_put_contents("outputs/class.ns.output.php", $tag->resolve());

echo "File was created successfully!";
<?php

//Define autoloader
spl_autoload_register(function ($classPath) {
    include dirname(dirname(__DIR__)) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

//Define autoloader
use CodeBuilder\Classes;

// Creates an ns object.
$ns = new Classes\ClassTrait("BaseTrait\Created\FromPHP");
$ns->add("\BaseTrait\Test");

// Class receives an ns builded.
$classes = new Classes\ClassComponent("ClassName");
$classes->add($ns);

// Finally the php tags.
$tag = new Classes\Tags($classes);

file_put_contents("outputs/class.trait.output.php", $tag->resolve());

echo "File was created successfully!";
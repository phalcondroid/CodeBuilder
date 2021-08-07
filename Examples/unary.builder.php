<?php

spl_autoload_register(function ($classPath) {
    include dirname(dirname(__DIR__)) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

use CodeBuilder\Expressions\Unary;
use CodeBuilder\Expressions\Variable;

$name = new Unary(new Variable("name"), ";");
$name->resolve() . PHP_EOL;

file_put_contents("outputs/unary.output.php", $name->resolve() . PHP_EOL, FILE_APPEND);

echo "File was created successfully!";
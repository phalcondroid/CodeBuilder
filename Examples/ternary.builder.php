<?php

spl_autoload_register(function ($classPath) {
    include dirname(dirname(__DIR__)) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

use CodeBuilder\Expressions\Unary;
use CodeBuilder\Expressions\Ternary;
use CodeBuilder\Expressions\Variable;
use CodeBuilder\Expressions\Literals\StringLiteral;

$ternary = new Ternary(
    new Unary(
        "!",
        new Variable("name")
    ),
    new Variable("name"),
    new StringLiteral("")
);

file_put_contents("outputs/ternary.output.php", $ternary->resolve() . PHP_EOL);

echo "File was created successfully!";
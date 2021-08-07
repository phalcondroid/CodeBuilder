<?php

spl_autoload_register(function ($classPath) {
    include dirname(dirname(__DIR__)) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

use CodeBuilder\Expressions\Binary;
use CodeBuilder\Expressions\Variable;
use CodeBuilder\Expressions\Literals\StringLiteral;

$expression = new Binary(
    new Variable("name"),
    "=",
    new StringLiteral("text!!!")
);

file_put_contents("outputs/binary.output.php", $expression->resolve() . PHP_EOL);

echo "File was created successfully!";
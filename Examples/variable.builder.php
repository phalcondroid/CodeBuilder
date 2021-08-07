<?php

spl_autoload_register(function ($classPath) {
    include dirname(dirname(__DIR__)) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

use CodeBuilder\Expressions\Variable;
$var = new Variable("var");
// output #1
echo $var->resolve() . PHP_EOL;
file_put_contents("outputs/variable.output.php", $var->resolve() . PHP_EOL);

// becomes in array variable
use CodeBuilder\Expressions\Literals\StringLiteral;
$var = new Variable("var");
// becomes in array variable
$var->asArray(new StringLiteral("assoc_index"));
file_put_contents("outputs/variable.output.php", $var->resolve() . PHP_EOL, FILE_APPEND);

echo "File was created successfully!";
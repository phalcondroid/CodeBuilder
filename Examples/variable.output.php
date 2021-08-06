<?php

spl_autoload_register(function ($classPath) {
    include dirname(dirname(__DIR__)) . "/" . str_replace("\\", "/", $classPath) . '.php';
});

use CodeBuilder\Expressions\Variable;
$var = new Variable("var");
// output #1
echo $var->resolve();

// becomes in array variable
use CodeBuilder\Expressions\Literals\StringLiteral;
$var = new Variable("var");
// becomes in array variable
$var->asArray(new StringLiteral("assoc_index"));
echo $var->resolve();

file_put_contents("outputs/variable.output.php", $tag->resolve());

echo "File was created successfully!";
# CodeBuilder

Codebuilder is a tool for php that allows you generate any files with any php code, you could create some files like a classes,
methods, functions, variables, Method calls, function calls, static methods and vars, etc..

## You can build php code througth php code with something like this.
```php

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

```

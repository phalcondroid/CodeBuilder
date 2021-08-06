# CodeBuilder

Codebuilder is a tool for php that allows you generate any files with any php code, you could create some files like a classes,
methods, functions, variables, Method calls, function calls, static methods and vars, etc..

## You can build php code througth php code with something like this.
```php

// import the namespaces that you have to use.
use CodeBuilder\Classes\Tags;
use CodeBuilder\Annotations\Comment;
use CodeBuilder\Annotations\PHPDocs;
use CodeBuilder\Classes\ClassMethod;
use CodeBuilder\Expressions\Variable;
use CodeBuilder\Classes\ClassComponent;
use CodeBuilder\Statements\StatementBlock;

// You can create the last dependencias at beggining, for example a comment of class method.
$comment = new Comment("This is a comment for class method");
$comment->add(new PHPDocs(
    DOCS_API,
    "string",
    new Variable("comemntParam")
));

// This is the class method.
$method  = new ClassMethod("methodoDeClase");
$method->add($comment);

// The class with a Statementblock, that means a { } curly braces when the code is included.
$classes = new ClassComponent("ClassName");
$classes->add(new StatementBlock($method));

// Finally the php tags.
$tag = new Tags($classes);

// Export or created the file with php code output.
file_put_contents("createdCode.php", $tag->resolve());

```

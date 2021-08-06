# CodeBuilder for PHP
Codebuilder is a php tool for generates php code, you can create any type of file that you need.

## You can build php code througth php code with something like this.

#### Including imports

```php
use CodeBuilder\Classes;
use CodeBuilder\Statements;
use CodeBuilder\Expressions;
use CodeBuilder\Annotations;
```

#### Defining a comment.
```php
// You can create php code with php through the CodeBuilder toolkit.
$comment = new Annotations\Comment("This is a comment for a class method");
$comment->add(new Annotations\PHPDocs(
    DOCS_PARAM,
    "string",
    new Expressions\Variable("comemntParam")
));
```

#### Defining a class method.
```php
// This is the class method.
$method  = new Classes\ClassMethod("methodForAClass");
$method->add($comment);
```

#### Defining a class and php tag.
```php
// The class with a Statementblock, that means a { } curly braces when the code is included.
$classes = new Classes\ClassComponent("ClassName");
$classes->add(new Statements\StatementBlock($method));

// Finally the php tags.
$tag = new Classes\Tags($classes);

```

## Output
`Examples/class.builder.php` -> `Examples/outputs/class.output.php`
```php
<?php

class ClassName
{
    /**
     * This is a comment for class method
     *
     * @param string $comemntParam
     */
    public function methodForAClass()
    {
    }
}

```

## Documentation

#### Classes

`CodeBuilder\Classes\ClassComponent`

This class creates a class struct in php receives in construct a string with the name of class to be created.

###### Constructor

`ClassComponent($className: String)`

#### Methods

Methods available in the ClassComponent

###### Getters

- `getClass()`
    * returns a string name class `ClassName::class`
- `getName()`
    * returns a class name assigned.

###### Setters

- `addExtends($name: String)`
    * Receives a string extends name, basically the class name where extending.
- `addImplements($name: String)`
    * Receives a string implements name, basically the interface name that you wants to implement.
- `add($component: Base)`
    * Receives a component object compatible with class creation component.

###### Inyectable classes to `ClassComponent`

- `ClassAttribute` this class extends from Variable and creates a attribute property in the class.
    







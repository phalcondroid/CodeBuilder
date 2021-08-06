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

#### Attribute Class for ClassComponent

- `ClassAttribute` this class receive a Variable object and creates an attribute property in the class.

###### Constructor

`ClassAttribute($className: Expression\Variable)`

#### Methods

Methods available in the ClassComponent

###### Getters

- `getName()`
    * returns a string name assigned.

###### Setters

- `addVisibility($attrVisibility: String)`
    * Receives a string with visibility option, default `public`.
    
Example in `CodeBuilder/Examples/class.attr.builder.php`

```php
use CodeBuilder\Classes;
use CodeBuilder\Annotations;
use CodeBuilder\Expressions;

// Comment for attribute.
$comment = new Annotations\Comment("This is a comment for a class method");
$comment->add(new Annotations\PHPDocs(
    DOCS_PARAM,
    "string",
    new Expressions\Variable("comemntParam")
));

// Creates an attribute object.
$attr = new Classes\ClassAttribute(
    new Expressions\Variable("attributeClass")
);
$attr->addVisibility("protected");
$attr->add($comment);

// The class with a Statementblock, that means a { } curly braces when the code is included.
$classes = new Classes\ClassComponent("ClassName");
$classes->add($attr);

// Finally the php tags.
$tag = new Classes\Tags($classes);

file_put_contents("outputs/class.attr.output.php", $tag->resolve());

echo "File was created successfully!";
```

#### Output

```php
<?php

class ClassName
{

    /**
     * This is a comment for a class attribute.
     *
     * @var string $attr
     */
    protected $attributeClass;
}
```
    







# CodeBuilder for PHP

Codebuilder is a php tool to generates php code, you can create any php code that you need.

## Building a class easy.

You can build php code througth php code with something like this.

#### How to define a comment.
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

#### Defining a class.
```php
// The class with a Statementblock, that means a { } curly braces when the code is included.
$classes = new Classes\ClassComponent("ClassName");
$classes->add(new Statements\StatementBlock($method));
```

#### Defining a class.
```php
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

### Creating Class Components

```php
CodeBuilder\Classes\ClassComponent
```

This class creates a class struct in php receives in construct a string with the name of class to be created.

#### Constructor

```php
ClassComponent($className: String)
```

#### Methods

Methods available in the ClassComponent

#### Getters

- `->getClass() `
    * returns a string name class `ClassName::class`
- `->getName() `
    * returns a class name assigned.

#### Setters

- `addExtends($name: String)`
    * Receives a string extends name, basically the class name where extending.
- `addImplements($name: String)`
    * Receives a string implements name, basically the interface name that you wants to implement.
- `add($component: Base)`
    * Receives a component object compatible with class creation component.



### Attribute Class for ClassComponent

```php
CodeBuilder\Classes\ClassAttribute
```

This class receive a Variable object and creates an attribute property in the class.

#### Constructor

```php
ClassAttribute($className: Expression\Variable)
```

#### Methods

Methods available in the ClassComponent

#### Getters

- `getName()`
    * returns a string name assigned.

#### Setters

- `addVisibility($attrVisibility: String)`
    * Receives a string with visibility option, default `public`.

Example in `CodeBuilder/Examples/class.attr.builder.php`

### Creates an Attribute
```php
// Creates an attribute object.
$attr = new Classes\ClassAttribute(
    new Expressions\Variable("attributeClass")
);
$attr->addVisibility("protected");
$attr->add($comment);
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


### Namespaces for a class component

```php
CodeBuilder\Classes\ClassNamespace
```

This class receive a class namespace as string.

`namespace \Example;`

#### Constructor

```php
ClassNamespace($namespace: String)
```

#### Methods

Methods available in the ClassNamespace

#### Setters

- `add($ns: String|Base)`
    * You can add a comment for the base namespace additionally.
    * The next additions in the add method becomes in a `use` for the class.

Example in `CodeBuilder/Examples/class.ns.builder.php`

```php
// Creates an ns object.
$ns = new Classes\ClassNamespace("BaseNamespace\Created\FromPHP");
$ns->add("\BaseNamespace\Test");
$ns->add("\BaseNamespace\Test2");
```
    
## Output

```php
<?php

/**
 * This is a comment for a namespace class.
 *
 * @author phalcondroid
 */
namespace BaseNamespace\Created\FromPHP;

use \BaseNamespace\Test;
use \BaseNamespace\Test2;

class ClassName
{
}
```


### Use traits in class component

```php
CodeBuilder\Classes\ClassTrait
```

This class receive a use trait as string.

`use \Example\Trait;`

#### Constructor

```php
ClassTrait($trait: String)
```

#### Methods

Methods available in the ClassTrait

#### Setters

- `add($trait: String)`
    * These additions in the add method becomes in a `use` for the class.

Example in `CodeBuilder/Examples/class.trait.builder.php`

```php
// Creates an trait object.
$ns = new Classes\ClassTrait("BaseTrait\Created\FromPHP");
$ns->add("\BaseTrait\Test");
```

## Output

```php
<?php

class ClassName
{
    use BaseTrait\Created\FromPHP, \BaseTrait\Test;
}
```






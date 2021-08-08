# CodeBuilder for PHP

Codebuilder is a php tool to generates php code, you can create any php code that you need.

## Quick sample

You can build php code througth php classes using something like this.

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

#### Defining a php tag <?php.
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

# Table of Contents
1. [Intro](#Intro)
2. [Expressions](#Expressions)
    * [Creating a variable](#Creating-a-variable)
    * [Understanding expression types](#Understanding-expression-types)
        - [Unary expression](#Unary-expression)
        - [Binary expression](#Binary-expression)
        - [Ternary expression](#Ternary-expression)
    * [Operator types](#Operator-types)
        - [Arithmetic](#Arithmetic)
        - [Combined](#Combined)
        - [Comparison](#Comparison)
        - [Decrement](#Decrement)
        - [Increment](#Increment)
        - [Logical](#Logical)
    * [Literals](#Literals)
        - [String](#String)
        - [Integer](#Integer)
        - [Boolean](#Boolean)
        - [Double](#Double)
        - [Constant](#Constant)
        - [Char](#Char)
        - [Object](#Object)
        - [Array](#Array)
3. [Grouping expressions](#Grouping-expressions)
    - [Brackets](#Brackets)
    - [Parenthesis](#Parenthesis)
    - [Square brackets](#Square-brackets)
4. [Statements](#Statements)
    - [Statement block](#Statement-block)
    - [If](#If-statement)
    - [Else](#else)
    - [Else if](#Else-if)
    - [Switch case](#Switch-case)
    - [Return](#Return)
    - [Throw](#Throw)
    - [For](#For)
    - [ForEach](#ForEach)
    - [While](#While)
    - [Break](#Break)
    - [TryCatch](#TryCatch)
5. [Statics](#Statics)
    - [Static](#Static)
    - [Static call](#Static-call)
6. [Structural functions](#Structural-functions)
    - [Calling a global function](#Calling-a-global-function)
7. [Creating classes](#Creating-classes)
    - [Creating a class](#Creating-a-class)
    - [Namespaces](#Namespaces)
    - [Calling traits](#Calling-traits)
    - [Attributes](#Class-attribute)
    - [Attribute call](#Attribute-call)
    - [Methods](#Methods)
    - [Calling methods](#Calling-methods)
8. [Comments & Annotations](#Comments-&-Annotations)
    - [Comment](#Comment)
    - [PHPDocs](#PHPDocs)
    - [Annotation](#Annotation)
9. [TODO](#TODO)

## Intro

CodeBuilder is a builder from php to creates php code with separated class helpers.

## Expressions

Expressions works to grouping classes, objects and anything following a precedence rules.

#### Creating a variable

We are going to start with a variable creation, this is the most simple component to represent a value.

###### Variable namespace
`use CodeBuilder\Expressions\Variable`

###### Functionalities

|  Method | Params |
|---|---|
| asArray| ($index: Base) |

###### Example #1

```php
$var = new Variable("var");
echo $var->resolve();
```

###### Output
```php
$var
```

###### Example #2
```php
// becomes in array variable
$var = new Variable("var");
$var->asArray(new CodeBuilder\Expressions\Literals\StringLiteral("assoc_index"));
echo $var->resolve();
```

###### Output
```php
$var["assoc_index"]
```

## Understanding expression types

There are several types of expressions when we want grouping the language components, something like unary that means 2 components.

### Unary expression

Is a group of two types of components.

`use CodeBuilder\Expressions\Unary`

```php
$expression = new Unary(
    new Variable("exp1"),
    ";"
);
echo $expression->resolve();
```

###### Output

```php
$name;
```

### Binary expression

Is a group of three types of components.

`use CodeBuilder\Expressions\Binary`

```php
$expression = new Binary(
    new Variable("name"),
    "=",
    new StringLiteral("text!!!");
);
echo $expression->resolve();
```

###### Output

```php
$name = "text!!!"
```

###### Combined
```php
$expression = new Unary(
    new Binary(
        new Variable("name"),
        "=",
        new StringLiteral("text!!!");
    ),
    ";"
);
echo $expression->resolve();
```

###### Output

```php
$name = "text!!!";
```

### Ternary expression

`use CodeBuilder\Expressions\Ternary;`

```php
$ternary = new Ternary(
    new Unary(
        "!",
        new Variable("name")
    ),
    new Variable("name"),
    new StringLiteral("")
);
echo $ternary->resolve();
```

###### Output
```php
!$name ? $name : ""
```

## Operator types

There are a lot of operator types, but we can intentify by types of them for example logic or arithmetic operators.

### Arithmetic

```php
class Arithmetic extends Operator
{
    const ADD = '+';
    const SUB = '-';
    const MULT = '*';
    const DIV = '/';
    const MOD = '%';
}
```

###### Example

```php
$bin = new Binary(
    new Variable("num1"),
    Arithmetic.ADD,
    new Unary(new Variable("num2"), ";")
);
echo $bin->resolve();
```

###### Output
```php
$num1 + $num2;
```

## Combine

```php
class Combined extends Operator
{
    const ADD = '+=';
    const SUB = '-=';
    const MUL = '*=';
    const DIV = '/=';
    const STR = '.=';
    const CONCAT = '.';
    const COMMA = ',';
}
```

###### Example

```php
$bin = new Binary(
    new Variable("num1"),
    Combined.ADD,
    new Unary(new Variable("num2"), ";")
);
echo $bin->resolve();
```

###### Output
```php
$num1 += $num2;
```

## Comparison

```php
class Comparison extends Operator
{
    const SET = '=';
    const ARRAY_ASSIGN = '=>';
    const EQUAL = '==';
    const LESS_THAN = '<';
    const NOT_EQUAL = '!=';
    const BLANK_SPACE = '=';
    const IDENTICAL = '===';
    const GREATER_THAN = '>';
    const STATIC_CLASS = '::';
    const NOT_IDENTICAL = '!==';
    const LESS_THAN_EQUAL = '<=';
    const GREATER_THAN_EQUAL = '>=';
    const _INSTANCEOF = 'instanceof';
}
```

###### Example

```php
$bin = new Binary(
    new Variable("num1"),
    Comparison._INSTANCEOF,
    new Unary(new Variable("num2"), ";")
);
echo $bin->resolve();
```

###### Output
```php
$num1 instanceof $num2;
```

## Increment

Just a ++ operator

```php
class Increment extends Operator
{
    const INCREMENT = '++';
    const PRE_INCREMENT = 'PRE_INC';
}
```

###### Example

```php
$bin = new Unary(new Variable("index"), Increment.INCREMENT);
echo $bin->resolve();
```

###### Output
```php
$index++
```

## Decrement

Just a -- operator

```php
class Decrement extends Operator
{
    const DECREMENT = '--';
    const PRE_DECREMENT = 'PRE_DEC';
}
```

###### Example

```php
$bin = new Unary(new Variable("index"), Decrement.DECREMENT);
echo $bin->resolve();
```

###### Output
```php
$index--
```

## Creating classes

This class creates a class struct in php receives in construct a string with the name of class to be created.

```php
CodeBuilder\Classes\ClassComponent
```

#### Constructor

```php
ClassComponent($className: String)
```

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

###### Example

```php
$method  = new Classes\ClassMethod("methodForAClass");
$method->add($comment);
$method->add(new Statements\ReturnStatement(
    new Expressions\Unary(
        new Literals\StringLiteral("Hi!!"),
        ";"
    ),
));

$classes = new Classes\ClassComponent("ClassName");
$classes->add(new Statements\StatementBlock($method));
echo $classes->resolve();
```

###### Output

```php
<?php

class ClassName
{
    public function methodForAClass()
    {
        return "Hi!!";;
    }
}
```

## Class attributes

```php
CodeBuilder\Classes\ClassAttribute
```

This class receive a Variable object and creates an attribute property in the class.

#### Constructor

```php
ClassAttribute($className: Expression\Variable)
```

#### Getters

- `getName()`
    * returns a string name assigned.

#### Setters

- `addVisibility($attrVisibility: String)`
    * Receives a string with visibility option, default `public`.

Example in `CodeBuilder/Examples/class.attr.builder.php`

### Creates an Attribute
```php
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
    protected $attributeClass;
}
```

## Namespaces

```php
CodeBuilder\Classes\ClassNamespace
```

This class receive a class namespace as string.

`namespace \Example;`

#### Constructor

```php
ClassNamespace($namespace: String)
```

#### Setters

- `add($ns: String|Base)`
    * You can add a comment for the base namespace additionally.
    * The next additions in the add method becomes in a `use` for the class.

###### Example

```php
$ns = new Classes\ClassNamespace("BaseNamespace\Created\FromPHP");
$ns->add("\BaseNamespace\Test");
$ns->add("\BaseNamespace\Test2");
```
    
###### Output

```php
<?php

namespace BaseNamespace\Created\FromPHP;

use \BaseNamespace\Test;
use \BaseNamespace\Test2;

class ClassName
{
}
```

## Traits

```php
CodeBuilder\Classes\ClassTrait
```

This class receive a use trait as string.

`use \Example\Trait;`

#### Constructor

```php
ClassTrait($trait: String)
```

#### Setters

- `add($trait: String)`
    * These additions in the add method becomes in a `use` for the class.

Example in `CodeBuilder/Examples/class.trait.builder.php`

```php
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






# Clear

### An ultralight PHP *non*-framework

## Core design philosophy

1. PHP's processors already have routers built in, stop writing routers in PHP.
2. PHP is already a templating language, stop using another one on top of it.
3. Stop auto-loading dozens or hundreds of unused files for every request.
4. Lets get back to the old days where adding a new page to our websites was as easy as creating ONE FILE.
	* You don't have to define a route for the new page!
	* You don't have to write a page controller if you don't want to!
	* You don't have to write a database model if you don't want to!
	* You don't even have to include `clear` if you don't want to!

## Clear::defaults

Function Signature: `Clear::defaults(array $input, array $defaults): array`

Returns a new array with only the specified values extracted from the given array. It will also fill in any allowed missing values and throw exceptions for required values. Can be used for validating user input forms.

```php
$model->insert(Clear::defaults($_POST, array(
	'name' => Clear::REQUIRED,
	'date' => Clear::NOTSET,
	'notes' => '',
)));
```

#### Constants

 Name         | Description
--------------|------------
NOTSET        | Skip the value if it's missing or empty.
OPTIONAL      | Skip the value if it's missing.
REQUIRED      | Throw an exception if the value is missing or empty,
ALLOWED_EMPTY | Throw an exception if the value is missing.

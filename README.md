# Clear

### A PHP *anti*-framework programming paradigm

Clear is a collection of functions and design philosophy for building web applications.

## Core design philosophy

1. PHP's servers already have routers built in, stop writing routers in PHP.
2. PHP is already a templating language, stop using another one on top of it.
3. Lets get back to the old days where adding a new page to our websites was as easy as creating ONE FILE.
	* You don't have to define a route for the new page!
	* You don't have to write a page controller if you don't want to!
	* You don't have to write a database model if you don't want to!
	* You don't even have to include `clear` if you don't want to!

See documentation [on the wiki](https://github.com/knickers/clear/wiki).

# Overview

Custom file extensions can be used as a naming convention, this offers some exciting benefits:
 * It's easy to spot which files perform what functions
 * The files are sorted in normal alphabetical order next to other related files
 * Web servers will only execute `.php` files dedicated for pages

Purpose    | Possible Extensions | Description
-----------|---------------------|------------
Page       |`.php`               | A web-accessible file that servers will recognize
Template   |`.pht` `.t` `.tpl` `.template`| Include-able template views for reusing components
Controller |`.phc` `.c` `.ctl` `.controller`| Controller code to validate and prepare variables
Model      |`.phm` `.m` `.mdl` `.model` | Class or functions for interacting with databases

Variables are available inside included files, so passing data around is easy. Declare a page name to be used in an included html head tag, or the controller can fetch data from the DB to be used in the main page.

Returning from an included file is like returning from a function, execution continues at the including file.

## Page

Create a normal `.php` file, web servers will execute the code and serve up the output just like usual. It can be in any subdirectory to build the desired url path.

## Template

Make sure 'short open tags' are enabled in `php.ini`. This makes php templating so nice!

```php
<!-- Execute a php statement -->
<? $var = 42 ?>

<!-- Echo a string to the html -->
<p>The answer is: <?= $var ?>!</p>
```

`index.php`
```php
<?
$pagename = 'Home';
include 'header.pht';
include 'navigation.pht';
?>

<div id="page">
    ...
```

`header.pht`
```php
<!DOCTYPE html>
<html>
    <head>
        <title><?= isset($pagename) ? "$pagename |" : '' ?> Website</title>
    </head>
    <body>
    ...
```

## Controller

`index.php`
```php
<?
include 'index.phc';
include 'header.pht';
include 'navigation.pht';
?>

<div id="page>
    ...
```

`index.phc`
```php
<?php
$pagename = 'Home';

/* If a controller is only used when a form is posted,
 * then simply return back to the parent file when not needed.
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return;
}

/* Validate post variables.
 * Created message and error variables will be accessible to the calling file.
 * Return at any time to calling file.
 * Perform DB queries.
 * Redirect if all was successful.
 * BE SURE TO CALL die(); AFTER REDIRECTING!
 */
header("Location: https://example.com/", true, 303);
die();
```

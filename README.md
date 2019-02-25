# Clear

### A PHP *anti*-framework programming paradigm

Clear is a design philosophy for building web applications without the need for a PHP framework.

## Core design philosophy

1. PHP's servers already have routers built in, stop writing routers in PHP.
2. PHP is already a templating language, stop using another one on top of it.
3. Separating MVC responsibilities by using `include` statements.
4. Adding a new page to a PHP website is as easy as creating ONE FILE.
	* No need to define a route for the new page
	* No need to make a page controller
	* No need to run an initialization script

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

The variable `$pagename` is created in `index.php` ...

```php
<?
$pagename = 'Home';
include 'header.pht';
include 'navigation.pht';
?>

<h1>Welcome</h1>

<? include 'footer.pht' ?>
```

... and is usable in `header.pht`:

```php
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?= isset($pagename) ? "$pagename |" : '' ?>
            Website Name
        </title>
    </head>
    <body>
```

footer.pht:
```php
    </body>
</html>
```

## Controller

Include the controller as the first thing in `index.php`:

```php
<?
include 'index.phc';
include 'header.pht';
include 'navigation.pht';
?>

<h2>Save your favorite links</h2>

<form method="POST">
    <input type="text" name="url">
    <button type="submit">Save</button>
</form>

<? include 'footer.pht' ?>
```

Return back to the page from `index.phc`:

```php
<?php
$pagename = 'Home';
$query = '';

// Simply return back to the parent file when not needed.
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['url'])) {
    return;
}

// Insert $_POST['url'] into the database

// Redirect if all was successful
header("Location: https://example.com/", true, 303);
die();
```

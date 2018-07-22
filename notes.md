- provide a bunch of well-made, common tools
	- databases
	- authentication
	- mailer
	- logging
	- HTML/URL escaping/encoding (in place of a templating language)
- an easy way to load controllers/models/middle-wares in one or a few lines
- Load a "plugin" if it has the name `/base/directory/*.plugin.php`
- Load a "model" if is has the name `/current/directory/*.model.php`
- Load a "controller" if it has the name `/current/directory/*.controller.php`
- Files that match `*.plugin.php`, `*.model.php` and `*.controller.php` should be disallowed


Enable mysql general log:
> SET GLOBAL general_log = 'ON';
> SET GLOBAL general_log_file = '/var/log/mysql/all.log';

# Overview

Custom file extensions can be used as a naming convention, this offers some exciting benefits:
 * It's easy to spot which files perform what functions
 * The files are sorted in normal alphabetical order next to other related files
 * Web servers will only serve `.php` files dedicated for pages

Purpose    | Possible Extensions | Description
-----------|---------------------|------------
Page       |`.php`               | A web-accessible file that servers will recognize
Template   |`.pht` `.t` `.tpl` `.template`| Include-able template views for reusing components
Controller |`.phc` `.c` `.ctrl` `.controller`| Controller code to validate and prepare variables
Model      |`.phm` `.m` `.model` | Class or functions for interacting with databases

Variables are available inside included files, so passing data around is easy. Declare a page name to be used in an included html head tag, or the controller can fetch data from the DB to be used in the main page.

Returning from an included file is like returning from a function, execution continues at the including file.

## Page

Create a normal `.php` file, web servers will serve it up just like usual. It can be in any subdirectory to build the desired url path.

## Template

`index.php`
```phtml
<?php
$pagename = 'Home';
include 'header.pht';
include 'navigation.pht';
?>

<div id="page>
	...
```

`header.pht`
```phtml
<!DOCTYPE html>
<html
	<head>
		<title><?= isset($pagename) ? $pagename.' |' : '' ?> Website</title>
	</head>
	<body>
	...
```

## Controller

`index.php`
```phtml
<?php
include 'index.phc';
include 'header.pht';
include 'navigation.pht';
?>

<div id="page>
	...
```

`index.phc`
```phtml
<?php
$pagename = 'Home';

/*
 * If a controller is only used when a form is posted,
 * then simply return back to the parent file when not needed.
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	return;
}

/**
 * Validate post variables.
 * Created message and error variables will be accessible to the calling file.
 * Return at any time to calling file.
 * Perform DB queries.
 * Redirect if all was successful.
 * BE SURE TO CALL die(); AFTER REDIRECTING!
 */
header("Location: https://example.com/", true, 303);
die();
```

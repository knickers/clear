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

Custom file extensions are used as a naming convention, this way it's easy to spot which files perform what functions, the files are sorted in normal alphabetical order, and web servers will only serve filed dedicated to pages.

Extension | Purpose    | Description
----------|------------|------------
`.php`    | Page       | A web-accessible file that servers will recognize.
`.pht`    | Template   | Include-able template views for reusing components.
`.phc`    | Controller | Controller code to validate and prepare page variables.

Variables are available inside included files, so passing data around is easy. Declare a page name to be used in an included html head tag, or the controller can fetch data from the DB to be used in the main page.

Returning from an included file is like returning from a function, execution continues at the including file.

## Page

Create a normal `.php` file, your web server will serve it up just like usual. It can be in any subdirectory to build your desired url path.

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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	return;
}

$required = ['name', 'email', 'comment'];

foreach ($required as $key) {
	if (empty($_POST[$key])) {
		$missing[$key] = true;
	}
	else {
		$$key = $_POST[$key];
	}
}

if (!empty($missing)) {
	return;
}

/**
 * Do something with the new variables
 */

header("Location: https://example.com/", true, 303);
die();
```

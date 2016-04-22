<html>
	<head>
		<title>Clear PHP</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
<?php if (!isset($_GET['globals'])) return ?>
<div>Global Variables</div>
<pre>
CURFILE : <?= CURFILE ?>

CURDIR  : <?= CURDIR ?>

BASEDIR : <?= BASEDIR ?>

BASEURL : <?= BASEURL ?>

RELURL  : <?= RELURL ?>
</pre>

<?php
require_once '../clear.php';

$err = [];

$yes = BASEDIR . '/_header.php';
$wins = [
	'_header', '/_header', '_header/', '/_header/',   // slashes
	' _header', '_header ', ' _header ', '/_header/', // spaces
	' /_header', '_header/ ', ' /_header/ ',          // slashes and spaces
	'_header.php', '/_header.php', '_header.php/','/_header.php/', // extension
];
foreach($wins as $name) {
	$got =  Clear::template($name, true);
	if ($got != $yes) {
		$err[] = "Expected $yes - Got $got";
	}
}

$fails = ['', null, false];
foreach($fails as $name) {
	$got =  Clear::template($name, true);
	if ($got != false) {
		$err[] = 'Expected FALSE - Got ' . $got;
	}
}

if (isset($err[0])) {
	foreach($err as $e) {
		echo 'Core::template test failed - ', $e, '<br>';
	}
} else {
	echo 'pass';
}

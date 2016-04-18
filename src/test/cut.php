<?php
require_once '../clear.php';

$echo = "'%s' - '%s' = '%s' : %s<br>";
$cut = '.php';
$yes = 'index';

echo 'rcut:<br>';

$rcut = [
	'index', 'index.php',
];
foreach($rcut as $str) {
	$got = rcut($str, $cut);
	$ok = $got == $yes ? 'pass' : 'fail';
	echo sprintf($echo, $str, $cut, $got, $ok);
}

echo '<hr>lcut:<br>';

$cut = 'home/';
$lcut = [
	'index', 'home/index',
];
foreach($lcut as $str) {
	$got = lcut($str, $cut);
	$ok = $got == $yes ? 'pass' : 'fail';
	echo sprintf($echo, $str, $cut, $got, $ok);
}

echo '<hr>cut:<br>';

$cut = 'hello';
$lcut = [
	'index', 'helloindex', 'indexhello', 'helloindexhello',
];
foreach($lcut as $str) {
	$got = cut($str, $cut);
	$ok = $got == $yes ? 'pass' : 'fail';
	echo sprintf($echo, $str, $cut, $got, $ok);
}

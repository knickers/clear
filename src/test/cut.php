<?php
require_once '../clear.php';

$echo = "%s: '%s' - '%s' = '%s' : %s<br>";

$cut = '.php';
$yes = 'index';
$rcut = [
	'index', 'index.php',
];
foreach($rcut as $str) {
	$got = rcut($str, $cut);
	$ok = $got == $yes ? 'pass' : 'fail';
	echo sprintf($echo, 'rcut', $str, $cut, $got, $ok);
}

echo '<hr>';

$cut = 'home/';
$lcut = [
	'index', 'home/index',
];
foreach($lcut as $str) {
	$got = lcut($str, $cut);
	$ok = $got == $yes ? 'pass' : 'fail';
	echo sprintf($echo, 'lcut', $str, $cut, $got, $ok);
}

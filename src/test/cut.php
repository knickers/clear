<?php
require_once '../clear.php';

$echo = '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>';
$cut = '.php';
$yes = 'index';

echo '<style>th, td { padding: 5px 5px 3px; }</style><table border="1">';
echo '<tr><th>Input</th><th>Cut</th><th>Result</th><th>Pass</th></tr>';
echo '<tr><th colspan="4" style="text-align:left;">rcut</th></tr>';

$rcut = ['index', 'index.php'];
foreach($rcut as $str) {
	$got = rcut($str, $cut);
	$ok = $got == $yes ? 'pass' : 'fail';
	echo sprintf($echo, $str, $cut, $got, $ok);
}

echo '<tr><th colspan="4" style="text-align:left;">lcut</th></tr>';

$cut = 'home/';
$lcut = ['index', 'home/index'];
foreach($lcut as $str) {
	$got = lcut($str, $cut);
	$ok = $got == $yes ? 'pass' : 'fail';
	echo sprintf($echo, $str, $cut, $got, $ok);
}

echo '<tr><th colspan="4" style="text-align:left;">cut</th></tr>';

$cut = 'hello';
$lcut = ['index', 'helloindex', 'indexhello', 'helloindexhello'];
foreach($lcut as $str) {
	$got = cut($str, $cut);
	$ok = $got == $yes ? 'pass' : 'fail';
	echo sprintf($echo, $str, $cut, $got, $ok);
}

echo '</table>';

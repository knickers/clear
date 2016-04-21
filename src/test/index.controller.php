<?php
require_once '../clear.php';

Clear::model('clear-sql');

$model = new ClearModel();
$model->init();

if (isset($_POST['debug'])) {
	error_log($_POST['debug']);
	$model->query('SET GLOBAL general_log = :log', array(
		':log' => (strtolower($_POST['debug']) == 'on' ? 'ON' : 'OFF'),
	));
	Clear::redirect('/test');
}

$debug = $model->query(
	'SHOW GLOBAL VARIABLES WHERE Variable_name = "general_log"'
)->fetch()->Value == 'ON';

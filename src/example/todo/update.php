<?php
require_once '../../clear.php';
Clear::model('example/todo/todo');

$model = new TodoModel();

if (isset($_POST['id']) && $_POST['id'] != '') {
	$model->set(Clear::defaults($_POST, array(
		'name' => Clear::OPTIONAL,
		'date' => Clear::OPTIONAL,
		'notes' => Clear::OPTIONAL,
	)), $_POST['id']);
}

Clear::redirect('/example/todo/');

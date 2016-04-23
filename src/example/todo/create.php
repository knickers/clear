<?php
require_once '../../clear.php';
Clear::model('example/todo/todo');

$model = new TodoModel();

$model->insert(Clear::extract($_POST, array(
	'name' => Clear::REQUIRED,
	'date' => Clear::NOTSET,
	'notes' => '',
)));

Clear::redirect('/example/todo/');

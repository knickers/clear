<?php
require_once '../../clear.php';
Clear::model('example/todo/todo');

$model = new TodoModel();

if (isset($_GET['id'])) {
	$model->set(array('done' => 0), $_GET['id']);
}

Clear::redirect('/example/todo/');

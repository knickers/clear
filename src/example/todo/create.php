<?php
require_once '../../clear.php';
Clear::model('example/todo/todo');

$model = new TodoModel();

$model->insert(array(
	'name' => $_POST['name'],
));

Clear::redirect('/example/todo/');

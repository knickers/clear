<?php
require_once '../../clear.php';
Clear::model('example/todo/todo');

$model = new TodoModel();

$name = Clear::get('name');

$model->insert(array(
	'name' => $_POST['name'],
));

Clear::redirect('/example/todo/');

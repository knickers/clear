<?php
Clear::model('example/todo/todo');
$model = new TodoModel();
$todos = $model->find(array('done' => 0), array('ORDER BY date'));
$done = $model->find(array('done' => 1), array('ORDER BY date'));

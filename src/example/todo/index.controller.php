<?php
Clear::model('example/todo/todo');
$model = new TodoModel();
$todos = $model->find();

<?php
require_once '../../clear.php';
Clear::model('sql');

class TodoModel extends ClearModel {
	static protected $table = 'todo';
}

TodoModel::init();

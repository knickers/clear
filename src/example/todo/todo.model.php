<?php
require_once '../../clear.php';
Clear::model('clear-sql');

class TodoModel extends ClearModel {
	static protected $table = 'todo';
}

TodoModel::init();

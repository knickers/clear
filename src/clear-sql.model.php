<?php

class ClearModel {
	static protected $db;
	static protected $table;
	static protected $primaryKey = 'id';
	static protected $queryOptionCount;
	
	public static function init() {
		if (!is_null(static::$db)) {
			return false;
		}
		// TODO These need to come from a config
		static::$db = new PDO('mysql:dbname=clear;host=db;port=3306', 'root', 'qwerty');
		static::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		static::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		static::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	}
	
	/*
	 * 1. Keys can be associative array pairs
	 * ex. $data = array(
	 *     'user' => 42,                            WHERE user = 42
	 *     'name' => 'bob',                           AND name = 'bob'
	 * )
	 *
	 * 2. Keys can be indexed array values
	 * ex. $data = array(
	 *     'deleted IS NOT NULL',                   WHERE deleted IS NOT NULL
	 *     'created > TIMESTAMPADD(DAY, -1, NOW())',  AND created > TIMESTAMP...
	 * )
	 * ex. $options = array(
	 *     'ORDER BY created DESC',                 ORDER BY created DESC
	 *     'LIMIT 10',                              LIMIT 10
	 * )
	 *
	 * 3. Keys can be formatted with %s
	 * ex. $data = array(
	 *     'name LIKE "%s"' => "%bob%",             WHERE name LIKE "%bob%"
	 *     'created < %s' => '2014-09-04',            AND created < '2014-09-04'
	 *     'updated BETWEEN %s AND %s' => array(      AND updated BETWEEN
	 *         '2014-09-04',                              '2014-09-04' AND
	 *         '2014-10-04',                              '2014-10-04'
	 *     ),
	 * )
	 */
	public static function buildOptions($data, &$vars, $seperator) {
		if (is_null(static::$queryOptionCount)) {
			static::$queryOptionCount = 0;
		}
		$sql = '';
		$i = static::$queryOptionCount;
		foreach ($data as $key => $val) {
			if ($i > static::$queryOptionCount) {
				$sql .= $seperator;
			}
			$i += 1;
			// Indexed array value e.g. 'LIMIT 10'
			if (!is_string($key)) {
				$sql .= $val;
				continue;
			}
			// Associative array pair (not formatted with %s)
			if (strpos($key, '%s') === false) {
				$k = preg_replace('/[^\w]/', '', $key);
				$sql .= "$key = :$k";
				$vars[":$k"] = $val;
				continue;
			}
			// Formatted with single %s
			if (!is_array($val)) {
				$sql .= preg_replace('/%s/', ':option' . $i, $key, 1);
				$vars[':option' . $i] = $val;
				continue;
			}
			// Formatted with multiple %s
			// 'created_at BETWEEN %s AND %s' => array(
			//     '2014-09-04',
			//     '2014-10-04',
			// )
			$count = substr_count($key, '%s') <= count($val)
				? substr_count($key, '%s')
				: count($val);
			for($j=0; $j<$count; $j+=1) {
				$key = preg_replace('/%s/', ':option'.$i, $key, 1);
				$vars[':option'.$i] = $val[$j];
				$i += 1;
			}
			$sql .= $key;
		}
		static::$queryOptionCount = $i;
		return $sql;
	}
	
	/**
	 * Build the WHERE clause of a typical SELECT statement
	 *
	 * @param $search : WHERE clause to search for, see buildOptions for syntax
	 * @param $options: after WHERE clause, see buildOptions for syntax
	 * @param &$vars  : array to be filled with prepared PDO replace variables
	 * @return sql string starting at WHERE
	 */
	public static function buildQuery($search, $options, &$vars) {
		$sql = '';
		
		$where = self::buildOptions($search, $vars, ' AND ');
		if ($where) {
			$sql .= ' WHERE ' . $where;
		}
		
		$where = self::buildOptions($options, $vars, ' ');
		if ($where) {
			$sql .= ' ' . $where;
		}
		
		return $sql;
	}
	
	/**
	 * Prepare and execute an sql string with parameters, data is not fetched
	 *
	 * @param $sql : string, sql query
	 * @param $vars: array, prepared sql replacment variables
	 * @return an executed statment, ready for ->fetch() or ->fetchAll()
	 */
	public static function query($sql, $vars=array()) {
		$stmt = static::$db->prepare($sql);
		$stmt->execute($vars);
		
		return $stmt;
	}
	
	/**
	 * Set values of a row by primary key
	 *
	 * @param $data, values to be updated
	 * @param $id, table primary key
	 * @return Statement
	 */
	public static function set($data, $options) {
		if (!is_array($options)) {
			$options = array(static::$primaryKey => $options);
		}
		
		$vars = array();
		
		$sql = 'UPDATE ' . static::$table . ' SET ';
		$sql .= self::buildOptions($data, $vars, ', ');
		$sql .= ' WHERE ' . self::buildOptions($options, $vars, ' AND ');
		
		$stmt = static::$db->prepare($sql);
		$stmt->execute($vars);
		
		return $stmt;
	}
	
	/**
	 * Get a row by primary key
	 *
	 * @param id  : the table's primary key id
	 * @param keys: optional string of comma seperated columns to return
	 * @return table row object
	 */
	public static function get($id, $keys='*') {
		return self::query(sprintf("SELECT $keys FROM %s WHERE %s = :id",
			static::$table,
			static::$primaryKey
		), array(
			':id' => $id,
		))->fetch();
	}
	
	/**
	 * Find all rows matching the provided search and option parameters
	 *
	 * @param $search : WHERE clause to search for, see buildOptions for syntax
	 * @param $options: after WHERE clause, see buildOptions for syntax
	 * @param $keys   : optional string of comma seperated columns to return
	 * @return array of objects
	 */
	public static function find($search=array(), $options=array(), $keys='*') {
		$vars = array();
		
		$sql = "SELECT $keys FROM " . static::$table;
		$sql .= self::buildQuery($search, $options, $vars);
		
		return self::query($sql, $vars)->fetchAll();;
	}
	
	/**
	 * Find one row matching the search and option parameters
	 *
	 * @param $search : WHERE clause to search for, see buildOptions for syntax
	 * @param $options: after WHERE clause, see buildOptions for syntax
	 * @param $keys   : optional string of comma seperated columns to return
	 * @return object
	 */
	public static function findOne($search=array(), $options=array(), $keys='*') {
		if (!isset($options['LIMIT 1'])) {
			$options[] = 'LIMIT 1';
		}
		$vars = array();
		
		$sql = "SELECT $keys FROM " . static::$table;
		$sql .= self::buildQuery($search, $options, $vars);
		
		return self::query($sql, $vars)->fetch();;
	}
	
	/**
	 * Count up all rows matching the search and option parameters
	 *
	 * @param $search : WHERE clause to search for, see buildOptions for syntax
	 * @param $options: after WHERE clause, see buildOptions for syntax
	 * @return int, number of matching rows
	 */
	public static function count($search=array(), $options=array()) {
		$vars = array();
		
		$sql = 'SELECT COUNT(' . static::$primaryKey . ') AS count FROM ' . static::$table;
		$sql .= self::buildQuery($search, $options, $vars);
		
		return (int) self::query($sql, $vars)->fetch()->count;
	}
	
	/**
	 * Sum a column for all rows matching the search and option parameters
	 *
	 * @param $column : key in the table to sum
	 * @param $search : WHERE clause to search for, see buildOptions for syntax
	 * @param $options: after WHERE clause, see buildOptions for syntax
	 * @return float, sum of matching rows
	 */
	public static function sum($column, $search=array(), $options=array()) {
		$vars = array();
		
		$sql = "SELECT $column AS sum FROM " . static::$table;
		$sql .= self::buildQuery($search, $options, $vars);
		
		return (float) self::query($sql, $vars)->fetch()->sum;
	}
	
	/**
	 * Insert a new row into the table
	 *
	 * @param $data : 
	 * @param $ignore: 
	 * @return int, number of matching rows
	 */
	public static function insert($data, $ignore=false) {
		$i = 0;
		$sql = 'INSERT '.($ignore ? 'IGNORE' : '').' INTO '.static::$table.' (';
		$vals = ') VALUES (';
		$vars = array();
		foreach($data as $key => $val) {
			if ($i) {
				$sql .= ', ';
				$vals .= ', ';
			}
			$i += 1;
			$sql .= $key;
			$vals .= ":$key";
			$vars[":$key"] = $val;
		}
		
		$stmt = self::query($sql.$vals.')', $vars);
		return static::$db->lastInsertId();
	}
	
	/**
	 * Delete a row from the table
	 *
	 * @param 
	 * @return float, sum of matching rows
	 */
	public static function delete($id) {
		$stmt = static::$db->prepare(sprintf('DELETE FROM %s WHERE %s = :id',
			static::$table,
			static::$primaryKey
		));
		return $stmt->execute(array(':id' => $id)) ? $stmt->rowCount() : false;
	}
	
	/**
	 * 9 lines
	 *
	 * @param $id, table primary key
	 * @return float, sum of matching rows
	 */
	public static function temp() {
	}
}

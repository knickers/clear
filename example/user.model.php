<?php
require_once 'clear.php';
Clear::model('sql');

if (session_id() == '') {
	session_start();
	$_SESSION['logged_in'] = isset($_SESSION['USER']);
}

class UserModel extends ClearModel {
	protected static $table = 'user';
	
	public static function authenticate($authString) {
		$tokens = explode(':', $authString);
		
		$user = self::findOne(array('auth_selector' => $tokens[0]));
		
		$same = $user->auth_token == hash('sha256', $tokens[1]);
		$expired = time() >= $user->auth_expiration;
		
		if ($same && !$expired) {
		}
	}
	
	public static function generateAuth(&$user) {
		$token = Clear::randomString();
		$days = 7; // TODO CONFIG days
		
		$user->auth_token = hash('sha256', $token);
		$user->auth_selector = uniqid();
		$user->auth_expiration = time() + 60*60*24*$days;
		
		self::set(array(
			'auth_token' => $user->auth_token,
			'auth_selector' => $user->auth_selector,
			'auth_expiration' => $user->auth_expiration,
		), $user->id);
	}
	
	public static function destroyAuth($user) {
		self::set(array(
			'auth_token' => null,
			'auth_selector' => null,
			'auth_expiration' => null,
		), $user->id);
	}
	
	public static function login($email, $password) {
		$user = self::findOne(array('email' => $email));
		
		if ($user && self::password_verify($password, $user->password)) {
			$_SESSION['USER'] = $user;
			$_SESSION['logged_in'] = true;
			return true;
		} else {
			unset($_SESSION['USER']);
			$_SESSION['logged_in'] = false;
			return false;
		}
	}
	
	public static function logout() {
		unset($_SESSION['USER']);
		$_SESSION['logged_in'] = false;
		session_destroy();
	}
}

UserModel::init();

<?php
require_once '../../clear.php';
Clear::model('sql');

if (session_id() == '') {
	session_start();
}

class UserModel extends ClearModel {
	protected static $table = 'user';
	
	public static function login($email, $password) {
		$user = self::findOne(array('email' => $email));
		
		return $user && self::password_verify($password, $user->password_hash);
	}
	
	public static function loginAuth($authString) {
		$tokens = explode(':', $authString);
		
		$user = self::findOne(array('auth_selector' => $tokens[0]));
		
		$same = $user->auth_token == hash('sha256', $tokens[1]);
		$expired = time() >= $user->auth_expiration;
		
		if ($same && !$expired) {
		}
	}
	
	public static function generateAuth(&$user) {
		$token = Clear::randomString();
		
		$user->auth_token = hash('sha256', $token);
		$user->auth_selector = uniqid();
		$user->auth_expiration = time() + 60*60*24*$days; // TODO CONFIG days
		
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
	
	public static function logout() {
		session_destroy();
	}
}

UserModel::init();

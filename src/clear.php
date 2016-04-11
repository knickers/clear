<?php

DEFINE('CURFILE', basename($_SERVER['PHP_SELF']));
DEFINE('CURFILENAME', basename($_SERVER['PHP_SELF'], '.php'));
DEFINE('CURDIR', getcwd()); // Current Working Directory
DEFINE('BASEDIR', __DIR__); // Directory of THIS file (clear.php)
DEFINE('BASEURL', 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://' . $_SERVER['HTTP_HOST']);

class Clear {
	public static function require($fileregex, $once=false) {
		$files = glob($fileregex);
		foreach($files as $file) {
			if ($once) {
				require_once $file;
			} else {
				require $file;
			}
		}
	}
	
	public static function template($file, $return=false) {
		$file = self::rcut(trim(trim($file), '/'), '.php');
		if (!$file) {
			return false;
		}
		if ($return) {
			return BASEDIR . "/$file.php";
		} else {
			require BASEDIR . "/$file.php";
		}
	}
	
	public static function cut($string, $cutString) {
		return self::lcut(self::rcut($string, $cutString), $cutString);
	}
	
	public static function lcut($string, $cutString) {
		$len = strlen($cutString);
		if (substr($string, 0, $len) === $cutString) {
			return substr($string, $len);
		}
	}
	
	public static function rcut($string, $cutString) {
		$len = strlen($cutString);
		if (substr($string, -$len) === $cutString) {
			return substr($string, 0, -$len);
		}
	}
}

DEFINE('RELURL', Clear::lcut(CURDIR, BASEDIR));

//Clear::require(BASEDIR . '/*.plugin.php');
//Clear::require(CURDIR . '/*.model.php');
//Clear::require(CURDIR . '/*.controller.php');

// Include a crontroller for this page if available
if (file_exists(CURDIR . '/' . CURFILENAME . '.controller.php')) {
	include CURDIR . '/' . CURFILENAME . '.controller.php';
}

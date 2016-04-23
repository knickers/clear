<?php

function lcut($string, $cutString) {
	$len = strlen($cutString);
	if (substr($string, 0, $len) === $cutString) {
		return substr($string, $len);
	}
	return $string;
}
function rcut($string, $cutString) {
	$len = strlen($cutString);
	if (substr($string, -$len) === $cutString) {
		return substr($string, 0, -$len);
	}
	return $string;
}
function cut($string, $cutString) {
	return lcut(rcut($string, $cutString), $cutString);
}

DEFINE('CURFILE', basename($_SERVER['PHP_SELF']));
DEFINE('CURFILENAME', basename($_SERVER['PHP_SELF'], '.php'));
DEFINE('CURDIR', getcwd()); // Current Working Directory
DEFINE('BASEDIR', __DIR__); // Directory of THIS file (clear.php)
DEFINE('BASEURL', 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://' . $_SERVER['HTTP_HOST']);
DEFINE('RELURL', lcut(CURDIR, BASEDIR));

class Clear {
	const NOTSET        = '(^_^)[o_o](^.^)(".")($.$)';    // faces
	const OPTIONAL      = '</////|====================-'; // foil, fencing sword
	const REQUIRED      = '_.~"(_.~"(_.~"(_.~"(_.~"(_';   // breaking waves
	const ALLOWED_EMPTY = '_,-*"`-._,-*"`-._,-*"`-._';    // waves
	
	public static function defaults($input, $defaults) {
		$return = array();
		foreach($defaults as $key => $val) {
			if ($val === static::NOTSET) {
				if (!isset($input[$key]) || $input[$key] === '') {
					continue;
				}
			} else if ($val === static::OPTIONAL) {
				if (!isset($input[$key])) {
					continue;
				}
			} else if ($val === static::REQUIRED) {
				if (!isset($input[$key])) {
					throw new Exception("Required value '$key' not provided");
				} else if ($input[$key] === '') {
					throw new Exception("Required value '$key' not allowed to be empty");
				}
			} else if ($val === static::ALLOWED_EMPTY) {
				if (!isset($input[$key])) {
					throw new Exception("Required value '$key' not provided");
				}
			}
			$return[$key] = isset($input[$key]) ? $input[$key] : $val;
		}
		return $return;
	}
	
	public static function model($file, $return=false) {
		$file = rcut(rcut(trim(trim($file), '/'), '.php'), '.model');
		if (!$file) {
			return false;
		}
		if ($return) {
			return BASEDIR . "/$file.model.php";
		} else {
			require_once BASEDIR . "/$file.model.php";
		}
	}
	
	/**
	 * Redirect helper
	 *
	 * @param $URL string relative URL, '/' = home
	 * @param $code int, HTML status code
	 *   301 = Moved permanently
	 *   302 = Found
	 *   303 = See other (for POST redirect GET)
	 *   304 = Not modified
	 *   307 = Temporary redirect
	 *
	 * @return none die();
	 */
	public static function redirect($URL, $code=303) {
		header('location: ' . BASEURL . $URL, true, $code);
		die();
	}
	
	public static function template($file, $return=false) {
		$file = rcut(trim(trim($file), '/'), '.php');
		if (!$file) {
			return false;
		}
		if ($return) {
			return BASEDIR . "/$file.php";
		} else {
			require BASEDIR . "/$file.php";
		}
	}
}

// Include a crontroller for this page if available
if (file_exists(CURDIR . '/' . CURFILENAME . '.controller.php')) {
	include CURDIR . '/' . CURFILENAME . '.controller.php';
}

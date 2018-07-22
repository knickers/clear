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

DEFINE('CURFILE',       basename($_SERVER['PHP_SELF']));
DEFINE('CURFILENAME',   basename($_SERVER['PHP_SELF'], '.php'));
DEFINE('CURDIR',        getcwd()); // Current Working Directory
DEFINE('BASEDIR',       __DIR__); // Directory of THIS file (clear.php)
DEFINE('BASEURL',       'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://' . $_SERVER['HTTP_HOST']);
DEFINE('RELURL',        lcut(CURDIR, BASEDIR));
DEFINE('NOTSET',        '(^_^)[o_o](^.^)(".")($.$)');    // faces
DEFINE('OPTIONAL',      '</////|====================-'); // foil, fencing sword
DEFINE('REQUIRED',      '_.~"(_.~"(_.~"(_.~"(_.~"(_');   // breaking waves
DEFINE('ALLOWED_EMPTY', '_,-*"`-._,-*"`-._,-*"`-._');    // rolling waves
DEFINE('CSRFSECRET',    'zA-2Q0eIUgLSlrAcDM_1-a1oF_Q7FFCK');

function randomString($len=30) {
	$fp = @fopen('/dev/urandom','rb');
	$str = '';
	if ($fp !== FALSE) {
		$str .= @fread($fp, $len);
		@fclose($fp);
	} else {
		trigger_error('Can not open /dev/urandom.');
	}
	$str = base64_encode($str);        // convert from binary to string
	$str = strtr($str, '+/', '-_');    // remove non-url chars
	$str = str_replace('=', '', $str); // Remove = from the end
	
	return substr($str, 0, $len);
}

/**
 * @param  $URL  string  relative URL, '/' = home
 * @param  $code int     HTML status code
 *               301     Moved permanently
 *               302     Found
 *               303     See other (for POST redirect GET)
 *               304     Not modified
 *               307     Temporary redirect
 * @return       none    die();
 */
function redirect($URL, $code=303) {
	header('location: ' . BASEURL . $URL, true, $code);
	die();
}

function array_extract($input, $extract) {
	$return = [];
	foreach($extract as $key => $val) {
		if ($val === NOTSET) {
			if (!isset($input[$key]) || $input[$key] === '') {
				continue;
			}
		}
		else if ($val === OPTIONAL) {
			if (!isset($input[$key])) {
				continue;
			}
		}
		else if ($val === REQUIRED) {
			if (!isset($input[$key]) || $input[$key] === '') {
				throw new Exception("Required value '$key' not provided");
			}
		}
		else if ($val === ALLOWED_EMPTY) {
			if (!isset($input[$key])) {
				throw new Exception("Required value '$key' not provided");
			}
		}
		else {
			$return[$key] = isset($input[$key]) ? $input[$key] : $val;
		}
	}
	return $return;
}

function csrfGenerate($name) {
	return hash('sha256', session_id() . $name . CSRFSECRET);
}

function csrfVerify($name, $token) {
	return $token === csrfGenerate($name);
}

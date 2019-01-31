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
DEFINE('BASEDIR',       $_SERVER['DOCUMENT_ROOT']);
DEFINE('BASEURL',       'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://' . $_SERVER['HTTP_HOST']);
DEFINE('RELURL',        lcut(CURDIR, BASEDIR));
DEFINE('NOTSET',        '(^_^)[o_o](^.^)(".")($.$)');    // faces
DEFINE('OPTIONAL',      '</////|====================-'); // foil, fencing sword
DEFINE('REQUIRED',      '_.~"(_.~"(_.~"(_.~"(_.~"(_');   // breaking waves
DEFINE('ALLOWED_EMPTY', '_,-*"`-._,-*"`-._,-*"`-._');    // rolling waves
DEFINE('CSRFSECRET',    'zA-2Q0eIUgLSlrAcDM_1-a1oF_Q7FFCK');

function rands($len=30) {
	$fp = @fopen('/dev/urandom', 'rb');

	if ($fp === false) {
		trigger_error('Can not open /dev/urandom.', E_USER_ERROR);
		return;
	}

	$str = base64_encode(@fread($fp, $len)); // convert from binary to string
	$str = strtr($str, '+/', '-_');          // remove non-url chars

	@fclose($fp);

	return substr($str, 0, $len);            // trim to length
}

/**
 * @param  $URL  string  relative URL, '/' = index (home)
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
		if ($val === NOTSET) { // Allowed to be unset and empty string
			if (!isset($input[$key]) || $input[$key] === '') {
				continue;
			}
		}
		else if ($val === OPTIONAL) { // Allowed to be unset, but not empty
			if (!isset($input[$key])) {
				continue;
			}
		}
		else if ($val === REQUIRED) { // Must be set and not empty string
			if (!isset($input[$key]) || $input[$key] === '') {
				throw new Exception("Required value '$key' not provided");
			}
		}
		else if ($val === ALLOWED_EMPTY) { // Must be set, allowed to be empty
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

/**
 * A prettier var_export(). Always returns a string, never printing the result.
 *
 * var_export()       | export()
 * -------------------+------------------------
 * array (            | array (
 *   '_GET' =>        |     '_GET' => array (
 *   array (          |         'id' => '12',
 *     'id' => '12',  |     ),
 *   ),               |     '_POST' => array(),
 *   '_POST' =>       | ),
 *   array (          |
 *   ),               |
 * ),                 |
 */
function export($var) {
	$str = var_export($var, true);
	// Put object values on the same line as the key
	$str = preg_replace('/ => \n\s*(.*)/', ' => $1', $str);
	// Collapse empty arrays
	$str = preg_replace('/array ?\(\s*\)/', 'array()', $str);
	// Increase indentation to 4 spaces
	return str_replace('  ', '    ', $str);
}

function csrfGenerate($name) {
	return hash('sha256', session_id() . $name . CSRFSECRET);
}

function csrfVerify($name, $token) {
	return $token === csrfGenerate($name);
}

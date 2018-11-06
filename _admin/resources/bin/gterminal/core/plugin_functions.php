<?
	
	// Authorizes user also. If require_login is set to false
	// workdir is not updated to match the shell!
	function is_ajax($require_login = true) {
		if (isset($_GET['ajax'])) {
			$logic_err = $_GET['ajax'] != "2";
			// save hmac, before updating salt
			$hmac = hmac(file_get_contents("php://input"), $require_login ? SHELL_USERNAME.SHELL_PASSWORD : "guest");
			// print next hmac salt, to prevent replay
			// notice that salt is not updated when fetching resources
			if ($logic_err) echo ($_SESSION['hmac_salt'] = time().uniqid()).":";
			// check hmac
			if ($_GET['ajax_hmac'] != $hmac) {
				if ($logic_err) echo "3";
				else echo "Sync error, please try again!";
				exit; // quit execution!
			}
			// check for login, if required by plugin
			if ($require_login) {
				$login = require_login($_GET["ajax_cwd"]);
				if ($login != "0") {
					if ($logic_err) echo $login;
					else echo "An error has occured!";
					exit; // quit execution!
				} else {
					if ($logic_err) echo $login;
					return true;
				}
			} else { // no error
				if ($logic_err) echo "0";
				return true;
			}
		}
		return false;
	}
	
	function require_login($dir) {
		if (pbxt() == "Windows") {
			$dir = encode_iconv("UTF-8", "gbk", ($dir));
		}		
		if (!is_logged_in() || $_SESSION['login']['IP'] != $_SERVER['REMOTE_ADDR'] || $_SESSION['login']['UA'] != $_SERVER['HTTP_USER_AGENT']) {
			$_SESSION = array();
			return "1";
		} else if (!@chdir($dir)) { // this chdir was successfull ;-)
			@chdir($_SERVER['DOCUMENT_ROOT']);
			return "2".getcwd();
		}
		return "0"; // no error
	}
	
	function ticket_request() {
		$_SESSION['ticket'] = time().uniqid();
		return $_SESSION['ticket'];
	}
	function ticket_validate($hash, $msg) {
		$b = $hash == sha1($_SESSION['ticket'].sha1($_SESSION['ticket'].$msg));
		$_SESSION['ticket'] = "";
		return $b;
	}
	function is_utf8($s) {
		return preg_match("/^[\\x00-\\x7F]*$/u", $s) || preg_match("/^[\\x00-\\xFF]*$/u", $s);
	}
	function hmac($message, $key) {
		// prepare
		$blocksize = 64; // bytes
		// produce keys
		if (strlen($key) > $blocksize) $key = sha1($key); // shorten long keys
		if (strlen($key) < $blocksize) $key = $key . str_repeat(0x00, $blocksize-strlen($key));
		$o_key_pad = str_repeat(0x5c, $blocksize) ^ $key;
		$i_key_pad = str_repeat(0x36, $blocksize) ^ $key;
		// return hmac
	//	die($i_key_pad . $_SESSION['hmac_salt'] . $message);
		return sha1($o_key_pad . sha1($i_key_pad . $_SESSION['hmac_salt'] . $message));
	}
	function encode_iconv($sencoding, $tencoding, $str) {
    if (function_exists("mb_convert_encoding")) {
        $str = mb_convert_encoding($str, $tencoding, $sencoding);
    } else {
        $str = iconv($sencoding, $tencoding . "//TRANSLIT//IGNORE", $str);
    }
    return $str;
	}
	function preg_is_utf8($string)   
{   
    return preg_match('/^.*$/u', $string) > 0;//preg_match('/^./u', $string)   
}  
	
?>
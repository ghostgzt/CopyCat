<?
	/*
	Copyright (c) 2010 Theis Mackeprang

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
	*/
	error_reporting(0);
	function pbxt() {
		if (PATH_SEPARATOR == ':') {
			return 'Linux';
		} else {
			return 'Windows';
		}
	}
    if (pbxt() == "Windows") {	
		header("Content-type: text/html; charset=gbk");
	}else{
		header("Content-type: text/html; charset=utf-8");
	}
	// SESSION HANDLING
	session_name("tssid");
	if ($_GET['tssid']) session_id($_GET['tssid']);
	session_start();
	if (!is_array($_SESSION)) $_SESSION = array();
	
	// CHECK THAT CONFIGURATION IS DONE
	@include("config.php");
	if (!defined('SHELL_USERNAME') || !defined('SHELL_PASSWORD')) require("core/config_missing.php");
	
	// UNDO MAGIC QUOTES
	if(get_magic_quotes_gpc()) {
		function undo_magic_quotes($array) {
			return is_array($array) ? array_map('undo_magic_quotes', $array) : stripslashes($array);
		}
		$_GET = undo_magic_quotes($_GET);
		$_POST = undo_magic_quotes($_POST);
		$_COOKIE = undo_magic_quotes($_COOKIE);
		$_REQUEST = undo_magic_quotes($_REQUEST);
	}
	
	// MERGE GET DATA INTO POST DATA (USED IN PLUGINS)
	$_POST = array_merge($_GET, $_POST);
	
	function is_logged_in() {
		return $_SESSION['login']['username'] == SHELL_USERNAME && $_SESSION['login']['password'] == SHELL_PASSWORD;
	}
	
?>
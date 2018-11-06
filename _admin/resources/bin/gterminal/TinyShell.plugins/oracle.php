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

require("../plugin.php");

if (!defined('ORACLE_DEFAULT_USERNAME')) define('ORACLE_DEFAULT_USERNAME', 'scott');
if (!defined('ORACLE_DEFAULT_PASSWORD')) define('ORACLE_DEFAULT_PASSWORD', 'tiger');
if (!defined('ORACLE_DEFAULT_HOSTNAME')) define('ORACLE_DEFAULT_HOSTNAME', 'localhost/orcl');

function get_oci_error($r = false) {
	$e = $r ? oci_error($r) : oci_error();
	$errtext = "ERROR ".$e['message'];
	if ($e['sqltext']) {
		$errtext .= "\n".preg_replace("#\s#si", " ", $e['sqltext']);
		$errtext .= "\n".sprintf("%".($e['offset']+1)."s", "^");
	}
	return $errtext;
}

if (is_ajax()) {
	switch ($_POST['action']) {
	case "login":
		if (!$_POST['h']) $_POST['h'] = ORACLE_DEFAULT_HOSTNAME;
		if (!$_POST['u']) $_POST['u'] = ORACLE_DEFAULT_USERNAME;
		if (!$_POST['p']) $_POST['p'] = ORACLE_DEFAULT_PASSWORD;
		if (is_callable("oci_connect")) {
			if ($conn = @oci_connect($_POST["u"], $_POST["p"], $_POST["h"])) {
				$_SESSION['oracle'] = $_POST;
				$_SESSION['oracle']['login'] = 1;
				echo oci_server_version($conn);
				oci_close($conn);
				exit;
			}
			else die(get_oci_error());
		} else die("ERROR: PHP OCI8 extension is not enabled.\nCheck TinyShell's homepage for help.");
		break;
	case "suggest":
		if (!$_SESSION['oracle']['login']) exit;
		$conn = oci_connect($_SESSION['oracle']["u"], $_SESSION['oracle']["p"], $_SESSION['oracle']["h"]);
		preg_match("#^(.*?)([a-z0-9_.]*)$#i", strtoupper($_POST['start']), $_POST['start']);
		$str = addslashes($_POST['start'][2]);
		$len = strlen(utf8_decode($_POST['start'][2]));
		
		if (strpos($_POST['start'][2], ".") === false) $sql = "
			(SELECT USERNAME AS SUG
			FROM ALL_USERS
			WHERE SUBSTR(USERNAME, 1, $len) = '$str')
			UNION
			(SELECT NAME AS SUG
			FROM USER_SOURCE
			WHERE SUBSTR(NAME, 1, $len) = '$str')
			UNION
			(SELECT TABLE_NAME AS SUG
			FROM USER_TABLES
			WHERE SUBSTR(TABLE_NAME, 1, $len) = '$str')
			UNION
			(SELECT COLUMN_NAME AS SUG
			FROM USER_TAB_COLUMNS
			WHERE SUBSTR(COLUMN_NAME, 1, $len) = '$str')
			ORDER BY SUG";
		else $sql = "
			(SELECT TABLE_NAME||'.'||COLUMN_NAME AS SUG
			FROM USER_TAB_COLUMNS
			WHERE SUBSTR(TABLE_NAME||'.'||COLUMN_NAME, 1, $len) = '$str')
			UNION
			(SELECT OWNER||'.'||NAME AS SUG
			FROM ALL_SOURCE
			WHERE SUBSTR(OWNER||'.'||NAME, 1, $len) = '$str')
			UNION
			(SELECT OWNER||'.'||TABLE_NAME AS SUG FROM ALL_TABLES WHERE SUBSTR(OWNER||'.'||TABLE_NAME, 1, $len) = '$str')
			ORDER BY SUG";
		echo $_POST['start'][2]."\t";
		$stid = oci_parse($conn, $sql); oci_execute($stid);
		$i = 0;
		while ($d = oci_fetch_assoc($stid)) echo ($i++?"\n":"").$d['SUG'];
		oci_free_statement($stid);
		oci_close($conn);
		break;
	case "query":
		if (!$_SESSION['oracle']['login']) exit;
		$conn = oci_connect($_SESSION['oracle']["u"], $_SESSION['oracle']["p"], $_SESSION['oracle']["h"]) or die(get_oci_error()."\n");
		//oci_query("SET NAMES utf8");
		$sqls = array();
		$sql = trim($_POST['sql'], "\r\n\t ;");
		// remove comments
		// replace escaped backslashes in strings
		// strip away strings
		// strip away multi statement blocks
		// replace escaped back
		// identify queries
		$strings = array();
		function save_sql_strings(&$a, $s) {
			$u = "#".uniqid()."#";
			$a[$u] = str_replace(
				array(
					'\"',
					'\\\\|'
				), array(
					'"',
					'\\\\'
				), $s);
			return $u;
		}
		$stmts = preg_split("#(\s*;\s*)+#", preg_replace(
			array(
				"/#[^\n]*/",
				"#(\"|').*?(?<!\\\\)\\1#e",
				"#\bBEGIN_MULTI_STMT\s(.*)\bEND_MULTI_STMT\b#eus"
			), array(
				"",
				'save_sql_strings($strings, \'\\0\')',
				'save_sql_strings($strings, \'\\1\')'
			),
			str_replace('\\\\','\\\\|',$sql)
		));
		$sqls = array();
		// insert strings and begin..end blocks back in:
		foreach ($stmts as $stmt) {
			while (strpos($stmt, "#") !== false) $stmt = strtr($stmt, $strings);
			$sqls[] = $stmt;
		}
		// execute queries:
		$qn = 0; foreach ($sqls as $sql) {
			if ($qn++) echo "\n";
			switch (strtoupper(substr($sql, 0, 4))) {
			case "QUIT":
			case "EXIT":
			case "CLEA": // clear
				echo "Cannot execute this in a multi-statement query";
				break;
			case "HELP":
				echo "Ups - No help here, check TinyShell's homepage";
				break;
			case "DELI": // delimiter
				echo "Delimiter change not supported\nHint: Use BEGIN_MULTI_STMT [SQL routine statement] END_MULTI_STMT";
				break;
			case "CONN": // connect
				echo "Not supported, please exit and reconnect";
				break;
			default:
				$stmt = oci_parse($conn, $sql);
				if (!$stmt) echo get_oci_error($conn);
				else {
					$time = microtime(true);
					if (!oci_execute($stmt)) echo get_oci_error($stmt);
					else {
						$time = microtime(true)-$time;
						if (($aff = oci_num_rows($stmt)) || !($d = oci_fetch_assoc($stmt))) {
							echo "Query OK";
							if ($aff) echo ", ".$aff." rows affected";
							echo " (".number_format($time, 2, ".", ",")." sec) ";
						} else {
							$rows = array();
							$cols = array();
							if (!$d) $d = oci_fetch_assoc($stmt); // make sure we fetched the first one
							do {
								foreach ($d as $k => $c) {
									if ($c === null) $d[$k] = $c = "NULL";
									$cols[$k] = max($cols[$k], strlen(utf8_decode($c)));
								}
								$rows[] = $d;
							} while ($d = oci_fetch_assoc($stmt));
							$totalrows = count($rows);
							// fields
							foreach ($cols as $field => $length) $cols[$field] = max(strlen(utf8_decode($field)), $length);
							$rowlength = array_sum($cols)+count($cols)*3+1;
							echo "+".str_repeat("-", $rowlength-2)."+\n";
							foreach ($cols as $field => $length) echo "| ".utf8_encode(str_pad(utf8_decode($field), $cols[$field], " ", STR_PAD_RIGHT))." ";
							
							echo "|\n";
							echo "+".str_repeat("-", $rowlength-2)."+\n";
							// rows
							foreach ($rows as $row) {
								foreach ($row as $field => $value) echo "| ".utf8_encode(str_pad(utf8_decode($value), $cols[$field], " ", STR_PAD_RIGHT))." ";
								echo "|\n";
							}
							echo "+".str_repeat("-", $rowlength-2)."+\n";
							echo $totalrows." row".($totalrows > 1 ? "s" : "")." in set";
							echo " (".number_format($time, 2, ".", ",")." sec) ";
						}
					}
				}
				oci_free_statement($stmt);
				break;
			}
			echo "\n";
		}
		oci_close($conn);
		break;
	}
	exit;
}

?>

/**
 * Oracle CLI
**/
TinyShell.plugins.oracle = new Class({
	description: "Advanced Oracle command line client",
	user : '',
	password : '',
	host: '',
	terminal : {},
	autocomplete : function(r) {
		r = r.toUpperCase().split("\t"); // we want case insensitiveness, completing word with uppercase
		this.terminal.cursor_autocomplete(r[1], r[0]);
	},
	run : function(terminal, args) {
		this.terminal = terminal;
		
		for (var i = 0; i < args.length; i++) {
			// host
			if (args[i].substring(0,2).toLowerCase() == "-h") {
				if (args[i].length == 2) { // arg == '-h'
					if (args.length > i+1) this.host = args[i+1];
					else {
						terminal.print("oracle: option ´-h´ requires an argument\n").resume();
						return;
					}
				}
				else this.host = args[i].substring(2);
			}
			if (args[i].substring(0,7).toLowerCase() == "--host=") this.host = args[i].substring(7);
			// user
			if (args[i].substring(0,2).toLowerCase() == "-u") {
				if (args[i].length == 2) { // arg == '-u'
					if (args.length > i+1) this.user = args[i+1];
					else {
						terminal.print("oracle: option ´-u´ requires an argument\n").resume();
						return;
					}
				}
				else this.user = args[i].substring(2);
			}
			if (args[i].substring(0,7).toLowerCase() == "--user=") this.user = args[i].substring(7);
			// pwd
			if (args[i].substring(0,2).toLowerCase() == "-p") this.password = args[i].substring(2).length ? args[i].substring(2) : false;
			if (args[i].substring(0,11).toLowerCase() == "--password=") this.password = args[i].substring(11);
		}
		if (this.password === false) terminal.set_protocol("Enter password: ", "password").read_line(this.auth);
		else this.auth();
	},
	auth: function(terminal, line, args, argc) {
		if (argc) this.password = line;
		this.terminal.ajax_request(this.validate_auth, "<?php echo $_AJAX_URL?>", "action=login&h="+encodeURIComponent(this.host)+"&u="+encodeURIComponent(this.user)+"&p="+encodeURIComponent(this.password));
	},
	validate_auth: function(response) {
		if (response.substring(0,5) == "ERROR") this.terminal.print(response+"\n").resume();
		else {
			this.terminal.print("Welcome to the Oracle monitor.  Commands end with ;").print("Your Oracle connection id is not static").print("Server version: "+response).print().print("Type 'clear' to clear the buffer.").print();
			// implement tabbing:
			this.onkeydown = function(e) {
				if (e.key == 'tab' && !e.shift) {
					e.stop();
					e.stop_default = true;
					this.terminal.ajax_request(this.autocomplete, "<?php echo $_AJAX_URL?>", "action=suggest&start="+encodeURIComponent(this.terminal.cursor_read_word())); // use uppercased string, usefull for case sensitive databases
					return false;
				}
				return true;
			}
			// read sql:
			this.get_command();
		}
	},
	get_command: function() {
		this.terminal.set_protocol("ora> ").read_line(this.parse_command);
	},
	parse_command: function(terminal, line, args) {
		if (!args.length) args = [''];
		var sarg = args[0].replace(/;/g, "");
		if (sarg == "quit" || sarg == "exit" || sarg == "bye") terminal.print("Bye").resume();
		else if (sarg == "clear") {
			terminal.clear_history();
			this.get_command();
		} else {
			terminal.ajax_request(this.command_output, "<?php echo $_AJAX_URL?>", "action=query&sql="+encodeURIComponent(line));
		}
	},
	command_output: function(response) {
		this.terminal.print(response);
		this.get_command();
	}
});

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

if (is_ajax()) {
	if ($_POST["action"] == 'ls') {
	    if (pbxt() == "Windows") {
	$cmd="dir /?";
    }else{
	$cmd="ls --help";	
	}

		// try "secure" ls access on system
		if (@shell_exec($cmd." 2>&1")) die(shell_exec(escapeshellcmd((pbxt() == "Windows")?("dir"):($_POST['cmd']))." 2>&1"));
		// try exec (cannot redirect error stream in safe_mode)
		unset($out);
		exec($cmd, $out);
		if ($out) {
			unset($out);
			exec(escapeshellcmd($_POST['cmd']), $out);
			die(implode("\n", $out)."\n");
		}
		// just print all files
		$files = glob("*");
		if ($files) echo implode("\n", $files);
		exit;
	}
	exit;
}
?>

/**
 * List directory
**/
TinyShell.plugins.ls = new Class({
	description: "List files",
	run : function(terminal, args, line) {
		this.t = terminal;
		terminal.ajax_request(this.print, "<?php echo $_AJAX_URL?>", "action=ls&cmd="+encodeURIComponent(line));
	},
	print : function(response) {
		this.t.print(response);
		this.t.resume();
	}
});

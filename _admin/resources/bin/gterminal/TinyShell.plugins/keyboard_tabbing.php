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
		$list = @glob($_POST['start']."*");
		if ($list) {
			$i = 0;
			foreach ($list as $k => $v) {
				if ($i++) echo "\n";
				echo is_dir($v) ? $v."/" : $v;
			}
		}
	}
	exit;
}
?>

/**
 * Auto complete from directory
**/

ts.onkeydown.push(function(e) {
	if (!this.proc && e.key == 'tab' && !e.shift) {
		e.stop();
		if (this.cursor_read_line().test(/\s/)) this.ajax_request(this.cursor_autocomplete, "<?php echo $_AJAX_URL?>", "action=ls&start="+encodeURIComponent(this.cursor_read_word()));
		else {
			// suggest commands
			var plugs = [];
			for (plugin in TinyShell.plugins) plugs.push(plugin+" ");
			plugs.sort();
			this.cursor_autocomplete(plugs.join("\n"));
		}
		return false;
	}
	return true;
});
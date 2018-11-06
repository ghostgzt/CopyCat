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
	$file=$_POST['file'];
    if (pbxt() == "Windows") {
        $file = encode_iconv("UTF-8", "gbk", ($file));
    }
	if ($_POST["action"] == 'rm') {
		if (!file_exists($file)) die("1");
		if (is_dir($file)) die("2");
		die(@unlink($file) ? "0" : "3");
	}
	exit;
}
?>

/**
 * Remove file
**/
TinyShell.plugins.rm = new Class({
	description: "Remove file",
	run : function(terminal, args) {
		this.t = terminal;
		if (args.length != 1) {
			terminal.print("rm: usage: rm filename");
			terminal.resume();
		} else {
			this.file = args[0];
			this.t.ajax_request(this.print, "<?php echo $_AJAX_URL?>", "action=rm&file="+encodeURIComponent(this.file));
		}
	},
	print: function(r) {
		if (r == "1") this.t.print("rm: file `"+this.file+"'; file does not exist");
		else if (r == "2") this.t.print("rm: file `"+this.file+"'; is a directory");
		else if (r == "3") this.t.print("rm: file `"+this.file+"'; permission denied");
		else this.t.print();
		this.t.resume();
	}
});
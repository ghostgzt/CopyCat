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
	if ($_POST["action"] == 'cat') {
		if (!is_file($file) || !is_readable($file)) die("1");
		$file = file_get_contents($file);
		die("0".(is_utf8($file) ? $file : utf8_encode($file)));
	}
	exit;
}
?>

/**
 * Cat file
**/
TinyShell.plugins.cat = new Class({
	description: "Show file",
	run : function(terminal, args) {
		this.t = terminal;
		if (args.length) {
			this.file = args[0];
			this.t.ajax_request(this.print, "<?php echo $_AJAX_URL?>", "action=cat&file="+encodeURIComponent(this.file));
		} else {
			terminal.print("cat: usage: cat filename");
			terminal.resume();
		}
	},
	print: function(r) {
		if (r.substring(0, 1) != "0") this.t.print("cat: `"+this.file+"' is not a file");
		else this.t.print(r.substring(1));
		this.t.resume();
	}
});
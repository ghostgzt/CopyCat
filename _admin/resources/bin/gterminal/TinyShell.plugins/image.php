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
	switch ($_POST["action"]) {
		case 'check':
			die(is_file($file) && is_readable($file)?"1":"-1");
		case 'fetch':
			readfile($file);
			break;
	}
	exit;
}
?>

/**
 * Show image
**/
TinyShell.plugins.image = new Class({
	description: "Display image file",
	run : function(terminal, args) {
		this.t = terminal;
		if (args.length) {
			this.file = args[0];
			this.width= args[1]?args[1]:"auto";
			this.height= args[2]?args[2]:"auto";
			this.style= args[3]?args[3]:"";					
			this.t.ajax_request(this.print, "<?php echo $_AJAX_URL?>", "action=check&file="+encodeURIComponent(this.file));
		} else {
			terminal.print("image: usage: image filename [width height style]");
			terminal.resume();
		}
	},
	print: function(r) {
		if (r != "1") this.t.print("image: `"+this.file+"' is not a file");
		else this.t.print("<img height='"+this.height+"' width='"+this.width+"' style='"+this.style+"' src='"+this.t.create_url("<?php echo $_AJAX_URL?>", "action=fetch&file="+encodeURIComponent(this.file))+"' alt='Filename: "+this.file+"' />", true);
		this.t.resume();
	}
});

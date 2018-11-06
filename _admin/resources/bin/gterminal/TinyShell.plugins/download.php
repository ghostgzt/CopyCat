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
	require_once("../core/lib_download.php");
$dlr = new Downloader();	
	require("../plugin.php");
	
if (is_ajax()) {
	$file=$_POST['file'];
	$filex=$file;	
    if (pbxt() == "Windows") {
        $file = encode_iconv("UTF-8", "gbk", ($file));
    }
	if ($_POST["action"] == 'download') {
		if (!is_file($file)) die("1".$file); // not file
		if (!is_readable($file)) die("2".$file); // denied
		die("0".$file);
	} else if ($_POST['action'] = 'fetch') {
	
		//header('Content-Type: application/octet-stream');
		//header('Content-Disposition: attachment; filename="'.$file.'"');
		//readfile($file);

			$dlr->downFile($file , end(explode("/",str_replace("\\","/",$filex))),0,"","",true,0,1);
			die();	
	}
	exit;
}
?>

/**
 * Download file
**/
TinyShell.plugins.download = new Class({
	description: "Download files from the server",
	run : function(terminal, args) {
		this.t = terminal;
		this.req = args.length;
		this.rec = 0;
		// async download check
		if (args.length) for (var i = 0; i < args.length; i++) this.t.ajax_request(this.print, "<?php echo $_AJAX_URL?>", "action=download&file="+encodeURIComponent(args[i]), true);
		else {
			terminal.print("download: usage: download filename [filename ...]");
			terminal.resume();
		}
	},
	print: function(r) {
		switch (r.substring(0, 1)) {
			case "1":
				this.t.print("download: `"+r.substring(1)+"' is not a file");
				break;
			case "2":
				this.t.print("download: unable to read file `"+r.substring(1)+"'; permission denied");
				break;
			default:
				r = r.substring(1);
				this.t.print("<a href='"+this.t.create_url("<?php echo $_AJAX_URL?>", "action=fetch&file="+encodeURIComponent(r))+"' target='_blank'>Download file: "+r+"</a>", true);
		}
		if (++this.rec >= this.req) this.t.resume();
	}
});
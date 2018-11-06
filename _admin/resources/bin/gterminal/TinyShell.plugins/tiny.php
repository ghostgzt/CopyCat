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
	switch ($_POST['action']) {
	case 'cat':
		if (!file_exists($file)) die("2");
		if (!is_file($file)) die("3");
		$file = file_get_contents($file);
		switch ($_POST['enc']) {
			case 'utf8':
				header("Content-type: text/html; charset=utf-8");
				die("1".$file);
				break;	
			case 'gbk':
				header("Content-type: text/html; charset=gbk");
				die("0".$file);				
				//die("0".encode_iconv("gbk", "utf-8", ($file)));
				//die("0".utf8_encode($file));
				break;
			case 'auto':
			default:
				//die(is_utf8($file) ? "1".$file : "0".utf8_encode($file));
				if(mb_detect_encoding($file, array('ASCII','GB2312','GBK','UTF-8'))=="UTF-8"){
						header("Content-type: text/html; charset=utf-8");
						die("1".$file);						
				}else{
						header("Content-type: text/html; charset=gbk");
						die("0".$file);		
				}
			/*	switch(mb_detect_encoding($file, array('ASCII','GB2312','GBK','UTF-8'))){
					case "GB2312′":					
					case "GBK’":
						header("Content-type: text/html; charset=gbk");
						die("0".$file);								
					break;
					case "UTF-8":
						header("Content-type: text/html; charset=utf-8");
						die("1".$file);						
					break;					
				}*/

				//die(is_utf8($file) ? "1".$file : "0".utf8_encode($file));
				break;
		}
		break;
	case 'save':
		die(@file_put_contents($file, $_POST['utf8']?$_POST['data']:/*utf8_decode*/encode_iconv("utf-8", "gbk",$_POST['data'])) === false ? "-1" : "1");
		break;
	}
	exit;
}

?>

/**
 * Tiny text editor
**/
TinyShell.plugins.tiny = new Class({
	description: "Basic text editor",
	t : {},
	cr : false,
	utf8 : true,
	force_enc : false,
	run : function(t, args) {
		this.t = t;
		if (args.length) {
			if (args[0] == "-e" && args.length > 2) {
				this.force_enc = 1;
				this.utf8 = args[1].toLowerCase() == 'utf8';
				this.file = args[2];
			} else this.file = args[0];
			this.t.ajax_request(this.open, "<?php echo $_AJAX_URL?>", "action=cat&enc="+(this.force_enc?(this.utf8?"utf8":"gbk"):"auto")+"&file="+encodeURIComponent(this.file));
		} else {
			this.t.print("tiny: usage: tiny [-e utf8 | gbk] filename");
			this.t.resume();
		}
	},
	open: function(r) {
		if (r.substring(0,1) == "3") {
			this.t.print("tiny: `"+this.file+"': permission denied");
			this.t.resume();
			return;
		}
		
		// force cursor movements
		this.onkeydown = function(e) {
			switch (e.key) {
				case "up":
				case "down":
				case "tab":
				case "enter":
					e.shift = true;
					break;
				case "s": // save
					if (e.control) {
						e.stop();
						this.quit_after_saving = e.shift;
						this.save();
						return false;
					}
					break;
				case "q": // quit
					if 	(e.control) {
						e.stop();
						this.quit();
						return false;
					}
					break;
			}
			return true;
		}
		// keyboard commands
		this.onkeypress = function(e) {
			switch (e.key) {
				case "s": // save
				case "q": // quit
					if 	(e.control) {
						// stop event
						e.stop();
						return false;
					}
					break;
			}
			return true;
		}
		this.t.print('Tiny commands:\nCTRL + S: Save\nCTRL + Q: Quit\nCTRL + SHIFT + S : Save and quit');
		if (r.substring(0,1) == "2") {
			if (!this.force_enc) this.utf8 = true;
			r = "";
			this.t.print("`"+this.file+"': New file");
		} else {
			if (!this.force_enc) this.utf8 = r.substring(0, 1) == 1;
			r = r.substring(1);
			this.t.print("`"+this.file+"': "+r.length+" bytes read ("+(this.utf8?"UTF-8":"GBK")+")");
		}
		this.t.set_protocol("> ").read_line(this.dummy);
		if (r.indexOf("\r") > -1) {
			this.cr = true;
			r = r.replace(/\r/g, '');
		}
		this.t.cursor_overwrite(r);
		this.t.cursor_move_home();
	},
	save : function () {
		r = this.t.cursor_read_line();
		if (this.cr) r = r.replace(/\n/g, "\r\n");
		this.bytes_saved = r.length;
		this.t.ajax_request(this.save_status, "<?php echo $_AJAX_URL?>", "action=save&utf8="+(this.utf8?"1":"0")+"&file="+encodeURIComponent(this.file)+"&data="+encodeURIComponent(r));
	},
	save_status : function (r) {
		if (r < 1) this.t.print("`"+this.file+"': Permission denied");
		else {
			this.t.print("`"+this.file+"': "+this.bytes_saved+" bytes written on "+(new Date()).toLocaleTimeString());
			if (this.quit_after_saving) this.quit();
		}
	},
	quit : function () {
		this.t.resume.delay(100, this.t); // delay to make sure keypress event has fired
	},
	dummy : function() {
		// dummy function
	}
});
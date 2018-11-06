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
 * Show web
**/
TinyShell.plugins.web = new Class({
	description: "Display web resources",
	run : function(terminal, args) {
		this.t = terminal;
		if (args.length) {
			this.file = args[0];
			this.width= args[1]?args[1]:"70%";
			this.height= args[2]?args[2]:"70%";
			this.type= args[3]?args[3]:"";	
			this.style= args[4]?args[4]:"";			
			this.flag= args[5]?args[5]:"";				
			//this.t.ajax_request(this.print, "<?php echo $_AJAX_URL?>", "action=check&file="+encodeURIComponent(this.file));
			terminal.print('<embed class="runemb" type="'+this.type+'" style="background:white;'+this.style+'" '+this.flag+' src="'+this.file+'"></embed>',true);
			if(this.width&&this.height){
			var emb=document.getElementsByClassName("runemb")[document.getElementsByClassName("runemb").length-1];
			emb.style.width=this.width;emb.style.height=this.height;emb.parentNode.style.width='100%';emb.parentNode.style.height='100%';
			}
			terminal.resume();
		} else {
			terminal.print("web: usage: web path [width height type style flag] ,like: "+'\nweb http://www.example.com/ 70% 70% "text/html" "border:1px solid white;" "allowfullscreen=\\"true\\" quality=\\"high\\""');//"/vcastr22.swf?BarColor=0x000000&BarPosition=1&vcastr_file=fff.mp4" 70% 70% application/x-shockwave-flash "border:1px solid white;" "allowfullscreen=\\"true\\" quality=\\"high\\""
			terminal.resume();
		}
	},
	print: function(r) {
		/*if (r != "1") this.t.print("video: `"+this.file+"' is not a file");
		else this.t.print("<video src='"+this.t.create_url("<?php echo $_AJAX_URL?>", "action=fetch&file="+encodeURIComponent(this.file))+"' alt='Filename: "+this.file+"' controls='controls'></video>", true);
		this.t.resume();*/
	}
});

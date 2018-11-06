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
if ($_POST['action'] = 'upload'){
echo "<div onmouseover=\"this.style.border='1px solid white';\" onmouseout=\"this.style.border='1px solid black';\" class=\"updp\" style=\"background:white;border:1px solid black;color:black;\"><span style=\"float:right;right:0;top:0;opacity:0.8;padding:10px;background: black;\"><a style=\"text-decoration: none;\" href=\"javascript:void(0);\" onclick=\"try{iframe.height=iframe.contentWindow.document.documentElement.scrollHeight;window.scroll(0, document.body.scrollHeight);clearInterval(ds);document.getElementsByClassName('updp')[document.getElementsByClassName('updp').length-1].innerHTML='Upload have been closed!'+'<br>'+iframe.contentWindow.document.getElementById('uploadInf').innerHTML;}catch(e){document.getElementsByClassName('updp')[document.getElementsByClassName('updp').length-1].innerHTML='Upload have been closed!';}tt.resume();\">Close</a></span><iframe onload=\"window.scroll(0, document.body.scrollHeight);\" class=\"upd\" src=\"zyupload/#".urlencode(getcwd())."\" width=\"100%\" height=\"400px\"   frameborder=\"no\" border=\"0\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"auto\" style=\"background:white;\" allowtransparency=\"yes\"></iframe></div>";
}
exit;
}
	
?>

/**
 * Upload file
**/
TinyShell.plugins.upload = new Class({
	description: "Upload files to the server",
	run : function(terminal, args) {
		/*terminal.print("<a href='"+terminal.create_url("<?php echo $_AJAX_URL?>", "action=form")+"' target='_blank'>Click here to upload files</a>", true);*/
		//terminal.resume();
		
		this.t = terminal;
		 tt=terminal;
		terminal.ajax_request(this.print, "<?php echo $_AJAX_URL?>", "action=upload");
		
		
		



		
	},
	print : function(response) {
		this.t.print(response,true);
				
		 iframe=document.getElementsByClassName("upd")[document.getElementsByClassName("upd").length-1];
		 ds=setInterval(' iframe=document.getElementsByClassName("upd")[document.getElementsByClassName("upd").length-1];iframe.height=iframe.contentWindow.document.documentElement.scrollHeight;',1000);
}
});
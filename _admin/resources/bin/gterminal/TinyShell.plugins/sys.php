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
	if ($_POST["action"] == 'system') {
		unset($out);
		if( !ini_get('safe_mode') ){ /*$out = @shell_exec($_POST['cmd']." 2>&1");*/}
		else {
			// unfortunately error stream cannot be redirected in safe_mode
			// since this will be escaped by escapeshellcmd
			echo "sys: PHP safe_mode_exec_dir is: ".ini_get('safe_mode_exec_dir')."\n";
			//exec($_POST['cmd'], $out);
			//$out = $out ? implode("\n", $out)."\n" : "";
		}
		$c=explode("|flag|->",$_POST['cmd']);
		$out='<iframe class="runifm" onmouseover="this.style.border=\'1px solid white\';" onmouseout="this.style.border=\'1px solid black\';" src="realtime.php?command='.base64_encode($c[0])."&cd=".base64_encode(getcwd())."&flag=".base64_encode(json_encode(explode("->",$c[1]))).'" frameborder="no" border="1px solid black" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes" height="0" width="99%"></iframe>';
		//$out=getcwd();
		echo $out;
	}
	exit;
}
?>

/**
 * Run command on system
**/
TinyShell.plugins.sys = new Class({
	description: "Run commands on the server",
	run : function(terminal, args, line) {
		this.t = terminal;
		if (line.length > 4) terminal.ajax_request(this.print, "<?php echo $_AJAX_URL?>", "action=system&cmd="+encodeURIComponent(line.substring(4)));
		else this.t.print("sys: usage: sys command,\"|flag|->\" is a separator,like: cmd |flag|->cd c:\ -|>1->c:-|>1->dir-|>2->help").resume();
	},
	print : function(response) {
		this.t.print(response,true);

		
		 tt=this.t;
		 iframe=document.getElementsByClassName("runifm")[document.getElementsByClassName("runifm").length-1];
		 ds=setInterval(' iframe=document.getElementsByClassName("runifm")[document.getElementsByClassName("runifm").length-1];iframe.height=iframe.contentWindow.document.documentElement.scrollHeight;window.scroll(0, document.body.scrollHeight);',1000);


	if (iframe.attachEvent){ 

iframe.attachEvent("onload", function(){ 
iframe.height=iframe.contentWindow.document.documentElement.scrollHeight;
window.scroll(0, document.body.scrollHeight);clearInterval(ds);
tt.resume();
iframe.attachEvent("onload","");
iframe.contentWindow.done();
}); 
} else { 



iframe.onload = function(){ 
iframe.height=iframe.contentWindow.document.documentElement.scrollHeight;
window.scroll(0, document.body.scrollHeight);clearInterval(ds);
tt.resume();
iframe.onload = "";
iframe.contentWindow.done();
}; 
} 


		
	}
});

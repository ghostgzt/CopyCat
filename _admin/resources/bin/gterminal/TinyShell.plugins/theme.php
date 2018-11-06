<?php
/*
	Copyright (c) 2010 Temperini Mirko

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
	if ($_POST["action"] == 'theme') {
		$css=dirname(__FILE__)."/../themes/{$_POST['file']}.theme.css";
		if (!file_exists($css) || !is_readable($css)) die("1$css");
		die("0themes/{$_POST['file']}.theme.css");
	}
	exit;
}
?>

/**
 * Theme file
**/
TinyShell.plugins.theme = new Class({
	description: "Load a theme",
	run : function(terminal, args){
		this.t = terminal;
		if (args.length){
			this.file = args[0];
			this.t.ajax_request(this.print, "<?php echo $_AJAX_URL?>", "action=theme&file="+encodeURIComponent(this.file));
            }
        else{
			terminal.print("theme: usage: theme themename");
			terminal.resume();
            }
        },
	print: function(r) {
		if (r.substring(0, 1) != "0"){
            this.t.print("theme: `"+this.file+"` is not a valid theme");
            }
        else{
            document.getElement('head').adopt(
                new Element('link',{
                    type:'text/css',
                    href:r.substring(1),
                    rel:'stylesheet'
                    })
                );
            this.t.print('theme '+this.file+' successful laoded');
            }
		this.t.resume();
        }
    });

/**
 * Who
**/
TinyShell.plugins.who = new Class({
	description: "Show detailed user information",
	run : function(terminal, args) {
		terminal.print(terminal.user+"\tpts/1\t<?=date("Y-m-d H:i")?> (<?=gethostbyaddr($_SERVER["REMOTE_ADDR"])?>)");
		terminal.resume();
	}
});
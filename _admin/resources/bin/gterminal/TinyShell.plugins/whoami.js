
/**
 * Who am I?
**/
TinyShell.plugins.whoami = new Class({
	description: "Show username",
	run : function(terminal) {
		terminal.print(terminal.user);
		terminal.resume();
	}
});

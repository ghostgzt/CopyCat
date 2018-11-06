
/**
 * Clear screen
**/
TinyShell.plugins.clear = new Class({
	description: "Clear history",
	run : function(terminal) {
		terminal.clear_history();
		terminal.resume();
	}
});

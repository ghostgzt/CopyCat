
/**
 * Help
**/
TinyShell.plugins.help = new Class({
	description: "Show help",
	run : function(t) {
		t.print("TinyShell:");
		t.print("Version "+TinyShell.version);
		t.print();
		t.print("Special keyboard actions:");
		t.print("UP ARROW            Previous command");
		t.print("DOWN ARROW          Next command");
		t.print("TAB                 Autocomplete");
		t.print("SHIFT+ENTER         New line");
		t.print("SHIFT+UP ARROW      Line up");
		t.print("SHIFT+DOWN ARROW    Line down");
		t.print();
		t.print("Installed command plugins:");
		var plugs = [];
		for (plugin in TinyShell.plugins) plugs.push(plugin+this.repeat(" ", 19-plugin.length)+" "+$pick(new TinyShell.plugins[plugin]().description, "No description available"));
		plugs.sort();
		t.print(plugs.join("\n"));
		t.resume();
	},
	repeat : function ($s, $n) {
		r = "";
		for (var i = 0; i < $n; i++) r += $s;
		return r;
	}
});

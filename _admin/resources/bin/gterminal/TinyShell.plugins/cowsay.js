
/**
 * Cowsay
**/
TinyShell.plugins.cowsay = new Class({
	description: "Express yourself as a cow",
	run : function(t, args, line) {
		var text = (args.length ? args[0] : "Moooh ?!").split("\n");
		var rows = text.length;
		var cols = 0;
		for (var i = 0; i < rows; i++) if (text[i].length > cols) cols = text[i].length;
		t.print();
		t.print("  _"+this.repeat("_", cols)+"_ ");
		for (var i = 0; i < rows; i++) t.print(" "+(rows<2?"<":!i?"/":i+1<rows?"|":"\\")+" "+text[i]+this.repeat(" ", cols-text[i].length)+" "+(rows<2?">":!i?"\\":i+1<rows?"|":"/"));
		t.print("  -"+this.repeat("-", cols)+"- ");
		t.print("    \\   ^__^");
		t.print("     \\  (oo)\\_______");
		t.print("        (__)\\       )\\/\\");
		t.print("            ||----w |");
		t.print("            ||     ||");
        t.print();
		t.resume();
	},
	repeat: function(str, n) {
		var space = "";
		for (var i = 0; i < n; i++) space += str;
		return space;
	}
});


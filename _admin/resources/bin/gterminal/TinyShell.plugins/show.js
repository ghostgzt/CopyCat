
/**
 * Show
**/
TinyShell.plugins.show = new Class({
	description: "Show copyright and license",
	run : function(t) {
		var license = [];
		license.push("Copyright (c) 2010 Theis Mackeprang");
		license.push("");
		license.push("Permission is hereby granted, free of charge, to any person obtaining a copy");
		license.push("of this software and associated documentation files (the \"Software\"), to deal");
		license.push("in the Software without restriction, including without limitation the rights");
		license.push("to use, copy, modify, merge, publish, distribute, sublicense, and/or sell");
		license.push("copies of the Software, and to permit persons to whom the Software is");
		license.push("furnished to do so, subject to the following conditions:");
		license.push("");
		license.push("The above copyright notice and this permission notice shall be included in");
		license.push("all copies or substantial portions of the Software.");
		license.push("");
		license.push("THE SOFTWARE IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR");
		license.push("IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,");
		license.push("FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE");
		license.push("AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER");
		license.push("LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,");
		license.push("OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN");
		license.push("THE SOFTWARE.");
		license.push("");
		t.print(license.join("\n"));
		t.resume();
	}
});


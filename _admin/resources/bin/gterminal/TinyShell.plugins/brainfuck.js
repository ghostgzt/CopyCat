
/**
 * Javascript brainfuck interpreter, inspired
 * by http://www.muppetlabs.com/~breadbox/bf/
**/
TinyShell.plugins.brainfuck = new Class({
	description: "Interpret brainfuck code",
	run : function(t, args) {
		if (!args.length) {
			t.print("brainfuck: usage: brainfuck code [input]  ,like: \n brainfuck ++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.  ");
			t.resume();
			return;
		}
	    var commands = {
	        '>' : "++p;",
	        '<' : "--p;",
	        '+' : "if(++array[p]>255)array[p]=0;", // modulus
	        '-' : "if(--array[p]<0)array[p]=255;", // modulus
	        '.' : "output.push(array[p]);",
	        ',' : "array[p]=input.shift()||0;",
	        '[' : "while(array[p]){",
	        ']' : "}"
	    }
	    var output = [];
	    var input = [];
	    if (args.length > 1) for (var i = 0; i < args[1].length; i++) input.push(args[1].charCodeAt(i));
	    var js = "var array=[];for(var j=0;j<30000;j++){array[j]=0;};var p=0;";
	    for(var i = 0; i < args[0].length; i++) if ($defined(commands[args[0].charAt(i)])) js += commands[args[0].charAt(i)];
	    eval(js);
	    var outstr = "";
	    for(var i = 0; i < output.length; i++) outstr += String.fromCharCode(output[i]);
	    t.print(outstr);
	    t.resume();
	}
});

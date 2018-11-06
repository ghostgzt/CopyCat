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

var TinyShell = {
	version: "3.0",
	plugins: {}
};

TinyShell.shell = new Class({
	home : '',
	dir : "/",
	user : "guest",
	pass : "",
	server : '',
	commandhistory : new Array(''),
	commandhistorypointer : -1,
	tempcommand : "",
	proc : null,
	proc_name : "",
	cursor : null,
	cursortimer : null,
	onkeypress : [],
	onkeydown : [],
	_hmac_next_salt : "",
	_session_id : "",
	
	run : function(home, server, hmac_next_salt, session_id) {
		this.home = home;
		this.server = server;
		this.commandline = $('terminal-cl');
		this.input = $('terminal-input');
		this.protocol = $('terminal-protocol');
		this.shellhistory = this.history = $('terminal-history');
		this.window = $('terminal-window');
		this.dir = this.home;
		this._hmac_next_salt = hmac_next_salt;
		this._session_id = session_id;

		document.addEvent('keydown', (function(e) {
			if (this._no_events) return;
			var $cont = true;
			if (this.proc && this.proc.onkeydown) $cont = this.proc.onkeydown(e);
			if ($cont) this.onkeydown.each(function(f) { if ($cont) $cont = f.run(e, this); }, this); // extras
			if ($cont && this._onkeydown) this._onkeydown(e);
		}).bindWithEvent(this));
		document.addEvent('keypress', (function(e) {
			if (this._no_events) return;
			var $cont = true;
			if (this.proc && this.proc.onkeypress) $cont = this.proc.onkeypress(e);
			if ($cont) this.onkeypress.each(function(f) { if ($cont) $cont = f.run(e, this); }, this); // extras
			if ($cont && this._onkeypress) this._onkeypress(e); // native
		}).bindWithEvent(this));
		
		this.execute('login');
	},
	// API / general functions
	ticket_hash : function(ticket, msg) {
		return this._sha1(ticket+(this._sha1(ticket+msg)));
	},
	get_process_name : function() {
		return this.proc ? this.proc_name : "";
	},
	print : function(content, html, wrap) {
		// this function forces pre to display multiple newlines and spaces.
		if (typeof content == 'object') content.inject(this.history);
		else new Element("div", {'class':wrap?'prewrap':'pre'}).set('html', content && typeof content == 'string' ? this._format_pre(content, html) : "&nbsp;").inject(this.history);
		this.scroll_to_cursor();
		return this;
	},
	ajax_request: function(callback, uri, postdata, async) {
		if (!async) this._no_events = true;
		var cb = function(a, b) {
			// retrieve next salt
			this._hmac_next_salt = a.split(":",1)[0];
			a = a.substring(this._hmac_next_salt.length+1);
			// check for errors before continueing
			var error = a.substring(0, 1);
			if (error == "1") {
				this.cursor_print();
				this.cursor_overwrite('');
				this.print("Your session has expired.");
				this.execute('login');
			}
			else if (error == "2") {
				this.cursor_print();
				this.cursor_overwrite('');
				this.dir = a.substring(1);
				this.print("A working dir error occured.");
				this.resume();
			}
			else if (error == "3") {
				this.cursor_print();
				this.cursor_overwrite('');
				this.print("Sync error, please try again.");
				this.resume();
			}
			else callback.run([a.substring(1), b], this.proc || this);
			this._no_events = false;
		}
		new Request({
			'url': uri+"?ajax=1&ajax_hmac="+this._hmac(postdata)+"&ajax_cwd="+encodeURIComponent(this.dir)+"&tssid="+this._session_id,
			'data': postdata,
			'onComplete': cb.bind(this),
			'method': 'post',
			'async': async,
			'link': 'chain',
			'onFailure': function() {
				this.print("Connection error..");
				this.resume();
			}.bind(this)
		}).send();
		
	},
	read_line : function($callback) {
		this._init_shell();
		this.read_line_call_back = $callback.bind(this.proc || this);
		return this;
	},
	set_protocol : function($v, $type) {
		this.protocol.set('html',$v);
		if ($type == "password")	this.input.addClass('password');
		else						this.input.removeClass('password');
		this.input.setProperty('inputtype', $type);
		return this;
	},
	reset_protocol : function($v) {
	//alert(this.cwd);	
		this.set_protocol(this.user+"@"+this.server+"->"+((this.dir.substr(0,this.cwd.length)==this.cwd)?("~"+this.dir.substr(this.cwd.length)):(this.dir))+"$ ");
		return this;
	},
	get_protocol : function() {
		return this.protocol.get('text');
	},
	pause : function() {
		this._blur();
		this.commandline.setStyle('display','none');
		return this;
	},
	resume : function() {
		this.reset_protocol();
		this.cursor_overwrite('')
		this.history = this.shellhistory.setStyle('display','block');
		this.window.setStyle('display','none');
		this._init_shell();
		if (this.proc) delete this.proc;
		this.proc = null;
		return this;
	},
	create_url: function(u, p) {
		// tiny shell get parameters after p, to make sure they are overwritten to be correct if in p also
		return u+"?"+p+"&ajax_cwd="+encodeURIComponent(this.dir)+"&ajax=2&ajax_hmac="+this._hmac("")+"&tssid="+this._session_id;
	},
	parse_args : function(args) {
		var arga = new Array(); var temp = ''; var inquotes = false; var c = '';
		
		for (var i = 0; i < args.length; i++) {
			c = args.charAt(i);
			if (c == "\\") {
				if (++i < args.length) temp += args.charAt(i) == 'n' ? '\n' : args.charAt(i);
				continue;
			} else if (c == '"' || c == "'") {
				if (inquotes) {
					if (c == inquotes) inquotes = false;
					else temp += c;
				} else inquotes = c;
				continue;
			} else if (c == ' ' || c == '\n') {
				if (!inquotes) {
					if (temp.length) arga.push(temp);
					temp = '';
					continue;
				} else temp += c;
			} else temp += c;
		}
		if (inquotes !== false) return false;
		
		if (temp.length) arga.push(temp);
		
		return arga;
	},
	execute : function(program, args, line) {
		args = args || [];
		var proc;
		proc = new TinyShell.plugins[program]();
		this.pause();
		this.proc_name = program;
		if (this.proc) delete this.proc;
		this.proc = proc;
		proc.run(this, args, line || '');
	},
	scroll_to_cursor : function() {
		var scroll = (function() {
			var l, t;
			if (this.cursor_is_active()) {
				l = Math.max(0, this.cursor.offsetLeft+Math.round(this.cursor.offsetWidth/2)-Math.round(document.documentElement.clientWidth/2));
				t = Math.max(0, this.cursor.offsetTop-Math.round(document.documentElement.clientHeight/3));
			} else {
				l = 0;
				t = document.body.offsetHeight;
			}
			window.scrollTo(l, t);
		}).bind(this);
		// hack to make sure content is rendered before scrolling (1 for fast browsers, 100 for slow; execute both):
		scroll.delay(1);
		scroll.delay(100);
		return this;
	},
	clear_history : function() {
		this.history.empty();
		return this;
	},
	exit : function() {
		this.pause();
		this.history = this.window.setStyle('display','block');
		this.shell.setStyle('display','none');
		return this;
	},
	cursor_read_line : function(f) {
		// buggy for ie support
		var cmd = "";
		var a = this.input.getFirst();
		if (a && a.getNext()) do {
			cmd += f ? (a.getProperty('char') == '\n' ? " \n> " : a.get('text')) : a.getProperty('char');
			a = a.getNext();
		} while (a.getNext());
		return cmd;
	},
	cursor_read_word : function() {
		var sa = [];
		var c = this.cursor;
		while (c.getPrevious()) {
			c = c.getPrevious();
			if (!c.get('text').test(/\s/)) sa.push(c.getProperty('char'));
			else break;
		}
		return sa.reverse().join("");
	},
	cursor_indexOf : function(f) {
		// buggy for ie support
		var offset = 0;
		var a = this.input.getFirst();
		if (a && a.getNext()) do {
			if (a.getProperty('char') == f) return offset;
			a = a.getNext();
			offset++;
		} while (a.getNext());
		return -1;
	},
	cursor_autocomplete : function(r, l) {
		if (this.cursor_is_active()) {
			r = r.split(/[\r\n]+/);
			sa = typeof l == 'string' ? l : this.cursor_read_word();
			var sug = "";
			var sugs = [];
			for (var i = 0; i < r.length; i++) if (r[i].length > sa.length && r[i].substring(0, sa.length) == sa) {
				if (sugs.length) {
					if (sug.length > sa.length) {
						var old_sug = sug;
						var new_sug = r[i];
						sug = 0;
						for (var j = 0; j < old_sug.length && j < new_sug.length && new_sug.charAt(j) == old_sug.charAt(j); j++) sug++;
						sug = old_sug.substring(0, sug);
					}
				} else sug = r[i];
				sugs.push(r[i]);
			}
			if (sugs.length) {
				if (sug.length <= sa.length) {
					sugs.sort();
					this.cursor_print();
					this.print(sugs.join("\t").replace(/\s+/g, ' '), false, true);
				} else this.cursor_write(sug.substring(sa.length));
			}
		}
		this.scroll_to_cursor();
	},
	cursor_print : function() {
		this.print(this.get_protocol()+(this.input.getProperty('inputtype') == "password" ? "" : this.cursor_read_line(1)));
	},
	cursor_is_active : function() {
		return this.cursor && this.commandline.getStyle('display') != "none";
	},
	cursor_execute : function(no_history, no_print) {
		if (!no_print) this.cursor_print();
		var line = this.cursor_read_line();
		this.cursor_overwrite('');
		
		var args = this.parse_args(line);
		
		this.commandhistorypointer = -1;
		this.tempcommand = "";
		if (!no_history && line.length && this.input.getProperty('inputtype') != "password") this.commandhistory.unshift(line);
		
		if (this.proc != null) {
			try {
				this.pause();
				this.read_line_call_back(this, line, args, args.length);
			} catch (e) {
				this.print("-TinyShell: Runtime error ("+e+")");
				this.resume();
			}
		} else {
			if (args === false) this.print("-TinyShell: command error: unescaped quotes");
			else if(args.length) {
				try {
					var program = args.shift();//.replace(/[^a-z0-9-_]/ig, '');
					this.execute(program, args, line);
				} catch (e) {
					try {
						// redirect to sys plugin if installed
						this.execute('sys', args, 'sys '+line);
					} catch (e2) {
						this.print("-TinyShell: "+program+": command not found ("+e+")");
						this.resume();
					}
				}
			}
		}
	},
	cursor_overwrite : function($v) {
		this._blur();
		this.cursor = false;
		this.input.empty();
		for (var i = 0; i < $v.length; i++) new Element("span").inject(this.input).setProperty('char', $v.charAt(i)).set( ($v.charAt(i)==" "||$v.charAt(i)=="\n"?'html':'text'), $v.charAt(i) == "\n" ? " <br>&gt; " : ($v.charAt(i)==" "?"&nbsp;":$v.charAt(i)));
		this._focus();
		this.scroll_to_cursor();
		return this;
	},
	encodeHtml : function(s){
      return (typeof s != "string") ? s :
          s.replace(this.REGX_HTML_ENCODE,
                    function($0){
                        var c = $0.charCodeAt(0), r = ["&#"];
                        c = (c == 0x20) ? 0xA0 : c;
                        r.push(c); r.push(";");
                        return r.join("");
                    });
  },
	cursor_write : function($c) {
		if ($c.length < 1) return false;
		$c = $c.replace(/\r/g, " ");
		for (var i = 0; i < $c.length; i++) new Element("span").injectBefore(this.cursor).setProperty('char', $c.charAt(i)).set( ($c.charAt(i)==" "||$c.charAt(i)=="\n"?'html':'text'), $c.charAt(i) == "\n" ? " <br>&gt; " : ($c.charAt(i)==" "?"&nbsp;":$c.charAt(i)));
		this._focus();
		this.scroll_to_cursor();
		return true;
	},
	cursor_delete : function() {
		if (this.cursor_is_active() && this.cursor.getNext()) {
			this._blur();
			this.cursor = this.cursor.getNext();
			this.cursor.getPrevious().destroy();
			this._focus();
			this.scroll_to_cursor();
			return true;
		}
		return false;
	},
	cursor_erase : function() {
		if (this.cursor_is_active() && this.cursor.getPrevious()) {
			this.cursor.getPrevious().destroy();
			this._focus();
			this.scroll_to_cursor();
			return true;
		}
		return false;
	},
	cursor_move : function(dir) {
		if (this.cursor_is_active() && dir > 0) {
			if (this.cursor.getNext()) {
				this._blur();
				this.cursor = this.cursor.getNext();
				this._focus();
				this.scroll_to_cursor();
				return true;
			}
		} else {
			if (this.cursor.getPrevious()) {
				this._blur();
				this.cursor = this.cursor.getPrevious();
				this._focus();
				this.scroll_to_cursor();
				return true;
			}
		}
		return false;
	},
	cursor_move_home : function() {
		if (this.cursor_is_active()) {
			this._blur();
			this.cursor = this.input.getFirst();
			this._focus();
			this.scroll_to_cursor();
			return true;
		}
		return false;
	},
	cursor_move_end : function() {
		if (this.cursor_is_active()) {
			this._blur();
			this.cursor = this.input.getLast();
			this._focus();
			this.scroll_to_cursor();
			return true;
		}
		return false;
	},
	// CORE FUNCTIONS:
	_format_pre : function(c, html) {
		if (!html) c = c.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
		return c.replace(/\r/g, "").replace(/\n(?=\n|$)/g, "\n&nbsp;").replace(/\ (?=\ |$)/g, "&nbsp;").replace(/\n/g, "<br />");
	},
	_init_shell : function() {
		this.commandline.setStyle('display','block');
		this._focus();
		this.scroll_to_cursor();
		return this;
	},
	_focus : function() {
		if (!this.cursor_is_active()) this.cursor = new Element("span").inject(this.input).set('html',"&nbsp;");
		else this._blur();
		this.cursor.addClass('cursor');
		this.cursor.highlighted = 1;
		this.cursortimer = window.setInterval(this._blink.bind(this), 500);
		return this.cursor;
	},
	_blur : function() {
		$clear(this.cursortimer);
		if (this.cursor) {
			this.cursor.removeClass('cursor');
			this.cursor.highlighted = 0;
		}
	},
	_blink : function() {
		if (this.cursor.highlighted) {
			this.cursor.removeClass('cursor');
			this.cursor.highlighted = 0;
		} else {
			this.cursor.addClass('cursor');
			this.cursor.highlighted = 1;
		}
	},
	_cursor_paste : function() {
		this.cursor_write($('keyboard-trigger').value);
		$('keyboard-trigger').value = "";
	},
	_hmac: function(message) {
		// prepare
		var hash = this._sha1;
		var blocksize = 64; // bytes
		var key = this.user+this.pass;
		// produce keys
		if (key.length > blocksize) key = hash(key); // shorten long keys
		if (key.length < blocksize) key = key + new Array(blocksize-key.length+1).join(0x00);
		var o_key_pad = this._xor(new Array(blocksize+1).join(0x5c), key);
		var i_key_pad = this._xor(new Array(blocksize+1).join(0x36), key);
		// return hmac
		return hash(o_key_pad + hash(i_key_pad + this._hmac_next_salt + message));
	},
	_xor: function(a, b) {
		var l = Math.min(a.length, b.length);
		var c = [];
		for (var i = 0; i < l; ++i) c.push(String.fromCharCode(a.charCodeAt(i) ^ b.charCodeAt(i)));
		return c.join("");
	},
	/**
	*
	*  Secure Hash Algorithm (SHA1)
	*  http://www.webtoolkit.info/
	*
	**/
	_sha1 : function (msg) {
		function rotate_left(n,s) {
			var t4 = ( n<<s ) | (n>>>(32-s));
			return t4;
		}
		function lsb_hex(val) {
			var str="";
			var i;
			var vh;
			var vl;
			for( i=0; i<=6; i+=2 ) {
				vh = (val>>>(i*4+4))&0x0f;
				vl = (val>>>(i*4))&0x0f;
				str += vh.toString(16) + vl.toString(16);
			}
			return str;
		}
		function cvt_hex(val) {
			var str="";
			var i;
			var v;
			for( i=7; i>=0; i-- ) {
				v = (val>>>(i*4))&0x0f;
				str += v.toString(16);
			}
			return str;
		}
		function Utf8Encode(string) {
			string = string.replace(/\r\n/g,"\n");
			var utftext = "";
			for (var n = 0; n < string.length; n++) {
				var c = string.charCodeAt(n);
				if (c < 128) {
					utftext += String.fromCharCode(c);
				}
				else if((c > 127) && (c < 2048)) {
					utftext += String.fromCharCode((c >> 6) | 192);
					utftext += String.fromCharCode((c & 63) | 128);
				}
				else {
					utftext += String.fromCharCode((c >> 12) | 224);
					utftext += String.fromCharCode(((c >> 6) & 63) | 128);
					utftext += String.fromCharCode((c & 63) | 128);
				}
			}
			return utftext;
		}
		var blockstart;
		var i, j;
		var W = new Array(80);
		var H0 = 0x67452301;
		var H1 = 0xEFCDAB89;
		var H2 = 0x98BADCFE;
		var H3 = 0x10325476;
		var H4 = 0xC3D2E1F0;
		var A, B, C, D, E;
		var temp;
		msg = Utf8Encode(msg);
		var msg_len = msg.length;
		var word_array = new Array();
		for( i=0; i<msg_len-3; i+=4 ) {
			j = msg.charCodeAt(i)<<24 | msg.charCodeAt(i+1)<<16 |
			msg.charCodeAt(i+2)<<8 | msg.charCodeAt(i+3);
			word_array.push( j );
		}
		switch( msg_len % 4 ) {
			case 0:
				i = 0x080000000;
				break;
			case 1:
				i = msg.charCodeAt(msg_len-1)<<24 | 0x0800000;
				break;
			case 2:
				i = msg.charCodeAt(msg_len-2)<<24 | msg.charCodeAt(msg_len-1)<<16 | 0x08000;
				break;
			case 3:
				i = msg.charCodeAt(msg_len-3)<<24 | msg.charCodeAt(msg_len-2)<<16 | msg.charCodeAt(msg_len-1)<<8	| 0x80;
				break;
		}
		word_array.push( i );
		while( (word_array.length % 16) != 14 ) word_array.push( 0 );
		word_array.push( msg_len>>>29 );
		word_array.push( (msg_len<<3)&0x0ffffffff );
		for ( blockstart=0; blockstart<word_array.length; blockstart+=16 ) {
			for( i=0; i<16; i++ ) W[i] = word_array[blockstart+i];
			for( i=16; i<=79; i++ ) W[i] = rotate_left(W[i-3] ^ W[i-8] ^ W[i-14] ^ W[i-16], 1);
			A = H0;
			B = H1;
			C = H2;
			D = H3;
			E = H4;
			for( i= 0; i<=19; i++ ) {
				temp = (rotate_left(A,5) + ((B&C) | (~B&D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
				E = D;
				D = C;
				C = rotate_left(B,30);
				B = A;
				A = temp;
			}
			for( i=20; i<=39; i++ ) {
				temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
				E = D;
				D = C;
				C = rotate_left(B,30);
				B = A;
				A = temp;
			}
			for( i=40; i<=59; i++ ) {
				temp = (rotate_left(A,5) + ((B&C) | (B&D) | (C&D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
				E = D;
				D = C;
				C = rotate_left(B,30);
				B = A;
				A = temp;
			}
			for( i=60; i<=79; i++ ) {
				temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
				E = D;
				D = C;
				C = rotate_left(B,30);
				B = A;
				A = temp;
			}
			H0 = (H0 + A) & 0x0ffffffff;
			H1 = (H1 + B) & 0x0ffffffff;
			H2 = (H2 + C) & 0x0ffffffff;
			H3 = (H3 + D) & 0x0ffffffff;
			H4 = (H4 + E) & 0x0ffffffff;
		}
		var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);
		return temp.toLowerCase();
	}
});


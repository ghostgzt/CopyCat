/**
 * File with native events
**/
ts._onkeydown = function(event) {
	if (!this.cursor_is_active()) return;
	
	var stop_event = true;
	switch (event.key) {
		case "up":
			if (event.shift) {
				if (this.cursor_is_active()) {
					this._blur();
					var cline = 0;
					while (this.cursor.getPrevious()) {
						if (this.cursor.getPrevious().getProperty('char') == '\n' && cline++) break;
						this.cursor = this.cursor.getPrevious();
					}
					this._focus();
				}
			} else {
				if (this.commandhistorypointer == -1) this.tempcommand = this.cursor_read_line();
				if (this.commandhistorypointer + 1 < this.commandhistory.length) this.cursor_overwrite(this.commandhistory[++this.commandhistorypointer]);
			}
			this.scroll_to_cursor();
			break;
		case "down":
			if (event.shift) {
				if (this.cursor_is_active()) {
					this._blur();
					while (this.cursor.getNext()) {
						if (this.cursor.getProperty('char') == '\n') {
							this.cursor = this.cursor.getNext();
							break;
						}
						this.cursor = this.cursor.getNext();
					}
					this._focus();
				}
			} else if (this.commandhistorypointer - 1 >= -1) this.cursor_overwrite(--this.commandhistorypointer<0?this.tempcommand:this.commandhistory[this.commandhistorypointer]);
			this.scroll_to_cursor();
			break;
		case "left":
			this.cursor_move(-1);
			break;
		case "right":
			this.cursor_move(1);
			break;
		case "enter":
			if (event.shift) this.cursor_write("\n");
			else this.cursor_execute.bind(this)();
			break;
		case "backspace":
			this.cursor_erase();
			break;
		case "delete":
			this.cursor_delete();
			break;
		case "tab":
			this.cursor_write("\t");
			break;
		case "v":
			if 	(event.control) {
				$('keyboard-trigger').focus();
				this._cursor_paste.delay(1, this);
			}
			stop_event = false;
			break;
		default:
			switch (event.code) {
				/*case 32: // space
					//this.cursor_write(" ");
					break;*/
				case 35: // end
					this.cursor_move_end();
					break;
				case 36: // home
					this.cursor_move_home();
					break;
				default:
					stop_event = false;
			}
			break;
	}
	if (stop_event) event.stop();
	
}

ts._onkeypress = function(event) {
	if (!this.cursor_is_active()) return;
	
	var allow_keypress = false;
	if ($defined(event.event.charCode) && !event.event.charCode) {
		// special key pressed (in IE this event does not fire at all)
		switch (event.code) {
			case 33: // page up
			case 34: // page down
			case 91: // windows key
			case 93: // right mouse key
			case 112: // f1
			case 113: // f2
			case 114: // f3
			case 115: // f4
			case 116: // f5
			case 117: // f6
			case 118: // f7
			case 119: // f8
			case 120: // f9
			case 121: // f10
			case 122: // f11
			case 123: // f12
				// allow these keys to be pressed
				break;
			default:
				// we dont know it, we dont want it
				event.stop();
				break;
		}
	} else {
		// a character is pressed
		switch (event.key) {
			case "esc":
				break;
			case "c": // copy ?
				if (!event.control) allow_keypress = true;
				break;
			case "v": // paste ?
				if 	(!event.control) allow_keypress = true;
				break;
			default:
				allow_keypress = true;
		}
	}
	
	if (allow_keypress) {
		event = new Event(event);
		this.cursor_write(String.fromCharCode(event.code));
		event.stop();
	}
	
}

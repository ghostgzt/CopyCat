
/**
 * If in a multiline statement, make new line on enter and change lines with arrows.
 * Then hold shift to browse command history or fire command.
**/
ts.onkeydown.push(function(e) {
	if (this.cursor_indexOf('\n') == 0) switch (e.key) {
		case 'enter':
		case 'up':
		case 'down':
			e.shift = !e.shift;
			break;
	}
	return true;
});
$.post("index.php", {
	Action: "post",
	op: "load",
	name: "settings"
},
function(data, textStatus) {
	if (data.file) {
		config = data.file;
	}
},
"json");
$.post("index.php", {
	Action: "post",
	op: "settings"
},
function(data, textStatus) {
	num = data.length;
	tdata = data;
	loadss(data);
},
"json");
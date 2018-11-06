$.post("index.php", {
	Action: "post",
	op: "pages",
	zs: "100"
},
function(data, textStatus) {
	num = data.length;
	tdata = data;
	loadpp(data);
},
"json");
$.post("../copycatdeal", {
	op: "loadroot"
},
function(data, textStatus) {
	document.getElementById("root").value = data;
});
$.get("resources/tpl/settings.modules_left.tpl",
function(data, textStatus) {
	if (data) {
		document.getElementById("tdel").innerHTML = data;
		if (xhash[1]) {
			$("#moremenu").css("display","block");
		}
	}
});
if (xhash[1]) {
	config = htmlcl(xhash[1]);
	loadconfig(config);
	$(".title").html("基本设置::" + config+" [修改]");
} else {

	$.post("index.php", {
		Action: "post",
		op: "load",
		name: "settings"
	},
	function(data, textStatus) {
		if (data.file) {
			config = data.file;
			loadconfig(config);
			$(".title").html("基本设置::" + config);
		}
	},
	"json");
}



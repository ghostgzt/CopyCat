if (xhash[1]) {
	config = htmlcl(xhash[1]);
	$(".title").html("内容替换::" + config+" [修改]");
} else {
	config = "";
}
$.get("resources/tpl/settings.modules_left.tpl",
	function(data, textStatus) {
		if (data) {
			document.getElementById("tdel").innerHTML = data;
		}
	});
load('replaces',0,config);
load('locations',0,config);
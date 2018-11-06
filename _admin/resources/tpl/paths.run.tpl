if (xhash[1]) {
	config = htmlcl(xhash[1]);
	$(".title").html("路径映射::" + config+" [修改]");
} else {
	config = "";
}
$.get("resources/tpl/settings.modules_left.tpl",
	function(data, textStatus) {
		if (data) {
			document.getElementById("tdel").innerHTML = data;
		}
	});
load('path',0,config);
load('ips',0,config);
if (xhash[1]) {
	config = htmlcl(xhash[1]);
	$(".title").html("自定义页面::" + config+" [修改]");
} else {
	config = "";
}
$.get("resources/tpl/settings.modules_left.tpl",
	function(data, textStatus) {
		if (data) {
			document.getElementById("tdel").innerHTML = data;
		}
	});
load('page',0,config);
load('mime',0,config);

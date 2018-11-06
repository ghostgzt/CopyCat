if (xhash[1]) {
	$('html,body').animate({
		scrollTop: $("#" + xhash[1]).offset().top
	},
	500);
}
$.get("resources/ext/rule.txt",
function(data, textStatus) {
	document.getElementById("rule").value = data;
});
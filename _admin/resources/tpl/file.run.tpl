if (xhash[1]) {
	if (xhash[1] == "runcode") {
		document.getElementById("file").src = "/gftp.php?op=run";
	} else {
		if(xhash[1].substr(0,2)=="->"){
			document.getElementById("file").src = "/gftp.php"+xhash[1].substring(2);
		}else{
			$.post("index.php", {
				op: "realpath",
				name: xhash[1]
			},
			function(data, textStatus) {
				if (data) {
					document.getElementById("file").src = "/gftp.php?op=home&folder=" + data;
				} else {
					document.getElementById("file").src = "/gftp.php";
				}
			});
		}
	}
} else {
	document.getElementById("file").src = "/gftp.php";
}
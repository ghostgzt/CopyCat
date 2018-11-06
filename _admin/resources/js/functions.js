function ResumeError() {
	return true;
}
//window.onerror = ResumeError;
var config, num, tdata, isss;
var site = cron = page = mime = replaces = locations = path = ips = [];
$.post("index.php", {
	op: "fastverify"
},
function(data, textStatus) {
	if (!data) {
		window.location.href = "login.html";
		exit();
	} else {
		$.post("index.php", {
			op: "readsite"
		},
		function(data, textStatus) {
			if (!isss && !data) {
				alert("请设置好当前站点！");
				//window.location.href = "index.html?_="+(new Date().getTime())+"#site";
				turnurl("index.html#site");
				/*window.location.reload();*/
			}
		});		
		if (document.getElementById("logname")) {
			document.getElementById("logname").innerHTML = data + ",";
		}
	}
});
function resizex(iframe) {
	var shh = window.pageYOffset;
	iframe.height = 0;
	iframe.height = iframe.contentWindow.document.documentElement.scrollHeight;
	window.scroll(0, shh);
}
function turnurl(url,type){
	if(!type){
		type="_self";
	}
	window.open(url,type);
	//window.location.href=url;
	if(type=="_self"){
		setTimeout(function(){window.location.reload()},500);		
	}
}
//gotop
function gotoTop(min_height) {
	var gotoTop_html = '<div id="gotoTop">返回顶部</div>';
	$("#footer").append(gotoTop_html);
	$("#gotoTop").click(function() {
		$('html,body').animate({
			scrollTop: 0
		},
		700);
	}).hover(function() {
		$(this).addClass("hover");
	},
	function() {
		$(this).removeClass("hover");
	});
	min_height ? min_height = min_height: min_height = 100;
	$(window).scroll(function() {
		var s = $(window).scrollTop();
		if (s > min_height) {
			$("#xsubmenu").css("position","fixed");
			$("#gotoTop").fadeIn(100);
		} else {
			$("#xsubmenu").css("position","inherit");		
			$("#gotoTop").fadeOut(200);
		};
	});
};

//写cookies
function setCookie(name, value) {
	var Days = 30;
	var exp = new Date();
	exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
	document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
}
//读取cookies
function getCookie(name) {
	var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
	if (arr = document.cookie.match(reg)) return unescape(arr[2]);
	else return null;
}
//删除cookies
function delCookie(name) {
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval = getCookie(name);
	if (cval != null) document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
}
function logout() {
	delCookie("copycat_user");
	delCookie("copycat_passwd");
	window.location.href = "login.html";
}
function importsettings(source,table) {  

    var file = source.files[0];  
    if(window.FileReader) {  
        var fr = new FileReader();  
        fr.onloadend = function(e) {  
			loadsetting(table,b.decode(e.target.result.split(",")[1]));
        };  
        fr.readAsDataURL(file);  
    }  

}  



//setting
function presave(table) {

	var host = document.getElementById("host").value;
	var zdroot = document.getElementById("zdroot").checked;
	var root = document.getElementById("root").value;
	var encoding = document.getElementById("encoding").value;
	var thym = document.getElementById("thym").checked;
	var thnr = document.getElementById("thnr").checked;
	var xczs = document.getElementById("xczs").checked;	
	var wyc = document.getElementById("wyc").checked;		
	var cjhc = document.getElementById("cjhc").checked;		
	var fyjt = document.getElementById("fyjt").checked;		
	var ymys = document.getElementById("ymys").checked;
	var dwjdl = document.getElementById("dwjdl").checked;
	var dwjzxz = document.getElementById("dwjzxz").value;	
	var fykg = document.getElementById("fykg").checked;	
	var fyyz = document.getElementById("fyyz").value;	
	var fylx = (document.getElementById("fylx").value) ? (document.getElementById("fylx").value) : ("text/html,text/xml,application/x-javascript,application/json");	
	var fybmd = (document.getElementById("fybmd").value) ? (document.getElementById("fybmd").value) : ("*");		
	var hckg = document.getElementById("hckg").checked;
	var hclx = document.getElementById("hclx").selectedIndex;
	var hcsx = (document.getElementById("hcsx").value) ? (document.getElementById("hcsx").value) : ("3600");
	var zydhc = document.getElementById("zydhc").value;
	var sjkg = document.getElementById("sjkg").checked;	
	var tjdm = document.getElementById("tjdm").value;	
	var tjbmd = document.getElementById("tjbmd").value;	
	var hxsz = document.getElementById("hxsz").selectedIndex;	
	var csz = document.getElementById("csz").selectedIndex;
	var zydc = document.getElementById("zydc").value;
	var llqbzsz = document.getElementById("llqbzsz").selectedIndex;
	var zydllqbz = document.getElementById("zydllqbz").value;
	var llsz = document.getElementById("llsz").selectedIndex;
	var zydll = document.getElementById("zydll").value;
	var ipsz = document.getElementById("ipsz").selectedIndex;
	var zydip = document.getElementById("zydip").value;
	var dlsz = document.getElementById("dlsz").selectedIndex;
	var zyddl = document.getElementById("zyddl").value;
	var dlgz = document.getElementById("dlgz").value;	
	var hgz = document.getElementById("hgz").value;		
	var hsz = document.getElementById("hsz").selectedIndex;
	var zydh = document.getElementById("zydh").value;
	var rr = '{"host":"' + b.encode(host) + '","zdroot":"' + b.encode(zdroot) + '","root":"' + b.encode(root) + '","encoding":"' + b.encode(encoding) + '","thym":"' + b.encode(thym) + '","thnr":"' + b.encode(thnr)+  '","wyc":"' + b.encode(wyc)  +  '","xczs":"' + b.encode(xczs) +'","cjhc":"' + b.encode(cjhc) +'","ymys":"' + b.encode(ymys) + '","dwjdl":"' + b.encode(dwjdl) +'","dwjzxz":"' + b.encode(dwjzxz) + '","fykg":"' + b.encode(fykg) +'","fyjt":"' + b.encode(fyjt) +'","fyyz":"' + b.encode(fyyz) +'","fylx":"' + b.encode(fylx) +'","fybmd":"' + b.encode(fybmd) +'","hckg":"' + b.encode(hckg) + '","hclx":"' + b.encode(hclx) + '","hcsx":"' + b.encode(hcsx) + '","zydhc":"' + b.encode(zydhc) +'","sjkg":"' + b.encode(sjkg) +'","tjdm":"' + b.encode(tjdm) +'","tjbmd":"' + b.encode(tjbmd) + '","hxsz":"' + b.encode(hxsz) + '","csz":"' + b.encode(csz) + '","zydc":"' + b.encode(zydc) + '","llqbzsz":"' + b.encode(llqbzsz) + '","zydllqbz":"' + b.encode(zydllqbz) + '","llsz":"' + b.encode(llsz) + '","zydll":"' + b.encode(zydll) + '","ipsz":"' + b.encode(ipsz) + '","zydip":"' + b.encode(zydip) + '","dlsz":"' + b.encode(dlsz) + '","zyddl":"' + b.encode(zyddl) + '","hgz":"' + b.encode(hgz)+ '","dlgz":"' + b.encode(dlgz) + '","hsz":"' + b.encode(hsz) + '","zydh":"' + b.encode(zydh) + '"}';
	return b.encode(rr);
}
function preload(table, data) {
	//alert(table);
	document.getElementById("host").value = b.decode(data.host);
	document.getElementById("zdroot").checked = ((b.decode(data.zdroot) == "false") ? (false) : (true));
	if (b.decode(data.zdroot) == 'false') {
		document.getElementById("customcheckbox_zdroot").className = "checkbox off";
		document.getElementById('zdrootp').style.display = 'block';
	} else {
		document.getElementById("customcheckbox_zdroot").className = "checkbox on";
	}
	if (((data.root) && (b.decode(data.zdroot) == 'false'))) {
		document.getElementById("root").value = b.decode(data.root);
	} else {
		$.post("../copycatdeal", {
			op: "loadroot"
		},
		function(data, textStatus) {
			document.getElementById("root").value = data;
		});
	}
	if(b.decode(data.encoding)){
		document.getElementById("encoding").value = b.decode(data.encoding);
	for(var i=0;i<document.getElementById("encoding").length;i++){
	if(document.getElementById("encoding").options[i].value==b.decode(data.encoding)){
	document.getElementById("encoding").selectedIndex=i;
	}
	}
	}else{
		document.getElementById("encoding").selectedIndex = 0;
	}	
	
	
	
	
	document.getElementById("thym").checked = ((b.decode(data.thym) == "true") ? (true) : (false));
	//alert(b.decode(data.thym));
	if (b.decode(data.thym) == 'true') {
		document.getElementById("customcheckbox_thym").className = "checkbox on";
		//document.getElementById('hcp').style.display='block';
	} else {
		document.getElementById("customcheckbox_thym").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}

	document.getElementById("thnr").checked = ((b.decode(data.thnr) == "true") ? (true) : (false));
	//alert(b.decode(data.thym));
	if (b.decode(data.thnr) == 'true') {
		document.getElementById("customcheckbox_thnr").className = "checkbox on";
		//document.getElementById('hcp').style.display='block';
	} else {
		document.getElementById("customcheckbox_thnr").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}

	document.getElementById("ymys").checked = ((b.decode(data.ymys) == "true") ? (true) : (false));
	//alert(b.decode(data.thym));
	if (b.decode(data.ymys) == 'true') {
		document.getElementById("customcheckbox_ymys").className = "checkbox on";
		//document.getElementById('hcp').style.display='block';
	} else {
		document.getElementById("customcheckbox_ymys").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}
	
	document.getElementById("xczs").checked = ((b.decode(data.xczs) == "true") ? (true) : (false));
	//alert(b.decode(data.thym));
	if (b.decode(data.xczs) == 'true') {
		document.getElementById("customcheckbox_xczs").className = "checkbox on";
		//document.getElementById('hcp').style.display='block';
	} else {
		document.getElementById("customcheckbox_xczs").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}	
	document.getElementById("wyc").checked = ((b.decode(data.wyc) == "true") ? (true) : (false));
	//alert(b.decode(data.thym));
	if (b.decode(data.wyc) == 'true') {
		document.getElementById("customcheckbox_wyc").className = "checkbox on";
		//document.getElementById('hcp').style.display='block';
	} else {
		document.getElementById("customcheckbox_wyc").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}		
	document.getElementById("cjhc").checked = ((b.decode(data.cjhc) == "true") ? (true) : (false));
	//alert(b.decode(data.thym));
	if (b.decode(data.cjhc) == 'true') {
		document.getElementById("customcheckbox_cjhc").className = "checkbox on";
		//document.getElementById('hcp').style.display='block';
	} else {
		document.getElementById("customcheckbox_cjhc").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}		
	
	document.getElementById("fyjt").checked = ((b.decode(data.fyjt) == "true") ? (true) : (false));
	//alert(b.decode(data.thym));
	if (b.decode(data.fyjt) == 'true') {
		document.getElementById("customcheckbox_fyjt").className = "checkbox on";
		//document.getElementById('hcp').style.display='block';
	} else {
		document.getElementById("customcheckbox_fyjt").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}		

	document.getElementById("dwjdl").checked = ((b.decode(data.dwjdl) == "true") ? (true) : (false));
	//alert(b.decode(data.thym));
	if (b.decode(data.dwjdl) == 'true') {
		document.getElementById("customcheckbox_dwjdl").className = "checkbox on";
		//document.getElementById('dwjdlp').style.display = 'block';
	} else {
		document.getElementById("customcheckbox_dwjdl").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}
	//alert(data.dwjzxz);

	if (data.dwjzxz) {
		document.getElementById("dwjzxz").value = b.decode(data.dwjzxz);
	} else {

		document.getElementById("dwjzxz").value = "1048576";
	}	
	
	document.getElementById("fykg").checked = ((b.decode(data.fykg) == "true") ? (true) : (false));
	//alert(b.decode(data.hckg));
	if (b.decode(data.fykg) == 'true') {
		document.getElementById("customcheckbox_fykg").className = "checkbox on";
		document.getElementById('fyp').style.display = 'block';
	} else {
		document.getElementById("customcheckbox_fykg").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}

	if(b.decode(data.fyyz)){
		document.getElementById("fyyz").value = b.decode(data.fyyz);
	for(var i=0;i<document.getElementById("fyyz").length;i++){
	if(document.getElementById("fyyz").options[i].value==b.decode(data.fyyz)){
	document.getElementById("fyyz").selectedIndex=i;
	}
	}
	}else{
		document.getElementById("fyyz").selectedIndex = 0;
	}
	//document.getElementById("fyyz").onchange();	
	document.getElementById("fylx").value = (b.decode(data.fylx))?(b.decode(data.fylx)):("text/html,text/xml,application/x-javascript,application/json");
	document.getElementById("fybmd").value = (b.decode(data.fybmd))?(b.decode(data.fybmd)):("*");	
	
	
	document.getElementById("hckg").checked = ((b.decode(data.hckg) == "true") ? (true) : (false));
	//alert(b.decode(data.hckg));
	if (b.decode(data.hckg) == 'true') {
		document.getElementById("customcheckbox_hckg").className = "checkbox on";
		document.getElementById('hcp').style.display = 'block';
	} else {
		document.getElementById("customcheckbox_hckg").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}

	document.getElementById("hclx").selectedIndex = b.decode(data.hclx);
	document.getElementById("hclx").onchange();

	document.getElementById("hcsx").value = b.decode(data.hcsx);

	document.getElementById("sjkg").checked = ((b.decode(data.sjkg) == "true") ? (true) : (false));
	//alert(b.decode(data.hckg));
	if (b.decode(data.sjkg) == 'true') {
		document.getElementById("customcheckbox_sjkg").className = "checkbox on";
		document.getElementById('sjkgp').style.display = 'block';
	} else {
		document.getElementById("customcheckbox_sjkg").className = "checkbox off";
		//document.getElementById("hckg").onchange();
	}	
	document.getElementById("tjdm").value = (b.decode(data.tjdm))?(b.decode(data.tjdm)):("");
	document.getElementById("tjbmd").value = (b.decode(data.tjbmd))?(b.decode(data.tjbmd)):("*");		
	
	
	document.getElementById("zydhc").value = b.decode(data.zydhc);
	document.getElementById("hxsz").selectedIndex = b.decode(data.hxsz);
	document.getElementById("csz").selectedIndex = b.decode(data.csz);
	document.getElementById("csz").onchange();
	document.getElementById("zydc").value = b.decode(data.zydc);
	document.getElementById("llqbzsz").selectedIndex = b.decode(data.llqbzsz);
	document.getElementById("llqbzsz").onchange();
	document.getElementById("zydllqbz").value = b.decode(data.zydllqbz);
	document.getElementById("llsz").selectedIndex = b.decode(data.llsz);
	document.getElementById("llsz").onchange();
	document.getElementById("zydll").value = b.decode(data.zydll);
	document.getElementById("ipsz").selectedIndex = b.decode(data.ipsz);
	document.getElementById("ipsz").onchange();
	document.getElementById("zydip").value = b.decode(data.zydip);
	document.getElementById("dlsz").selectedIndex = b.decode(data.dlsz);
	document.getElementById("dlsz").onchange();
	document.getElementById("zyddl").value = b.decode(data.zyddl);
	document.getElementById("dlgz").value =  (b.decode(data.dlgz))?(b.decode(data.dlgz)):("*");	
	document.getElementById("hgz").value =  (b.decode(data.hgz))?(b.decode(data.hgz)):("*");		
	document.getElementById("hsz").selectedIndex = b.decode(data.hsz);
	document.getElementById("hsz").onchange();
	document.getElementById("zydh").value = b.decode(data.zydh);
	loadqjcookie(document.getElementById("hxsz").selectedIndex);
	//alert(data.hclx);
}
function cleancache(xconfig,isfy) {
	if (!xconfig) {
		xconfig = "";
	}
	if (!isfy) {
		isfy = "";
	}	
	$.post("index.php", {
		op: "cleancache",
		config: xconfig,
		isfy: isfy
	},
	function(data, textStatus) {
		alert(xconfig+" " + ((isfy)?("翻译"):(""))+"缓存已清空");
	});
}
function delcache(dcp,xconfig) {
	if (!xconfig) {
		xconfig = "";
	}		
	$.post("../copycatdeal", {
		delcache: dcp,
		config: xconfig
	},
	function(data, textStatus) {
		alert(data);
	});
}
function delfycache(dcp,xconfig) {
	if (!xconfig) {
		xconfig = "";
	}		
	$.post("index.php", {
		op: "delfycache",
		set: dcp,
		config: xconfig
	},
	function(data, textStatus) {
		alert(data);
	});
}
function timefycache(dcp,xconfig) {
	if (!xconfig) {
		xconfig = "";
	}	
	$.get("../copycatdeal?op=cacheclean"+(xconfig?"&config="+xconfig:"")+"&time="+dcp+"&type=2",
	function(data, textStatus) {
		alert(data);
	});
}
function timecache(dcp,xconfig) {
	$.get("../copycatdeal?op=cacheclean"+(xconfig?"&config="+xconfig:"")+"&time="+dcp+"&type=1",
	function(data, textStatus) {
		alert(data);
	});
}
function cachepath(xconfig, isconfig,isfy) {
	if (!xconfig) {
		xconfig = "";
	}
	if (!isfy) {
		isfy = "";
	}	
	if (!isconfig) {
		isconfig = "";
	}
	$.post("index.php", {
		op: "cachepath",
		config: xconfig,
		isconfig: isconfig,
		isfy: isfy
	},
	function(data, textStatus) {
		//window.location.href = "index.html?_="+(new Date().getTime())+"#file|" + data;
		turnurl("index.html#file|" + data,"_blank");
		//window.location.reload();
	});
}
function wycpath() {
	$.post("index.php", {
		op: "wycpath"
	},
	function(data, textStatus) {
		//window.location.href = "index.html?_="+(new Date().getTime())+"#file|->" + data;
		turnurl("index.html#file|->" + data,"_blank");
		//window.location.reload();
	});
}

function saveconfig(table,tt) {
	if (!tt) {
		tt = "0";
	}else{
		tt = "1";
	}	
	/*var tt = "0";
	if ((xhash[1]) && (!confirm("是否启用为默认配置？"))) {
		tt = "1";
	}*/
	$.post("index.php", {
		op: "saveconfig",
		name: table,
		json: presave(table),
		type: tt
	},
	function(data, textStatus) {
		alert(table + " : " + data.result);
		if (xhash[1]&&tt=="0") {
			//window.location.href = 'index.html?_='+(new Date().getTime())+'#users';
			if(confirm("是否已完成配置修改?")){
				turnurl('index.html#users');	
			}
			/*window.location.reload();*/
		}else{
			if(tt=="1"){
				turnurl('index.html#settings');
			}
		}
	},
	"json");
}
function delconfig(table) {
	$.post("index.php", {
		op: "delconfig",
		name: table
	},
	function(data, textStatus) {
		if (data) {
			alert(table + " : " + "已删除");
			//window.location.href = 'index.html?_='+(new Date().getTime())+'#users';
			turnurl('index.html#users');
			/*window.location.reload();*/
		} else {
			alert(table + " : " + "删除错误");
		}
	});
}
function loadconfig(table) {
	$.post("index.php", {
		op: "loadconfig",
		name: table
	},
	function(data, textStatus) {
		preload(table, data);
	},
	"json");
}

//page,path,replace
function bindEvent() {
	$("td.editAble").unbind();
	$("td.textEditor").bind("click",
	function() {
		var val = $(this).html();
		//$(this).html("<input type='text' style='width:100%' onblur='saveEdit(this)' value='"+val+"' >");
		//$(this).children("input").select();
		$(this).html("<textarea style='height:100%;width:100%;'  onblur='saveEdit(this)'>" + val + "</textarea>");
		$(this).children("textarea").select();
		$(this).unbind();
	});
}
$(function() {
	bindEvent();
});
function checkInput(str) {
	if (str) {
		return true;
	}
}

function saveEdit(ctl) {
	if (checkInput(ctl)) {
		$(ctl).parent().html(htmlcl($(ctl).attr("value")));
		$(ctl).parent().attr("orig", htmlcl($(ctl).attr("value")));
		var pnt = $(ctl).parent();
		$(pnt).html($(ctl).attr("value"));
		$(pnt).attr("orig", $(ctl).attr("value"));
	}
	$(ctl).remove();
	bindEvent();
}

function checkqx(table) {
	var nn = 0
	for (var i = 1; i < document.getElementById(table).rows.length; i++) {
		if (document.getElementById(table).rows[i].cells[0].getElementsByTagName('input')[0].checked) {
			nn++;
		}
	}
	if ((nn == (document.getElementById(table).rows.length - 1)) && (document.getElementById(table).rows.length > 1)) {
		document.getElementById(table).rows[0].cells[0].getElementsByTagName('input')[0].checked = true;
	} else {
		document.getElementById(table).rows[0].cells[0].getElementsByTagName('input')[0].checked = false;
	}
}

function fnInsert(table, status, name, path, contents, issite,irow) {
	irow=parseInt(irow);
	if((!irow)&&(irow!=0)){
		irow=-1;
	}
	var oTable = document.getElementById(table);	
	if(irow>oTable.rows.length-1){
		irow=-1;
	}
	if(irow==0){irow=1;}
	if(irow<0){
		irow=oTable.rows.length + irow+1;
	}
	var oTr = oTable.insertRow(irow);
	var oTd1 = oTr.insertCell(0);
	var oTd2 = oTr.insertCell(1);
	var oTd3 = oTr.insertCell(2);
	var oTd4 = oTr.insertCell(3);
	var oTd5 = oTr.insertCell(4);
	var oTd6 = oTr.insertCell(5);
	oTable.rows[irow].innerHTML = '<td><input onchange="if(this.checked){' + table + '.push(this.parentNode.parentNode.rowIndex);}else{' + table + '.remove(this.parentNode.parentNode.rowIndex);}checkqx(\'' + table + '\');" type="checkbox" name="checkbox"></td><td>' + status + '</td><td  class="editAble textEditor" orig="' + htmlcl(name) + '" style="word-break: break-all">' + htmlcl(name) + '</td><td  class="editAble textEditor" orig="' + htmlcl(path) + '" style="word-break: break-all">' + htmlcl(path) + '</td><td  class="editAble textEditor" orig="' + htmlcl(contents) + '" style="word-break: break-all">' + htmlcl(contents) + '</td><td><a href="javascript:void(0);" onclick="this.parentNode.parentNode.parentNode.rows[this.parentNode.parentNode.rowIndex].cells[1].innerHTML=\'run\'" class="button"><small class="icon play"></small><span>play</span></a><a href="javascript:void(0);" onclick="this.parentNode.parentNode.parentNode.rows[this.parentNode.parentNode.rowIndex].cells[1].innerHTML=\'stop\'" class="button"><small class="icon stop"></small><span>stop</span></a><a href="javascript:void(0);" onclick="' + table + '.remove(this.parentNode.parentNode.rowIndex);this.parentNode.parentNode.parentNode.deleteRow(this.parentNode.parentNode.rowIndex);" class="button"><small class="icon cross"></small><span>delete</span></a><a href="javascript:void(0);" onclick="if(this.parentNode.parentNode.rowIndex>1){var s0=this.parentNode.parentNode.parentNode.rows[this.parentNode.parentNode.rowIndex-1].innerHTML;var s1=this.parentNode.parentNode.parentNode.rows[this.parentNode.parentNode.rowIndex].innerHTML;var ss=s0;this.parentNode.parentNode.parentNode.rows[this.parentNode.parentNode.rowIndex-1].innerHTML=s1;this.parentNode.parentNode.parentNode.rows[this.parentNode.parentNode.rowIndex].innerHTML=ss;}else{alert(\'toped\');}bindEvent();" class="button"><small class="icon arrow_up"></small><span>up</span></a><a href="javascript:void(0);" onclick="if(this.parentNode.parentNode.rowIndex<this.parentNode.parentNode.parentNode.rows.length-1){var s0=this.parentNode.parentNode.parentNode.rows[this.parentNode.parentNode.rowIndex+1].innerHTML;var s1=this.parentNode.parentNode.parentNode.rows[this.parentNode.parentNode.rowIndex].innerHTML;var ss=s0;this.parentNode.parentNode.parentNode.rows[this.parentNode.parentNode.rowIndex+1].innerHTML=s1;this.parentNode.parentNode.parentNode.rows[this.parentNode.parentNode.rowIndex].innerHTML=ss;}else{alert(\'ended\');}bindEvent();" class="button"><small class="icon arrow_down"></small><span>down</span></a>' + ((issite) ? ('<div style="line-height: 32px;"><br><a href="javascript:void(0);" onclick="cleancache(\'' + contents + '\');" class="button"><small class="icon unfavorite"></small><span>cacheclean</span></a><a href="javascript:void(0);" onclick="cachepath(\'' + contents + '\');" class="button"><small class="icon documents"></small><span>cacheview</span></a><a href="javascript:void(0);" onclick="cachepath(\'' + contents + '\',1);" class="button"><small class="icon favorite"></small><span>configview</span></a></div>') : ('')) + '</td>';
	bindEvent();
}

Array.prototype.indexOf = function(val) {
	for (var i = 0; i < this.length; i++) {
		if (this[i] == val) return i;
	}
	return - 1;
};
Array.prototype.remove = function(val) {
	var index = this.indexOf(val);
	if (index > -1) {
		this.splice(index, 1);
	}
};

function plsz(sz) {

	var newarray = [];
	var oldarray = sz;
	var max = 0;
	var nn = sz.length;
	while (newarray.length < nn) {

		for (var i = 0; i < oldarray.length; i++) {
			if (oldarray[i] > max) {
				max = oldarray[i];

			}

		}
		newarray.push(max);
		oldarray.remove(max);
		max = 0;
	}
	//alert(newarray.join(","));
	return newarray;
}
function gjsn(status, name, path, contents) {
	/*alert(status);
alert(name);
alert(path);
alert(contents);*/
	var rr = ',{"status":"' + b.encode(status) + '","name":"' + b.encode(name) + '","path":"' + b.encode(path) + '","contents":"' + b.encode(contents) + '"}';

	return rr;
}
var b = new Base64();

function loadsetting(table, jsn) {
	if(!jsn){return false};
	try {
		var ss = JSON.parse(jsn);
		var tb = document.getElementById(table);
		var rowNum = tb.rows.length;
		for (i = 1; i < rowNum; i++) {
			tb.deleteRow(i);
			rowNum = rowNum - 1;
			i = i - 1;
		}
	for (var i = 0; i < ss.length; i++) {
		var xisset = 0;
		if (table == "site") {
			xisset = 1;
		}
		fnInsert(table, b.decode(ss[i].status), b.decode(ss[i].name), b.decode(ss[i].path), b.decode(ss[i].contents), xisset);
	}
	} catch(e) {}
}
function savesetting(table) {
	var ztt = document.getElementById(table).rows[i];
	var jsn = '[';
	for (var i = 1; i < document.getElementById(table).rows.length; i++) {
		jsn += gjsn(htmlcl(document.getElementById(table).rows[i].cells[1].innerHTML, 1), htmlcl(document.getElementById(table).rows[i].cells[2].innerHTML, 1), htmlcl(document.getElementById(table).rows[i].cells[3].innerHTML, 1), htmlcl(document.getElementById(table).rows[i].cells[4].innerHTML, 1));
	}
	jsn += ']';
	jsn = jsn.replace('[,', '[');
	return jsn;
}

function save(table, issite, tconfig) {
	if (!issite) {
		issite = 0;
	}
	if (!tconfig) {
		tconfig = 0;
	}		
	$.post("index.php", {
		op: "save",
		name: table,
		json: b.encode(savesetting(table)),
		site: issite,
		config: tconfig
	},
	function(data, textStatus) {
		alert(table + " : " + data.result);
	},
	"json");
}
function load(table, issite, tconfig) {
	if (!issite) {
		issite = 0;
	}
	if (!tconfig) {
		tconfig = 0;
	}	
	$.post("index.php", {
		op: "load",
		name: table,
		site: issite,
		config: tconfig
	},
	function(data, textStatus) {
		loadsetting(table, data);
	});
}

//articles
function htmlcl(str, fz) {
	if (!fz) {
		return str.replace(/\&/g, "&amp;").replace(/\"/ig, "&quot;").replace(/\'/g, "&#39;").replace(/\</ig, "&lt;").replace(/\>/ig, "&gt;");
	} else {
		return str.replace(/\&gt\;/ig, ">").replace(/\&lt\;/ig, "<").replace(/\&\#39\;/ig, "'").replace(/\&quot\;/ig, "\"").replace(/\&amp\;/ig, "&");
	}
}
function delpage(table) {

	$.post("index.php", {
		op: "delpage",
		name: table
	},
	function(data, textStatus) {
		if (data) {
			alert(table + " : " + "已删除");
			//window.location.href = 'index.html?_='+(new Date().getTime())+'#articles';
			turnurl('index.html#articles');			
			/*window.location.reload();*/
		} else {
			alert(table + " : " + "删除错误");
		}
	});
}
function viewbox(table) {
	document.getElementById('edit').style.display = "block";
	document.getElementById('ttll').innerHTML = '<h2 style="overflow:hidden" title="'+table+'">' + htmlcl((table.length > 10) ? (table.substring(0, 10) + "...") : (table)) + ' - 编辑模板<a href="javascript:void(0);" onclick="delpage(\'' + table.trim() + '\');"><span style="right:40px">Delete</span></a>&nbsp;<a href="javascript:void(0);" onclick="document.getElementById(\'editor\').src=\'\';document.getElementById(\'edit\').style.display=\'none\';"><span>Close</span></a></h2>';
	document.getElementById('editor').src = "index.php?op=editor&name=" + table;

}
function loadpp(data) {
	var sx = "";
	var ch = parseInt(data.length / 5);
	if (ch * 5 < data.length) {
		ch++;
	}
	for (var i = 0; i < ch; i++) {
		sx += '<div class="shelf"><div class="left"></div><div class="right"></div><div class="inside"><div class="books articles">';
		for (var x = 0; x < 5; x++) {
			var xxz = data[i * 5 + x];
			if (xxz) {
				sx += '<div class="col w2"><a href="javascript:void(0);" onclick="viewbox(\'' + xxz[0] + '\');" ><span style="overflow:hidden"><div align="center">' + xxz[2] + '</div>' + htmlcl(xxz[0]) + '</span><small style="overflow:hidden;word-wrap: break-word;">' + xxz[1] + '</small></a></div>';
			}
		}
		sx += '</div></div><div class="clear"></div></div>';
	}
	document.getElementById("zw").innerHTML = sx;
}
function searchuserp(key) {
	if (key) {
		var dd = [];
		for (var i = 0; i < num; i++) {
			if ((tdata[i][0].length > tdata[i][0].replace(key, "").length) || ((tdata[i][1].length > tdata[i][1].replace(key, "").length)) || ((tdata[i][2].length > tdata[i][2].replace(key, "").length))) {
				dd.push(tdata[i]);
			}
		}
		loadpp(dd);
	} else {
		loadpp(tdata);
	}
}

//user
function loadss(data) {
	var sx = "";
	var ch = parseInt(data.length / 5);
	if (ch * 5 < data.length) {
		ch++;
	}
	for (var i = 0; i < ch; i++) {
		sx += '<div class="shelf"><div class="left"></div><div class="right"></div><div class="inside"><div class="books">';
		for (var x = 0; x < 5; x++) {
			var xxz = data[i * 5 + x];
			if (xxz) {
				sx += '	<div class="col w2"><a href="javascript:void(0);" onclick="turnurl(\'index.html#settings|'+xxz+'\');"><span>' + xxz + ((xxz == config) ? ("[启用]") : ("")) + '</span><img src="resources/images/shelf_sample_image.png" height="108px" alt="" /></a></div>';
			}
		}
		sx += '</div></div><div class="clear"></div></div>';
	}
	document.getElementById("zw").innerHTML = sx;
}
function searchuseru(key) {
	if (key) {
		var dd = [];
		for (var i = 0; i < num; i++) {
			if ((tdata[i].length > tdata[i].replace(key, "").length)) {
				dd.push(tdata[i]);
			}
		}
		loadss(dd);
	} else {
		loadss(tdata);
	}
}

//site
function loaduser() {
	$.post("index.php", {
		op: "loaduser"
	},
	function(data, textStatus) {
		var data = JSON.parse(data);
		document.getElementById("user").value = data.user;
		document.getElementById("passwd").value = data.passwd;
	});
}
function saveuser() {
	if (document.getElementById("user").value && document.getElementById("user").value) {
		$.post("index.php", {
			op: "saveuser",
			user: document.getElementById("user").value,
			passwd: document.getElementById("passwd").value
		},
		function(data, textStatus) {
			alert("Done!");
			window.location.reload();
		});
	}
}
function loadqjcookie(xcsz) {
	$.post("index.php", {
		op: "loadqjcookie",
		config: xcsz
	},
	function(data, textStatus) {
		document.getElementById("qjc").value = data
	});
}
function saveqjcookie(xcsz) {
	$.post("index.php", {
		op: "saveqjcookie",
		config: xcsz,
		data: document.getElementById("qjc").value
	},
	function(data, textStatus) {
		alert("Done!");
	});
}
function loadhtaccess() {
	$.post("index.php", {
		op: "loadhtaccess"
	},
	function(data, textStatus) {
		document.getElementById("data").value = data
	});
}
function savehtaccess() {
	$.post("index.php", {
		op: "savehtaccess",
		data: document.getElementById("data").value
	},
	function(data, textStatus) {
		alert("Done!");
	});
}
function backhtaccess() {
	$.post("index.php", {
		op: "backhtaccess"
	},
	function(data, textStatus) {
		document.getElementById("data").value = data
	});
}
function cronstart() {
	$.get("cron.php",
	function(data, textStatus) {
		alert(data);
	});
}
function cronstate() {
	$.post("cron.php", {
		cron: "state"
	},
	function(data, textStatus) {
		if(data!="1"){
			var cc=confirm('Cron服务不在运行状态，是否立刻启动服务？');if(cc){cronstart();}
		}
	});
}
function cronstop() {
	$.post("cron.php", {
		cron: "stop"
	},
	function(data, textStatus) {
		alert(data);
	});
}
function cleanlog() {
	$.post("cron.php", {
		cron: "cleanlog"
	},
	function(data, textStatus) {
		alert(data);
	});
}
function croncheck() {
	$.post("cron.php", {
		cron: "checkurl"
	},
	function(data, textStatus) {
		if (prompt("监控外链", data)) {
			$.post("cron.php", {
				cron: "check"
			},
			function(data, textStatus) {
				alert(data);
			});
		}
	});
}
function changeadminpath(xnad) {
	$.post("index.php", {
		op: "changeadminpath",
		nad: xnad
	},
	function(data, textStatus) {
		window.location.href = "../" + data + "/index.html";
		//turnurl("../" + data + "/index.html#site");
		/*if(data!=xnad){
			window.location.reload();
		}*/
	});
}
function readadminpath() {
	$.post("index.php", {
		op: "readadminpath"
	},
	function(data, textStatus) {
		var xx = prompt('请输入新的后台系统目录:', data);
		if (xx) {
			if (xx != data) {
				changeadminpath(xx);
			} else {
				alert("请输入新的后台系统目录！");
			}
		}
	});
}
//help
function getzy(str) {
	$.post("index.php", {
		op: "getzy",
		str: str
	},
	function(data, textStatus) {
		prompt("转义结果:", data);
	});
}
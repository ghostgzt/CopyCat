<?php
//error_reporting(0);
error_reporting(E_ALL);
require ("iptables.php");
header("Content-type: text/html; charset=utf-8");
/*-----------------INIT------------------*/
$sindex = @base64_decode(@file_get_contents(".index"));
if ($sindex == "") {
    $sindex = "_admin";
}
if (!file_exists($sindex)) {
    die("System Error!");
}
define("ADMIN", $sindex);
define("LIB", ADMIN . "/resources/lib");
define("EXT", ADMIN . "/resources/ext");
/*------------------Functions---------------------*/
require_once(LIB."/functions.php");
/*------------------Functions---------------------*/
/*----------------<file>----------------------*/
//$isop = (substr(str_replace(siteUri(), "", $_SERVER['REQUEST_URI']), 0, 9) == "index.php") ? true : false;
$ee=explode("?",strrchr($_SERVER['REQUEST_URI'], '/'));
$isop=(reset($ee)=="/copycatdeal")?true:false;
if (@$_REQUEST["link"] && $isop) {
    $lfdname = ADMIN . "/pages/" . (@base64_decode(@$_REQUEST["link"]));
    //die($lfdname);
    $r       = @file_get_contents($lfdname . ".xkz");
    $j       = json_decode($r, 1);
    if (file_exists($lfdname . ".dat") && ($j["type"] == "data")) {
        header("Content-type:" . $j["mime"]);
        if ($j["mime"] == "application/octet-stream") {
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: " . filesize($lfdname . ".dat"));
            Header("Content-Disposition: attachment; filename=" . $j["name"]);
        }
        require_once(LIB . "/download.php");
			$dlr = new Downloader();		
			$dlr->downFile($lfdname . ".dat",$j["name"],0,"",$j["mime"],false,0,1);
			die();
    } else {	
        header("Content-type: text/html; charset=utf-8");
        if (substr($r, 0, 5) == "data:") {
            $s = explode(",", $r);
            $k = explode(";", substr($s[0], 5));
            $k = $k[0];
            header("Content-type: " . $k);
            $r = base64_decode($s[1]);
        }
    }
	if(@$_REQUEST["plain"]){
		header("Content-type: text/plain; charset=utf-8");
	}		
    die($r);
}
/*----------------<file>----------------------*/

$siteuri  = siteUri();    
	//$headers = @getallheaders();
	//$proxyhost=@$headers["CopyCat"];
if (@$_REQUEST["delcache"] && $isop) {
    $urltmp=explode("/",@$_REQUEST["delcache"]);  
    $host     = $urltmp[0]."//".$urltmp[2] . "/";
    $litehost = $urltmp[2];    
    define("PATH", @$_REQUEST["delcache"]);
   
}else{
    $host     = ((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http')) . "://" . $_SERVER['HTTP_HOST'] . "/";
    $litehost = $_SERVER['HTTP_HOST'];    
    define("PATH", ((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http')) . "://" . $_SERVER['HTTP_HOST'] .($_SERVER["SERVER_PORT"]!="80"?":".$_SERVER["SERVER_PORT"]:""). $_SERVER['REQUEST_URI']);
}
define("ROOT", dirname(PATH . "*"));
/*----------------<cron>----------------------*/
if (@$_REQUEST["cron"] && $isop) {
    if (@$_REQUEST["cron"] == "log") {
        header("Content-type: text/plain");
        die(@file_get_contents(ADMIN . "/cron/run.log"));
    }
    die(@file_get_contents(ROOT . "/" . ADMIN . "/cron.php?cron=" . @$_REQUEST["cron"]));
}
/*----------------<cron>----------------------*/
define("FILE", strstr($_SERVER['SCRIPT_NAME'], "/"));
define("ADIR", ADMIN . "/config/" . ((@$_REQUEST["delcache"]&&@$_REQUEST["config"])?@$_REQUEST["config"]:readsite()));
if (!file_exists(ADIR)) {
    @mkdir(ADIR);
    @file_put_contents(ADIR . "/settings.json", '{"file":"' . readsite() . '"}');
}
/*----------------<op>----------------------*/
if (@$_REQUEST["op"] && $isop) {
    switch (strtolower(@$_REQUEST["op"])) {
        case "cacheclean":
        if ($_REQUEST["config"]) {
            $adir = ADMIN . "/config/" .$_REQUEST["config"];
			}else{
				$adir=ADIR;
			}
	    if (is_numeric(@$_REQUEST["time"])) {
		if(!$_REQUEST["type"]||($_REQUEST["type"]=="1")){
            $r = @scandir($adir."/cache");
            $s = $f = 0;
			if($r){
            foreach ($r as $value) {
			if(($value!=".")&&($value!="..")){
                if (time()-filemtime($adir."/cache/".$value)>(intval(@$_REQUEST["time"]))) {					
                    @unlink($adir."/cache/".$value);
                    if (!file_exists($adir."/cache/".$value)) {
                        $s += 1;
                    } else {
                        $f += 1;
                    }
                }
			}	
            }
			}
			if($_REQUEST["type"]=="1"){
            die("在Cache中".$s . "个文件成功被删除" . $f . "个文件删除失败！");	
			}else{
			echo("在Cache中".$s . "个文件成功被删除" . $f . "个文件删除失败！".PHP_EOL);	
			}
			}
		if(!$_REQUEST["type"]||($_REQUEST["type"]=="2")){			
            $r = @scandir($adir."/fy_cache");
            $s = $f = 0;
			if($r){
            foreach ($r as $value) {
			if(($value!=".")&&($value!="..")){
                if (time()-filemtime($adir."/fy_cache/".$value)>(intval(@$_REQUEST["time"]))) {
                    @unlink($adir."/fy_cache/".$value);
                    if (!file_exists($adir."/fy_cache/".$value)) {
                        $s += 1;
                    } else {
                        $f += 1;
                    }
                }
			}	
            }
			}
            die("在FY_Cache中".$s . "个文件成功被删除" . $f . "个文件删除失败！");
		}
        } else {
            if (@destroyDir($adir . "/cache")) {
				if(is_dir($adir . "/git_cache")){
					@copy_dir($adir . "/git_cache",$adir . "/cache");
				}
                echo("Cache Cleaned!".PHP_EOL);
            } else {
                echo("Cache Failure!".PHP_EOL);
            }
            if (@destroyDir($adir . "/fy_cache")) {
                die("FY_Cache Cleaned!");
            } else {
                die("FY_Cache Failure!");
            }
        }		
            break;
        case "loadroot":
            die($siteuri);
            break;
        default:
            die("Not Support!");
            break;
    }
}
/*----------------<op>----------------------*/
/*-----------------INIT------------------*/
/*-----------------INFO------------------*/
$isf = @json_decode(file_get_contents(ADIR . "/settings.json"), 1);
define("INFO_SETTINGS", @file_get_contents(ADMIN . "/settings/" . $isf["file"] . ".json"));
define("INFO_PAGE", @file_get_contents(ADIR . "/page.json"));
define("INFO_PATH", @file_get_contents(ADIR . "/path.json"));
define("INFO_REPLACE", @file_get_contents(ADIR . "/replaces.json"));
define("INFO_LOCATION", @file_get_contents(ADIR . "/locations.json"));
define("INFO_MIME", @file_get_contents(ADIR . "/mime.json"));
define("INFO_IPS", @file_get_contents(ADIR . "/ips.json"));
/*-----------------INFO------------------*/
/*-----------------Settings------------------*/
$site = readconfig(INFO_SETTINGS, "host");
/*if (!$site) {
    die(str_replace("{label}", "Site Not Found!", @file_get_contents(ADMIN . "/resources/ext/sitenotset.ext")));
    //die("Site Not Found!");
}*/
$zdroot = readconfig(INFO_SETTINGS, "zdroot");
$root   = readconfig(INFO_SETTINGS, "root");

if (($zdroot == "false") && (strlen($root))) {
    if (substr($root, 0, 1) != "/") {
        $root = "/" . $root;
    }
    if (substr($root, strlen($root) - 1) != "/") {
        $root .= "/";
    }
    $siteuri = $root;
}
if($site=="*"){
	$headers = getallheaders();
	$proxyhost=@$headers["CopyCat"];
	if(!$proxyhost){
		die("Not Setted Proxy Host!");
	}else{
		$site=((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http')) . '://' .$proxyhost."/";
		$_SERVER['HTTP_HOST']=$proxyhost;
	}
	//die($site);
}
if (@end(@explode("/", $site . "*")) != "*") {
    $site0   = $site;
    $site1   = explode("://", $site);
    $site2   = explode("/", $site1[1]);
    $site    = $site1[0] . "://" . $site2[0] . "/";
    $siteuri = dirname($_SERVER['REQUEST_URI'] . "*");
    if (!$siteuri) {
        $siteuri = "/";
    }
    if (substr($siteuri, 0, 1) != "/") {
        $siteuri = "/" . $siteuri;
    }
    if (substr($siteuri, strlen($siteuri) - 1) != "/") {
        $siteuri .= "/";
    }
    /*$rootUrl =dirname($site0."*")."/";*/
    $uri = substr($site0, strlen($site));
    if (substr($uri, 0, 1) == "/") {
        $uri = substr($uri, 1);
    }
    $url     = $site0;
    $thisExt = pathinfo($site0, PATHINFO_EXTENSION);
} else {
    $thisExt = pathinfo(@$_SERVER['PATH_INFO'], PATHINFO_EXTENSION);
    $uri     = substr($_SERVER['REQUEST_URI'], strlen($siteuri));
    if (substr($uri, 0, 1) == "/") {
        $uri = substr($uri, 1);
    }
    $url = $site . $uri;
}
$xlitesite = explode("://", $site);
$litesite  = substr($site, strlen($xlitesite[0]) + 3);
if (substr($litesite, strlen($litesite) - 1) == "/") {
    $litesite = substr($litesite, 0, strlen($litesite) - 1);
}
$litesitehost=dirname($litesite)=="."?$litesite:dirname($litesite);
$itehost=$xlitesite[0]."://".$litesitehost."/";
$xliteurl = explode("://", $url);
$liteurl  = substr($url, strlen($xliteurl[0]) + 3);
if (substr($liteurl, strlen($liteurl) - 1) == "/") {
    $liteurl = substr($liteurl, 0, strlen($liteurl) - 1);
}
//die($thisExt);





if (@$_REQUEST["delcache"] && $isop) {
    $json = json_decode(file_get_contents(ADMIN."/config/site.json"), 1);
	$siteinfo=getsiteinfo($json,array("config"=>@$_REQUEST["config"]));
    $rootUrl=$siteinfo["site"];
    $siteuri=str_replace($urltmp[0]."//".$urltmp[2],"",$rootUrl);    
    $uri=str_replace(rtrim($host,"/").$siteuri,"",@$_REQUEST["delcache"]);

    //die($siteuri);
   if(strpos(@$_REQUEST["delcache"],"http://")!==0&&strpos(@$_REQUEST["delcache"],"https://")!==0){
        $url=rtrim($site,"/")."/".ltrim(@$_REQUEST["delcache"],"/");
        //die($url);
    }else{
        if (@end(@explode("/", $site . "*")) == "*") {
            if(strpos($rootUrl,"http://")!==0&&strpos($rootUrl,"https://")!==0){
                $rootUrl = ((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http')) . '://' . $rootUrl.'/';
            }
            $url = $site . substr(@$_REQUEST["delcache"], strlen($rootUrl));
        }        
        //die($url);
    }
     $thisExt = pathinfo(@$_REQUEST["delcache"], PATHINFO_EXTENSION);
     $liteurl=str_lite($url);
    //$url=@$_REQUEST["delcache"];
}else{
    $rootUrl = ((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http')) . '://' . $_SERVER['HTTP_HOST'] . $siteuri;
}
//die($thisExt);
$literoot    = str_lite(ROOT);
$litepath    = str_lite(PATH);
$literooturl = str_lite($rootUrl);
$litesiteuri =str_lite($siteuri);
$liteuri =str_lite($siteuri);

$rcg = readconfig(INFO_SETTINGS, "encoding");
if(!$rcg){$rcg="auto|utf-8";}
$rcgz=explode("|",$rcg);
$charset   = @$rcgz[0];
$pcharset= $charset=="auto"?@$rcgz[1]:$charset;
$thym      = readconfig(INFO_SETTINGS, "thym");
$thnr      = readconfig(INFO_SETTINGS, "thnr");
$wyc       = readconfig(INFO_SETTINGS, "wyc");
$xczs      = readconfig(INFO_SETTINGS, "xczs");
$cjhc      = readconfig(INFO_SETTINGS, "cjhc");
$ymys      = readconfig(INFO_SETTINGS, "ymys");
$dwjdl     = readconfig(INFO_SETTINGS, "dwjdl");
$dwjzxz    = readconfig(INFO_SETTINGS, "dwjzxz");
$fykg      = readconfig(INFO_SETTINGS, "fykg");
$fyjt      = readconfig(INFO_SETTINGS, "fyjt");
$fyyz      = readconfig(INFO_SETTINGS, "fyyz");
$fylx      = readconfig(INFO_SETTINGS, "fylx");
$fybmd     = readconfig(INFO_SETTINGS, "fybmd");
$hckg      = readconfig(INFO_SETTINGS, "hckg");
$hclx      = readconfig(INFO_SETTINGS, "hclx");
$hcsx      = readconfig(INFO_SETTINGS, "hcsx");
$zydhc     = readconfig(INFO_SETTINGS, "zydhc");
$sjkg      = readconfig(INFO_SETTINGS, "sjkg");
$tjdm      = readconfig(INFO_SETTINGS, "tjdm");
$tjbmd     = readconfig(INFO_SETTINGS, "tjbmd");
$hxsz      = readconfig(INFO_SETTINGS, "hxsz");
$csz       = readconfig(INFO_SETTINGS, "csz");
$zydc      = readconfig(INFO_SETTINGS, "zydc");
$llqbzsz   = readconfig(INFO_SETTINGS, "llqbzsz");
$zydllqbz  = readconfig(INFO_SETTINGS, "zydllqbz");
$llsz      = readconfig(INFO_SETTINGS, "llsz");
$zydll     = readconfig(INFO_SETTINGS, "zydll");
$ipsz      = readconfig(INFO_SETTINGS, "ipsz");
$zydip     = readconfig(INFO_SETTINGS, "zydip");
$dlsz      = readconfig(INFO_SETTINGS, "dlsz");
$zyddl     = readconfig(INFO_SETTINGS, "zyddl");
$dlgz      = readconfig(INFO_SETTINGS, "dlgz");
$hgz       = readconfig(INFO_SETTINGS, "hgz");
$hsz       = readconfig(INFO_SETTINGS, "hsz");
$zydh      = readconfig(INFO_SETTINGS, "zydh");
/*-----------------Settings------------------*/
/*-----------------Pages------------------*/
$pages     = json_decode(INFO_PAGE, 1);
/*-----------------Pages------------------*/
/*-----------------Paths------------------*/
$paths     = json_decode(INFO_PATH, 1);
/*-----------------Paths------------------*/
/*-----------------Repalces------------------*/
$replaces  = json_decode(INFO_REPLACE, 1);
/*-----------------Repalces------------------*/
/*-----------------Locations------------------*/
$locations = json_decode(INFO_LOCATION, 1);
/*-----------------Locations------------------*/
/*-----------------MIME------------------*/
$mime      = json_decode(INFO_MIME, 1);
/*-----------------MIME------------------*/
/*-----------------IPS------------------*/
$ips       = json_decode(INFO_IPS, 1);
/*-----------------IPS------------------*/

/*--------------------run_ips------------------------*/
/*$xheader=@get_headers($url,1);
$httpcode=@explode(" ",$xheader[0])[1];
if(!$httpcode){
$httpcode="404";
}*/
for ($i = 0; $i < count($ips); $i++) {
    if ((base64_decode($ips[$i]["status"]) == "run") && ($ips[$i]["path"])) {
        $ips_check = false;
		$ips_check =pre_ippd(base64_decode($ips[$i]["path"]));
        if ($ips_check) {
            $ips_c = base64_decode($ips[$i]["contents"]);
			if(!$ips_c){die((string)$ips_c);}			
            $ips_k = clpage($ips_c);
            if ($ips_k != false) {
                die(@encode_iconv("utf-8", $pcharset, $ips_k));
            }
        }
    }
}

/*--------------------run_ips------------------------*/
/*--------------------run_pages------------------------*/
for ($i = 0; $i < count($pages); $i++) {
    if (base64_decode($pages[$i]["status"]) == "run") {
        $pages_a=base64_decode($pages[$i]["path"]);
		if(substr($pages_a,0,strlen("<HTTPCODE:"))!="<HTTPCODE:"){
			$pages_check = pre_pbpage($pages_a);
		}else{
			$pages_check = false;
		}
        if ($pages_check) {
            $pages_c = base64_decode($pages[$i]["contents"]);
			if(!$pages_c){die((string)$pages_c);}
            $pages_k = clpage($pages_c);
            if ($pages_k != false) {
                die(@encode_iconv("utf-8", $pcharset, $pages_k));
            }
        }
    }
}
/*--------------------run_pages------------------------*/
if (!$site) {
    die(str_replace("{label}", "Site Not Found!", @file_get_contents(EXT . "/sitenotset.ext")));
    //die("Site Not Found!");
}

/*--------------------run_paths------------------------*/
for ($i = 0; $i < count($paths); $i++) {
    if ((base64_decode($paths[$i]["status"]) == "run") && $paths[$i]["path"]) {
        
        
        $paths_a = base64_decode($paths[$i]["path"]);
        
        
        $paths_aa = @json_decode($paths_a, 1);
        if ($paths_aa && ($paths_aa["op"] != "run") && ($paths_aa["op"] != "php")&& (@$paths_aa["op"] != "include")&& ($paths_aa["op"] != "dom")) {
            $paths_a = $paths_aa;
        } else {
            $paths_a = array(
                $paths_a
            );
        }
        
        for ($k = 0; $k < count($paths_a); $k++) {
            //if(($site.$paths_a[$k]==$url)||($site.cleandz($paths_a[$k],$uri,1,1)==$url)){
            
            $paths_d = cleandz($paths_a[$k], $uri, 1, 1);

            $paths_b = base64_decode($paths[$i]["contents"]);
            $paths_b = getpages($paths_b);
            $paths_b = clnr(base64_decode($paths[$i]["path"]), $url, $paths_b);
            
            if ((substr($paths_b, 0, 7) == "http://") || (substr($paths_b, 0, 8) == "https://")) {
                $paths_d = $site . $paths_d;
            }
            
            $pglnr = glnr($paths_a[$k], $url, $paths_b, true);
			
            if ($pglnr) {
                $paths_d = $pglnr;
            }
            
            $url = str_replace($paths_d, $paths_b, $url);
            
            
            
            $yglnr = glnr($paths_a[$k], $url, $paths_b, false);
            if ($yglnr) {
                $url = $yglnr;
            }
            
            //}
        }
    }
}
//die($url);
/*--------------------run_paths------------------------*/
/*----------------<delcache>----------------------*/
if (@$_REQUEST["delcache"] && $isop) {
	if (($hclx != "2")&&($hclx != "3")){
	    //die("123");
		$cloc=glob(ADIR . "/cache/" . md5($url) . "*.loc");
	}else{
		$dhcn=md5(json_encode(array($url, $zydll, $zydh, $zydc, $zydllqbz, $zyddl)));
		$cloc=glob(ADIR . "/cache/d_" . $dhcn. ".cac");
	}
    if (count($cloc)) {
        if (@unlink($cloc[0])) {
            die("Cleaned " . @end(@explode("/",$cloc[0])));
        } else {
            die("Failure " . @end(@explode("/",$cloc[0])));
        }
    }
	$ccac=glob(ADIR . "/cache/" . md5($url) . "*.cac");	
    if (count($ccac)) {
        if (@unlink($ccac[0])) {
            die("Cleaned " . @end(@explode("/",$ccac[0])));
        } else {
            die("Failure " .@end(@explode("/",$ccac[0])));
        }
    }
    die("Cache Not Found! " . $url);
}
/*----------------<op>----------------------*/
/*--------------------read_cache------------------------*/
//die($url);
read_cache($url);
/*--------------------read_cache------------------------*/
/*--------------------run_getlx------------------------*/
handle_flags();
$dhcd=false;
if ($hckg == "true" && (($hclx == "2")||($hclx == "3"))) {
	$dhcn=md5(json_encode(array($url, $ref, $header, $cookie, $data, $agent, $proxy, $lxcore)));
	$ccac=ADIR . "/cache/d_" . $dhcn. ".cac";
	if(file_exists($ccac)){
		if ((time() - date(filemtime($ccac)) < $hcsx) || ($hclx == "3")) {
			supercache($ccac);
			$dhc=@file_get_contents($ccac);
			//die($dhc);
							if (isgzip($dhc)) {
								$dhc = @gzdecode($dhc);
							}
			$lxres=@json_decode($dhc,1);
			$lxres['result']=@base64_decode($lxres['result']);
			$dhcd=true;
		}
	}
}
if(!$dhcd){
	$lxres = (getlx($url, $ref, $header, $cookie, $data, $agent, $proxy, $lxcore));
}
$httpcode = $lxres["info"]["http_code"];
if (!$httpcode) {
    $httpcode = "404";
}
$redirect_url = @$lxres["info"]["redirect_url"];
$fmime = explode(";", $lxres["info"]["content_type"]);
$fmime = $fmime[0];

if ($csz == "0"||!$csz) {
    $kfcookie = cleandz('/Set\-Cookie\:\s*(.*?)\s*\;/is', $lxres["header"], 0, 0, 1);
    if ($kfcookie) {
        for ($i = 0; $i < count($kfcookie); $i++) {
            $kfc = explode("=", $kfcookie[$i]);
            setcookie($kfc[0], urlencode(substr($kfcookie[$i], strlen($kfc[0]) + 1)), null, $siteuri); //setcookie($kfc[0],$kfc[1],null,$siteuri);
        }
    }
}

if(($hsz=="0"||!$hsz)&&$lxres["header"]){
	$lxrh=@explode("\n",str_replace("\r","\n",str_replace("\r\n","\n",$lxres["header"])));
	@array_shift($lxrh);
	$lxrh=@array_diff($lxrh,array(""));
//	die(var_dump($lxrh));
	$notlxrh=array("Content-Encoding","Content-Length","Set-Cookie","Content-Encoding","Content-Type","Location","Transfer-Encoding");
	//$lxrhb=array();
	foreach($lxrh as $key){
		$lxrha=@explode(":",$key);
		if(!@in_array(trim($lxrha[0]),$notlxrh)){
			//$lxrhb[]=$key;
			@header($key);
		}
	}		
}
//die(var_dump($lxrhb));
//$lxrh=$lxrhb;

$results = $lxres["result"];
/*--------------------run_getlx------------------------*/
/*--------------------write_d_cache------------------------*/
if ($hckg == "true" && (($hclx == "2")||($hclx == "3")) && $lxres&&!$dhcd&&in_array($httpcode,array("200","301","302"))) {
    if (checkgz($zydhc)) {
        @mkdir(ADIR . "/cache");
		$wlxres=$lxres;
		$wlxres["result"]=base64_encode($lxres["result"]);
		$wresults=json_encode($wlxres);
        if ($ymys == "true") {
            $wresults = @gzenCode($wresults, 9);
        }
        file_put_contents(ADIR . "/cache/d_" . $dhcn. ".cac", $wresults);
    }
}
/*--------------------write_d_cache------------------------*/
/*--------------------run_mime------------------------*/
if ($fmime) {
    @header("Content-type: $fmime");
    $kmime = doexts($thisExt, $mime, $results);
	if($kmime){$fmime=$kmime;}
} else {
    $fmime = setmime($thisExt, $mime, $results);
}
/*--------------------run_mime------------------------*/
/*--------------------run_charset------------------------*/
$cc = clcharset($results, $charset, $fmime);
/*--------------------run_charset------------------------*/
/*--------------------httpcode_pages------------------------*/

for ($i = 0; $i < count($pages); $i++) {
    if (base64_decode($pages[$i]["status"]) == "run") {
        $xhc     = 0;
        $pages_c = base64_decode($pages[$i]["contents"]);
        $pages_z = cleandz('/\<HTTPCODE\s*\:\s*(.*?)\s*\>/i', base64_decode($pages[$i]["path"]), 0, 1);
		
        $pages_d = @substr(strstr(@$pages_z,"|"),1);
        $pages_z = explode("|", $pages_z);
        
        
        $pages_z = @$pages_z[0];
        if ($pages_d) {
            $pages_check = pre_pbpage($pages_d);
        } else {
            $pages_check = false;
        }
        if ($pages_z && $pages_check) {
            //die(var_dump($pages_z));
            //$httpcode="302";
            if ($httpcode == $pages_z) {
                $xhc = 1;
            }
        }
        //if(base64_decode($pages[$i]["path"])=="*"){$xhc=1;$fh=1;}
        if ($xhc) {
            
            //die($pages_c);
            //die(header($pages_c));
			if(!$pages_c){die((string)$pages_c);}			
            $pages_k = clpage($pages_c);
            if ($pages_k != false) {
                //$xxsf = @encode_iconv("utf-8", $charset, $pages_k);
                /*if($fh){
                echo $xxsf;
                }else{*/
                die(@encode_iconv("utf-8", $pcharset, $pages_k));
                //}
            }
        }
    }
}
/*--------------------httpcode_pages------------------------*/

/*--------------------{301or302}------------------------*/
/*$xheader=@get_headers($url,1);
$httpcode=@explode(" ",$xheader[0])[1];*/
if(!@$lxres["info"]["iswjdl"]){
$xloc = str_replace($site, $rootUrl, $redirect_url);
}else{
$xloc = $redirect_url;
}
if ($xloc) {

    /*--------------------run_locations------------------------*/
	
    for ($i = 0; $i < count($locations); $i++) {
        if ((base64_decode($locations[$i]["status"]) == "run") && $locations[$i]["path"]) {
            $locations_a  = base64_decode($locations[$i]["path"]);
            $locations_aa = @json_decode($locations_a, 1);
            if ($locations_aa && ($locations_aa["op"] != "run") && ($locations_aa["op"] != "php")&& (@$locations_aa["op"] != "include")&& ($locations_aa["op"] != "dom")) {
                $locations_a = $locations_aa;
            } else {
                $locations_a = array(
                    $locations_a
                );
            }
            for ($k = 0; $k < count($locations_a); $k++) {
                $locations_d = cleandz($locations_a[$k], $uri, 1, 1);
                $locations_b = base64_decode($locations[$i]["contents"]);
                $locations_b = getpages($locations_b);
                $locations_b = clnr(base64_decode($locations[$i]["path"]), $xloc, $locations_b);
				
                $pglnr       = glnr($locations_a[$k], $xloc, $locations_b, true);
                if ($pglnr) {
                    $locations_d = $pglnr;
                }
                $xloc  = str_replace($locations_d, $locations_b, $xloc);
                $yglnr = glnr($locations_a[$k], $xloc, $locations_b, false);
                if ($yglnr) {
                    $xloc = $yglnr;
                }
				
				//die(var_dump($xloc));
            }
        }
    }
    /*--------------------run_locations------------------------*/
    
    /*------------------->write_loc_cache<-----------------------*/
    if ($hckg == "true"&& (($hclx != "2")&&($hclx != "3"))) {
        if (checkgz($zydhc)) {
            @mkdir(ADIR . "/cache");
            file_put_contents(ADIR . "/cache/" . md5($url) . "_".$httpcode.".loc", $xloc);
        }
    }
    /*------------------->write_loc_cache<-----------------------*/
	if($httpcode!="301"&&$httpcode!="302"){
		$httpcode="301";
	}
	switch ($httpcode){
		case "301":
			header("HTTP/1.1 301 Moved Permanently");
		break;
		case "302":
			header("HTTP/1.1 302 Found");
		break;
	}
    die(header("Location: $xloc"));
}
/*--------------------{301or302}------------------------*/
/*--------------------{httperror}------------------------*/
if(in_array($httpcode,array("400","403","404","500","502","503","504"))){
	switch($httpcode){
	case "400":
		header("HTTP/1.1 400 Bad Request ");
	break;
	case "403":
		header("HTTP/1.1 403 Forbidden ");
	break;
	case "404":
		header("HTTP/1.1 404 Not Found");
	break;
	case "500":
		header("HTTP/1.1 500 Internal Server Error");
	break;
	case "502":
		header("HTTP/1.1 502 Bad Gateway");
	break;
	case "503":
		header("HTTP/1.1 503 Service Unavailable");
	break;
	case "504":
		header("HTTP/1.1 504 Gateway Timeout");
	break;
	}
	die();
}
/*--------------------{httperror}------------------------*/
//替换域名 relativeHTML relativeCSS
/*--------------------替换域名------------------------*/
if ($thym != "false") {
    /*if(in_array($thisExt,array('','php','asp','jsp','html','js'))){*/
    //替换域名
    $results = str_replace($site, $rootUrl, $results);
	if(substr($site,-1)=="/"){
		$results = str_replace(substr($site,0,-1)."\"", substr($rootUrl,0,-1)."\"", $results);
		$results = str_replace(substr($site,0,-1)."'", substr($rootUrl,0,-1)."'", $results);		
	}
    $results = str_replace(str_zy($site), str_zy($rootUrl), $results);	
	$results = str_replace("//".$litesite."/", /*((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http'))*/"h0t0t0p" ."://".$literooturl."/", $results);
	$results = str_replace("//".$litesite."\"",/*((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http'))*/"h0t0t0p"."://".$literooturl."\"", $results);
	$results = str_replace("\\/\\/".str_zy($litesite)."\\/", /*((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http'))*/"h0t0t0p" .":\\/\\/".str_zy($literooturl)."\/", $results);
	$results = str_replace("\\/\\/".str_zy($litesite)."\"", /*((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http'))*/"h0t0t0p" .":\\/\\/".str_zy($literooturl)."\"", $results);	
	
	$results = str_replace("//".$litesite."'",/*((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http'))*/"h0t0t0p"."://".$literooturl."'", $results);
	$results = str_replace("\\/\\/".str_zy($litesite)."'", /*((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http'))*/"h0t0t0p" .":\\/\\/".str_zy($literooturl)."'", $results);	
	
    //$results = preg_replace('/[\'|\"]\/\/'.$litesite.'/i',$rootUrl, $results);
    //die($results );
    /*	if(substr($site,0,5)=="http:"){
    $grm=(cleandz("/http\:\/\/(.*?)\//is",$site,0,1));
    $rrm=dirname(substr($rootUrl,7)."*");
    }
    if(substr($site,0,6)=="https:"){
    $grm=(cleandz("/https\:\/\/(.*?)\//is",$site,0,1));
    $rrm=dirname(substr($rootUrl,8)."*");
    }*/
    //die($rootUrl);
    //die(dirname(substr($rootUrl,7)."*"));
    //$results = str_replace($litesite,$liteurl,$results);
    /*}*/
}
/*--------------------替换域名------------------------*/

/*--------------------替换相对地址------------------------*/
//替换相对地址relativeHTML
if ($thnr != "false") {
    
    $url0 = explode("/", $url);
    $url1 = array();
    for ($i = 0; $i < count($url0); $i++) {
        if ($i > 2) {
            $url1[count($url1)] = $url0[$i];
        }
    }
    $url1 = (join("/", $url1));
    if (strtolower(substr($url, 0, strlen($site))) != strtolower($site)) {
        $crt = str_replace($url1, "", $uri);
        if ($crt == $uri) {
            $crt = explode("/", $uri);
            $crt = $crt[0];
        }
        if (substr($crt, 0, 1) == "/") {
            $crt = substr($crt, 1);
        }
        if (substr($crt, strlen($crt) - 1) == "/") {
            $crt = substr($crt, 0, strlen($crt) - 1);
        }
    } else {
        $crt = "";
    }
    
    
    if (strtolower($thisExt) == "js"||$fmime == "application/javascript"||$fmime == "application/x-javascript") {
        $crt = "";
    }
    /*if(in_array($thisExt,array('','php','asp','jsp','html','js'))){*/
    /*$results = str_replace('="//', '="' . ((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http')) . '://', $results);
    $results = str_replace('=\'//', '=\'' . ((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http')) . '://', $results);
    $results = str_replace('="/', '="' . $siteuri, $results);
    $results = str_replace('=\'/', '=\'' . $siteuri, $results);*/
    
    $results = @preg_replace('/\\s*\\=\\s*\\"\\/\\//i', '="' . '：//', $results);
    $results = @preg_replace('/\\s*\\=\\s*\'\\/\\//i', '=\'' . '：//', $results);
    $results = @preg_replace('/\\s*\\=\\s*\\"\\//i', '="' . $siteuri . ($crt ? $crt . '/' : ''), $results);
    $results = @preg_replace('/\\s*\\=\\s*\'\\//i', '=\'' . $siteuri . ($crt ? $crt . '/' : ''), $results);
    $results = strtr($results, array('="：//' => '="//', '=\'：//' => '=\'//'));
	
    if ($fmime == 'text/html') {
        if (!cleandz('/<link\\s*rel\\s*\\=\\s*[\\"|\']shortcut\\s*icon[\\"|\']\\s*(.*?)href\\s*\\=\\s*[\\"|\'](.*?)[\\"|\']\\s*([\\/]?)>/is', $results, 0, 1, 1)) {
            $results = str_replace('<head>', '<head>' . PHP_EOL . '<link rel="shortcut icon" href="' . $siteuri . ($crt ? $crt . '/' : '') . 'favicon.ico" />', $results);
        }
    }
    //$results = @preg_replace('/<base\s*href\s*\=\s*(.*?)([\/]?)>/i', '', $results);
    //}
    
    //替换CSS相对地址
    if (in_array(strtolower($thisExt), array(
        'css'
    ))||$fmime == "text/css"||$fmime == "text/html") {
        
        /*$results = str_replace('url(../../', 'u1r1l(../../', $results);
        
        $results = str_replace('url(../', 'u0r0l(../', $results);
        
        $results = str_replace('url(http:', 'u2r2l(http:', $results);
        $results = str_replace('url(https:', 'u3r3l(https:', $results);
        $results = str_replace('url(data:', 'u4r4l(data:', $results);
        $results = str_replace('url(/', 'u5r5l(/', $results);
        //die(dirname($rootUrl.$uri));
        $results = str_replace('url(', 'url(' . dirname($rootUrl . $uri) . "/", $results);*/
        
        //$results = @preg_replace('/url\s*\(\s*\.\.\/\.\.\//i', 'u1r1l(../../', $results);
        //$results = @preg_replace('/url\s*\(\s*\.\.\//i', 'u0r0l(../', $results);
        //$results = @preg_replace('/url\s*\(\s*http\:/i', 'u2r2l(http:', $results);
        //$results = @preg_replace('/url\s*\(\s*https\:/i', 'u3r3l(https:', $results);
        //$results = @preg_replace('/url\s*\(\s*data\:/i', 'u4r4l(data:', $results);
        $results = @preg_replace('/url\s*\(\s*\/\//i', 'u6r6l(//', $results);
        $results = @preg_replace('/url\s*\(\s*\//i', 'u5r5l(/', $results);
        $results = @preg_replace('/url\s*\(\'\s*\/\//i', 'u6r6l(\'//', $results);
        $results = @preg_replace('/url\s*\(\"\s*\/\//i', 'u6r6l("//', $results);
        $results = @preg_replace('/url\s*\(\'\s*\//i', 'u5r5l(\'/', $results);
        $results = @preg_replace('/url\s*\(\"\s*\//i', 'u5r5l("/', $results);
        //$results = @preg_replace('/url\s*\((\.\/)?/i', 'url(' . dirname($rootUrl . $uri) . "/", $results);
        //die(var_dump(array($url,$site,$uri,substr($url,0,strlen($site)))));
        
        
        //die($rootUrl.substr($uri,0,strlen($uri)-1));
        //die(getlv($rootUrl.substr($uri,0,strlen($uri)-1),2));
        //$results = str_replace('u1r1l(../../', 'url(' . $rootUrl . getlv($rootUrl . $uri, 3), $results);
        
        //$results = str_replace('u0r0l(../', 'url(' . $rootUrl . getlv($rootUrl . $uri, 2), $results);
        //die($rootUrl.$uri);
        //die(getlv($rootUrl.$uri,2));
        //if(!($rootUrl.$crt)){die($crt );}
        //die($rootUrl.getlv($rootUrl.$uri,2));
        $results = str_replace('u6r6l(//', 'url(' . 'h0t0t0p://', $results);
        $results = str_replace('u5r5l(/', 'url(' . $siteuri . $crt . "/", $results);
        $results = str_replace('u6r6l(\'//', 'url(\'' . 'h0t0t0p://', $results);
        $results = str_replace('u5r5l(\'/', 'url(\'' . $siteuri . $crt . "/", $results);
        $results = str_replace('u6r6l("//', 'url("' . 'h0t0t0p://', $results);
        $results = str_replace('u5r5l("/', 'url("' . $siteuri . (($crt) ? ($crt . "/") : ("")), $results);
        //$results = str_replace('u2r2l(http:', 'url(http:', $results);
        //$results = str_replace('u3r3l(https:', 'url(https:', $results);
        //$results = str_replace('u4r4l(data:', 'url(data:', $results);
        
    }
}
/*--------------------替换相对地址------------------------*/
/*--------------------回替地址------------------------*/
$results=str_replace("h0t0t0p:\\/\\/","//",$results);
$results=str_replace("h0t0t0p://","//",$results);
/*--------------------回替地址------------------------*/
/*--------------------run_replaces------------------------*/
for ($i = 0; $i < count($replaces); $i++) {

    if ((base64_decode($replaces[$i]["status"]) == "run") && $replaces[$i]["name"] && pre_pbpage(base64_decode($replaces[$i]["path"]))) {
        
        $replaces_a = getpages(tsnr(base64_decode($replaces[$i]["name"])));
        $replaces_c = base64_decode($replaces[$i]["contents"]);
        $replaces_c = getpages($replaces_c);
        $replaces_c = clnr(base64_decode($replaces[$i]["name"]), $results, $replaces_c);

        $replaces_aa = @json_decode($replaces_a, 1);
        if ($replaces_aa && (@$replaces_aa["op"] != "run") && (@$replaces_aa["op"] != "php") && (@$replaces_aa["op"] != "include") && (@$replaces_aa["op"] != "dom")) {
            $replaces_a = $replaces_aa;
        } else {
            $replaces_a = array(
                $replaces_a
            );
        }
		
        for ($k = 0; $k < count($replaces_a); $k++) {
            $gglnr = glnr($replaces_a[$k], $results, $replaces_c, true);
								
            if ($gglnr) {
                $replaces_a[$k] = $gglnr;
            }
            $results = delstr((($cc) ? (@encode_iconv("utf-8", $pcharset, $replaces_a[$k])) : ($replaces_a[$k])), (($cc) ? (@encode_iconv("utf-8", $pcharset, $replaces_c)) : ($replaces_c)), $results, 1);
            $rglnr   = glnr($replaces_a[$k], $results, $replaces_c, false);
			
            if ($rglnr) {
                $results = $rglnr;
            }
        } 
    }
}
/*--------------------run_replaces------------------------*/
/*--------------------page_preout------------------------*/
$results=page_preout($results);
/*--------------------page_preout------------------------*/
/*--------------------output------------------------*/
if ($ymys == "true"&&!@$GLOBALS["include_X"]) {
	if (!isgzip($results)) {
		$results = @gzenCode($results, 9);
	}
	header("Content-Encoding: gzip");
	header("Vary: Accept-Encoding");
	header("Content-Length: " . strlen($results));
}

die($results);
/*--------------------output------------------------*/
?>
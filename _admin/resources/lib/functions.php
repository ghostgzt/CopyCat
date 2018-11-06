<?php
if (!function_exists("gzdecode")) {
	require_once(LIB . "/gzdecode.php");
}
/*--------------------DOM命令式处理------------------------*/
function getdomvalue($code, $rule) //getdomvalue(file_get_contents("http://www.baidu.com/"),"/html/body//a//@href")
{
    
    $results = array();
    $dom     = new DOMDocument();
    @$dom->loadHTML($code);
    $dom->normalize();
    $xpath = new DOMXPath($dom);
    $hrefs = $xpath->evaluate($rule);
    for ($i = 0; $i < $hrefs->length; $i++) {
        $href                     = $hrefs->item($i);
        $linktext                 = $href->nodeValue;
        $results[count($results)] = $linktext;
    }
    
    return json_encode($results);
    
}
/*--------------------获取站点信息------------------------*/
function getsiteinfo($json,$arr) {
	//die(var_dump($arr));
	$out = array();
	foreach($json as $key) {
		$skey = array("status" =>base64_decode($key["status"]), "name" =>base64_decode($key["name"]), "site" =>base64_decode($key["path"]), "config" =>base64_decode($key["contents"]));
		if ($arr["site"] && $arr["config"]) {
			if (base64_decode($key["path"]) == $arr["site"] && base64_decode($key["contents"]) == $arr["config"]) {
				return $skey;
			}
		} else {

			if ($arr["site"] && !$arr["config"]) {
				if (base64_decode($key["status"]) == "run" && base64_decode($key["path"]) == $arr["site"]) {
					return $skey;
				}
			} else {

				if (!$arr["site"] && $arr["config"]) {
				    //die(var_dump($arr));
					if (base64_decode($key["status"]) == "run" && base64_decode($key["contents"]) == $arr["config"]) {
					   // die(var_dump($arr));
						return $skey;
					}
				}

			}

		}
		$out[] = $skey;
	}
	return $out;

}
/*--------------------复制目录------------------------*/
function copy_dir($source, $dest) {
    $result = false;
    if (is_file($source)) {
        if ($dest[strlen($dest) - 1] == '/') {
            $__dest = $dest . "/" . basename($source);
        } else {
            $__dest = $dest;
        }
        $result = @copy($source, $__dest);
        //echo encode_iconv( $config['app_charset'],$config['system_charset'], $source);
        @chmod($__dest, 0755);
    } elseif (is_dir($source)) {
        if ($dest[strlen($dest) - 1] == '/') {
            $dest = $dest . basename($source);
            @mkdir($dest);
            @chmod($dest, 0755);
        } else {
            @mkdir($dest, 0755);
            @chmod($dest, 0755);
        }
        $dirHandle = opendir($source);
        while ($file = readdir($dirHandle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($source . "/" . $file)) {
                    $__dest = $dest . "/" . $file;
                } else {
                    $__dest = $dest . "/" . $file;
                }
                $result = copy_dir($source . "/" . $file, $__dest);
            }
        }
        closedir($dirHandle);
    } else {
        $result = false;
    }
    return $result;
}
/*--------------------删除目录------------------------*/
function destroyDir($dir, $virtual = false)
{
    $ds  = DIRECTORY_SEPARATOR;
    $dir = $virtual ? realpath($dir) : $dir;
    $dir = substr($dir, -1) == $ds ? substr($dir, 0, -1) : $dir;
    if (is_dir($dir) && $handle = opendir($dir)) {
        while ($file = readdir($handle)) {
            if ($file == '.' || $file == '..') {
                continue;
            } elseif (is_dir($dir . $ds . $file)) {
                destroyDir($dir . $ds . $file);
            } else {
                unlink($dir . $ds . $file);
            }
        }
        closedir($handle);
        rmdir($dir);
        return true;
    } else {
        return false;
    }
}
/*--------------------站点根目录------------------------*/
function siteUri()
{
    $r  = "/";
    $r0 = explode("/", dirname(str_replace(str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']), "", $_SERVER['SCRIPT_FILENAME']) . "*") . "/");
    $r1 = explode("/", dirname($_SERVER['REQUEST_URI'] . "*") . "/");
    for ($i = 0; $i < count($r1); $i++) {
        for ($x = 0; $x < count($r0); $x++) {
            if ($r0[$x] && ($r0[$x] == $r1[$i])) {
                $r .= "/".str_replace("\\", "", $r1[$i]);
				$r=str_replace("//","/",$r);
            }
        }
    }
    if (substr($r, strlen($r) - 1) != "/") {
        $r .= '/';
    }
    return $r;
}
/*--------------------数组键名删除------------------------*/
function array_delkey($arr,$delarr){
	foreach($delarr as $key){
		unset($arr[$key]);//利用unset删除这个元素
	}
    foreach($arr as $key){
        if(@strstr(@trim($arr[$key])," ")){
            unset($arr[$key]);//利用unset删除这个元素  
        }      
	}    
	return $arr;
}
/*--------------------请求信息预处理------------------------*/
function handle_flags(){
global $hxsz,$lxcore,$csz,$cookie,$zydc,$llqbzsz,$agent,$zydllqbz,$llsz,$ref,$rootUrl,$site,$zydll,$ipsz,$ip,$zydip,$header,$dlsz,$proxy,$dlgz,$zyddl,$proxy,$hsz,$hgz,$zydh,$data;

	switch ($hxsz) {
		case "0":
			$lxcore = 0;
			break;
		case "1":
			$lxcore = 1;
			break;
		default:
			$lxcore = 0;
			break;
	}
	switch ($csz) {
		case "0":
			$cookie = $_COOKIE;
			break;
		case "1":
			$cookie = "";
			break;
		case "2":
			$cookie = "*";
			break;
		case "3":
			$cookie = $zydc;
			break;
		default:
			$cookie = $_COOKIE;
			break;
	}
	switch ($llqbzsz) {
		case "0":
			$agent = $_SERVER['HTTP_USER_AGENT'];
			break;
		case "1":
			$agent = "";
			break;
		case "2":
			$agent = $zydllqbz;
			break;
		default:
			$agent = $_SERVER['HTTP_USER_AGENT'];
			break;
	}
	switch ($llsz) {
		case "0":
			$ref = str_replace($rootUrl, $site, @$_SERVER['HTTP_REFERER']);
			break;
		case "1":
			$ref = "";
			break;
		case "2":
			$ref = $zydll;
			break;
		default:
			$ref = str_replace($rootUrl, $site, $_SERVER['HTTP_REFERER']);
			break;
	}
	switch ($ipsz) {
		case "0":
			$ip = getClientIp();
			break;
		case "1":
			$ip = "";
			break;
		case "2":
			$ip = $zydip;
			break;
		default:
			$ip = getClientIp();
			break;
	}
	if ($ip) {
		$header = array(
			'X-Forwarded-For:' . $ip,
			'X-Client-IP:' . $ip
		);
	} else {
		$header = "";
	}
	switch ($dlsz) {
		case "0":
			$proxy = "";
			break;
		case "1":
			if (checkgz($dlgz)) {
				$proxy = $zyddl;
			} else {
				$proxy = "";
			}
			break;
		case "2":
			if (checkgz($dlgz)) {
				$proxy = @file_get_contents($zyddl);
			} else {
				$proxy = "";
			}
			break;
		default:
			$proxy = "";
			break;
	}
	$headers = getallheaders();
	$notheaders=array("Host","User-Agent","Referer","Cookie","Content-Length","Origin","CopyCat");
	$headers=array_delkey($headers,$notheaders);
	if ($ip) {
		$notip=array("X-Forwarded-For","X-Client-IP");
		$headers=array_delkey($headers,$notip);
	}
	$hs="";
	while (list($headerz, $value) = each($headers)) {
	  $hs.= "\n$headerz: $value";
	}	
	
	switch ($hsz) {
		case "0":
			$header =join("\n", $header). $hs . "\n";
			break;		
		case "1":
			$header = join("\n", $header) . "\n";
			break;
		case "2":
		//die(var_dump(pbpage($hgz)));
			$header = join("\n", $header) . "\n". ((checkgz($hgz))?($zydh):(""));
			break;
		default:
			$header =join("\n", $header). $hs . "\n";
			break;
	}
//die($header);
	//die(var_dump($header));
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$payload=(file_get_contents( "php://input"));
		/*print_r($pl);
		$payload =$pl? json_encode( array( "customer"=> $pl ) ):"";	*/
		if($payload){
			$data=$payload;
		}else{
			$data = $_POST;
		}
		//die($data);
	} else {
		$data = "";
	}

}
/*--------------------读出缓存------------------------*/
function read_cache($url){
	global $hckg,$hclx,$hcsx,$thisExt,$charset,$pcharset,$ymys,$fykg,$fybmd,$fyjt,$mime,$fmime;
	//var_dump(checkgz('!["*.css","/f(.*?)$/"]||[""]'));
	//$hcsx='[[[["*.css","/f(.*?)$/"],120],["",360]],7200]';
	if(!($hcsx>0)){
		$j0=@json_decode($hcsx,1);
		$jt=$j0[1];
		$j0=$j0[0];
		//var_dump($j0);
		if($j0){
			foreach($j0 as $key){
				if(is_array($key[0])){
					$j1=json_encode($key[0]);
				}else{
					$j1=$key[0];
				}
				//var_dump($j1) ;
				if(checkgz($j1)){
					$hcsx=$key[1];
					$j2=1;
				}
			}
		}
		if(!$j2){
			$hcsx=$jt;
		}		
	}else{
		$hcsx=@(int)$hcsx;
	}

	//var_dump($hcsx);
	//die("test");
	if ($hckg == "true"&& (($hclx != "2")&&($hclx != "3"))) {
	$cloc=glob(ADIR . "/cache/" . md5($url) . "*.loc");
	$dhttpcode=@(end(explode("_",reset(explode(".",end(explode("/",$ccac[0])))))));
		if (count($cloc)) {
			supercache($cloc[0]);
			$lloc = @file_get_contents($cloc[0]);
			if ($lloc) {
				if($dhttpcode){
					switch($dhttpcode){
						case "301":
							header("HTTP/1.1 301 Moved Permanently");
						break;
						case "302":
							header("HTTP/1.1 302 Found");
						break;					
					}
				}
				die(header("Location: $lloc"));
			}
		}
	$ccac=glob(ADIR . "/cache/" . md5($url) . "*.cac");	
	$dmime=@base64_decode(rawurldecode(end(explode("_",reset(explode(".",end(explode("/",$ccac[0]))))))));

		if (count($ccac)) {
			if ((time() - date(filemtime($ccac[0])) < $hcsx) || ($hclx == "1")) {
				supercache($ccac[0]);
			   /* if ($thisExt) {
					header("Content-type: text/$thisExt; charset=$charset");
				} else {
					header("Content-type: text/html; charset=$charset");
				}*/
				$results = (@file_get_contents($ccac[0]));
				
				if (($ymys == "true") &&(($fykg != "true") ||(($fykg == "true") && (!checkgz($fybmd)))||(($fykg == "true") &&($fyjt == "true")))) {
					if (!isgzip($results)) {
						$results = @gzenCode($results, 9);
					}
									//die($results);
					header("Content-Encoding: gzip");
					header("Vary: Accept-Encoding");
					header("Content-Length: " . strlen($results));
					if($dmime){
						header("Content-type: ".$dmime.";charset=$pcharset");
					}else{
						setmime($thisExt, $mime, $results);
					}
					die($results);
				} else {
					if (isgzip($results)) {
						$results = @gzdecode($results);
					}
				}
				//die("123");

					if($dmime){
					
						header("Content-type: ".$dmime);
						$fmime=$dmime;
					}else{					
						if (function_exists("image_type_to_mime_type") && function_exists("exif_imagetype")) {
							$pmime = (@image_type_to_mime_type(@exif_imagetype($ccac[0])));
							
						} else {
							$pmime = "application/octet-stream";
						}
						
						//die($pmime);
						if (($pmime != "application/octet-stream") && $pmime) {
							header("Content-type: $pmime");
							$fmime = $pmime;
							//doexts($thisExt,$mime,$results,$fmime);
						} else {
							$fmime = setmime($thisExt, $mime, $results);
						}
					}
					//$GLOBALS['fmime']=$fmime;			
				/*--------------------run_charset------------------------*/
				clcharset($results, $charset, $fmime);
				/*--------------------run_charset------------------------*/
					
				/*--------------------run_zwfy------------------------*/
				//die($fmime);
				
				if(($fykg == "true") && (checkgz($fybmd)) &&($fyjt != "true")){
					$results = zwfy($results);
				}
			
				/*--------------------run_zwfy------------------------*/
				if (($ymys == "true")) {
					if (!isgzip($results)) {
						$results = @gzenCode($results, 9);
					}
					header("Content-Encoding: gzip");
					header("Vary: Accept-Encoding");
					header("Content-Length: " . strlen($results));
				}

				die($results);
			}
		}
	}

}
/*--------------------写入缓存------------------------*/
function write_cache($results,$url){
	global $hckg,$hclx,$httpcode,$zydhc,$fyjt,$fykg,$charset,$fmime,$ymys;
	if ($hckg == "true" && (($hclx != "2")&&($hclx != "3")) && strlen($results) && ($httpcode == "200")) {
		if (checkgz($zydhc)) {
			@mkdir(ADIR . "/cache");
			$wresults=$results;
			if(($fyjt=="true")&&($fykg=="true")){
				if ($charset != "utf-8"&&in_array($fmime,array("text/html","text/css","text/xml","application/x-javascript","application/json","text/plain"))) {
					$wresults = @encode_iconv("utf-8",((strtolower($charset)=="gb2312")?("gbk"):($charset)), $wresults,$fmime);				
				}				
			}	
			if ($ymys == "true") {
				$wresults = @gzenCode($wresults, 9);
			}
			file_put_contents(ADIR . "/cache/" . md5($url)."_".rawurlencode(base64_encode($fmime)) . ".cac", $wresults);
		}
	}
}		
/*--------------------超级缓存功能------------------------*/
function supercache($fileName=null){
	global $cjhc;
	if($cjhc=="true"){
		if(@is_readable(@$fileName)){
				$fileStat = stat($fileName); 
				$fileSize = $fileStat['size']; 		
				$lastModified = $fileStat['mtime']; 
				$md5 = md5($fileStat['mtime'] .'='. $fileStat['ino'] .'='. $fileStat['size']); 
				$etag = '"' . $md5 . '-' . crc32($md5) . '"'; 
				header('Last-Modified: ' . gmdate("D, d M Y H:i:s", $lastModified) . ' GMT'); 
				header("ETag: $etag"); 
				header('Pragma: cache'); 
				header('Cache-Control: public, must-revalidate, max-age=0'); 
		}
		
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $lastModified) 
		{ 
			header("HTTP/1.1 304 Not Modified"); 
			return true; 
		} 
	 
		if (isset($_SERVER['HTTP_IF_UNMODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_UNMODIFIED_SINCE']) < $lastModified) 
		{ 
			header("HTTP/1.1 304 Not Modified"); 
			return true; 
		} 
	  
		if (isset($_SERVER['HTTP_IF_NONE_MATCH']) &&  $_SERVER['HTTP_IF_NONE_MATCH'] == $etag) 
		{ 
			header("HTTP/1.1 304 Not Modified"); 
			return true; 
		} 
	}	
}
/*--------------------HEADER信息检测------------------------*/
function check_fileget_header($url,$header_array){
	global $dwjdl,$dwjzxz;
  
	if(!is_numeric(@$dwjzxz)||!@$dwjzxz){
	$dwjzxz=1048576;
	}
	if(function_exists("stream_context_set_default")){
		@stream_context_set_default($header_array);	
	}
	//$url = ((strtolower(substr($url, 0, strlen("https"))) == "https") ? ("http" . substr($url, strlen("https"))) : ($url));
	$preinfo=@get_headers($url, 1);
	$etag=@$preinfo["ETag"];
	$lastModified=@$preinfo["Last-Modified"];
	if($etag){
		header("ETag: $etag");
	}
	if($lastModified){
		header("Last-Modified:  $lastModified");
	}
	supercache();
	$httpcode=@cleandz('/HTTP\/1\.[0|1]\s(.*?)\s/is', $preinfo[0], 0, 1, 1);
	if(in_array($httpcode,array("400","403","404","500","502","503","504"))){
		return array(
			"header" => $preinfo,
			"result" => "",
			"info" => array("http_code"=>$httpcode,"redirect_url"=>"","content_type"=>@$preinfo['Content-Type'])
		);
	}
	if (@$preinfo['Content-Length'] > $dwjzxz) {

		if ($dwjdl == "true") {
				global $cjhc;	
				require_once(LIB . "/download.php");
				$dlr = new Downloader();		
				$dlr->downFile($url,"",1,array(
				'timeout'=>120,
				'agent'=>$agent,
				'proxy'=>$proxy,
				'ppx'=>$ppx,
				'maxrds'=>0,
				'method'=>$method,
				'head'=>$ref . $cookie . $header,
				'data'=>$data
				),@$preinfo['Content-Type'],false,0,$cjhc);
				die();

		} else {
			return array(
				"header" => $preinfo,
				"result" => "",
				"info" => array("http_code"=>$httpcode,"redirect_url"=>$url,"content_type"=>@$preinfo['Content-Type'],"iswjdl"=>"1")
			);
		}
	}else{
		return false;
	}
}
function check_curl_header($url,$agent,$proxy,$ref,$cookie,$header,$data,$preinfo) {
	global $dwjdl,$dwjzxz;
   if (is_null($data) || !$data) {
		$method = "GET";
		
	} else if (is_string($data)) {
		$method = "POST";
		
	} else if (is_array($data)) {
		$method = "POST";
		$data   = http_build_query($data);
	}
	if (!empty($proxy)) {
		$proxy = "tcp://" . $proxy;
		$ppx   = true;
	} else {
		$ppx = false;
	}
	if (!empty($ref)) {
		$ref = "Referer: $ref\n";
	}
	
	if (!empty($cookie)) {
		if ($cookie != "*") {
			$cw = 0;
			if (is_array($cookie)) {
				$cookie = str_replace("&", ";", http_build_query($cookie));
			}
			$cookie = "Cookie: $cookie\n";
		} else {
			if (!file_exists(ADIR . "/file_cookie")) {
				file_put_contents(ADIR . "/file_cookie", "");
				$cookie = "";
			} else {
				$cookie = file_get_contents(ADIR . "/file_cookie") . "\n";
			}
		}
	}     
	$etag=@$preinfo["etag"];
	$lastModified=@$preinfo["last-modified"];
	if($etag){
		header("ETag: $etag");
	}
	if($lastModified){
		header("Last-Modified:  $lastModified");
	}
	supercache();
	$httpcode=$preinfo["httpcode"];
	if(in_array($httpcode,array("400","403","404","500","502","503","504"))){
	    unset($preinfo["httpcode"]);
		return array(
			"header" => $preinfo,
			"result" => "",
			"info" => array("http_code"=>$httpcode,"redirect_url"=>"","content_type"=>@$preinfo['content-type'])
		);
	}

	if ($dwjdl == "true") {
		global $cjhc;
		require_once(LIB . "/download.php");
		$dlr = new Downloader();		
		$dlr->downFile($url,"",1,array(
		'timeout'=>120,
		'agent'=>$agent,
		'proxy'=>$proxy,
		'ppx'=>$ppx,
		'maxrds'=>0,
		'method'=>$method,
		'head'=>$ref . $cookie . $header,
		'data'=>$data
		),@$preinfo['content-type'],false,0,$cjhc);
		die();

	} else {
		return array(
			"header" => $preinfo,
			"result" => "",
			"info" => array("http_code"=>$httpcode,"redirect_url"=>$url,"content_type"=>@$preinfo['content-type'],"iswjdl"=>"1")
		);
	}

}
/*--------------------获取信息功能核心------------------------*/
function getlx($url, $ref = null, $header = null, $cookie = null, $data = null, $agent = "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)", $proxy = null, $isfilecore = null)
{
	
		$isupload=$_FILES?true:false;
	//	var_dump(key($_FILES));
//die(var_dump($_FILES));
//die(json_encode($_POST));

    if(!function_exists("openssl_open")){
        $url = ((strtolower(substr($url, 0, strlen("https"))) == "https") ? ("http" . substr($url, strlen("https"))) : ($url));
    } 
	if($data){
		if($_SERVER["CONTENT_TYPE"]){
			$header="Content-Type:".$_SERVER["CONTENT_TYPE"]."\n".$header;
		}else{
			if(@json_decode($data,1)){$header="Content-Type:application/json\n".$header;}
		}
	}


    // die($url);
    /*var_dump( $url);
    var_dump( $ref);
    var_dump( $proxy);	
    var_dump($header);
    var_dump( $cookie);
    var_dump( $data);
    var_dump( $agent);
	var_dump( $header);
    die();*/    
    if (!$isfilecore) {
$xheader=array();
$size = 0;
$GLOBALS['return']=0;
global $dwjdl,$dwjzxz;
if(!is_numeric(@$dwjzxz)||!@$dwjzxz){
	$dwjzxz=1048576;
}
        $ch = curl_init($url);
        
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 返回字符串，而非直接输出
        curl_setopt($ch, CURLOPT_HEADER, 1); // 不返回header部分
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // 设置socket连接超时时间
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($ch, $str) use (&$xheader){
	// 第一个参数是curl资源，第二个参数是每一行独立的header!
    @list ($name, $value) = array_map('trim', explode(':', $str, 2));
    $name = strtolower($name);
    if($name&&!is_null($value)){
        $xheader[$name]=$value;
    }
    // 判断大小啦
    if ('content-length' == $name) {
		$size=$value;
    	 global $dwjzxz;
        if ($size > $dwjzxz) {
    	    //die("too big!");
    	   $GLOBALS['return']=1;
        	return 0;	// 返回0就会中断读取
        }
        
    }
    return strlen($str);
});

// 对于没有content-length的，我们一边读取一边判断
$xstr="";

    curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $str) use (&$size,$url,&$xstr,&$return) {
       
    	$len = strlen($str);
        $size += $len;
        $xstr.=$str;
        global $dwjzxz;
       // var_dump($size);
        if ($size > $dwjzxz) {
            $GLOBALS['return']=1;
            unset($xstr);
            //$retrun=1;
            //die($dwjzxz."too big2!");

        	return 0;	// 中断读取
        }
        
        return $len;
    });

	if($isupload){
			if(!is_array($data)){
				$data=array();
			}
	$kheader = cleandz('/Content\-Type\:\s*(.*?)\s*\\n/is', $header, 1, 0, 1);
	$header=str_replace($kheader,"",$header);		
			//die(var_dump($_FILES));
while (list($fileskey, $filesvalue) = each($_FILES)) {
	$data[$fileskey]="@".str_replace("\\","/",$_FILES[$fileskey]["tmp_name"]);
}	
			
			//$data = array('name' => $_FILES[key($_FILES)]["name"], key($_FILES) => '@'.$_FILES[key($_FILES)]["tmp_name"]);
			
	//die(var_dump($data));		
			
			
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);			
	}else{
		if (is_null($data) || !$data) {
            // GET

        } else if (is_string($data)) {
			//die("123");

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			
            // POST
            
        } else if (is_array($data)) {
			//die("456");
            // POST
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }		
	}


		
        if (!empty($agent)) {
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        }
        if (!empty($ref)) {
            curl_setopt($ch, CURLOPT_REFERER, $ref); // 设置引用网址
        }
        if (!empty($proxy)) {
            //die($proxy);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
		//curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));		
        if (!empty($header)) {
            $header = explode("\n", str_replace("\r", "", $header));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        
        if (!empty($cookie)) {
            if ($cookie != "*") {
                if (is_array($cookie)) {
                    $cookie = str_replace("&", ";", http_build_query($cookie));
                }
                curl_setopt($ch, CURLOPT_COOKIE, $cookie); // 设置引用Cookies
            } else {
                //die(realpath(ADIR."/cookie"));
                //$cookief=ADIR."/cookie";
                if (!file_exists(ADIR . "/curl_cookie")) {
                    file_put_contents(ADIR . "/curl_cookie", "");
                }
                curl_setopt($ch, CURLOPT_COOKIEFILE, realpath(ADIR . "/curl_cookie"));
                curl_setopt($ch, CURLOPT_COOKIEJAR, realpath(ADIR . "/curl_cookie"));
            }
        }

        
        $str = curl_exec($ch);
		//die(var_dump($str));
        $http_code=curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //die(var_dump($GLOBALS['return']));
        if($GLOBALS['return']){
           // var_dump(curl_getinfo($ch));
          // $xheader=curl_getinfo($ch);
            //$GLOBALS['return']=check_curl_header($url,$agent,$proxy,$ref,$cookie,$header,$data,$ctype);
            //var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE));
            //var_dump($xheader);
            $xheader["httpcode"]=$http_code;
            return check_curl_header($url,$agent,$proxy,$ref,$cookie,$header,$data,$xheader);
            //die("123");
        }
        if($str&&!is_null($xstr)){
            $str=$xstr;
        }        
        //die($str);		
        $hc  = curl_getinfo($ch);
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $hdr        = substr($str, 0, $headerSize);
            $str        = substr($str, $headerSize);
        } else {
            $hdr = "";
        }
        
        
        //var_dump($str);
        
        curl_close($ch);
        
        return array(
            "header" => $hdr,
            "result" => $str,
            "info" => $hc
        );
    } else {
        if (is_null($data) || !$data) {
            $method = "GET";
            
        } else if (is_string($data)) {
            $method = "POST";
            
        } else if (is_array($data)) {
            $method = "POST";
            $data   = http_build_query($data);
        }
        if (!empty($proxy)) {
            $proxy = "tcp://" . $proxy;
            $ppx   = true;
        } else {
            $ppx = false;
        }
        if (!empty($ref)) {
            $ref = "Referer: $ref\n";
        }
        
        if (!empty($cookie)) {
            if ($cookie != "*") {
                $cw = 0;
                if (is_array($cookie)) {
                    $cookie = str_replace("&", ";", http_build_query($cookie));
                }
                $cookie = "Cookie: $cookie\n";
            } else {
                $cw = 1;
                if (!file_exists(ADIR . "/file_cookie")) {
                    file_put_contents(ADIR . "/file_cookie", "");
                    $cookie = "";
                } else {
                    $cookie = file_get_contents(ADIR . "/file_cookie") . "\n";
                }
            }
        } else {
            $cw = 0;
        }
        //die($agent);
        //die($ref.$cookie.join("\n",explode("\n",str_replace("\r","",$header))));

        
        //$url = ((strtolower(substr($url, 0, strlen("https"))) == "https") ? ("http" . substr($url, strlen("https"))) : ($url));
		
if($isupload){
	define('MULTIPART_BOUNDARY', '--------------------------'.microtime(true));
	$kheader = cleandz('/Content\-Type\:\s*(.*?)\s*\\n/is', $header, 1, 0, 1);
	$header=str_replace($kheader,"",$header);
	//die(var_dump($kfcookie));
	$header .= "Content-Type: multipart/form-data; boundary=".MULTIPART_BOUNDARY;
	// equivalent to <input type="file" name="uploaded_file"/>
while (list($fileskey, $filesvalue) = each($_FILES)) {	
	
	$filekey=$fileskey;
	$filename=$_FILES[$fileskey]["name"];
	$filepath = $_FILES[$fileskey]["tmp_name"];
	
	$file_contents = file_get_contents($filepath);    
//die($header);
	$data =  "--".MULTIPART_BOUNDARY."\r\n".
				"Content-Disposition: form-data; name=\"".$filekey."\"; filename=\"".($filename)."\"\r\n".
				"Content-Type: application/octet-stream\r\n\r\n".
				$file_contents."\r\n";
}
	// add some POST fields to the request too: $_POST['foo'] = 'bar'
	/*$data .= "--".MULTIPART_BOUNDARY."\r\n".
				"Content-Disposition: form-data; name=\"foo\"\r\n\r\n".
				"bar\r\n";*/
while (list($postkey, $postvalue) = each($_POST)) {
 $data .= "--".MULTIPART_BOUNDARY."\r\n".
				"Content-Disposition: form-data; name=\"".$postkey."\"\r\n\r\n".
				"".$postvalue."\r\n";
}
	// signal end of request (note the trailing "--")
	$data .= "--".MULTIPART_BOUNDARY."--\r\n";	
//die($data);	
$method="POST";
}		

        $options = array(
            'http' => array(
                'timeout' => 120,
                'user_agent' => $agent,
                'proxy' => $proxy,
                'request_fulluri' => $ppx,
                'max_redirects' => 0,
                'method' => $method,
                'header' => $ref . $cookie . $header,
                'content' => $data
            )
        );		
		if(!$isupload){
			$hcc=check_fileget_header($url,$options);
			if($hcc){
				return $hcc;
			}				
		}
        $r   = @file_get_contents($url, false, stream_context_create($options));
		
		
		
        if (isgzip($r)) {
            if (!function_exists("gzdecode")) {
                require_once(LIB . "/gzdecode.php");
            }
            $r = @gzdecode($r);
        }
        $http_response_header = join(PHP_EOL, $http_response_header);
        if ($cw) {
            $kfcookie = cleandz('/Set\-Cookie\:\s*(.*?)\s*\;/is', $http_response_header, 0, 0, 1);
            
            //die(var_dump($http_response_header));
            if ($kfcookie) {
                for ($i = 0; $i < count($kfcookie); $i++) {
                    
                    $kfc = explode("=", $kfcookie[$i]);
                    //die($kfc[0]."=".urlencode(substr($kfcookie[$i], strlen($kfc[0]) + 1)).";");
                    //var_dump($kfc);
                    //die(urlencode(substr($kfcookie[$i],strlen($kfc[0])+1)));
                    $cwc .= $kfc[0] . "=" . urlencode(substr($kfcookie[$i], strlen($kfc[0]) + 1)) . ";";
                }
            }
            //$kfcookie = str_replace("&", ";", http_build_query($kfcookie));
            if ($kfcookie) {
                file_put_contents(ADIR . "/file_cookie", $kfcookie);
            }
        }
		if($http_response_header){
        return array(
            "header" => $http_response_header,
            "result" => $r,
            "info" => array(
                "http_code" => cleandz('/HTTP\/1\.[0|1]\s(.*?)\s/is', $http_response_header, 0, 1, 1),
                "redirect_url" => cleandz('/Location\s*\:\s*(.*?)[\r]?\n/is', $http_response_header, 0, 1, 1),
                "content_type" => cleandz('/Content\-\Type\s*\:\s*(.*?)[\r]?\n/is', $http_response_header, 0, 1, 1)
            )
        );
		}else{
        return array(
            "header" => $preinfo,
            "result" => $r,
            "info" => array(
                "http_code" => cleandz('/HTTP\/1\.[0|1]\s(.*?)\s/is', $preinfo[0], 0, 1, 1),
                "redirect_url" => $preinfo['Location'],
                "content_type" => $preinfo['Content-Type']
            )
        );		
		}
    }
}
/*--------------------自定义MIME------------------------*/
function doexts($thisExt, $mime, $results)
{
    global $rootUrl;
    if (!strlen($results)) {
        return false;
    }
    for ($i = 0; $i < count($mime); $i++) {
        
        //die($site.$paths[$i]["search"]);
        if ((base64_decode($mime[$i]["status"]) == "run") && $mime[$i]["name"] && (strtolower($thisExt) == strtolower(base64_decode($mime[$i]["name"])))) {
            
            //die(var_dump(pbpage(base64_decode($mime[$i]["path"]))));
            
            //die(base64_decode($mime[$i]["path"]));
            if (pbpage(base64_decode($mime[$i]["path"]))) {
                //die("123");
                //die(var_dump(base64_decode($mime[$i]["name"])));
                //&&((base64_decode($mime[$i]["path"])=="*")||($site.base64_decode($mime[$i]["path"])==$url)||($site.cleandz(base64_decode($mime[$i]["path"]),$uri,1,1)==$url))){
                //if($thisExt==base64_decode($mime[$i]["name"])){
                
                if (($rootUrl . cleandz(base64_decode($mime[$i]["path"]), $uri, 1, 1) == PATH)) {
                    header("Content-type: " . base64_decode($mime[$i]["contents"]));
                    return base64_decode($mime[$i]["contents"]);
                }
                /*if($mime[$i]["replace"]){
                die(str_replace("{results}",$results,base64_decode($mime[$i]["path"])));
                }*/
            }
        }
    }
}
//die($thisExt );
/*--------------------MIME默认配置------------------------*/
function setmime($thisExt, $mime, $results, $url = null)
{
    if (!strlen($results)) {
        return false;
    }
    switch (strtolower($thisExt)) {
        case "png":
            header("Content-type: image/png");
            die($results);
            break;
        case "jpg":
            header("Content-type: image/jpg");
            die($results);
            break;
        case "gif":
            header("Content-type: image/gif");
            die($results);
            break;
        case "js":
            header("Content-type: application/javascript");
            $r = "application/javascript";
            break;
        case "css":
            header("Content-type: text/css");
            $r = "text/css";
            break;
        case "json":
            header("Content-type: application/json");
            $r = "application/json";
            break;
        case "woff":
            header("Content-type: application/x-font-woff");
            die($results);
            break;			
        case "swf":
            header("Content-type:application/x-shockwave-flash");
            die($results);
            break;
        case "mp3":
            header("Content-type:audio/mp3");
            die($results);
            break;
        case "mp4":
            header("Content-type:video/mp4");
            die($results);
            break;
        case "webm":
            header("Content-type:video/webm");
            die($results);
            break;			
        case "mkv":
            header("Content-type:video/x-matroskaMKV-application/octet-stream");
            die($results);
            break;	
        case "ico":
            header("Content-type:image/x-icon");
            die($results);
            break;				
        case "html":
        case "htm":
        case "xml":
        case "asp":
        case "php":
        case "jsp":
        case "":
            header("Content-type: text/html");
            $r = "text/html";
            break;
        default:
            header("Content-type: application/octet-stream");
            if ($url) {
                header("Content-Disposition: attachment; filename=" . end(explode('/', $url)));
            }
            $r = "application/octet-stream";
            /*die($results);*/
            
            break;
    }
	switch(getmimecode($results)){
		case 13780:
            header("Content-type: image/png");
            die($results);		
		break;
		case 7173:
            header("Content-type: image/gif");
            die($results);		
		break;
		case 255216:
            header("Content-type: image/jpg");
            die($results);		
		break;		
		case 7368:
            header("Content-type: audio/mp3");
            die($results);		
		break;				
		/*case 0:
            header("Content-type: video/mp4");
            die($results);		
		break;						*/
	}
    $rx = doexts($thisExt, $mime, $results);
    if (!$rx) {
        $rx = $r;
    }
    return $rx;
}
/*--------------------正则功能核心------------------------*/
function cleandz($gz, $html, $full = null, $single = null, $est = null)
{
	/*if(substr($gz,0,1)=="<"&&substr($gz,-1)==">"){
		$gz="/".str_zy($gz)."/";
	}*/
    @preg_match_all($gz, $html, $match);
    if (!$full) {
        $match = $match[1];
    }
    @$a = array_unique($match);
    $s = array();
    
    for ($i = 0; $i < count($match); $i++) {
        if (@$a[$i]) {
            $s[count($s)] = $a[$i];
        }
    }
    if ($s) {
        if ($full) {
            $s = $s[0];
        }
    } else {
        $s = array(
            $gz
        );
    }
    if ($single) {
        $s = $s[0];
    }
    if (($est && ($s == $gz)) || ($est && ($s[0] == $gz) && (count($s) == 1))) {
        return (false);
    }
    return ($s);
}
/*--------------------综合替换功能------------------------*/
function delstr($match, $replace, $html, $full = null)
{
    //die($replace);
    $r = cleandz($match, $html, $full, 0);
    for ($i = 0; $i < count($r); $i++) {
        $html = str_replace($r[$i], $replace, $html);
    }
    return $html;
}
/*--------------------获取HEADER信息------------------------*/
function getheader($url, $type, $all = null)
{
    $x = @get_headers($url, 1);
    $r = @$x[$type];
    if (!$all) {
        if (is_array($r)) {
            $r = $r[0];
        }
    }
    return $r;
}
/*--------------------获取HTTPCODE码------------------------*/
function httpcode($url)
{
    $httpcode = @explode(" ", getheader($url, 0));
    $httpcode = @$httpcode[1];
    //if($httpcode=="302"){$httpcode=@explode(" ",get_headers(get_headers($url,1)["Location"],1)[0])[1];}
    return $httpcode;
}
/*--------------------当前站点配置读取------------------------*/
function readsite()
{

    //die(substr(dirname($_SERVER['REQUEST_URI']."*")."/",1));
    //die(substr(dirname(PATH."*")."/",0,strlen));
    $r = @file_get_contents(ADMIN . "/config/site.json");
    $r = json_decode($r, 1);
    for ($i = 0; $i < count($r); $i++) {
        if (base64_decode($r[$i]["status"]) == "run") {
            $p  = base64_decode($r[$i]["path"]);
			$ep=explode("|",$p);
			if(!@$ep[1]){
				$iprz=true;
			}else{
				$iprz=pre_ippd($ep[1]);
			}
            $px = cleandz(strtolower($ep[0]), PATH, 1, 1, 1);
            if (strlen($px)) {
                $p = $px;
            }else{
				$p = $ep[0];
			}
            if (((strtolower($p) == strtolower($_SERVER["HTTP_HOST"])) || (strtolower($p) == strtolower(substr(PATH, 0, strlen($p)))))&&$iprz) {
                
                if (strtolower($p) == strtolower(substr(PATH, 0, strlen($p)))) {
                    global $siteuri;
                    $siteuri = substr(dirname($p . "*"), strlen((($_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http')) . "://" . $_SERVER['HTTP_HOST'])) . "/";
                }
                
                return base64_decode($r[$i]["contents"]);
                
                
            }
        }
    }
    //die("It's Work!");
	supercache(EXT . "/sitenotset.ext");
    die(str_replace("{label}", "Site Not Setted!", @file_get_contents(EXT . "/sitenotset.ext")));
}
/*--------------------配置读取------------------------*/
function readconfig($key, $name)
{
    $x = @json_decode($key, 1);
    return @base64_decode($x[$name]);
}
/*--------------------获取来访IP------------------------*/
function getClientIp()
{
    if (!empty($_SERVER["HTTP_CLIENT_IP"]))
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    else if (!empty($_SERVER["REMOTE_ADDR"]))
        $ip = $_SERVER["REMOTE_ADDR"];
    else
        $ip = "err";
    
    $ip = explode(",", $ip);
    return $ip[0];
}
/*--------------------返回泛指路径（../等）的真实路径------------------------*/
function getlv($str, $sz)
{
    /*
    global $site;
    $r=explode("/",$str);
    for($i=0;$i<count($r)-$sz;$i++){
    $s.=$r[$i]."/";
    }
    return substr($s,strlen($site)+1);
    */
    global $rootUrl;
    for ($i = 0; $i < ($sz); $i++) {
        $str = dirname($str . "*");
    }
    $r = substr($str, strlen($rootUrl)) . "/";
    if (substr($r, 0, 1) == "/") {
        $r = substr($r, 1);
    }
    return $r;
}
/*--------------------编码探测------------------------*/
function tcbm($str,$charset=null){
	global $pcharset;
	if(strtolower($charset)=="auto"||!$charset){
		if(function_exists("mb_detect_encoding")){
			$charset=strtolower(mb_detect_encoding($str, array('UTF-8', 'ASCII', 'GBK', 'GB2312', 'BIG5', 'JIS', 'eucjp-win', 'sjis-win', 'EUC-JP')));
			//die($charset);
		}else{
			if(preg_match('/^.*$/u', $str) > 0){
				$charset="utf-8";
			}else{
				$charset=$pcharset;
			}
		}
	}
	return $charset;
	//return (in_array(strtolower($charset),array("gb2312","gbk","utf-8","ascii","big5","jis","eucjp-win", "sjis-win","euc-jp")))?$charset:$pcharset;
}
/*--------------------编码转换------------------------*/
function encode_iconv($sencoding, $tencoding, $str,$fmime=null)
{	
	//global $fmime;
	//header("Content-type: text/html; charset=utf-8");
	//die($fmime);
	if(@$fmime){
		$ttf=@explode("/",@$fmime);
		if(in_array(@$ttf[0],array("image","video","audio"))||$fmime=="application/octet-stream"){
			return $str;
		}
	}
	$tencoding=tcbm($str,$tencoding);
	$sencoding=tcbm($str,$sencoding);
	if($tencoding=="gb2312"){$tencoding="gbk";}
	if($sencoding=="gb2312"){$sencoding="gbk";}
	/*echo $tencoding;
	echo $sencoding;
	die("123");*/
	if(strtolower($sencoding)!=strtolower($tencoding)){
		if (function_exists("mb_convert_encoding")) {
			$str = @mb_convert_encoding($str, $tencoding, $sencoding);
		} else {
			$str = @iconv($sencoding, $tencoding . "//TRANSLIT//IGNORE", $str);
		}
	}
	/*header("Content-type: text/html; charset=utf-8");
die(@$str);*/
    return $str;
}
/*--------------------获取随机字符------------------------*/
function getRandStr($length,$type) {
	switch($type){
	case 0:
		$str='0123456789';
	break;
	case 1:
		$str='abcdefghijklmnopqrstuvwxyz';
	break;
	case 2:
		$str='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	break;
	case 3:
		$str = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	break;
	default:
		$str = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	break;
	}
	$randString = '';
	$len = strlen($str) - 1;
	for ($i = 0; $i < $length; $i++) {
		$num = mt_rand(0, $len);
		$randString.= $str[$num];
	}
	return $randString;
}
/*--------------------获取Unicode------------------------*/
function utf8tounicode($str){
return substr(json_encode($str),1,-1);
}
/*--------------------页面内容替换功能------------------------*/
function getpages($c)
{
    global $siteuri,$litesiteuri, $site, $rootUrl, $url, $uri, $litesite,$sitehost,$litesitehost, $liteurl,$liteuri, $host, $litehost, $results, $httpcode, $lxres, $literoot, $litepath, $literooturl;
    $type = array(
        "input",
        "web",
        "eval",
        "location",
        "run",
		"rand",
		"strrand",
		"unicode"
    );
    //die(var_dump(count($type)));
    for ($i = 0; $i < count($type); $i++) {
        $z = cleandz('/\{' . $type[$i] . '\s*\:\s*(.*?)\}/i', $c, 0, 0, 1);
        //die(var_dump(count($type)));
        //die(var_dump(cleandz('/\{'.$type[19].'\:(.*?)\}/is',$c,0,1)));
        
        //if($z&&($z!='/\{'.$type[$i].'\:(.*?)\}/is')){
        for ($t = 0; $t < count($z); $t++) {
            switch (strtolower($type[$i])) {
                case "input":
                    $x = @file_get_contents(ADMIN . "/pages/" . urlencode($z[$t]) . ".xkz");
                    break;
                case "web":
                    $x = @file_get_contents($z[$t]);
                    break;
                case "rand":
					$xz=explode("-",$z[$t]);
                    $x = @rand($xz[0],$xz[1]);
                    break;		
                case "strrand":
					$xz=explode(",",$z[$t]);
                    $x = @getRandStr($xz[0],$xz[1]);
                    break;						
                case "location":
                    $x = @getheader($z[$t], "Location");
                    break;
                case "eval":
                    $k = @file_get_contents(ADMIN . "/pages/" . urlencode($z[$t]) . ".xkz");
                    if ($k) {
                        $x = @eval($k);
                    }
                    break;
                case "run":
                    if ($z[$t]) {
                        $x = @eval(@base64_decode($z[$t]));
                    }
                    break;
                case "unicode":
                    if ($z[$t]) {
                        $x = utf8tounicode($z[$t]);
                    }
                    break;					
            }
            $c = str_replace("{" . $type[$i] . ":" . $z[$t] . "}", $x, $c);
        }
        
        
    }
    //if($x){return $x;}
    
    return $c;
}


/*--------------------自定义页面功能------------------------*/
function clpage($c, $fh = null)
{
    global $siteuri,$litesiteuri, $site, $rootUrl, $url, $uri, $litesite,$sitehost,$litesitehost, $host, $litehost, $liteurl,$liteuri, $results, $httpcode, $lxres, $literoot, $litepath, $literooturl,$pcharset;
    header("Content-type: text/html; charset=".($fh?$pcharset:"utf-8"));
    $z = @json_decode($c, 1);

    if ($z) {
        
        switch (strtolower($z["op"])) {
		
            case "header":
                switch ($z["code"]) {
                    case "403":
                        $s = header("HTTP/1.1 403 Forbidden ");
						die($s);
                        break;
                    case "404":
                        $s = header("HTTP/1.1 404 Not Found");
                        die($s);
                        break;
                    case "500":
                        $s = header("HTTP/1.1 500 Internal Server Error");
                        die($s);
                        break;
                    case "301":
                        header("HTTP/1.1 301 Moved Permanently");
                        $s = header("Location:" . $z["location"]);
                       die($s);
                        break;
                    case "302":
                        header("HTTP/1.1 302 Found");
                        $s = header("Location:" . $z["location"]);
                        die($s);
                        break;
                    default:
                        $s = header($z["code"]);
                        return false;
                        break;
                }
                //if($fh){return $s;}else{die($s);}
                break;	
            case "curl":
				$flag = @json_decode(@base64_decode(@$z["config"]),1);
				$url=$z["code"];
					if(!function_exists("openssl_open")){
						$url = ((strtolower(substr($url, 0, strlen("https"))) == "https") ? ("http" . substr($url, strlen("https"))) : ($url));
					} 
				if($flag){
					$s   = @file_get_contents($url, false, stream_context_create($flag));				
				}else{
					$s = @file_get_contents($url);
				}
                if ($fh) {
                    return $s;
                } else {
                    die((string)$s);
                }
                break;
            case "location":
                $s = header("Location: " . $z["code"]);
                if ($fh) {
                    return $s;
                } else {
                    die($s);
                }
                break;
            case "include":
				@include(ADMIN . "/pages/" . urlencode($z["code"]) . ".xkz");
				$GLOBALS["include_X"]=1;
                /*if ($fh) {*/
                    return false;
                /*} else {
                    die();
                }*/				
                break;						
            case "text":
				if (!$fh) {supercache(ADMIN . "/pages/" . urlencode($z["code"]) . ".xkz");}
                $s = @file_get_contents(ADMIN . "/pages/" . urlencode($z["code"]) . ".xkz");
                if ($fh) {
                    return $s;
                } else {
                    die((string)$s);
                }
                break;
            case "php":
                $flag = @base64_decode(@$z["config"]);
                $s    = @eval(@file_get_contents(ADMIN . "/pages/" . urlencode($z["code"]) . ".xkz"));
                
                /*if ($fh) {*/
                    return $s;
                /*} else {
                    die($s);
					}*/
                break;
            case "file":
                //die($c);
				if (!$fh) {supercache(ADMIN . "/pages/" . urlencode($z["code"]) . ".xkz");}
                $r = @file_get_contents(ADMIN . "/pages/" . urlencode($z["code"]) . ".xkz");
                
                
                
                
                
                $lfdname = ADMIN . "/pages/" . urlencode($z["code"]);
                $j       = @json_decode($r, 1);
                //die(var_dump(file_exists($lfdname.".dat")));
                if (file_exists($lfdname . ".dat") && (@$j["type"] == "data")) {
                    
                    header("Content-type:" . @$j["mime"]);
                    if (@$j["mime"] == "application/octet-stream") {
                        Header("Accept-Ranges: bytes");
                        Header("Accept-Length: " . filesize($lfdname . ".dat"));
                        Header("Content-Disposition: attachment; filename=" . @$j["name"]);
                    }
                    $file = fopen($lfdname . ".dat", "r"); // 打开文件
                    $r    = fread($file, filesize($lfdname . ".dat"));
                    fclose($file);
                     die($r);
                    
                } else {
                    
                    
                    
                    
                    if (substr($r, 0, 5) == "data:") {
                        $s = explode(",", $r);
                        $k = explode(";", substr($s[0], 5));
                        $k = $k[0];
                        header("Content-type: " . $k);
                        $r = base64_decode($s[1]);
						 die($r);
                    }else{
						$r=@$s;
						//die($z["mime"]);
						if(@$z["mime"]){
							header("Content-type: " . @$z["mime"]);
						}
						 die($r);
					}
                    
                    
                }
                /*$s = $r;
                if ($fh) {
                    return $s;
                } else {
                    die($s);
                }*/
                break;
            case "run":
                //die(base64_decode($z["code"]));
                $flag = @base64_decode(@$z["config"]);
                $s    = @eval(@base64_decode($z["code"]));
                /*if ($fh) {*/
                    return $s;
                /*} else {
                    die($s);
					}*/
                break;
            default:
                break;
        }
    }
	$s=tsnr($c);
    return $s?$s:($c);
}
/*--------------------页面内容替换外挂------------------------*/
function glnr($c, $results, $value, $replace)
{
    global $siteuri,$litesiteuri, $site, $rootUrl, $url, $uri, $litesite,$sitehost,$litesitehost, $host, $litehost, $liteurl,$liteuri, $results, $httpcode, $lxres, $literoot, $litepath, $literooturl,$fmime,$charset;
//die($charset);
    $z = @json_decode($c, 1);
    if ($z) {
        if (($replace == @$z["replace"])||(!$replace&&(strtolower($z["op"])=="dom"))||(!$replace&&(strtolower($z["op"])=="include"))) {
            $flag = @base64_decode(@$z["config"]);
            switch (strtolower($z["op"])) {
                case "php":
                    $s = @eval(@file_get_contents(ADMIN . "/pages/" . urlencode($z["code"]) . ".xkz"));
                    if ($s) {
                        return $s;
                    }
                    break;
                case "include":
						@include(ADMIN . "/pages/" . urlencode($z["code"]) . ".xkz");
						$GLOBALS["include_X"]=1;
                        return false;
                    break;					
                case "run":
                    $s = @eval(@base64_decode($z["code"]));
                    //die($s);
                    if ($s) {
                        return $s;
                    }
                    break;
				case "dom":
				    //die($c);
					if(in_array($fmime,array("text/xml","text/html"))){
					$config=array(array("dom"=>$z["dom"],"do"=>$z["do"],"find"=>$z["find"],"replace"=>$value));
					//die($results);
					$GLOBALS["dom_charset"]="utf-8";
					$s = html_dom_replace($results,$config,$charset);
                    if ($s) {
					//die($s);
                        return $s;
                    }			
					}
					break;
            }
        }
    }
    
    
}
/*--------------------字符串简化------------------------*/
function str_lite($str)
{
if(strstr($str,"://")){
    $xlite = explode("://", $str);
    $lite  = substr($str, strlen($xlite[0]) + 3);
		}else{
		$lite=$str;
		}
    if (substr($lite,0,1) == "/") {
        $lite = substr($lite,1);
    }		
    if (substr($lite, strlen($lite) - 1) == "/") {
        $lite = substr($lite, 0, strlen($lite) - 1);
    }

    return $lite;
}
/*--------------------通配符------------------------*/
function tsnr($target)
{
    global $siteuri,$litesiteuri, $site, $rootUrl, $url, $uri, $litesite,$sitehost,$litesitehost, $liteurl,$liteuri, $host, $litehost, $httpcode, $literoot, $litepath, $literooturl, $results;
    $ppgz               = array();
    $ppgz[count($ppgz)] = array(
        "results",
        $results
    );
    $ppgz[count($ppgz)] = array(
        "site",
        $site
    );
    $ppgz[count($ppgz)] = array(
        "litesite",
        $litesite
    );
    $ppgz[count($ppgz)] = array(
        "litesiteuri",
        $litesiteuri
    );	
    $ppgz[count($ppgz)] = array(
        "sitehost",
        $sitehost
    );	
    $ppgz[count($ppgz)] = array(
        "litesitehost",
        $litesitehost
    );		
    $ppgz[count($ppgz)] = array(
        "host",
        $host
    );
    $ppgz[count($ppgz)] = array(
        "litehost",
        $litehost
    );
    $ppgz[count($ppgz)] = array(
        "siteuri",
        $siteuri
    );
    $ppgz[count($ppgz)] = array(
        "adir",
        ADIR
    );
    $ppgz[count($ppgz)] = array(
        "admin",
        ADMIN
    );
    $ppgz[count($ppgz)] = array(
        "root",
        ROOT
    );
    $ppgz[count($ppgz)] = array(
        "path",
        PATH
    );
    $ppgz[count($ppgz)] = array(
        "rooturl",
        $rootUrl
    );
    $ppgz[count($ppgz)] = array(
        "liteurl",
        $liteurl
    );
    $ppgz[count($ppgz)] = array(
        "$liteuri",
        $liteuri
    );	
    $ppgz[count($ppgz)] = array(
        "literoot",
        $literoot
    );
    $ppgz[count($ppgz)] = array(
        "litepath",
        $litepath
    );
    $ppgz[count($ppgz)] = array(
        "literooturl",
        $literooturl
    );
    $ppgz[count($ppgz)] = array(
        "url",
        $url
    );
    $ppgz[count($ppgz)] = array(
        "uri",
        $uri
    );
    $ppgz[count($ppgz)] = array(
        "httpcode",
        $httpcode
    );
    for ($i = 0; $i < count($ppgz); $i++) {
        $target = str_replace('{' . $ppgz[$i][0] . ',zy}', str_zy($ppgz[$i][1]), $target);
        $target = str_replace('{' . $ppgz[$i][0] . ',lite}', str_lite($ppgz[$i][1]), $target);
        $target = str_replace('{' . $ppgz[$i][0] . ',base64}', base64_encode($ppgz[$i][1]), $target);		
        $target = str_replace('{' . $ppgz[$i][0] . '}', $ppgz[$i][1], $target);
		$tjj0=@cleandz("/\{".$ppgz[$i][0]."\,\[(.*?)\]\}/is", $target , 0, 1,1);
		$tjj1=@json_decode("{".$tjj0."}",1);
		if($tjj1){
			$tjj2=@cleandz($tjj1["rule"], $ppgz[$i][1] , 0, 1,1);
			$target = str_replace('{' . $ppgz[$i][0] . ',['.$tjj0.']}', $tjj2?$tjj2:"", $target);//rule
		}
	}
    return $target;
}
/*--------------------高级通配符------------------------*/
function clnr($gz, $source, $target)
{
    //echo $gz;echo $source;
    //$ss='{$1}-{$2}-{$3}-{$4}';//"/127\.(.*?)\.(.*?)\.(.*?)\|/is"//"127.1.2.3|-127.6.8.6|"//clnr("/127\.(.*?)\.(.*?)\.(.*?)\|/is","127.1.2.3|-127.6.8.6|",'{$1}-{$2}-{$3}-{$4}');
    @preg_match($gz, $source, $m);
    //var_dump($m);
    for ($i = 1; $i < count($m); $i++) {
        $target = str_replace('{$' . $i . ',zy}', str_zy($m[$i]), $target);
        $target = str_replace('{$' . $i . ',lite}', str_lite($m[$i]), $target);
        $target = str_replace('{$' . $i . ',base64}', base64_encode($m[$i]), $target);		
        $target = str_replace('{$' . $i . '}', $m[$i], $target);
    }
    
    $target = tsnr($target);
    //die(var_dump($target));
    return $target;
}
/*--------------------压缩页面判断------------------------*/
function isgzip($results)
{
    $bin      = (substr($results, 0, 2));
    $strInfo  = @unpack("C2chars", $bin);
    $typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);
    switch ($typeCode) {
        case 31139:
            //网站开启了gzip 
            $isGzip = 1;
            break;
        default:
            $isGzip = 0;
    }
    return $isGzip;
    
}
/*--------------------MIME_Code------------------------*/
function getmimecode($results)
{
    $bin      = (substr($results, 0, 2));
    $strInfo  = @unpack("C2chars", $bin);
    $typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);
    return $typeCode;
    
}
/*--------------------自定义页面路径判断------------------------*/
function pre_pbpage($path){

	//$path='!||*';
	//die($path);

	if($path==""||$path=="!"){return pbpage($path);}
	$xx=explode("||",$path);
	//die(var_dump(pbpage($xx[0])));
	for($i=0;$i<count($xx);$i++){
		if(!pbpage($xx[$i])){
			return false;
		}
	}
	return true;
}
function pbpage($path)
{
    global $thisExt, $site, $url, $uri, $rootUrl,$fmime;
	if($path==$uri){return true;}
    $x_check = false;
    if (($path != "*")) {
		if ((substr($path, 0, 1) == "{") || (substr($path, 0, 2) == "!{")) {
            if ((substr($path, 0, 2) == "!{")) {
                $xzz = json_decode(substr($path, 1), 1);
            } else {
                $xzz = json_decode($path, 1);
            }
				//die(var_dump($xzz));
			//die($fmime);
			if(@$xzz["mime"]&&@$fmime){
				for ($t = 0; $t < count($xzz["mime"]); $t++) {
					if (substr($path, 0, 1) != "!") {
						if (strtolower($xzz["mime"][$t]) == strtolower($fmime)) {
							$x_check = true;
						}						
					}else{
						if (strtolower($xzz["mime"][$t]) != strtolower($fmime)) {
							$x_check = true;
						} else {
							$x_check = false;
							break;
						}						
					}
				}
			}
			return $x_check;
		}
	
	
	
        if ((substr($path, 0, 1) == "[") || (substr($path, 0, 2) == "![")) {
            if ((substr($path, 0, 2) == "![")) {
                $xzz = json_decode(substr($path, 1), 1);
            } else {
                $xzz = json_decode($path, 1);
            }
            for ($z = 0; $z < count($xzz); $z++) {
                if ((substr($path, 0, 1) != "!")) {
				//die(var_dump($rootUrl . $xzz[$z] != PATH));
                    if ((strtolower($xzz[$z]) == "*." . strtolower($thisExt)) || ($rootUrl . $xzz[$z] == PATH) || ($rootUrl . cleandz($xzz[$z], $uri, 1, 1) == PATH) || (cleandz($xzz[$z], PATH, 1, 1) == PATH)) {
                        $x_check = true;
                    }
                } else {
                    if ((strtolower($xzz[$z]) != "*." . strtolower($thisExt)) && ($rootUrl . $xzz[$z] != PATH) && ($rootUrl . cleandz($xzz[$z], $uri, 1, 1) != PATH) && (cleandz($xzz[$z], PATH, 1, 1) != PATH)) {
                        $x_check = true;
                    } else {
                        $x_check = false;
                        break;
                    }
                    
                }
            }
        } else {
            if ((substr($path, 0, 1) == "!")) {
                $xzz = substr($path, 1);
            } else {
                $xzz = $path;
            }
            if ((substr($path, 0, 1) == "!")) {
                if ((strtolower($xzz) != "*." . strtolower($thisExt)) && ($rootUrl . $xzz != PATH) && ($rootUrl . cleandz($xzz, $uri, 1, 1) != PATH) && (cleandz($xzz, PATH, 1, 1) != PATH)) {
                    $x_check = true;
                }
            } else {
			
                //echo(var_dump($path));
                //if($xzz="hdslb/js/page.calendar.js"){die("hdslb/js/page.calendar.js");}
                if ((strtolower($xzz) == "*." . strtolower($thisExt)) || ($rootUrl . $xzz == PATH) || ($rootUrl . cleandz($xzz, $uri, 1, 1) == PATH) || (cleandz($xzz, PATH, 1, 1) == PATH)) {
                    $x_check = true;
                }
            }
        }
    } else {
        $x_check = true;
    }
    return $x_check;
}
/*--------------------编码设定------------------------*/
function clcharset($results, $charset, $kmime=null)
{
    //die($charset);
    global $charset,$pcharset;
    $c = cleandz('/\s*charset\s*\=\s*[\'|\"]*(.*?)[\'|\"]/is', $results, 0, 1, 1);
    if (!$c) {
        $c = cleandz('/\sencoding\s*\=\s*[\'|\"]*(.*?)[\'|\"]/is', $results, 0, 1, 1);
    }
	   if (!$c) {
        $c = cleandz('/setcharset\s*\(\s*[\'|\"](.*?)[\'|\"]\s*\)\s*/is', $results, 0, 1, 1);
    }
    if (($c) && (strtolower($c) != "utf-8")) {
        $charset = $c;
		$pcharset = &$pcharset ;
    }
    if ((trim(strtolower($charset)) != "utf-8")) {

		if($charset=="auto"){
			//$results=str_replace("encoding=".$charset,"encoding=utf-8",str_replace("encoding=\"".$charset."\"","encoding=\"utf-8\"",str_replace('charset='.$charset.'\'','charset=utf-8\'',str_replace('charset=\''.$charset.'\'','charset=\'utf-8\'',str_replace('charset='.$charset.'"','charset=utf-8"',str_replace('charset="'.$charset.'"','charset="utf-8"',$results)));
			/*$yc=tcbm($results);
			$trr=array(
			'charset="'.$yc.'"'=>'charset="utf-8"',
			'charset=\''.$yc.'\''=>'charset=\'utf-8\'',
			'charset='.$yc=>'charset=utf-8',
			"encoding=\"".$yc."\""=>"encoding=\"utf-8\"",
			"encoding='".$yc."'"=>"encoding='utf-8'",
			"encoding=".$yc=>"encoding=utf-8",
			"setcharset(\"".$yc=>"setcharset(\"utf-8",
			"setcharset('".$yc=>"setcharset('utf-8",
			);
			$results=strtr($results,$trr);*/
			$results=encode_iconv($charset,"utf-8",$results,$kmime);
				//die($pcharset);
			@header("Content-type: $kmime;charset=$pcharset");
		}else{
		
			header("Content-type: $kmime;charset=$charset");
        }
        $cc = 1;
    } else {
		@header("Content-type: $kmime;charset=$charset");
        $cc = 0;
    }
    return $cc;
}
/*--------------------字符串转义------------------------*/
function str_zy($str)
{
    $r = @json_encode($str);
    if (strlen($r) > 2) {
        $r = substr($r, 1, -1);
    } else {
        $r = "";
    }
    return $r;
}
/*--------------------规则判定------------------------*/
function checkgz($zydhc)
{
    global $uri;

    $xxz = 0;
    if ($zydhc != "*") {
        if ((substr($zydhc, 0, 1) != "[") && (substr($zydhc, 0, 2) != "![") && ($zydhc!="")) {
            $hczz = explode('|', $zydhc);
            for ($i = 0; $i < count($hczz); $i++) {
                $xhczz = $hczz[$i];
                if (substr($xhczz, 0, 1) == "!") {
                    $xxz   = 1;
                    $xhczz = substr($xhczz, 1);
                } else {
                    $xxz = 0;
                }
                if (strtolower($xhczz) == strtolower(end(explode('.', end(explode('/', $uri)))))) {
                    if (substr($hczz[$i], 0, 1) == "!") {
                        $xxz = 0;
                        return $xxz;
                    } else {
                        $xxz = 1;
                        return $xxz;
                    }
                }
            }
        } else {
			
            if (pre_pbpage($zydhc)) {
                $xxz = 1;
            } else {
                $xxz = 0;
            }
        }
    } else {
        $xxz = 1;
    }
    return $xxz;
}
/*--------------------消除注释------------------------*/
function compress_all($results,$fmime){


    if ($fmime == "text/html") {
	
		$style=@cleandz("/<style(.*?)>(.*?)<\/style>/is", $results , 1, 0,1);
		$sy0=array();
		$sy1=array();
		for($i=0;$i<count($style);$i++){
		$sy0[]=$style[$i];
		$sy1[]="【：style".$i."：】";
		}
		$results=str_replace($sy0,$sy1,$results);

		$script=@cleandz("/<script(.*?)>(.*?)<\/script>/is", $results , 1, 0,1);
		$st0=array();
		$st1=array();
		for($i=0;$i<count($script);$i++){
		$st0[]=$script[$i];
		$st1[]="【：script".$i."：】";
		}
		$results=str_replace($st0,$st1,$results);	
	
        $results = compress_html($results);
		for($i=0;$i<count($sy0);$i++){
			$sy0[$i] = compress_css($sy0[$i]);
		}		
		for($i=0;$i<count($st0);$i++){
			$st0[$i] = compress_js($st0[$i]);
		}		
			//die(($results));
		$results=str_replace($st1,$st0,$results);		
		$results=str_replace($sy1,$sy0,$results);		
    }
    if ($fmime == "text/css") {
        $results = compress_css($results);
    }
    if (in_array($fmime ,array("application/x-javascript","application/javascript"))) {
        $results = compress_js($results);
		/*require_once(LIB."/JavaScriptPacker.php");
		$packer = new JavaScriptPacker($results, 'Normal', true, false);  
		$results = $packer->pack();*/  		
    }


	return $results;	
}
function compress_html($string)
{

    $string  = str_replace("\r\n", '', $string); //清除换行符
    $string  = str_replace("\n", '', $string); //清除换行符
    $string  = str_replace("\t", '', $string); //清除制表符
    $pattern = array(
        "/> *([^ ]*) *</", //去掉注释标记
        "/[\s]+/",
        "/<!--[\\w\\W\r\\n]*?-->/",
        "/\" /",
        "/ \"/",
        "'/\*[^*]*\*/'"
    );
    $replace = array(
        ">\\1<",
        " ",
        "",
        "\"",
        "\"",
        ""
    );
    return preg_replace($pattern, $replace, $string);
}
function compress_css($buffer)
{
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		//$buffer = preg_replace('/(\/{2,}.*?(\r|\n))|(\/\*(\n|.)*?\*\/)/', '', $buffer);		
	if(substr($buffer,0,2)=="//"){
		$b1=explode("\n",$buffer);
		if(count($b1)>1){
			$buffer = substr($buffer ,strlen($b1[0]));
		}
	}
    /* remove tabs, spaces, newlines, etc. */
    $buffer = str_replace(array(
        "\r\n",
        "\r",
        "\n",
        "\t",
        '  ',
        '    ',
        '    '
    ), '', $buffer);
    return $buffer;
}
function compress_js($results){
		$results = str_replace("*/*", '【**？？】', $results);	
		$results = str_replace("\\/*", '【*？？】', $results);	
		$results = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $results);	
		//$results = preg_replace('/(\/{2,}.*?(\r|\n))|(\/\*(\n|.)*?\*\/)/', '', $results);			
		/*$results = str_replace("http://", '【：？？】', $results);	
		$results = str_replace("https://", '【s：？？】', $results);	
		$results = str_replace("\\//", '【/：？？】', $results);	
		$results = str_replace("\"//", '【"：？？】', $results);		
		$results = str_replace("'//", '【\'：？？】', $results);		
		$results = str_replace("(//", '【(：？？】', $results);*/				
		//$results = preg_replace('/\/\/(.*?)\n/is', PHP_EOL, $results);	
		$results = str_replace("	", '', $results);
		while(strstr($results, "  ")){
			$results = str_replace("  ", " ", $results);	
		}		
		/*$results = str_replace('【：？？】', "http://", $results);	
		$results = str_replace( '【s：？？】',"https://", $results);	
		$results = str_replace( '【/：？？】',"\\//", $results);		
		$results = str_replace( '【"：？？】',"\"//", $results);			
		$results = str_replace( '【\'：？？】',"'//", $results);		
		$results = str_replace( '【(：？？】',"(//", $results);*/	
		$results = str_replace( '【*？？】',"\\/*", $results);	
		$results = str_replace( '【**？？】',"*/*", $results);			
		$results= str_replace(PHP_EOL,"\n", $results);	
		$results= str_replace("\r\n","\n", $results);			
		$results= str_replace("\r","\n", $results);	
		$results= str_replace("\n ","\n", $results);	
		$results= str_replace(" \n","\n", $results);			
		/*if(substr($results,0,strlen(PHP_EOL))==PHP_EOL){
			$results=substr($results,strlen(PHP_EOL));
		}*/
		if(substr($results,0,1)=="\n"){
			$results=substr($results,1);
		}			
		while(strstr($results, "\n"."\n")){
			$results = str_replace("\n"."\n", "\n", $results);	
		}
		return $results;
}
/*--------------------中文翻译------------------------*/
function zwfy($results)
{
    global $fykg, $fybmd, $fmime, $fylx, $charset, $fyyz;
	if(@$fmime){
		$ttf=@explode("/",@$fmime);
		if(in_array(@$ttf[0],array("image","video","audio"))||$fmime=="application/octet-stream"){
			return $results;
		}
	}
    if ($fykg == "true") {
        if (checkgz($fybmd) && $fyyz) {
		
            if (in_array($fmime, explode(",", $fylx))) {
			
			//die($results);
				if ($charset != "utf-8") {
				//die($charset);
					$results = @encode_iconv($charset, "utf-8", $results,$fmime);
					header("Content-type: $fmime; charset=utf-8");	
					
				}	
//die($results);
				$uu=array(
				"\\u0008"=>"|u0008",
				"\\u0009"=>"|u0009",
				"\\u000a"=>"|u000a",
				"\\u000b"=>"|u000b",
				"\\u000c"=>"|u000c",
				"\\u000d"=>"|u000d",
				"\\u0020"=>"|u0020",
				"\\u0022"=>"|u0022",
				"\\u0027"=>"|u0027",
				"\\u005c"=>"|u005c",
				"\\u00a0"=>"|u00a0",
				"\\u2028"=>"|u2028",
				"\\u2029"=>"|u2029",
				"\\ufeff"=>"|ufeff"
				);
				$tt=array(
				"|u0008"=>"\\u0008",
				"|u0009"=>"\\u0009",
				"|u000a"=>"\\u000a",
				"|u000b"=>"\\u000b",
				"|u000c"=>"\\u000c",
				"|u000d"=>"\\u000d",
				"|u0020"=>"\\u0020",
				"|u0022"=>"\\u0022",
				"|u0027"=>"\\u0027",
				"|u005c"=>"\\u005c",
				"|u00a0"=>"\\u00a0",
				"|u2028"=>"\\u2028",
				"|u2029"=>"\\u2029",
				"|ufeff"=>"\\ufeff"
				);
				
				$results=strtr($results,$uu);
				$fywb=preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", str_replace("\\\\u", "\$ZYF$/u", $results));
				
				if($fyyz=="simc"||$fyyz=="trac"){
					require_once(LIB . "/big5_gb2312.php");			
					$bgc = new Trans();
					switch ($fyyz){
						case "simc":
							$results=$bgc->t2c($fywb);
						break;
						case "trac":
							$results=$bgc->c2t($fywb);
						break;					
					}
				}else{
					require_once(LIB . "/translate.php");
					$tbd = new BaiduTranslator();
					$results = $tbd->textbdfy($fywb, $fyyz, "zh", "utf-8", $fmime);
				}
				$results = str_replace("\$ZYF$/u", "\\\\u", $results);
				/*if ($charset != "utf-8") {
					$results = @encode_iconv("utf-8", $charset, $results);				
					header("Content-type: $fmime; charset=$charset");
				}*/
				$results=strtr($results,$tt);
            }
        }
    }
    return $results;
}
/*--------------------DOM处理------------------------*/
function html_dom_replace(&$body, $config)
{
//die($dom_charset);
	global $pcharset;
	//die($dom_charset);
//die("ss");
	require_once(LIB."/simple_html_dom.php");
    $html = str_get_html($body);
    foreach ($config as $item) {
        $indexs      = explode('|', $item['dom']);
        $item['dom'] = array_shift($indexs);
		$item['replace']=@encode_iconv("utf-8", $pcharset, $item['replace']);
		$item['find']=@encode_iconv("utf-8", $pcharset, $item['find']);		
        $elements    = $html->find($item['dom']);
        if (empty($elements))
            continue;
        foreach ($elements as $i => $element) {
            if (!empty($indexs))
                if (!in_array($i, $indexs))
                    continue;
            switch ($item['do']) {

                case 1:
                    $element->innertext = $item['replace'] . $element->innertext;
                    break;
                case 2:
                    $element->innertext .= $item['replace'];
                    break;
                case 3:
                    $element->outertext = $item['replace'];
                    break;					
                default:

                    if (empty($item['find'])) {
                        $element->innertext = $item['replace'];
                    } else {
                        $element->innertext = delstr($item['find'], $item['replace'] ,$element->innertext,1);
										//die($element->innertext );
                    }
                    break;
            }
        }
    }
    $body = (string) $html;
    $html->clear();
    unset($html);
    return $body;
}
/*--------------------统计代码------------------------*/
function pagesum($results){
	global $sjkg,$tjdm,$tjbmd,$fmime;
	if(($sjkg == "true") && checkgz($tjbmd) &&$tjdm&&$results&&$fmime=="text/html"){
		$results=strtr($results,array("</body>"=>$tjdm."</body>"));
	}
	return $results;
}
/*--------------------IP判断------------------------*/
function ippd($ipgz){
		if($ipgz=="*"){return true;}
		$ips_check=false;
        if ((substr($ipgz, 0, 1) == "[") || (substr($ipgz, 0, 2) == "![")) {
            if ((substr($ipgz, 0, 2) == "![")) {
                $ipszz = json_decode(substr($ipgz, 1), 1);
            } else {
                $ipszz = json_decode($ipgz, 1);
            }
            for ($z = 0; $z < count($ipszz); $z++) {
                if ((substr($ipgz, 0, 1) == "[")) {
                    if ((getClientIp() == $ipszz[$z]) || (cleandz($ipszz[$z], getClientIp(), 1, 1) == getClientIp())) {
                        $ips_check = true;
                    }
                } else {
                    if (($ipszz[$z] != getClientIp()) && (cleandz($ipszz[$z], getClientIp(), 1, 1) != getClientIp())) {
                        $ips_check = true;
                    } else {
                        $ips_check = false;
                        break;
                    }
                }
            }
        } else {
            if ((substr($ipgz, 0, 1) == "!")) {
                $ipszz = substr($ipgz, 1);
            } else {
                $ipszz = $ipgz;
            }
            if ((substr($ipgz, 0, 1) == "!")) {
                if (($ipszz != getClientIp()) && (cleandz($ipszz, getClientIp(), 1, 1) != getClientIp())) {
                    $ips_check = true;
                }
            } else {
                if ((getClientIp() == $ipszz) || (cleandz($ipszz, getClientIp(), 1, 1) == getClientIp())) {
                    $ips_check = true;
                }
            }
        }
		//die(var_dump($ips_check));
		return $ips_check ;
}
function pre_ippd($ipgz){
	$xx=explode("||",$ipgz);
	//die(var_dump($xx));
	for($i=0;$i<count($xx);$i++){
		if(!ippd($xx[$i])){
			return false;
		}
	}
	return true;
}
/*--------------------伪原创------------------------*/
function wyc($results,$charset){
	if(!ereg('['.chr(0xa1).'-'.chr(0xff).']', $results)){return $results;}
	global $fmime;
	$sf=@explode("/",@$fmime);
	if($sf[0]=="text"||in_array($fmime,array("application/javascript","application/json","application/x-javascript"))){
		require_once(LIB."/sameword.php");
		$r= new sameword;
		$results =$r->wyc($results,EXT."/sameword.txt",$charset);	
	}
	return $results;
}
/*--------------------输出页面前处理------------------------*/
function page_preout($results){

	global $wyc,$pcharset,$xczs,$fmime,$fyjt,$fykg,$ymys,$url;
	/*--------------------wyc------------------------*/
	if ($wyc == "true") {
		//header("Content-type: text/html; charset=utf-8");
		//$results="强力推荐正在观看";
		$results=wyc($results,$pcharset);
		//die($results);
	}
	/*--------------------wyc------------------------*/		
	/*--------------------compress------------------------*/
	if ($xczs == "true") {
		$results=compress_all($results,$fmime);
	}
	/*--------------------compress------------------------*/
	/*--------------------zwfy------------------------*/
	if(($fyjt=="true")&&($fykg=="true")){
		$results = zwfy($results);
	}
	/*--------------------zwfy------------------------*/
	/*--------------------pagesum------------------------*/
	$results = pagesum($results);
	/*--------------------pagesum------------------------*/
	/*--------------------write_cache------------------------*/
	write_cache($results,$url);
	/*--------------------write_cache------------------------*/
	/*--------------------zwfy------------------------*/
	if(($fyjt!="true")&&($fykg=="true")){
		$results = zwfy($results);
	}
	/*--------------------zwfy------------------------*/
	return $results;
}
?>
<?php
error_reporting(0);
//error_reporting(E_ALL);
function verify()
{
    require("config.php");
    
    
    if (($user != $_COOKIE["copycat_user"]) || (md5($password)) != $_COOKIE["copycat_passwd"]) {
        return false;
    } else {
        return $user;
    }
}
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
function readsite()
{
    if (!verify()) {
        die();
    }
    $r = @file_get_contents("config/site.json");
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
				$px = cleandz(strtolower($ep[0]), $_SERVER["HTTP_HOST"], 1, 1, 1);
				if (strlen($px)) {
					$p = $px;
				}else{
					$p = $ep[0];
				}
				if (strtolower($p) == strtolower($_SERVER["HTTP_HOST"])&&$iprz) {
					return base64_decode($r[$i]["contents"]);
				}
		}	
    }
}
function readx($path, $zs)
{
    $file = fopen($path, "r");
    return (fread($file, $zs));
    fclose($file);
}
function getfile($folder, $kzm, $zs)
{
    $style = opendir($folder);
    $files = array();
    while ($stylesheet = readdir($style)) {
        if (strtolower(pathinfo($stylesheet, PATHINFO_EXTENSION)) == $kzm) {
            if ($zs) {
                /*$files[count($files)] = array(
                    urldecode(basename($stylesheet, ".$kzm")),
                    htmlspecialchars(readx("pages/" . basename($stylesheet, "." . $kzm) . "." . $kzm, $zs)),
                    "" . date("Y-m-d", filemtime($folder . "/" . $stylesheet))
                );*/
				$files[$stylesheet] = filemtime($folder . "/" . $stylesheet); 
            } else {
                $files[count($files)] = urldecode(basename($stylesheet, ".$kzm"));
            }
        }
    }
	 if ($zs) {
		arsort($files);	
		$rfiles=array();
		for($i=0;$i<count($files);$i++) {
			$thisFile = each($files); 
			$rfiles[count($rfiles)] = array(
                    urldecode(basename($thisFile[0], ".$kzm")),
                    htmlspecialchars(readx("pages/" . basename($thisFile[0], "." . $kzm) . "." . $kzm, $zs)),
                    "" . date("Y-m-d", $thisFile[1])
                );
		}
		$files=$rfiles;
	 }else{
		sort($files);	
	 }
    return $files;
}
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
if (@$_REQUEST["verify"]) {
    require("config.php");
    $salt = md5(time());
    die(json_encode(array(
        "user" => $user,
        "passwd" => md5($salt . md5($password) . $salt),
        "salt" => $salt
    )));
}
@mkdir("config");
@mkdir("settings");
if (!@$_REQUEST["site"]) {
    $ml = readsite() . "/";
}
switch (@$_REQUEST["op"]) {
    case "readsite":
        die(readsite());
        break;
    case "uploadfile":
        if (($_FILES["ufile"]["tmp_name"]) && (!$_FILES["ufile"]["error"])) {
            $fux = explode("/", $_FILES["ufile"]["type"]);
            if ($fux[0] != "text") {
                $data       = json_encode(array(
                    "type" => "data",
                    "mime" => $_FILES["ufile"]["type"],
                    "name" => $_FILES["ufile"]["name"],
                    "size" => $_FILES["ufile"]["size"]
                ));
                $upfiledata = "pages/" . ((file_exists("pages/" . urlencode($_FILES["ufile"]["name"]) . ".xkz")) ? (time() . "_") : ("")) . urlencode($_FILES["ufile"]["name"]) . ".dat";
                copy($_FILES["ufile"]["tmp_name"], $upfiledata);
            } else {
                $data = (file_get_contents($_FILES["ufile"]["tmp_name"]));
            }
            $file = "pages/" . ((file_exists("pages/" . urlencode($_FILES["ufile"]["name"]) . ".xkz")) ? (time() . "_") : ("")) . urlencode($_FILES["ufile"]["name"]) . ".xkz";
            @file_put_contents($file, $data);
        }
        die(header("Location:index.html#articles"));
        break;
    case "load":
        if ($_REQUEST["config"]) {
            $ml = $_REQUEST["config"] . "/";
        }		
        die(@file_get_contents("config/" . $ml . urlencode($_REQUEST["name"]) . ".json"));
        break;
    case "save":
        if (!$_REQUEST["site"]) {
			if ($_REQUEST["config"]) {
				$ml = $_REQUEST["config"] . "/";
				@mkdir("config/" . $ml);
			}else{
				if(readsite()){
					@mkdir("config/" . readsite());
				}				
			}		
        }
        $r = @file_put_contents("config/" . $ml . urlencode($_REQUEST["name"]) . ".json", base64_decode($_REQUEST["json"]));
        die("{\"result\": $r}");
        break;
    case "settings":
        die(@json_encode(getfile("settings", "json")));
        break;
    case "pages":
        die(@json_encode(getfile("pages", "xkz", $_REQUEST["zs"])));
        break;
    case "loadconfig":
        die(@file_get_contents("settings/" . urlencode($_REQUEST["name"]) . ".json"));
        break;
    case "delfycache":
        if ($_REQUEST["set"]) {
			if ($_REQUEST["config"]) {
				$ml = $_REQUEST["config"] . "/";
			}			
            $r = scandir("config/" . $ml . "fy_cache");
            $s = $f = 0;
            foreach ($r as $value) {
                if (substr($value, 0, strlen($_REQUEST["set"])) == $_REQUEST["set"]) {
                    @unlink("config/" . $ml . "fy_cache/" . $value);
                    if (!file_exists("config/" . $ml . "fy_cache/" . $value)) {
                        $s += 1;
                    } else {
                        $f += 1;
                    }
                }
            }
            die($s . "个文件成功被删除，" . $f . "个文件删除失败！");
        } else {
            die("没文件被删除！");
        }
        break;
    case "cleancache":
        if ($_REQUEST["config"]) {
            $ml = $_REQUEST["config"] . "/";
        }
        if ($_REQUEST["isfy"]) {
            $cml = "fy_cache";
        } else {
            $cml = "cache";
        }
        $d=(@destroyDir("config/" . $ml . $cml));
		if(!$_REQUEST["isfy"]){
				if(is_dir("config/" . $ml  . "git_cache")){
					@copy_dir("config/" . $ml  . "git_cache","config/" . $ml  . "cache");
				}
		}
		die($d);
        break;
    case "loadhtaccess":
        die(file_get_contents("../.htaccess"));
        break;
    case "loadqjcookie":
        if ($_REQUEST["config"]) {
            $qz = "file_";
        } else {
            $qz = "curl_";
        }
        die(file_get_contents("config/" . $ml . $qz . "cookie"));
        break;
    case "saveqjcookie":
        if ($_REQUEST["config"]) {
            $qz = "file_";
        } else {
            $qz = "curl_";
        }
        die(file_put_contents("config/" . $ml . $qz . "cookie", $_REQUEST["data"]));
        break;
    case "savehtaccess":
        die(file_put_contents("../.htaccess", $_REQUEST["data"]));
        break;
    case "backhtaccess":
        $kk = str_replace("\\", "/", @file_get_contents(((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http')) . '://' . $_SERVER['HTTP_HOST'] . dirname(str_replace("\\", "/", dirname($_SERVER['REQUEST_URI'] . "*"))) . "/copycatdeal?op=loadroot"));
        $cc = str_replace("{dir}", ((!$kk) ? ("/") : ($kk)), base64_decode("UmV3cml0ZUVuZ2luZSBPbgpSZXdyaXRlQmFzZSB7ZGlyfQpSZXdyaXRlQ29uZCAle1NDUklQVF9GSUxFTkFNRX0gIS1mClJld3JpdGVDb25kICV7U0NSSVBUX0ZJTEVOQU1FfSAhLWQKUmV3cml0ZVJ1bGUgXiguKikkIGluZGV4LnBocC8kMQpSZXdyaXRlUnVsZSAuaW5kZXgkIC4vIFtSLE5DLExdCk9wdGlvbnMgQWxsIC1JbmRleGVzCk9yZGVyIEFsbG93LERlbnkgIApBbGxvdyBmcm9tIGFsbAo="));
        die($cc);
        break;
    case "loaduser":
        include("config.php");
        die(@json_encode(array(
            "user" => $user,
            "passwd" => $password
        )));
        break;
    case "saveuser":
        $cc = '<?php
$user="' . $_REQUEST["user"] . '";
$password="' . $_REQUEST["passwd"] . '";
?>';
        die(file_put_contents("config.php", $cc));
        break;
    case "saveconfig":
        if ($_REQUEST["type"] == "1") {
            if (readsite() && !@$_REQUEST["site"]) {
                @mkdir("config/" . readsite());
            }
            $r = @file_put_contents("config/" . $ml . "settings.json", '{"file":"' . $_REQUEST["name"] . '"}');
        }
        $r = @file_put_contents("settings/" . urlencode($_REQUEST["name"]) . ".json", base64_decode($_REQUEST["json"]));
        die("{\"result\": $r}");
        break;
    case "delpage":
        @unlink("pages/" . urlencode($_REQUEST["name"]) . ".dat");
        $r = @unlink("pages/" . urlencode($_REQUEST["name"]) . ".xkz");
        die($r);
        break;
    case "delconfig":
        $r = @unlink("settings/" . urlencode($_REQUEST["name"]) . ".json");
        die($r);
        break;
    case "editor":
        die('<style>html,input,textarea{font-family: Microsoft YaHei;}</style><form action="index.php" target="_parent" method="post"><input type="hidden" name="op" value="savepage"><b>模板名称</b><br><input type="hidden" name="ybname" value="' . $_REQUEST["name"] . '"><input style="width:100%;border-radius: 5px;border: 1px solid;" name="name" value="' . $_REQUEST["name"] . '"><br><b>模板内容</b>&nbsp;<a href="javascript:void(0);" onclick="if(this.innerHTML==\'编辑\'){document.getElementById(\'aifm\').style.display=\'none\';document.getElementById(\'atext\').style.display=\'block\';this.innerHTML=\'查看\'}else{document.getElementById(\'aifm\').style.display=\'block\';document.getElementById(\'atext\').style.display=\'none\';this.innerHTML=\'编辑\'}" style="color:grey" >编辑</a>&nbsp;<a href="javascript:void(0);" onclick="var xt=window.location.href.split(\'index.php?op=\')[0].split(\'\/\').length;var link=window.location.href.split(\'index.php?op=\')[0].split(\'\/\',xt-2).toString().replace(/\,/ig,\'/\')+\'/copycatdeal?link=' . base64_encode(urlencode($_REQUEST["name"])) . '\';if(prompt(\'外链路径:\',link)){window.open(link,\'_blank\');}" style="color:grey" target="_blank">外链</a><br><iframe id="aifm" src="../copycatdeal?plain=1&link=' . base64_encode(urlencode($_REQUEST["name"])) . '" style="position:absolute;" width="100%" height="320px" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="auto" allowtransparency="yes"></iframe><div  id="atext" style="display:none;"><textarea style="width:100%;height:288px;border-radius: 5px;border: 1px solid;" name="data">' . htmlspecialchars(file_get_contents("pages/" . urlencode($_REQUEST["name"]) . ".xkz")) . '</textarea><br><input style="width:100%;height:40px" type="submit" value="保存"></div></form>');
        break;
    case "savepage":
        if ($_REQUEST["name"] != $_REQUEST["ybname"]) {
            @unlink("pages/" . urlencode($_REQUEST["name"]) . ".dat");
            @copy("pages/" . urlencode($_REQUEST["ybname"]) . ".dat", "pages/" . urlencode($_REQUEST["name"]) . ".dat");
        }
        @file_put_contents("pages/" . urlencode($_REQUEST["name"]) . ".xkz", $_REQUEST["data"]);
        die(header("Location:index.html#articles"));
        break;
    case "fastverify":
        die(verify());
        break;
    case "realpath":
        die(realpath($_REQUEST["name"]));
        break;
    case "getzy":
        die(json_encode($_REQUEST["str"]));
        break;
    case "wycpath":
		die("?op=edit&fename=sameword.txt&folder=".realpath("./resources/ext/")."/");
        break;	
    case "cachepath":
        if ($_REQUEST["config"]) {
            $ml = $_REQUEST["config"] . "/";
        }
        $r = str_replace("\\", "/", @realpath("config/" . $ml));
        if (!$_REQUEST["isconfig"]) {
            if ($_REQUEST["isfy"]) {
                $cml = "fy_cache";
            } else {
                $cml = "cache";
            }
            if (file_exists($r . "/" . $cml)) {
                $r = $r . "/" . $cml;
            }
        }
        die($r);
        break;
    case "readadminpath":
        die(end(explode("/", dirname($_SERVER['REQUEST_URI'] . "*"))));
        break;
    case "changeadminpath":
        $yad = end(explode("/", dirname($_SERVER['REQUEST_URI'] . "*")));
        $nad = @$_REQUEST["nad"];
        if (urlencode($nad)) {
            $r = rename("../" . $yad, "../" . urlencode($nad));
            if ($r) {
                @file_put_contents("../.index", base64_encode(urlencode($nad)));
                die(urlencode($nad));
            } else {
                die($yad);
            }
        } else {
            die($yad);
        }
        break;
    default:
        header("Location: login.html");
        return false;
}
?>
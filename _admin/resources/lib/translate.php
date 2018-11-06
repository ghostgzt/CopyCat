<?php
error_reporting(0);
class BaiduTranslator
{
    function iszh($str)
    {
        if (!eregi("[^\x80-\xff]", "$str")) {
            return true;
        } else {
            return false;
        }
    }
    function my_sort($a, $b)
    {
        if ($a[0] == $b[0])
            return 0;
        return (strlen($a[0]) > strlen($b[0])) ? -1 : 1;
    }
    function dw_sort($a, $b)
    {
        if ($a == $b)
            return 0;
        return (strlen($a) > strlen($b)) ? -1 : 1;
    }
    function encode_iconv($sencoding, $tencoding, $str)
    {
        if (function_exists("mb_convert_encoding")) {
            $str = mb_convert_encoding($str, $tencoding, $sencoding);
        } else {
            $str = iconv($sencoding, $tencoding . "//TRANSLIT//IGNORE", $str);
        }
        return $str;
    }
    function convToUtf8($str)
    {
        if (mb_detect_encoding($str, "UTF-8, ISO-8859-1, GBK , GB2312") != "UTF-8") { //判断是否不是UTF-8编码，如果不是UTF-8编码，则转换为UTF-8编码
            return $this->encode_iconv("gbk", "utf-8", $str);
        } else {
            return $str;
        }
    }
    function mbstringtoarray($str, $size, $charset)
    {
        $strlen = mb_strlen($str,$charset);
        while ($strlen) {
            $array[] = mb_substr($str, 0, $size, $charset);
            $str     = mb_substr($str, $size, $strlen, $charset);
            $strlen  = mb_strlen($str,$charset);
        }
        return @$array;
    }
    function Post($url, $post = null)
    {
        $context = array();
        
        if (is_array($post)) {
            ksort($post);
            
            $context['http'] = array(
                'timeout' => 60,
                'method' => 'POST',
                'content' => http_build_query($post, '', '&')
            );
        }
        return file_get_contents($url, false, stream_context_create($context));
    }
    function dcbdfy($str, $to = "en", $form = "zh", $charset = "utf-8", $zq = 0)
    {
        $str = str_replace("|", "｜", $str);
		 $str = strtr($str,array("\r\n"=>PHP_EOL,"\n"=>PHP_EOL));
        $str = str_replace(PHP_EOL, "||", $str);
        if ($charset == "utf-8") {
			if($to=="wyw"){
				$z = 500;
			}else{
				$z = 2000;//((strlen("\n")-1)*substr_count($str,"||"))
			}
            
        } else {
			if($to=="wyw"){
				$z = 750;
			}else{
				$z = 3000;//((strlen("\n")-1)*substr_count($str,"||"))
			}
        }
        $r = $this->mbstringtoarray($str, $z, $charset);
        $s = "";
        $k = array();
        for ($i = 0; $i < count($r); $i++) {
            if (substr($r[$i], 0, 2) == "||") {
                $s     = "\n" . $s;
                $r[$i] = substr($r[$i], 2);
            }
            if (substr($r[$i], 0, 1) == "|") {
                $r[$i] = substr($r[$i], 1);
            }
            $r[$i] = str_replace("||", "|", $r[$i]);
            $r[$i] = str_replace("|", "\n" . "\n", $r[$i]);
            $r[$i] = str_replace("｜", "|", $r[$i]);
			$dr=$r[$i];
			if (substr($dr, -strlen("\n"."\n")) == "\n"."\n") {
                $dr = substr($dr,0, -strlen("\n"."\n"))."\n";
            }			
			/*if (substr($dr, -strlen("\n")) == "\n") {
                $dr = substr($dr,0, -strlen("\n"));
            }*/

                $data = array(
                    'from' => $form,
                    'to' => $to,
                    'query' => $dr ,
                    'transtype' => 'realtime'
                );
                $ktra = json_decode($this->Post('http://fanyi.baidu.com/v2transapi', $data), 1);
                $ktr  = $ktra["trans_result"]["data"];

            
            if ($zq) {
                for ($x = 0; $x < count($ktr); $x++) {
                    $a        = count($k);
                    $k[$a][0] = strtr($ktr[$x]["src"], array(
                        " " => "&nbsp;"
                    ));
                    $k[$a][1] = strtr($ktr[$x]["dst"], array(
                        "\n" => " ",
                        "\n" => " ",
                        "\"" => "“",
                        "'" => "`",
                        "\\" => "＼",
                        "<" => "＜",
                        ">" => "＞"
                    ));
                }
            } else {
                for ($x = 0; $x < count($ktr); $x++) {
                    
                    $s .= strtr($ktr[$x]["dst"], array(
                        PHP_EOL => " ",
                        "\n" => " "
                    ));
                    
                    if ($x != (count($ktr) - 1)) {
                        $s .= "\n";
                    }
                }
                if (substr($r[$i], -strlen("\n")) == "\n") {
                    $s .= "\n";
                }
                
            }
        }
        if ($zq) {
            return $k;
        } else {
            return str_replace("\n",PHP_EOL,$s);
        }
    }
    function zhgetlist($str)
    {
        $r = $str;
        $r = strtr($r, array(
            "&nbsp;" => "　",
            PHP_EOL => " ",
            "\r\n" => " ",
            "\n" => " "
        ));
        $r = "|" . preg_replace("/([[:alnum:]]|[[:space:]]|[[:punct:]])+/U", "|", $r) . "|";
        while (strstr($r, "|　") || strstr($r, "　|") || strstr($r, "||")) {
            $r = str_replace(array(
                "|　",
                "　|",
                "||"
            ), "|", $r);
            $r = str_replace("||", "|", $r);
        }
        $r = str_replace(array(
            "|微软雅黑|",
            "|黑体|",
            "|宋体|",
            "|　|"
        ), "|", $r);
        if (substr($r, -1) == "|") {
            $r = substr($r, 0, -1);
        }
        if (substr($r, 0, 1) == "|") {
            $r = substr($r, 1);
        }
        $r = strtr($r, array(
            "　" => "&nbsp;"
        ));
        $k = explode("|", $r);
        $k = array_unique($k);
        usort($k, array(
            "BaiduTranslator",
            "dw_sort"
        ));
        return $k;
    }
    function multbdfy($list = array(), $to = "en", $form = "zh", $charset = "utf-8")
    {
            @mkdir(ADIR . "/fy_cache");
            if (!function_exists("gzdecode")) {
                require_once(LIB . "/gzdecode.php");
            }			
			$p=ADIR . "/fy_cache/" . $to . "_" . $form . "_" . $charset . "_" . md5(join("",$list)) . ".cac";
            if (file_exists($p)) {
                $r = json_decode(@gzdecode(@file_get_contents($p)), 1);
            } else {	
				$r = $this->dcbdfy(strtr(join(PHP_EOL, $list), array("&nbsp;" => "　")), $to, $form, $charset, 1);
				if ($r) {
                    @file_put_contents($p, @gzencode(json_encode($r)));
                }
			}
        return $r;
        /*
        $k=array();
        $r=(explode(PHP_EOL,$this->dcbdfy(strtr(join(PHP_EOL,$list),array("&nbsp;"=>"　")),$to,$form,$charset)));
        for($i=0;$i<count($list);$i++){
        $s=count($k);
        $k[$s][0]=$list[$i];
        $k[$s][1]=$r[$i];
        }
        return $k;
        */
    }
    function zqbdfy($list = array(), $to = "en", $form = "zh", $charset = "utf-8")
    {
        $k = array();
        for ($i = 0; $i < count($list); $i++) {
            if ($list[$i]) {
                $s        = count($k);
                $k[$s][0] = $list[$i];
                $k[$s][1] = $this->dcbdfy(strtr($list[$i], array(
                    "&nbsp;" => " "
                )), $to, $form, $charset);
            }
        }
        return $k;
    }
    function arrreplace($arr, $from, $to)
    {
        if (is_array($arr)) {
            $arr1 = array();
            foreach ($arr as $key => $value) {
                $key        = str_replace($from, $to, $key);
                $arr1[$key] = $this->arrreplace($value, $from, $to);
            }
        } else {
            $arr1 = str_replace($from, $to, $arr);
        }
        return $arr1;
    }
    function textbdfy($txt_str, $to = "en", $form = "zh", $charset = "utf-8", $mime = "text/html")
    {
        $r = $txt_str;
        $z = $this->multbdfy($this->zhgetlist($txt_str), $to, $form, $charset);
        for ($i = 0; $i < count($z); $i++) {
			if(!in_array($to,array("zh","wyw","kor","yue","jp"))){
				$z[$i][1]=" ".$z[$i][1]." ";
			}
			global $fmime;
			if(in_array($fmime,array("application/x-javascript","application/javascript","application/json"))){$z[$i][1]=substr(json_encode($z[$i][1]),1,-1);}
            $r = str_replace($z[$i][0], $z[$i][1], $r);
        }
        return $r;
    }
    function jsonbdfy($json_str, $to = "en", $form = "zh", $charset = "utf-8")
    {
        if (substr($json_str, 0, strlen("jQuery")) == "jQuery") {
            @preg_match_all("/jQuery(.*?)\(/is", $json_str, $match);
            $jq       = $match[0][0];
            $json_str = substr(strstr($json_str, "("), 1);
            $json_str = substr($json_str, 0, -2);
        }
        $y = json_decode($json_str, 1);
        
        $z  = $this->multbdfy($this->zhgetlist(serialize($y)), $to, $form, $charset);
        $k0 = array();
        $k1 = array();
        for ($i = 0; $i < count($z); $i++) {
            $k0[count($k0)] = $z[$i][0];
            $k1[count($k1)] = $z[$i][1];
        }
        $r = json_encode($this->arrreplace($y, $k0, $k1), JSON_FORCE_OBJECT);
        if ($jq) {
            $r = $jq . $r . ");";
        }
        return $r;
    }
}
?>
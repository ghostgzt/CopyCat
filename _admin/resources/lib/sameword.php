<?php
class sameword
{
	function wyc($str=null,$rulefile,$charset="utf-8"){
		if(!$str){return false;}
		$uf=(cleandz("#\\\u([0-9a-f]{4})#ie",$str,1,1,1));
		$file=file_get_contents($rulefile);
		$file=str_replace("\r\n","\n",$file);
		$file=explode("\n",$file);
		$a=array();
		$b=array();
		$c=array();
		if($uf){
			$au=array();
			$bu=array();
			$cu=array();		
		}
		for($i=0;$i<count($file);$i++){
			$t=explode("=",$file[$i]);
			if(count($t)==2){
				if(strtolower($charset!="utf-8")){
					$t[0]=encode_iconv("utf-8", $charset, $t[0]);
					$t[1]=encode_iconv("utf-8", $charset, $t[1]);				
				}
				$a[]=$t[0];
				$b[]="【".md5($t[0])."】";
				$c[]=$t[1];
				if($uf){				
					$tt=substr(json_encode($t[0]),1,-1);
					$au[]=$tt;
					$bu[]="【".md5($tt)."】";
					$cu[]=substr(json_encode($t[1]),1,-1);		
				}
			}
		}
		$str=str_replace($a,$b,$str);
		$str=str_replace($c,$a,$str);
		$str=str_replace($b,$c,$str);
		if($uf){		
			$str=str_replace($au,$bu,$str);
			$str=str_replace($cu,$au,$str);
			$str=str_replace($bu,$cu,$str);		
		}
		return $str;
	}
}
?>
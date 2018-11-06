<?php
error_reporting(0);
class Downloader
{
	function downFile($fileName, $fancyName = '',$iswebfile=0,$flag=array(
	'timeout'=>120,
	'agent'=>"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)",
	'proxy'=>"",
	'ppx'=>false,
	'maxrds'=>3,
	'method'=>"GET",
	'head'=>"",
	'data'=>""
	),$contentType = '', $forceDownload = true, $speedLimit = 0 ,$superCache=0) { 
		if($iswebfile){
		if($flag["http"]){
			stream_context_set_default($flag);
		}else{
			stream_context_set_default(
			array(
			'http' => array(
				'method' => @$flag['method'],
				'timeout' => @$flag['timeout'],
				'user_agent' => @$flag['agent'],
				'proxy' => @$flag['proxy'],
				'request_fulluri' => @$flag['ppx'],
				'max_redirects' => @$flag['maxrds'],
				'header' => @$flag['head'],
				'content' => @$flag['data']
			)
			)
			);
			}
			//die(var_dump($flag));
			$preinfo=get_headers($fileName, 1);
			//die(var_dump($preinfo));
			$fileSize = $preinfo['Content-Length'];
			@preg_match_all('/HTTP\/1\.[0|1]\s(.*?)\s/is', $preinfo[0], $match); 
			if ($match[1][0]=="404") {  
				die(header("HTTP/1.1 404 Not Found"));  
			}  	
			if(@$preinfo["ETag"]){
				$etag=$preinfo["ETag"];
				header("ETag: $etag");
			}
			if(@$preinfo["Last-Modified"]){
				$lastModified=$preinfo["Last-Modified"];
				header("Last-Modified:  $lastModified");
			}
			if(@$preinfo["Accept-Ranges"]){
				$AcceptRanges=@$preinfo["Accept-Range"];
				header("Accept-Range:  $AcceptRanges");
			}	
		}else{
			if (!is_readable($fileName)) 
			{ 
				header("HTTP/1.1 404 Not Found"); 
				return false; 
			}
			$fileStat = stat($fileName); 
			$fileSize = $fileStat['size']; 		
			$lastModified = $fileStat['mtime']; 
			$md5 = md5($fileStat['mtime'] .'='. $fileStat['ino'] .'='. $fileStat['size']); 
			$etag = '"' . $md5 . '-' . crc32($md5) . '"'; 
			header('Last-Modified: ' . gmdate("D, d M Y H:i:s", $lastModified) . ' GMT'); 
			header("ETag: $etag"); 
		}
		if($superCache){
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
		if ($fancyName == '') 
		{ 
			$fancyName = basename($fileName); 
		} 
	  
		if ($contentType == '') 
		{ 
			$contentType = 'application/octet-stream'; 
		} 
	  

		$contentLength = $fileSize; 
		//die(var_dump($contentLength));
		$isPartial = false; 
	  
		if (isset($_SERVER['HTTP_RANGE'])) 
		{ 
			if (preg_match('/^bytes=(\d*)-(\d*)$/', $_SERVER['HTTP_RANGE'], $matches)) 
			{ 
				$startPos = $matches[1]; 
				$endPos = $matches[2]; 
	  
				if ($startPos == '' && $endPos == '') 
				{ 
					return false; 
				} 
	  
				if ($startPos == '') 
				{ 
					$startPos = $fileSize - $endPos; 
					$endPos = $fileSize - 1; 
				} 
				else if ($endPos == '') 
				{ 
					$endPos = $fileSize - 1; 
				} 
	  
				$startPos = $startPos < 0 ? 0 : $startPos; 
				$endPos = $endPos > $fileSize - 1 ? $fileSize - 1 : $endPos; 
	  
				$length = $endPos - $startPos + 1; 
	  
				if ($length < 0) 
				{ 
					return false; 
				} 
	  
				$contentLength = $length; 
				$isPartial = true; 
			} 
		} 
	  
		// send headers 
		if ($isPartial) 
		{ 
			header('HTTP/1.1 206 Partial Content'); 
			header("Content-Range: bytes $startPos-$endPos/$fileSize"); 
			$rangz=PHP_EOL."Accept-Ranges: bytes".PHP_EOL."Range: bytes= $startPos-";
		} 
		else 
		{ 
			header("HTTP/1.1 200 OK"); 
			$startPos = 0; 
			$endPos = $contentLength - 1; 
		} 
	  
		header('Pragma: cache'); 
		header('Cache-Control: public, must-revalidate, max-age=0'); 
		header('Accept-Ranges: bytes'); 
		header('Content-type: ' . $contentType); 
		if ($forceDownload) 
		{ 
			header('Content-Length: ' . $contentLength); 
			header('Content-Disposition: attachment; filename="' . rawurlencode($fancyName). '"'); 
		} 
	  
		header("Content-Transfer-Encoding: binary"); 
	  
		$bufferSize = 128; 
	  
		if ($speedLimit != 0) 
		{ 
			$packetTime = floor($bufferSize * 1000000 / $speedLimit); 
		} 
	  
		$bytesSent = 0; 
		
		set_time_limit(0);  
		$url=$fileName;

		//die($url);
		if($iswebfile){
			if(!function_exists("openssl_open")){
				$url = ((strtolower(substr($url, 0, strlen("https"))) == "https") ? ("http" . substr($url, strlen("https"))) : ($url));
			} 			
			if($flag["http"]){
				$options=$flag;
			}else{		
				$options = array(
					'http' => array(
						'timeout' => @$flag['timeout'],
						'user_agent' =>@ $flag['agent'],
						'proxy' => @$flag['proxy'],
						'request_fulluri' => @$flag['ppx'],
						'max_redirects' => @$flag['maxrds'],
						'method' => @$flag['method'],
						'header' => @$flag['head'].$rangz,
						'content' => @$flag['data']
					)
				);
			}	
			//die(var_dump($contentLength));
			if(is_null($contentLength)){
				readfile($url);
				die();
			}
			$fp = fopen($url, "rb",false,stream_context_create($options)); 
		}else{
			$fp = fopen($url, "rb"); 
			fseek($fp, $startPos); 
		}
		while ($bytesSent < $contentLength && !@feof($fp) && connection_status() == 0 ) 
		{ 
			if ($speedLimit != 0) 
			{ 
				list($usec, $sec) = explode(" ", microtime()); 
				$outputTimeStart = ((float)$usec + (float)$sec); 
			} 
	  
			$readBufferSize = $contentLength - $bytesSent < $bufferSize ? $contentLength - $bytesSent : $bufferSize; 
			$buffer = @fread($fp, $readBufferSize); 
	  
			echo $buffer; 
	  
			ob_flush(); 
			flush(); 
	  
			$bytesSent += $readBufferSize; 
	  
			if ($speedLimit != 0) 
			{ 
				list($usec, $sec) = explode(" ", microtime()); 
				$outputTimeEnd = ((float)$usec + (float)$sec); 
	  
				$useTime = ((float) $outputTimeEnd - (float) $outputTimeStart) * 1000000; 
				$sleepTime = round($packetTime - $useTime); 
				if ($sleepTime > 0) 
				{ 
					usleep($sleepTime); 
				} 
			} 
		} 
		return true; 
	} 
}
?>
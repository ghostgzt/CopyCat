<style>
.body{padding:10px;}
</style>
<div class="col w2">
	<div class="content">
		<div class="box header">
			<div class="head">
				<div>
				</div>
			</div>
			<h2>
				规则帮助
			</h2>
			<div class="desc">
				<p style="overflow: auto">
					在自定义页面规则和内容替换规则中使用
					<br>
					可以调用相应模板:
					<br>
					●自定义页面规则(规则前!表示相反意思)
					<br>
					★路径支持(空白" "代表主页)
					<br>
					&nbsp;&nbsp;&lt;HTTPCODE:404|["*.css","*.js"]||!123.css&gt;
					<br>
					&nbsp;&nbsp;字符串
					<br>
					&nbsp;&nbsp;正则规则
					<br>
					&nbsp;&nbsp;通配符 {xxx} 
					<br>					
					&nbsp;&nbsp;*
					<br>					
					&nbsp;&nbsp;["*.css","/f(.*?)$/"]
					<br>
					&nbsp;&nbsp;[""]
					<br>
					&nbsp;["*.css","/f(.*?)$/"]||!123.css 多规则并用 || 为分隔符
					<br>					
					&nbsp;!["127.0.0.0.1","192.168.0.1","175.163.0.1"]||/127.0.0.*/ (IP管理专用)
					<br>					
					★支持规则
					<br>
					{"op":"include","code":"test.html"}					
					<br>
					{"op":"file","code":"test.jpg","mime":"image\/jpg"}
					<br>
					{"op":"php","code":"fff.php","config":"JHh4PSIxMjMiOw=="}
					<br>
					{"op":"location","code":"http://www.google.com/"}
					<br>
					{"op":"curl","code":"http://www.baidu.com/",config="eyJodHRwIjp7InRpbWVvdXQiOjEyMCwidXNlcl9hZ2VudCI6IiIsInByb3h5IjoiIiwicmVxdWVzdF9mdWxsdXJpIjowLCJtYXhfcmVkaXJlY3RzIjowLCJtZXRob2QiOiJHRVQiLCJoZWFkZXIiOiIiLCJjb250ZW50IjoiIn19"}
					<br>
					{"op":"text","code":"1.txt"}
					<br>
					{"op":"header","code":"302","location":"http://www.baidu.com/"}
					<br>
					{"op":"run","code":"ZWNobyAiMTIzIjs=","config":"JHh4PSIxMjMiOw=="}
					<br>
					●内容替换查找和路径查找规则
					<br>
					字符串
					<br>
					["123","456"]
					<br>
					通配符 {xxx}
					<br>
					{"op":"include","code":"test.html"}	
					<br>					
					{"op":"php","code":"fff.php","config":"JG5hbWU9MTIzOw==","replace":false}
					<br>
					{"op":"run","code":"ZWNobyAiMTIzIjs=","config":"JG5hbWU9MTIzOw==","replace":false}
					<br>					
					("replace"中true表得到值做替换项，false为直接输出)					
					<br>
					{"op":"dom","dom":"#wrapper","do":"3","find":""}
					<br>
					(do为0-3,0:dom里正则替换;1:添加在dom前;2:添加在dom后;3:全dom替换)
					<br>
					●内容替换判断规则
					<br>
					路径字符串
					<br>		
					正则表达式
					<br>					
					MIME表达式 {"mime":["application\/javascript"]}
					<br>
					混合表达式 {"mime":["application\/javascript"]}||!/(.*?)\.html/is
					<br>
					●内容替换和路径替换规则
					<br>
					字符串
					<br>
					{input:1.png}
					<br>
					{rand:100-999}
					<br>
					{strrand:5,3}					
					<br>
					{eval:date.code}
					<br>
					{run:ZWNobyAiMTIzIjs=}
					<br>
					{web:http://www.baidu.com/}
					<br>
					{unicode:你好}
					<br>					
					●通配符(转义{xxx,zy} | 简化{xxx,lite} | Base64{xxx,base64})
					<br>
					{adir}{root},{path},{siteuri},{litesiteuri},{site},{litesite},{host},{litehost},{rooturl},{literoot},{litepath},{literooturl},{liteurl},{url},{uri},{results},{$1},{$2}...
					<br>
					正则通配符{xxx,["rule":"\/video\\/av(.*?)[\\.|\\/]$\/is"]}
					<br>
					●run或eval或php支持的变量
					<br>
					$siteuri,$litesiteuri, $site, $rootUrl, $url, $uri, $litesite,$sitehost,$litesitehost, $liteurl,$liteuri, $host, $litehost, $httpcode, $literoot, $litepath, $literooturl, $results,$httpcode,$lxres...
					<br>
					global xxx;
					<br>		
					$GLOBALS['xxx'];
					<br>
					●站点设置
					<br>
					域名 如: localhost
					<br>
					域名|访客IP 如: localhost|127.0.0.1||192.168.0.1			
					<br>						
					●缓存文件夹
					<br>
					cache为页面缓存文件夹
					<br>
					fy_cache为翻译缓存文件夹
					<br>
					git_cache为启动缓存文件夹(把cache复制为git_cache,每次清除cache时自动复制git_cache到cache)
					<br>					
					●外部功能
					<br>
					清空所有缓存 copycatdeal?op=cacheclean&config={配置}
					<br>
					清空过期缓存 copycatdeal?op=cacheclean&config={配置}&time=3600
					<br>					
					清空过期页面缓存 copycatdeal?op=cacheclean&config={配置}&time=3600&type=1
					<br>				
					清空过期翻译缓存 copycatdeal?op=cacheclean&config={配置}&time=3600&type=2
					<br>
					获取网站根目录 copycatdeal?op=loadroot							
					<br>						
					清空指定路径缓存 copycatdeal?delcache=网址
					<br>
					Cron服务激活维护 copycatdeal?cron=check
					<br>
					获取Cron日志文件 copycatdeal?cron=log					
				</p>
			</div>
			<div class="bottom">
				<div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col w8 last">
	<div class="content" id="zw">
		<div class="demobg">
			<div class="col w10 last">
				<div class="content">
					<p class="last" id="page">
						Pages
					</p>
				</div>
			</div>
			<div style="padding:10px">
				<img class="col w10" src="resources/help/pages.png">
			</div>
			<div class="col w10 last">
				<div class="content">
					<p class="last" id="mime">
						MIME
					</p>
				</div>
			</div>
			<div style="padding:10px">
				<img class="col w10" src="resources/help/mime.png">
			</div>
			<div class="col w10 last">
				<div class="content">
					<p class="last" id="path">
						Paths
					</p>
				</div>
			</div>
			<div style="padding:10px">
				<img class="col w10" src="resources/help/paths.png">
			</div>
			<div class="col w10 last">
				<div class="content">
					<p class="last" id="replaces">
						Replaces
					</p>
				</div>
			</div>
			<div style="padding:10px">
				<img class="col w10" src="resources/help/replaces.png">
			</div>
			<div class="col w10 last">
				<div class="content">
					<p class="last" id="locations">
						Locations
					</p>
				</div>
			</div>
			<div style="padding:10px">
				<img class="col w10" src="resources/help/locations.png">
			</div>
			<div class="col w10 last">
				<div class="content">
					<p class="last" id="ips">
						IPS
					</p>
				</div>
			</div>
			<div style="padding:10px">
				<img class="col w10" src="resources/help/ips.png">
			</div>

		<div class="col w10 last">
			<div class="content">
				<p class="last" id="host">
					Host
				</p>
			</div>
		</div>
		<div style="padding:10px">
			<img class="col w10" src="resources/help/host.png">
		</div>

	<div class="col w10 last">
		<div class="content">
			<p class="last" id="cron">
				Cron
			</p>
		</div>
	</div>
	<div style="padding:10px">
		<img class="col w10" src="resources/help/cron.png">
	</div>
	<div class="col w10 last">
		<div class="content">
			<p class="last" id="cron">
				正则表达式的基本语法<a href="javascript:void(0);" onclick="window.open('http://tool.lu/','_blank');" style="float:right;" >在线校验</a>
			</p>
		</div>
	</div>
	<div class="col w10" style="padding:10px">
	<textarea style="width:97%" id="rule" cols="125" rows="30" readonly></textarea>
	</div>	
</div>
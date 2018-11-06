<div id="messages">
</div>
<div class="clear">
</div>
<form>
	<div class="demobg">
		<div class="col w10 last">
			<div class="content">
				<p class="last">
					基本信息
				</p>
			</div>
		</div>
	</div>
	<div class="clear">
	</div>
	<div style="padding:20px">
		<p>
			<label for="simple_input">
				主机
			</label>
			<input type="text" id="host" name="host" value="" class="text w_20">
		</p>
		<p class="small">
			填写需要在线代理的网站! 如: http://www.example.com/
		</p>
		<br>
		<p>
			<label for="simple_input">
				根目录
			</label>
			<input type="checkbox " checked class="checkbox" onchange="if(!this.checked){this.checked=false}else{this.checked=true}if(this.checked){document.getElementById('zdrootp').style.display='block'}else{document.getElementById('zdrootp').style.display='none'}"
			id="zdroot" name="zdroot">
		</p>
		<p class="small">
			是否自动适配根目录?
		</p>
		<br>
		<div id="zdrootp" name="zdrootp" style="display:none;">
			<input type="text" id="root" name="root" value="" class="text w_20">
			</p>
			<p class="small">
				填写网站根目录!
			</p>
		</div>
		<br>
		<p>
			<label for="select">
				字符编码
			</label>
			<select name="select" id="encoding" name="encoding">
				<option value="auto|utf-8">
					自动编码+UTF-8
				</option>	
				<option value="auto|gbk">
					自动编码+GBK
				</option>							
				<option value="utf-8">
					UTF-8
				</option>
				<option value="gbk">
					GBK
				</option>
			</select>
		</p>
		<p class="small">
			选择页面的字符编码!
		</p>
		<br>
		<p>
			<label for="simple_input">
				替换域名
			</label>
			<input type="checkbox" class="checkbox" id="thym" name="thym" checked>
		</p>
		<p class="small">
			是否在页面中开启替换域名功能?
		</p>
		<br>
		<p>
			<label for="simple_input">
				替换相对地址
			</label>
			<input type="checkbox " class="checkbox" id="thnr" name="thnr" checked>
		</p>
		<p class="small">
			是否在页面中开启替换相对地址功能?
		</p>
		<br>			
		<p>
			<label for="simple_input">
				GZIP压缩
			</label>
			<input type="checkbox " class="checkbox" id="ymys" name="ymys">
		</p>
		<p class="small">
			是否在页面中开启GZIP压缩页面功能?
		</p>
		<br>
		<p>
			<label for="simple_input">
				消除注释
			</label>
			<input type="checkbox " class="checkbox" id="xczs" name="xczs">
		</p>
		<p class="small">
			是否开启消除页面(html,css,js)注释功能?
		</p>
		<br>		
		<p>
			<label for="simple_input">
				伪原创
			</label>
			<input type="checkbox " class="checkbox" id="wyc" name="wyc">
		</p>
		<p class="small">
			是否在页面中开启页面伪原创功能?&nbsp;<a href="javascript:void(0);" onclick="wycpath();">规则列表</a>
		</p>
		<br>		
		<p>
			<label for="simple_input">
				大文件代理
			</label>
			<input type="checkbox " class="checkbox" id="dwjdl" name="dwjdl">
		</p>
		<p class="small">
			是否在页面中开启大文件代理功能? (不开启则自动跳转!)
		</p>
		<br>
		<div id="dwjdlp" name="dwjdlp" style="display:block;">
			<input type="text" id="dwjzxz" name="dwjzxz" value="1048576" class="text w_20">
			</p>
			<p class="small">
				大文件最小值(bytes) 默认为 1048576
			</p>
		</div>	
		<br>			
	</div>
	<div class="demobg">
		<div class="col w10 last">
			<div class="content">
				<span id="fycacheop" style="float:right;padding:5px">
					<a href="javascript:void(0);" style="line-height:30px" onclick="var xx=prompt('清除指定时间翻译缓存，请输入过期秒数:','');if(xx){timefycache(xx,config);}">时间翻译缓存</a> / <a href="javascript:void(0);" style="line-height:30px" onclick="var xx=prompt('请输入翻译缓存类型，如en_zh_utf-8','');if(xx){delfycache(xx,config);}">删除翻译缓存</a> / <a href="javascript:void(0);" style="line-height:30px" onclick="cachepath(config,0,1);">查看翻译缓存</a> / <a href="javascript:void(0);" style="line-height:30px" onclick="cleancache(config,1);">清空翻译缓存</a>	
				</span>
				<p class="last">
					翻译设置
				</p>
			</div>
		</div>
	</div>
	<div class="clear">
	</div>
	<div style="padding:20px">
		<p>
			<label for="simple_input">
				翻译开关
			</label>
			<input type="checkbox" onchange="if(this.checked){this.checked=false}else{this.checked=true}if(this.checked){document.getElementById('fyp').style.display='block'}else{document.getElementById('fyp').style.display='none'}"
			class="checkbox" name="fykg" id="fykg">
		</p>
		<p class="small">
			是否在页面中开启缓存功能?
		</p>
		<br>
		<div id="fyp" name="fyp" style="display:none;">
			
		<p>
			<label for="simple_input">
				静态缓存
			</label>
			<input type="checkbox " class="checkbox" id="fyjt" name="fyjt">
		</p>
		<p class="small">
			是否开启页面翻译静态缓存功能? (仅当临时静态缓存或永久静态缓存开启时有效!)
		</p>
			<br>
			<p>
				<label for="select">
					中文翻译
				</label>
				<select id="fyyz" name="fyyz">
					<option value="simc">
						简体
					</option>				
					<option value="trac">
						繁体
					</option>				
					<option value="yue">
						粤语
					</option>
					<option value="wyw">
						文言文
					</option>
					<option value="en">
						英文
					</option>
					<option value="jp">
						日文
					</option>
					<option value="kor">
						韩文
					</option>
					<option value="de">
						德文
					</option>
					<option value="fra">
						法文
					</option>
					<option value="th">
						泰文
					</option>					
					<option value="it">
						意大利
					</option>		
					<option value="spa">
						西班牙
					</option>	
					<option value="pt">
						葡萄牙
					</option>	
					<option value="ru">
						俄罗斯
					</option>	
					<option value="ara">
						阿拉伯
					</option>						
				</select>
			</p>
			<p class="small">
				请选择将中文转化的语种!
			</p>
			<br>
			<p id="fysxp" name="fysxp" sxtyle="display:none;">
				<label for="simple_input">
					翻译类型
				</label>
				<input type="text" id="fylx" name="fylx" value="text/html,text/xml,application/x-javascript,application/javascript,application/json" class="text w_20">
				<p class="small">
				(支持text/html,text/xml,application/x-javascript,application/javascript,application/json)[","为分隔符]如：text/html,text/xml,application/x-javascript,application/javascript,application/json
				</p>				
			</p>
			<br>
			<p>
				<label for="simple_input">
					翻译白名单
				</label>
				<input type="text" id="fybmd" name="fybmd" value="*" class="text w_20">
				<p class="small">
					输入需要翻译的路径如：js|!html|css|! 或 * (强化规则：["*.","*.js","*.html","*.css"] 或 !["*.","*.js","*.html","*.css"] 或 ["\/(.*?)\/is"]或多规则并用 || 为分隔符)
				</p>
			</p>
		</div>
		<br>
	</div>		
	</div>
	
	<div class="demobg">
		<div class="col w10 last">
			<div class="content">
				<span id="cacheop" style="float:right;padding:5px"><a href="javascript:void(0);" style="line-height:30px" onclick="var xx=prompt('清除指定时间缓存，请输入过期秒数:','');if(xx){timecache(xx,config);}">时间缓存</a> <span id="delcache" name="delcache">/ <a href="javascript:void(0);" style="line-height:30px" onclick="var xx=prompt('请输入缓存的地址:','');if(xx){delcache(xx,config);}">删除缓存</a></span> / <a href="javascript:void(0);" style="line-height:30px" onclick="cachepath(config);">查看缓存</a> / <a href="javascript:void(0);" style="line-height:30px" onclick="cleancache(config);">清空缓存</a>	
				</span>
				<p class="last">
					缓存设置
				</p>
			</div>
		</div>
	</div>
	<div class="clear">
	</div>
	<div style="padding:20px">

		<p>
			<label for="simple_input">
				超级缓存
			</label>
			<input type="checkbox " class="checkbox" id="cjhc" name="cjhc">
		</p>
		<p class="small">
			是否开启浏览器超级缓存功能?
		</p>
			<br>		
		<p>
			<label for="simple_input">
				缓存开关
			</label>
			<input type="checkbox" onchange="if(this.checked){this.checked=false}else{this.checked=true}if(this.checked){document.getElementById('hcp').style.display='block'}else{document.getElementById('hcp').style.display='none'}"
			class="checkbox" name="hckg" id="hckg">
		</p>
		<p class="small">
			是否在页面中开启缓存功能?
		</p>
		<br>
		<div id="hcp" name="hcp" style="display:none;">
			<p>
				<label for="select">
					缓存类型
				</label>
				<select id="hclx" name="hclx" onchange="if(this.selectedIndex==0||this.selectedIndex==2){document.getElementById('hcsxp').style.display='block'}else{document.getElementById('hcsxp').style.display='none'}">
					<option value="0">
						临时静态缓存
					</option>
					<option value="1">
						永久静态缓存
					</option>
					<option value="2">
						临时动态缓存
					</option>
					<option value="3">
						永久动态缓存
					</option>					
				</select>
			</p>	
			<p class="small">
				请选择缓存类型!
			</p>				
			<br>
			<p id="hcsxp" name="hcsxp" style="display:block;">
				<label for="simple_input">
					缓存时限(s)
				</label>
				<input type="text" id="hcsx" name="hcsx" value="3600" class="text w_20">
				<p class="small">
					需要缓存的文件格式如：3600 或  [[[["*.css","/f(.*?)$/"],120],["",360]],7200](强化规则：参数分别为规则，时限，总体时限)
				</p>				
			</p>
			<br>
			<p>
				<label for="simple_input">
					自定义缓存
				</label>
				<input type="text" id="zydhc" name="zydhc" value="*" class="text w_20">
				<p class="small">
					需要缓存的文件格式如：js|!html|css|! 或 * (强化规则：["*.","*.js","*.html","*.css"] 或 !["*.","*.js","*.html","*.css"] 或 ["\/(.*?)\/is"]或多规则并用 || 为分隔符)
				</p>
			</p>
		</div>
	</div>



	<div class="demobg">
		<div class="col w10 last">
			<div class="content">
				<p class="last">
					数据统计
				</p>
			</div>
		</div>
	</div>
	<div class="clear">
	</div>
	<div style="padding:20px">
	
		<p>
			<label for="simple_input">
				统计开关
			</label>
			<input type="checkbox" onchange="if(this.checked){this.checked=false}else{this.checked=true}if(this.checked){document.getElementById('sjkgp').style.display='block'}else{document.getElementById('sjkgp').style.display='none'}"
			class="checkbox" name="sjkg" id="sjkg">
		</p>
		<p class="small">
			是否在页面中开启统计功能?
		</p>
		<br>
		<div id="sjkgp" name="sjkgp" style="display:none;">

			<textarea id="tjdm" style="width:100%" name="tjdm" rows="10" cols="50"></textarea>
			<p class="small">
				请输入统计代码如 : &lt;script&gt;xxx&lt;/script&gt;
			</p>
			<p>
				<label for="simple_input">
					统计白名单
				</label>
				<input type="text" id="tjbmd" name="tjbmd" value="*" class="text w_20">
				<p class="small">
					允许统计的路径如：["\/(.*?)\/is"] 或 * (!["\/(.*?)\/is"]表示除此之外都允许)
				</p>
			</p>
		</div>
	</div>




	
	<div class="demobg">
		<div class="col w10 last">
			<div class="content">
				<p class="last">
					高级信息
				</p>
			</div>
		</div>
	</div>
	<div class="clear">
	</div>
	<div style="padding:20px">
		<p>
			<label for="select">
				核心设置
			</label>
			<select id="hxsz" name="hxsz" onchange="loadqjcookie(document.getElementById('hxsz').selectedIndex);">
				<option value="0">
					CURL核心
				</option>
				<option value="1">
					FILE核心
				</option>				
			</select>
		</p>
		<br>		
		<p>
			<label for="select">
				COOKIES设置
			</label>
			<select id="csz" name="csz" onchange="if(this.selectedIndex==3){document.getElementById('zydcp').style.display='block'}else{document.getElementById('zydcp').style.display='none'}if(this.selectedIndex==2){document.getElementById('qjcp').style.display='block';}else{document.getElementById('qjcp').style.display='none'}">
				<option value="0">
					传统COOKIES
				</option>
				<option value="1">
					禁用COOKIES
				</option>				
				<option value="2">
					全局COOKIES
				</option>
				<option value="3">
					自定义COOKIES
				</option>
			</select>
		</p>
		<br>
		<span id="qjcp" name="qjcp" style="display:none;">
			<textarea id="qjc" style="width:100%" name="qjc" rows="10" cols="50"></textarea>
			<div style="float:right;padding:10px">
				<a href="javascript:void(0);" onclick="loadqjcookie(document.getElementById('hxsz').selectedIndex);" class="button">
					<small class="icon polaroids">
					</small>
					<span>
						Refresh
					</span>
				</a>
				<a href="javascript:void(0);" onclick="saveqjcookie(document.getElementById('hxsz').selectedIndex);" class="button">
					<small class="icon check">
					</small>
					<span>
						Save File
					</span>
				</a>
			</div>
		</span>
		<span id="zydcp" name="zydcp" style="display:none;">
			<label for="simple_input">
				自定义COOKIES
			</label>
			<textarea id="zydc" name="zydc" style="width:100%" rows="10" cols="50"></textarea>
			<p class="small">
				自定义COOKIES如(多个用“;”分隔)：user=123;password=123
			</p>
		</span>
		<br>
		<p>
			<label for="select">
				浏览器标识设置
			</label>
			<select id="llqbzsz" name="llqbzsz" onchange="if(this.selectedIndex==2){document.getElementById('zydllqbzp').style.display='block'}else{document.getElementById('zydllqbzp').style.display='none'}">
				<option value="0">
					客户端标识
				</option>
				<option value="1">
					不伪造标识
				</option>
				<option value="2">
					自定义标识
				</option>
			</select>
		</p>
		<br>
		<span id="zydllqbzp" name="zydllqbzp" style="display:none;">
			<label for="simple_input">
				自定义浏览器标识
			</label>
			<input type="text" id="zydllqbz" name="zydllqbz" value="" class="text w_20">
			<p class="small">
				自定义标识如：Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.31 (KHTML,
				like Gecko) Chrome/26.0.1410.64 Safari/537.31
			</p>
		</span>
		<br>
		<p>
			<label for="select">
				来路设置
			</label>
			<select id="llsz" name="llsz" onchange="if(this.selectedIndex==2){document.getElementById('zydllp').style.display='block'}else{document.getElementById('zydllp').style.display='none'}">
				<option value="0">
					全自动伪造
				</option>
				<option value="1">
					不使用来路
				</option>				
				<option value="2">
					自定义来路
				</option>
			</select>
		</p>
		<br>
		<span id="zydllp" name="zydllp" style="display:none;">
			<label for="simple_input">
				自定义来路
			</label>
			<input type="text" id="zydll" name="zydll" value="" class="text w_20">
			<p class="small">
				自定义来路如：http://www.baidu.com/
			</p>
		</span>
		<br>
		<p>
			<label for="select">
				IP设置
			</label>
			<select id="ipsz" name="ipsz" onchange="if(this.selectedIndex==2){document.getElementById('zydipp').style.display='block'}else{document.getElementById('zydipp').style.display='none'}">
				<option value="0">
					客户端IP
				</option>
				<option value="1">
					服务器IP
				</option>
				<option value="2">
					自定义IP
				</option>
			</select>
		</p>
		<br>
		<span id="zydipp" name="zydipp" style="display:none;">
			<label for="simple_input">
				自定义IP
			</label>
			<input type="text" id="zydip" name="zydip" value="" class="text w_20">
			<p class="small">
				自定义IP如：127.0.0.1
			</p>
		</span>
		<br>
		<p>
			<label for="select">
				代理设置
			</label>
			<select id="dlsz" name="dlsz" onchange="if(this.selectedIndex!=0){document.getElementById('zyddlp').style.display='block'}else{document.getElementById('zyddlp').style.display='none'}">
				<option value="0">
					不使用代理
				</option>
				<option value="1">
					静态代理
				</option>
				<option value="2">
					动态代理
				</option>				
			</select>
		</p>
		<br>
		<span id="zyddlp" name="zyddlp" style="display:none;">
			<label for="simple_input">
				自定义代理
			</label>
			<input type="text" id="zyddl" name="zyddl" value="" class="text w_20">
			<p class="small">
				静态代理如：127.0.0.1:8080 | 动态代理如： http://www.xxx.com/getproxy.php
			</p>

			<label for="simple_input">
				代理规则
			</label>
			<input type="text" id="dlgz" name="dlgz" value="*" class="text w_20">
			<p class="small">
				需要代理规则如：js|!html|css|! 或 * (强化规则：["*.","*.js","*.html","*.css"] 或 !["*.","*.js","*.html","*.css"] 或 ["\/(.*?)\/is"])
			</p>
		</span>
		<br>
		<p>
			<label for="select">
				Header设置
			</label>
			<select id="hsz" name="hsz" onchange="if(this.selectedIndex==2){document.getElementById('zydhp').style.display='block'}else{document.getElementById('zydhp').style.display='none'}">
				<option value="0">
					全自动Header
				</option>
				<option value="1">
					不使用Header
				</option>				
				<option value="2">
					自定义Header
				</option>
			</select>
		</p>
		<br>		
		<span id="zydhp" name="zydhp" style="display:none;">
			<label for="simple_input">
				自定义Header
			</label>
			<textarea id="zydh" name="zydh" style="width:100%" rows="10" cols="50"></textarea>
			<p class="small">
				自定义Header如(每行一条)： X-Requested-With: XMLHttpRequest
			</p>
			
			<label for="simple_input">
				Header规则
			</label>
			<input type="text" id="hgz" name="hgz" value="*" class="text w_20">
			<p class="small">
				需要Header规则如：js|!html|css|! 或 * (强化规则：["*.","*.js","*.html","*.css"] 或 !["*.","*.js","*.html","*.css"] 或 ["\/(.*?)\/is"])
			</p>
		</span>
	</div>
</form>
<style>
.body{padding:10px;}
</style>
<div id="edit" style="display:none;">
	<div class="overlay" style="position: fixed;display: block;">
	</div>
	<div class="modal_window default" style="border-radius: 5px;width: 400px; left: 481.5px; position:fixed;display: block;left:50%;top:50%;margin-left:-200px;margin-top:-229px;">
		<div class="header" id="ttll" style="border-radius: 3px;">
		</div>
		<div id="modal_inner">
			<iframe id="editor" src="" width="100%" height="400px" frameborder="no"
			border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes">
			</iframe>
		</div>
	</div>
</div>
<div class="col w2">
	<div class="content">
		<div class="box header">
			<div class="head">
				<div>
				</div>
			</div>
			<h2>
				模板说明
				<a style="float:right;margin-right: 10px;line-height: 15px;" href="javascript:void(0);"
				onclick="window.location.href='index.html#file|pages';window.location.reload();">
					文件管理
				</a>
			</h2>
			<div class="desc">
				<p style="overflow: auto">
					在自定义页面规则和内容替换规则中使用
					<br>
					可以调用相应模板:
					<br>
					★自定义页面和IPS支持规则
					<br>
					{"op":"file","code":"test.jpg"}
					<br>
					{"op":"include","code":"test.html"}					
					<br>
					{"op":"php","code":"fff.php","config":"JG5hbWU9MTIzOw=="}
					<br>
					{"op":"text","code":"1.txt"}
					<br>
					●内容查找规则
					<br>
					{"op":"include","code":"test.html"}							
					<br>
					{"op":"php","code":"fff.php","config":"JG5hbWU9MTIzOw=="}
					<br>
					●内容替换和路径替换规则
					<br>
					{input:1.png}
					<br>
					{eval:date.code}
					<br>
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
	</div>
	<div class="clear">
	</div>
</div>
<div class="clear">
</div>
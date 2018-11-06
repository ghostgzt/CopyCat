<div id="messages">
</div>
<div class="clear">
</div>
<div class="demobg">
	<div class="col w10 last">
		<div class="content">
			<p class="last">
				站点设定
			</p>
		</div>
	</div>
</div>
<div class="clear">
</div>
<div style="padding:20px">
	<input type="file" id="sitefile" name="sitefile" value="" onchange="importsettings(this,'site')" style="display:none;"  />
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','1');if(ss!=null){fnInsert('site','stop','New Host',window.location.host,'',1,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<site.length;i++){document.getElementById('site').rows[site[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<site.length;i++){document.getElementById('site').rows[site[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="site=plsz(site);for(var i=0;i<site.length;i++){document.getElementById('site').deleteRow(site[i]);}site=[];checkqx('site');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('sitefile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="site.json" onclick="var jsn=savesetting('site');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">	
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|host');"
		class="button">
			<small class="icon flatscreen">
			</small>
			<span>
				help
			</span>
		</a>
	</p>
	<table id="site" style="table-layout:fixed;">
		<tbody>
			<tr>
				<th class="checkbox" style="width:20px">
					<input onchange="site=[];for( var i=1;i<this.parentNode.parentNode.parentNode.rows.length;i++){document.getElementById('site').rows[i].cells[0].getElementsByTagName('input')[0].checked=this.checked;if(this.checked){site.push(i);}}"
					type="checkbox" name="checkbox">
				</th>
				<th style="width:50px">
					Status
				</th>
				<th>
					Name
				</th>
				<th>
					Site
				</th>
				<th>
					Config
				</th>
				<th style="width:350px">
					Operations
				</th>
			</tr>
		</tbody>
	</table>
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','-1');if(ss!=null){fnInsert('site','stop','New Host',window.location.host,'',1,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<site.length;i++){document.getElementById('site').rows[site[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<site.length;i++){document.getElementById('site').rows[site[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="site=plsz(site);for(var i=0;i<site.length;i++){document.getElementById('site').deleteRow(site[i]);}site=[];checkqx('site');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('sitefile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="site.json" onclick="var jsn=savesetting('site');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">	
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|host');"
		class="button">
			<small class="icon flatscreen">
			</small>
			<span>
				help
			</span>
		</a>
	</p>
	</p>
	<br>
</div>
<div class="clear">
</div>
<div class="demobg">
	<div class="col w10 last">
		<div class="content">
				<span id="cacheop" style="float:right;padding:5px"><a href="javascript:void(0);" style="line-height:30px" onclick="cronstart();">启动任务</a> / <a href="javascript:void(0);" style="line-height:30px" onclick="croncheck();">检测任务</a> / <a href="javascript:void(0);" style="line-height:30px" onclick="cronstop();">停止任务</a> / <a href="javascript:void(0);" style="line-height:30px" onclick="window.open('cron/run.log','_blank');">任务日志</a> / <a href="javascript:void(0);" style="line-height:30px" onclick="cleanlog();">清空日志</a>	
				</span>		
			<p class="last">
				定时任务
			</p>
		</div>
	</div>
</div>
<div class="clear">
</div>
<div style="padding:20px">
	<input type="file" id="cronfile" name="cronfile" value="" onchange="importsettings(this,'cron')" style="display:none;"  />
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','1');if(ss!=null){fnInsert('cron','stop','New Cron','3600','http://www.baidu.com/',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<cron.length;i++){document.getElementById('cron').rows[cron[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<cron.length;i++){document.getElementById('cron').rows[cron[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="cron=plsz(cron);for(var i=0;i<cron.length;i++){document.getElementById('cron').deleteRow(cron[i]);}cron=[];checkqx('cron');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('cronfile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="cron.json" onclick="var jsn=savesetting('cron');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">	
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|cron');"
		class="button">
			<small class="icon flatscreen">
			</small>
			<span>
				help
			</span>
		</a>		
	</p>
	<table id="cron" style="table-layout:fixed;">
		<tbody>
			<tr>
				<th class="checkbox" style="width:20px">
					<input onchange="cron=[];for( var i=1;i<this.parentNode.parentNode.parentNode.rows.length;i++){document.getElementById('cron').rows[i].cells[0].getElementsByTagName('input')[0].checked=this.checked;if(this.checked){cron.push(i);}}"
					type="checkbox" name="checkbox">
				</th>
				<th style="width:50px">
					Status
				</th>
				<th>
					Name
				</th>
				<th>
					Time(s)
				</th>
				<th>
					Path
				</th>
				<th style="width:350px">
					Operations
				</th>
			</tr>
		</tbody>
	</table>
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','-1');if(ss!=null){fnInsert('cron','stop','New Cron','3600','http://www.baidu.com/',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<cron.length;i++){document.getElementById('cron').rows[cron[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<cron.length;i++){document.getElementById('cron').rows[cron[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="cron=plsz(cron);for(var i=0;i<cron.length;i++){document.getElementById('cron').deleteRow(cron[i]);}cron=[];checkqx('cron');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('cronfile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="cron.json" onclick="var jsn=savesetting('cron');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">	
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|cron');"
		class="button">
			<small class="icon flatscreen">
			</small>
			<span>
				help
			</span>
		</a>
	</p>
	</p>
	<br>
</div>
<div class="clear">
</div>
<div class="demobg">
	<div class="col w10 last">
		<div class="content">
				<span id="cacheop" style="float:right;padding:5px"><a href="javascript:void(0);" style="line-height:30px" onclick="backhtaccess();">恢复默认</a> / <a href="javascript:void(0);" style="line-height:30px" onclick="savehtaccess();">保存文件</a>	
				</span>		
			<p class="last">
				.htaccess脚本
			</p>
		</div>
	</div>
</div>
<div class="clear">
</div>
<div align="center">
	<textarea name="data" id="data" style="width:98%" rows="10">
	</textarea>
</div>
<div class="clear">
</div>
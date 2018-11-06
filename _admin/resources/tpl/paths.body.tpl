<div id="messages">
</div>
<div class="clear">
</div>
<div class="demobg">
	<div class="col w10 last">
		<div class="content">
			<p class="last">
				映射管理
			</p>
		</div>
	</div>
</div>
<div class="clear">
</div>
<div style="padding:20px">
	<input type="file" id="pathfile" name="pathfile" value="" onchange="importsettings(this,'path')" style="display:none;"  />
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','1');if(ss!=null){fnInsert('path','stop','New Path','','',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<path.length;i++){document.getElementById('path').rows[path[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<path.length;i++){document.getElementById('path').rows[path[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="path=plsz(path);for(var i=0;i<path.length;i++){document.getElementById('path').deleteRow(path[i]);}path=[];checkqx('path');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('pathfile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="path.json" onclick="var jsn=savesetting('path');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|path');"
		class="button">
			<small class="icon flatscreen">
			</small>
			<span>
				help
			</span>
		</a>
	</p>
	<table id="path" style="table-layout:fixed;">
		<tbody>
			<tr>
				<th class="checkbox" style="width:20px">
					<input onchange="path=[];for( var i=1;i<this.parentNode.parentNode.parentNode.rows.length;i++){document.getElementById('path').rows[i].cells[0].getElementsByTagName('input')[0].checked=this.checked;if(this.checked){path.push(i);}}"
					type="checkbox" name="checkbox">
				</th>
				<th style="width:50px">
					Status
				</th>
				<th>
					Name
				</th>
				<th>
					Source
				</th>
				<th>
					Destination
				</th>
				<th style="width:350px">
					Operations
				</th>
			</tr>
		</tbody>
	</table>
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','-1');if(ss!=null){fnInsert('path','stop','New Path','','',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<path.length;i++){document.getElementById('path').rows[path[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<path.length;i++){document.getElementById('path').rows[path[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="path=plsz(path);for(var i=0;i<path.length;i++){document.getElementById('path').deleteRow(path[i]);}path=[];checkqx('path');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('pathfile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="path.json" onclick="var jsn=savesetting('path');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|path');"
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
<div class="demobg">
	<div class="col w10 last">
		<div class="content">
			<p class="last">
				IP管理
			</p>
		</div>
	</div>
</div>
<div class="clear">
</div>
<div style="padding:20px">
	<input type="file" id="ipsfile" name="ipsfile" value="" onchange="importsettings(this,'ips')" style="display:none;"  />
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','1');if(ss!=null){fnInsert('ips','stop','New IP','127.0.0.1','',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<ips.length;i++){document.getElementById('ips').rows[ips[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<ips.length;i++){document.getElementById('ips').rows[ips[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="ips=plsz(ips);for(var i=0;i<ips.length;i++){document.getElementById('ips').deleteRow(ips[i]);}ips=[];checkqx('ips');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('ipsfile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="ips.json" onclick="var jsn=savesetting('ips');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|ips');"
		class="button">
			<small class="icon flatscreen">
			</small>
			<span>
				help
			</span>
		</a>
	</p>
	<table id="ips" style="table-layout:fixed;">
		<tbody>
			<tr>
				<th class="checkbox" style="width:20px">
					<input onchange="ips=[];for( var i=1;i<this.parentNode.parentNode.parentNode.rows.length;i++){document.getElementById('ips').rows[i].cells[0].getElementsByTagName('input')[0].checked=this.checked;if(this.checked){ips.push(i);}}"
					type="checkbox" name="checkbox">
				</th>
				<th style="width:50px">
					Status
				</th>
				<th>
					Name
				</th>
				<th>
					IP
				</th>
				<th>
					Contents
				</th>
				<th style="width:350px">
					Operations
				</th>
			</tr>
		</tbody>
	</table>
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','-1');if(ss!=null){fnInsert('ips','stop','New IP','127.0.0.1','',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<ips.length;i++){document.getElementById('ips').rows[ips[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<ips.length;i++){document.getElementById('ips').rows[ips[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="ips=plsz(ips);for(var i=0;i<ips.length;i++){document.getElementById('ips').deleteRow(ips[i]);}ips=[];checkqx('ips');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('ipsfile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="ips.json" onclick="var jsn=savesetting('ips');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|ips');"
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
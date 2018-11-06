<div id="messages">
</div>
<div class="clear">
</div>
<div class="demobg">
	<div class="col w10 last">
		<div class="content">
			<p class="last">
				页面管理
			</p>
		</div>
	</div>
</div>
<div class="clear">
</div>
<div style="padding:20px">
	<input type="file" id="pagefile" name="pagefile" value="" onchange="importsettings(this,'page')" style="display:none;"  />
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','1');if(ss!=null){fnInsert('page','stop','New Page','','',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<page.length;i++){document.getElementById('page').rows[page[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<page.length;i++){document.getElementById('page').rows[page[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="page=plsz(page);for(var i=0;i<page.length;i++){document.getElementById('page').deleteRow(page[i]);}page=[];checkqx('page');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('pagefile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="page.json" onclick="var jsn=savesetting('page');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">	
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|page');"
		class="button">
			<small class="icon flatscreen">
			</small>
			<span>
				help
			</span>
		</a>
	</p>
	<table id="page" style="table-layout:fixed;">
		<tbody>
			<tr>
				<th class="checkbox" style="width:20px">
					<input onchange="page=[];for( var i=1;i<this.parentNode.parentNode.parentNode.rows.length;i++){document.getElementById('page').rows[i].cells[0].getElementsByTagName('input')[0].checked=this.checked;if(this.checked){page.push(i);}}"
					type="checkbox" name="checkbox">
				</th>
				<th style="width:50px">
					Status
				</th>
				<th>
					Name
				</th>
				<th>
					Path
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
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','-1');if(ss!=null){fnInsert('page','stop','New Page','','',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<page.length;i++){document.getElementById('page').rows[page[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<page.length;i++){document.getElementById('page').rows[page[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="page=plsz(page);for(var i=0;i<page.length;i++){document.getElementById('page').deleteRow(page[i]);}page=[];checkqx('page');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('pagefile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="page.json" onclick="var jsn=savesetting('page');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">	
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|page');"
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
				MIME设置
			</p>
		</div>
	</div>
</div>
<div class="clear">
</div>
<div style="padding:20px">
	<input type="file" id="mimefile" name="mimefile" value="" onchange="importsettings(this,'mime')" style="display:none;"  />
	<p>
		<p>
			<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','1');if(ss!=null){fnInsert('mime','stop','','*','',0,ss);}"
			class="button">
				<small class="icon plus">
				</small>
				<span>
					plus
				</span>
			</a>
			<a href="javascript:void(0);" onclick="for(var i=0;i<mime.length;i++){document.getElementById('mime').rows[mime[i]].cells[1].innerHTML='run';}"
			class="button">
				<small class="icon play">
				</small>
				<span>
					play
				</span>
			</a>
			<a href="javascript:void(0);" onclick="for(var i=0;i<mime.length;i++){document.getElementById('mime').rows[mime[i]].cells[1].innerHTML='stop';}"
			class="button">
				<small class="icon stop">
				</small>
				<span>
					stop
				</span>
			</a>
			<a href="javascript:void(0);" onclick="mime=plsz(mime);for(var i=0;i<mime.length;i++){document.getElementById('mime').deleteRow(mime[i]);}mime=[];checkqx('mime');"
			class="button">
				<small class="icon cross">
				</small>
				<span>
					delete
				</span>
			</a>
		<a href="javascript:void(0);" onclick="document.getElementById('mimefile').click();"
		class="button">
				<small class="icon eject">
				</small>
				<span>
					import
				</span>
			</a>
		<a href="javascript:void(0);" download="mime.json" onclick="var jsn=savesetting('mime');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">	
				<small class="icon next_track">
				</small>
				<span>
					export
				</span>
			</a>
			<a href="javascript:void(0);" onclick="window.open('index.html#help|mime');"
			class="button">
				<small class="icon flatscreen">
				</small>
				<span>
					help
				</span>
			</a>
		</p>
		<table id="mime" style="table-layout:fixed;">
			<tbody>
				<tr>
					<th class="checkbox" style="width:20px">
						<input onchange="mime=[];for( var i=1;i<this.parentNode.parentNode.parentNode.rows.length;i++){document.getElementById('mime').rows[i].cells[0].getElementsByTagName('input')[0].checked=this.checked;if(this.checked){mime.push(i);}}"
						type="checkbox" name="checkbox">
					</th>
					<th style="width:50px">
						Status
					</th>
					<th>
						Extension
					</th>
					<th>
						Path
					</th>
					<th>
						MIME
					</th>
					<th style="width:350px">
						Operations
					</th>
				</tr>
			</tbody>
		</table>
		<p>
			<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','-1');if(ss!=null){fnInsert('mime','stop','','*','',0,ss);}"
			class="button">
				<small class="icon plus">
				</small>
				<span>
					plus
				</span>
			</a>
			<a href="javascript:void(0);" onclick="for(var i=0;i<mime.length;i++){document.getElementById('mime').rows[mime[i]].cells[1].innerHTML='run';}"
			class="button">
				<small class="icon play">
				</small>
				<span>
					play
				</span>
			</a>
			<a href="javascript:void(0);" onclick="for(var i=0;i<mime.length;i++){document.getElementById('mime').rows[mime[i]].cells[1].innerHTML='stop';}"
			class="button">
				<small class="icon stop">
				</small>
				<span>
					stop
				</span>
			</a>
			<a href="javascript:void(0);" onclick="mime=plsz(mime);for(var i=0;i<mime.length;i++){document.getElementById('mime').deleteRow(mime[i]);}mime=[];checkqx('mime');"
			class="button">
				<small class="icon cross">
				</small>
				<span>
					delete
				</span>
			</a>
		<a href="javascript:void(0);" onclick="document.getElementById('mimefile').click();"
		class="button">
				<small class="icon eject">
				</small>
				<span>
					import
				</span>
			</a>
			<a href="javascript:void(0);" download="mime.json" onclick="var jsn=savesetting('mime');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">	
				<small class="icon next_track">
				</small>
				<span>
					export
				</span>
			</a>
			</a>
			<a href="javascript:void(0);" onclick="window.open('index.html#help|mime');"
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
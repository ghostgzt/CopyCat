<div id="messages">
</div>
<div class="clear">
</div>
<div class="demobg">
	<div class="col w10 last">
		<div class="content">
			<p class="last">
				页面替换
			</p>
		</div>
	</div>
</div>
<div class="clear">
</div>
<div style="padding:20px">
	<input type="file" id="replacesfile" name="replacesfile" value="" onchange="importsettings(this,'replaces')" style="display:none;"  />
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','1');if(ss!=null){fnInsert('replaces','stop','','*','',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<replaces.length;i++){document.getElementById('replaces').rows[replaces[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<replaces.length;i++){document.getElementById('replaces').rows[replaces[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="replaces=plsz(replaces);for(var i=0;i<replaces.length;i++){document.getElementById('replaces').deleteRow(replaces[i]);}replaces=[];checkqx('replaces');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('replacesfile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		
		<a href="javascript:void(0);" download="replaces.json" onclick="var jsn=savesetting('replaces');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|replaces');"
		class="button">
			<small class="icon flatscreen">
			</small>
			<span>
				help
			</span>
		</a>
	</p>
	<table id="replaces" style="table-layout:fixed;">
		<tbody>
			<tr>
				<th class="checkbox" style="width:20px">
					<input onchange="replaces=[];for( var i=1;i<this.parentNode.parentNode.parentNode.rows.length;i++){document.getElementById('replaces').rows[i].cells[0].getElementsByTagName('input')[0].checked=this.checked;if(this.checked){replaces.push(i);}}"
					type="checkbox" name="checkbox">
				</th>
				<th style="width:50px">
					Status
				</th>
				<th>
					Source
				</th>
				<th>
					Path
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
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','-1');if(ss!=null){fnInsert('replaces','stop','','*','',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<replaces.length;i++){document.getElementById('replaces').rows[replaces[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<replaces.length;i++){document.getElementById('replaces').rows[replaces[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="replaces=plsz(replaces);for(var i=0;i<replaces.length;i++){document.getElementById('replaces').deleteRow(replaces[i]);}replaces=[];checkqx('replaces');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('replacesfile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="replaces.json" onclick="var jsn=savesetting('replaces');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|replaces');"
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
				跳转替换
			</p>
		</div>
	</div>
</div>
<div class="clear">
</div>
<div style="padding:20px">
	<input type="file" id="locationsfile" name="locationsfile" value="" onchange="importsettings(this,'locations')" style="display:none;"  />
	<p>
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','1');if(ss!=null){fnInsert('locations','stop','New locations','','',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<locations.length;i++){document.getElementById('locations').rows[locations[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<locations.length;i++){document.getElementById('locations').rows[locations[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="locations=plsz(locations);for(var i=0;i<locations.length;i++){document.getElementById('locations').deleteRow(locations[i]);}locations=[];checkqx('locations');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('locationsfile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="locations.json" onclick="var jsn=savesetting('locations');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">		
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|locations');"
		class="button">
			<small class="icon flatscreen">
			</small>
			<span>
				help
			</span>
		</a>
	</p>
	<table id="locations" style="table-layout:fixed;">
		<tbody>
			<tr>
				<th class="checkbox" style="width:20px">
					<input onchange="locations=[];for( var i=1;i<this.parentNode.parentNode.parentNode.rows.length;i++){document.getElementById('locations').rows[i].cells[0].getElementsByTagName('input')[0].checked=this.checked;if(this.checked){locations.push(i);}}"
					type="checkbox" name="checkbox">
				</th>
				<th style="width:50px">
					Status
				</th>
				<th>
					Source
				</th>
				<th>
					Path
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
		<a href="javascript:void(0);" onclick="var ss=prompt('要插入第几行','-1');if(ss!=null){fnInsert('locations','stop','New locations','','',0,ss);}"
		class="button">
			<small class="icon plus">
			</small>
			<span>
				plus
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<locations.length;i++){document.getElementById('locations').rows[locations[i]].cells[1].innerHTML='run';}"
		class="button">
			<small class="icon play">
			</small>
			<span>
				play
			</span>
		</a>
		<a href="javascript:void(0);" onclick="for(var i=0;i<locations.length;i++){document.getElementById('locations').rows[locations[i]].cells[1].innerHTML='stop';}"
		class="button">
			<small class="icon stop">
			</small>
			<span>
				stop
			</span>
		</a>
		<a href="javascript:void(0);" onclick="locations=plsz(locations);for(var i=0;i<locations.length;i++){document.getElementById('locations').deleteRow(locations[i]);}locations=[];checkqx('locations');"
		class="button">
			<small class="icon cross">
			</small>
			<span>
				delete
			</span>
		</a>
		<a href="javascript:void(0);" onclick="document.getElementById('locationsfile').click();"
		class="button">
			<small class="icon eject">
			</small>
			<span>
				import
			</span>
		</a>
		<a href="javascript:void(0);" download="locations.json" onclick="var jsn=savesetting('locations');if(jsn!=null){this.href=('data:application/object;base64,'+b.encode(jsn));}" class="button">		
			<small class="icon next_track">
			</small>
			<span>
				export
			</span>
		</a>
		</a>
		<a href="javascript:void(0);" onclick="window.open('index.html#help|locations');"
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
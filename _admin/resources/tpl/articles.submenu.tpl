<div id="submenu">
	<div class="modules_left">
		<div class="module buttons">
			<a href="" class="dropdown_button">
				<small class="icon plus">
				</small>
				<span>
					New
				</span>
			</a>
			<div class="dropdown">
				<div class="arrow">
				</div>
				<div class="content">
					<form action="index.php" method="post" id="add">
						<p>
							<label for="name">
								Name:
							</label>
							<input type="hidden" name="op" value="savepage">
							<input type="text" class="text w_22" name="name" id="name" value="" />
						</p>
						<p>
							<label for="description">
								Data:
							</label>
							<textarea name="data" id="data" class="w_22" rows="10"></textarea>
						</p>
					</form>
					<a href="javascript:void(0);" onclick="document.getElementById('add').submit();"
					class="button green right">
						<small class="icon check">
						</small>
						<span>
							Save
						</span>
					</a>
					<a class="button red mr right close">
						<small class="icon cross">
						</small>
						<span>
							Close
						</span>
					</a>
					<a href="javascript:void(0);" onclick="document.getElementById('ufile').click()"
					class="button green left">
						<small class="icon polaroids">
						</small>
						<span>
							上传文件
							<form id="uform" action="index.php" method="post" target="_top" enctype="multipart/form-data">
								<input type="hidden" name="op" value="uploadfile">
								<input id="ufile" name="ufile" onchange="if(this.value){document.getElementById('uform').submit();}"
								style="display:none;width:1px" type="file">
							</form>
						</span>
					</a>
					<div class="clear">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="title">
		模板
	</div>
	<div class="modules_right">
		<div class="module search">
			<!--form action=""-->
			<p>
				<input type="text" value="Search..." onkeyup="searchuserp(this.value)"
				name="user_search" />
			</p>
			<!--/form-->
		</div>
	</div>
</div>
<div id="submenu">
	<div class="modules_left">
		<div class="module buttons">
			<a href="" class="dropdown_button">
				<small class="icon v-card">
				</small>
				<span>
					Info
				</span>
			</a>
			<div class="dropdown">
				<div class="arrow">
				</div>
				<div class="content">
					<form action="index.php" method="post" id="change">
						<p>
							<label for="name">
								User:
							</label>
							<input type="hidden" name="op" value="saveuser">
							<input type="text" class="text w_22" name="user" id="user" value="" />
						</p>
						<p>
							<label for="description">
								Password:
							</label>
							<input type="text" class="text w_22" name="passwd" id="passwd" value=""
							/>
						</p>
					</form>
					<a href="javascript:void(0);" onclick="saveuser();" class="button green right">
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
					<a href="javascript:void(0);" onclick="readadminpath()" class="button green left">
						<small class="icon settings">
						</small>
						<span>
							修改目录
						</span>
					</a>
					<div class="clear">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="title">
		站点管理
	</div>
	<div class="modules_right">
		<div class="module buttons">
			<a href="javascript:void(0);" onclick="save('site',1);save('cron',1);cronstate();"
			style="z-index:999" class="button">
				<small class="icon save">
				</small>
				<span>
					Save
				</span>
			</a>
		</div>
	</div>
</div>
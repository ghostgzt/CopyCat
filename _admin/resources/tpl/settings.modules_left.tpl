<a href="" class="dropdown_button">
	<small class="icon clipboard">
	</small>
	<span>
		Menu
	</span>
</a>
<div class="dropdown help_index">
	<div class="arrow">
	</div>
	<div class="content">
		<div class="col w5">
			<a href="javascript:void(0);" onclick="turnurl('#settings'+(xhash[1]?'|'+xhash[1]:''));">
				基本设置
				<span>
					基本信息，缓存设置，高级信息
				</span>
			</a>
			<hr/>
			<a href="javascript:void(0);" onclick="turnurl('#replaces'+(xhash[1]?'|'+xhash[1]:''));">
				内容替换
				<span>
					规则管理
				</span>
			</a>
		</div>
		<div class="col w5 last">
			<a href="javascript:void(0);" onclick="turnurl('#pages'+(xhash[1]?'|'+xhash[1]:''));">
				自定义页面
				<span>
					页面管理，MIME管理
				</span>
			</a>
			<hr/>
			<a href="javascript:void(0);" onclick="turnurl('#paths'+(xhash[1]?'|'+xhash[1]:''));">
				路径映射
				<span>
					映射管理
				</span>
			</a>
		</div>
<div id="moremenu" name="moremenu" style="display:none">		
		<div class="col w5 last">
			<hr/>		
			<a href="javascript:void(0);" onclick="if(xhash[1]&&confirm('是否启用为默认配置？')){saveconfig(config,1);}">
				默认配置
				<span>
					启用此配置为默认配置
				</span>
			</a>
		</div>
		<div class="col w5 last">
			<hr/>
			<a href="javascript:void(0);" onclick="if(confirm('是否要删除此配置？')){delconfig(config);}">
				删除配置
				<span>
					删除此配置文件
				</span>
			</a>
		</div>
</div>		
		<div class="clear"></div>
		<!--a class="button red right close">
			<small class="icon cross">
			</small>
			<span>
				Close
			</span>
		</a-->
		<div class="clear"></div>
	</div>
</div>
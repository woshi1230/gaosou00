<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
$menus = array (
    array('basic_config', 'javascript:Tab(0);', ($action == 'detail' && $tab != 0) ? 'style="display:none"' : ''),
    array('任务模式', 'javascript:Tab(1);', ($action == 'detail' && $tab != 1) ? 'style="display:none"' : ''),
    array('mark_config', 'javascript:Tab(2);', ($action == 'detail' && $tab != 2) ? 'style="display:none"' : ''),
    array('信誉规则', 'javascript:Tab(3);', ($action == 'detail' && $tab != 3) ? 'style="display:none"' : ''),
    array('标签管理', 'javascript:Tab(4);', ($action == 'detail' && $tab != 4) ? 'style="display:none"' : ''),
);
show_menu($menus);
?>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="tab" id="tab" value="<?php echo $tab;?>"/>
<input type="hidden" name="action" id="action" value="<?php echo $action;?>"/>
<div id="Tabs0" style="display:">
<div class="tt">basic_config</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">max_size</td>
<td><input type="text" size="3" name="tab0[max_size]" value="<?php echo $dbdata0['max_size']['v'];?>"/> MB</td>
</tr>
<tr>
<td class="tl">file_type</td>
<td>
<input type="text" name="tab0[file_type]" style="width:98%;" value="<?php echo $dbdata0['file_type']['v'];?>"/>
<br/>用 | 分隔不同的文件类型
</td>
</tr>
</table>
</div>

<div id="Tabs1" style="display:none">
<div class="tt">任务模式</div>
<?php if($action != 'detail') {?>
<table cellpadding="2" cellspacing="1" class="tb">
	<tr>
		<th width="100">模型标识</th>
		<th width="100">模型代号</th>
		<th width="100">模型名称</th>
		<th width="80">配置</th>
	</tr>
	<?php foreach($dbdata1 as $k=>$v) {?>
		<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
			<td><?php echo $v['model_id'];?></td>
			<td><?php echo $v['model_code'];?></td>
			<td><?php echo $v['model_name'];?></td>
			<td>
				<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&tab=1&action=detail&id=<?php echo $v['model_id'];?>', '[配置]任务模式');">配置</a>
			</td>
		</tr>
	<?php }?>
</table>
<?php }else{?>
<table cellpadding="2" cellspacing="1" class="tb">
	<input type="hidden" name="tab1[model_id]" value="<?php echo $dbdata1['model_id'];?>"/>
	<input type="hidden" name="tab1[model_code]" value="<?php echo $dbdata1['model_code'];?>"/>
	<tr>
		<td class="tl">模型名称</td>
		<td><input type="text" size="20" name="tab1[model_name]" value="<?php echo $dbdata1['model_name'];?>"/></td>
	</tr>
	<tr>
		<td class="tl">config</td>
		<td><input type="text" name="tab1[config]" value='<?php echo $dbdata1['config'];?>' style="width: 98%"/></td>
	</tr>
	<tr>
		<td class="tl">模型说明</td>
		<td><textarea name="tab1[model_desc]" style="width: 650px;height: 240px"><?php echo str_replace('<br />','',$dbdata1['model_desc']);?></textarea></td>
	</tr>
</table>
<?php }?>
</div>

<div id="Tabs2" style="display:none">
<div class="tt">mark_config</div>
<?php if($action != 'detail') {?>
	<table cellpadding="2" cellspacing="1" class="tb">
		<tr>
			<th width="100">编号</th>
			<th width="100">对象</th>
			<th width="100">好评</th>
			<th width="100">中评</th>
			<th width="100">差评</th>
			<th width="100">角色</th>
			<th width="80">配置</th>
		</tr>
		<?php foreach($dbdata2 as $k=>$v) {?>
			<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
				<td><?php echo $v['mark_config_id'];?></td>
				<td><?php echo $v['obj'];?></td>
				<td><?php echo $v['good'];?>%</td>
				<td><?php echo $v['normal'];?>%</td>
				<td><?php echo $v['bad'];?>%</td>
				<td><?php
					if ($v['type'] == '1') {
						echo '高手';
					} else {
						echo '雇主';
					};
				?></td>
				<td>
					<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&tab=2&action=detail&id=<?php echo $v['mark_config_id'];?>', '[配置]mark_config');">配置</a>
				</td>
			</tr>
		<?php }?>
	</table>
<?php }else{?>
	<table cellpadding="2" cellspacing="1" class="tb">
		<input type="hidden" name="tab2[mark_config_id]" value="<?php echo $dbdata2['mark_config_id'];?>"/>
		<input type="hidden" name="tab2[type]" value="<?php echo $dbdata2['type'];?>"/>
		<tr>
			<td class="tl" style="width: 15%;">obj</td>
			<td><input type="text" size="20" name="tab2[obj]" value="<?php echo $dbdata2['obj'];?>" readonly/></td>
		</tr>
		<tr>
			<td class="tl">好评</td>
			<td><input type="text" size="20" name="tab2[good]" value="<?php echo $dbdata2['good'];?>"/></td>
		</tr>
		<tr>
			<td class="tl">中评</td>
			<td><input type="text" size="20" name="tab2[normal]" value="<?php echo $dbdata2['normal'];?>"/></td>
		</tr>
		<tr>
			<td class="tl">差评</td>
			<td><input type="text" size="20" name="tab2[bad]" value="<?php echo $dbdata2['bad'];?>"/></td>
		</tr>
		<tr>
			<td class="tl">角色</td>
			<td class="tl"><?php
				if ($dbdata2['type'] == '1') {
					echo '高手';
				} else {
					echo '雇主';
				};
			?></td>
		</tr>
	</table>
<?php }?>
</div>

<div id="Tabs3" style="display:none">
<div class="tt">信誉规则</div>
<?php if($action != 'detail') {?>
	<table cellpadding="2" cellspacing="1" class="tb">
		<tr>
			<th width="100">编号</th>
			<th width="100">信誉值</th>
			<th width="100">能力值</th>
			<th width="100">买家头衔</th>
			<th width="100">卖家头衔</th>
			<th width="100">买家图标</th>
			<th width="100">卖家图标</th>
			<th width="80">配置</th>
		</tr>
		<?php foreach($dbdata3 as $k=>$v) {?>
			<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
				<td><?php echo $v['mark_rule_id'];?></td>
				<td><?php echo $v['g_value'];?></td>
				<td><?php echo $v['m_value'];?></td>
				<td><?php echo $v['g_title'];?></td>
				<td><?php echo $v['m_title'];?></td>
				<td><img src="<?php echo $v['g_ico'];?>"></td>
				<td><img src="<?php echo $v['m_ico'];?>"></td>
				<td>
					<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&tab=3&action=detail&id=<?php echo $v['mark_rule_id'];?>', '[配置]信誉规则');">配置</a>
				</td>
			</tr>
		<?php }?>
	</table>
<?php }else{?>
	<table cellpadding="2" cellspacing="1" class="tb">
		<input type="hidden" name="tab3[mark_rule_id]" value="<?php echo $dbdata3['mark_rule_id'];?>"/>
		<tr>
			<td class="tl">信誉值</td>
			<td><input type="text" size="20" name="tab3[g_value]" value="<?php echo $dbdata3['g_value'];?>"/></td>
		</tr>
		<tr>
			<td class="tl">能力值</td>
			<td><input type="text" size="20" name="tab3[m_value]" value="<?php echo $dbdata3['m_value'];?>"/></td>
		</tr>
		<tr>
			<td class="tl">买家头衔</td>
			<td><input type="text" size="20" name="tab3[g_title]" value="<?php echo $dbdata3['g_title'];?>"/></td>
		</tr>
		<tr>
			<td class="tl">卖家头衔</td>
			<td><input type="text" size="20" name="tab3[m_title]" value="<?php echo $dbdata3['m_title'];?>"/></td>
		</tr>
		<tr>
			<td class="tl">买家图标</td>
			<td><input name="tab3[g_ico]" id="g_ico" type="text" size="60" value="<?php echo $dbdata3['g_ico'];?>" readonly/>&nbsp;&nbsp;
				<span onclick="Dfile(<?php echo $moduleid;?>, Dd('g_ico').value, 'g_ico', 'jpg|gif|png');" class="jt">[上传]</span>&nbsp;&nbsp;
				<span onclick="if(Dd('g_ico').value) window.open(DTPath + Dd('g_ico').value);" class="jt">[预览]</span>&nbsp;&nbsp;
				<span onclick="Dd('g_ico').value='';" class="jt">[删除]</span></td>
		</tr>
		<tr>
			<td class="tl">卖家图标</td>
			<td><input name="tab3[m_ico]" id="m_ico" type="text" size="60" value="<?php echo $dbdata3['m_ico'];?>" readonly/>&nbsp;&nbsp;
				<span onclick="Dfile(<?php echo $moduleid;?>, Dd('m_ico').value, 'm_ico', 'jpg|gif|png');" class="jt">[上传]</span>&nbsp;&nbsp;
				<span onclick="if(Dd('m_ico').value) window.open(DTPath + Dd('m_ico').value);" class="jt">[预览]</span>&nbsp;&nbsp;
				<span onclick="Dd('m_ico').value='';" class="jt">[删除]</span></td>
		</tr>
	</table>
<?php }?>
</div>

<div id="Tabs4" style="display:none">
	<div class="tt">标签管理</div>
	<?php if($action != 'detail') {?>
		<table cellpadding="2" cellspacing="1" class="tb">
			<tr>
				<th width="100">标签标识</th>
				<th width="100">标签名称</th>
				<th width="100">缓存时间</th>
				<th width="80">配置</th>
			</tr>
			<?php foreach($dbdata4 as $k=>$v) {?>
				<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
					<td><?php echo $v['tag_id'];?></td>
					<td><?php echo $v['tag_name'];?></td>
					<td><?php echo $v['cache_time'];?></td>
					<td>
						<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&tab=4&action=detail&id=<?php echo $v['tag_id'];?>', '[配置]标签管理');">配置</a>
					</td>
				</tr>
			<?php }?>
		</table>
	<?php }else{?>
		<table cellpadding="2" cellspacing="1" class="tb">
			<input type="hidden" name="tab4[tag_id]" value="<?php echo $dbdata4['tag_id'];?>"/>
			<input type="hidden" name="tab4[tag_code]" value="<?php echo $dbdata4['tag_code'];?>"/>
			<tr>
				<td class="tl">标签名称</td>
				<td><input type="text" size="20" name="tab4[tag_name]" value="<?php echo $dbdata4['tag_name'];?>" readonly/></td>
			</tr>
			<tr>
				<td class="tl">缓存时间</td>
				<td><input type="text" size="20" name="tab4[cache_time]" value="<?php echo $dbdata4['cache_time'];?>"/></td>
			</tr>
			<tr>
				<td class="tl">标签说明</td>
				<td><textarea name="tab4[code]" style="width: 650px;height: 240px"><?php echo str_replace('<br />','',$dbdata4['code']);?></textarea></td>
			</tr>
		</table>
	<?php }?>
</div>

<div class="sbt" id="tableconf_sbt">
<input type="submit" name="submit" value="确 定" class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($action != 'detail') {?>
<input type="button" value="展 开" id="ShowAll" class="btn" onclick="TabAll();" title="展开/合并所有选项"/>&nbsp;&nbsp;&nbsp;&nbsp;
<?php }else{?>
<input type="button" value="返 回" id="Return" class="btn" onclick="myReturn();" title="返回列表" />
<?php }?>
</div>
</form>
<script type="text/javascript">
var tab = <?php echo $tab;?>;
var all = <?php echo $all;?>;
function TabAll() {
	var i = 0;
	while(1) {
		if(Dd('Tabs'+i) == null) break;
		Dd('Tabs'+i).style.display = all ? (i == tab ? '' : 'none') : '';
		i++;
	}
	Dd('ShowAll').value = all ? '展 开' : '合 并';
	all = all ? 0 : 1;
}
window.onload=function() {
	if(tab) Tab(tab);
	if(all) {all = 0; TabAll();}
};
function myReturn() {
//	window.parent.cDialog();
//	window.location.reload();
	window.parent.location.href='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&tab=<?php echo $tab;?>';
}
</script>
<?php include tpl('footer');?>
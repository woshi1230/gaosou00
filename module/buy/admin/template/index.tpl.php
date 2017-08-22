<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
	<form action="?">
		<div class="tt"><?php echo $MOD['name'];?>搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
		<table cellpadding="2" cellspacing="1" class="tb">
			<tr>
				<td>
					&nbsp;<?php echo $fields_select;?>&nbsp;
					<input placeholder="请输入任务标题关键词" type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
					<?php echo $level_select;?>&nbsp;
					<?php echo $order_select;?>&nbsp;
					<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
					<input type="submit" value="搜 索" class="btn"/>&nbsp;
					<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
				</td>
			</tr>
		</table>
	</form>
	<form method="post">
		<div class="tt"><?php echo $menus[$menuid][0];?></div>
		<table cellpadding="2" cellspacing="1" class="tb">
			<tr>
				<th width="">编号</th>
				<th width="27%">任务标题</th>
				<th width="15%">任务金额</th>
				<th width="10%">发布者</th>
				<th width="10%">审核状态</th>
				<th width="25%">处理</th>
			</tr>
				<?php foreach($lists as $k=>$v) {?>
				<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
				<td><?php echo $v['task_id'];?></td>
<!--					<td><a href="--><?php //echo $v['caturl'];?><!--" target="_blank">--><?php //echo $v['catname'];?><!--</a></td>-->
					<!--<td>xxsss--><?php //if($v['level']) {?><!--<a href="?moduleid=--><?php //echo $moduleid;?><!--&file=--><?php //echo $file;?><!--&action=--><?php //echo $action;?><!--&level=--><?php //echo $v['level'];?><!--"><img src="admin/image/level_--><?php //echo $v['level'];?><!--.gif" title="--><?php //echo $v['level'];?><!--级" alt=""/></a>--><?php //} ?><!--</td>-->
					<!--<td><a href="javascript:_preview('--><?php //echo $v['task_pic'];?><!--');"><img src="--><?php //echo $v['task_pic'];?><!--" width="80" style="padding:5px;"/></a></td>-->
					<td align="center">&nbsp;<a href="<?php echo 'index.php?do=task&id='.$v['task_id'];?>" target="_blank"><?php echo $v['task_title'];?></a><?php if($v['vip']) {?> <img src="<?php echo DT_SKIN;?>image/vip_<?php echo $v['vip'];?>.gif" title="<?php echo VIP;?>:<?php echo $v['vip'];?>" align="absmiddle"/><?php } ?></td>
					<td align="center">&nbsp;￥
						<?php if($v['model_id'] == '4' || $v['model_id'] == '5') { ?>
							<?php echo $v['real_cash'];?>
						<?php } else { ?>
							<?php echo $v['task_cash'];?>
						<?php } ?>
					元</td>
					<td>
						<?php if($v['username']) { ?>
							<?php echo $v['username'];?>
						<?php } else { ?>
							<a href="javascript:_ip('<?php echo $v['ip'];?>');" title="游客"><?php echo $v['ip'];?></a>
						<?php } ?>
					<td>
						<!--<a href="?moduleid=--><?php //echo $moduleid;?><!--&file=--><?php //echo $file;?><!--&action=edit&task_id=--><?php //echo $v['task_id'];?><!--"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;-->
						<?php
						if($v['task_status']==2){
							echo '审核通过';
						}elseif($v['task_status']==0){
							echo '未付款';
						}elseif($v['task_status']==1){
							echo '待审核';
						}elseif($v['task_status']=='p2'){
							echo '投标中';
						}elseif($v['task_status']=='d2'){
							echo '竞标中';
						}elseif($v['task_status']==3){
							echo '选稿中';
						}elseif($v['task_status']==4){
							echo '投票中';
						}elseif($v['task_status']=='p4'){
							echo '工作中';
						}elseif($v['task_status']=='d4'){
							echo '待托管';
						}elseif($v['task_status']==5){
							echo '公示中';
						}elseif($v['task_status']==6){
							echo '交付中';
						}elseif($v['task_status']==7){
							echo '冻结中';
						}elseif($v['task_status']==8){
							echo '结束';
						}elseif($v['task_status']==9){
							echo '失败';
						}elseif($v['task_status']==10){
							echo '审核失败';
						}elseif($v['task_status']==11){
							echo '仲裁中';
						}elseif($v['task_status']==13){
							echo '交付冻结';
						}else{
							echo '请管理员设置该状态';
						}
						?>
					</td>
					<td>
<!--						<a href="?moduleid=--><?php //echo $moduleid;?><!--&file=--><?php //echo $file;?><!--&action=edit&task_id=--><?php //echo $v['task_id'];?><!--"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;-->
						<?php if($v[task_status]==1||$v[task_status]==0){ ?>
							<a style="margin-left: 10px;" href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=check&task_id=<?php echo $v['task_id'];?>" onclick=""> <span>审核通过 </span></a>
							<a style="margin-left: 10px;" href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reject&task_id=<?php echo $v['task_id'];?>" onclick=""> <span>审核失败 </span></a>
						<?php } ?>
<!--						<a style="margin-left: 10px;" href="?moduleid=--><?php //echo $moduleid;?><!--&file=--><?php //echo $file;?><!--&action=edit&task_id=--><?php //echo $v['task_id'];?><!--"" onclick=""> 查看 </a>-->
						<a style="margin-left: 10px;" href="#" onclick=""> 查看 </a>

<!--						--><?php //if(in_array($v['task_status'],array('8','9','10'))){ ?>
							<a onclick ="if(confirm('确认删除？')==false) return false;" href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&task_id=<?php echo $v['task_id'];?>" onclick=""> <span>删除 </span></a>
<!--						--><?php //} ?>

						<?php if(!in_array($v['task_status'],array('0','1','8','9','10'))){ ?>
							<a style="margin-left: 10px;" href="#" onclick=""> <span>111111结束任务 </span></a>

						<?php } ?>

						<?php if($v['task_status']==13){ ?>
							<a style="margin-left: 10px;" href="#" onclick=""> <span>处理 </span></a>
						<?php } ?>

						<?php if($v['is_trust']&&$v['task_status']=='9'&&time()>$v['end_time']){ ?><!--担保模式，任务失败退款-->
							<a style="margin-left: 10px;" href="#" onclick=""> <span>处理 </span></a>
						<?php } ?>
					</td>
<!--					<td>-->
<!--						<a href="?moduleid=--><?php //echo $moduleid;?><!--&file=--><?php //echo $file;?><!--&action=edit&task_id=--><?php //echo $v['task_id'];?><!--"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;-->
<!--						<a href="?moduleid=--><?php //echo $moduleid;?><!--&file=--><?php //echo $file;?><!--&action=delete&task_id=--><?php //echo $v['task_id'];?><!--" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>-->
<!--					</td>-->
				</tr>

				<?php }?>
		</table>
	<div class="pages"><?php echo $pages;?></div>
		<?php include tpl('notice_chip');?>
<?php include tpl('footer');?>
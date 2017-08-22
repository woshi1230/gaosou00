<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">举报搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $DT['city'] ? ajax_area_select('areaid', '地区(分站)', $areaid).'&nbsp;' : '';?>
<?php echo $order_select;?>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt">举报留言</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<?php if($type=='2') { ?>
    <th>举报编号</th>
    <th>所属对象</th>
    <th>举报类型</th>
    <th>举报原因</th>
    <th>举报人</th>
    <th>被举报人</th>
    <th>举报附件</th>
    <th width="130">举报时间</th>
    <th width="130">当前状态</th>
    <th width="130">处理人</th>
    <th width="50">操作</th>
    </tr>
<?php } else { ?>
    <th>维权编号</th>
    <th>所属对象</th>
    <th>举报类型</th>
    <th>举报原因</th>
    <th>维权人</th>
    <th>被维权人</th>
    <th>维权附件</th>
    <th width="130">维权时间</th>
    <th width="130">当前状态</th>
    <th width="130">处理人</th>
    <th width="50">操作</th>
    </tr>
<?php } ?>

<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="report_id[]" value="<?php echo $v['report_id'];?>"/></td>
<td><?php echo $v['report_id'];?></td>
<td>
    <?php if($v['obj']=='task') { ?><!--任务-->
        <a href="index.php?do=task&id=<?php echo $v['origin_id'];?>" target="_blank">查看所属任务</a>
    <?php } elseif($v['obj']=='work') { ?><!--稿件-->
        <a href="index.php?do=taskhandle&op=workinfo&taskId=<?php echo $v['origin_id'];?>&workId=<?php echo $v['obj_id'];?>" target="_blank">查看所属稿件</a>
    <?php } ?><!--稿件-->

</td>
<td><?php echo $v['report_reason'];?></td>
<td align="left"><?php echo $v['report_desc'];?></td>
<td><a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a></td>
<td><a href="javascript:_user('<?php echo $v['op_username'];?>');"><?php echo $v['op_username'];?></a></td>
<td align="left"><?php echo $v['report_file'];?></td>
<td class="px11"><?php echo $v['adddate'];?></td>
<td>
    <?php
    $trans_obj = array (
        "1" => '待处理',
        "2" => '处理中',
        "3" => '未成立',
        "4" => '已处理'
    );
    echo $trans_obj [$v['report_status']];
    ?>
</td>
<td><?php echo $v['op_username'];?></td>
<td>
<!--<a href="?moduleid=--><?php //echo $moduleid;?><!--&file=--><?php //echo $file;?><!--&action=edit&itemid=--><?php //echo $v['report_id'];?><!--"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;-->
<a href="<?php echo DT_PATH;?>admin/index.php?do=trans&view=process&type=<?php if($type=='2') { ?>report<?php } else { ?>rights<?php } ?>&report_id=<?php echo $v['report_id'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<?php if($v['report_status']=='3') { ?><!--举报无效的才可删除-->
    <a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['report_id'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
<?php } ?>
</td>
</tr>
<?php }?>
</table>
<div class="btns">
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>
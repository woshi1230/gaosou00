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
&nbsp;关键词
<input type="text" size="50" id="kw" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $cat_select;?>&nbsp;
<?php echo category_select('catid', '选择分类', $catid, $moduleid);?>&nbsp;
<input type="button" value="搜 索" class="btn" onclick="check();"/>
<input type="button" value="重 置" class="btn" onclick="Go('<?php echo $doc_url;?>?file=cloud&action=doc');"/>
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt"><?php echo $menus[$menuid][0];?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th width="90">分类</th>
<th>标 题</th>
<th width="200"><?php echo $timetype == 'add' ? '添加' : '更新';?>时间</th>
<th width="150">浏览</th>
<th width="50">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><a href="<?php echo $v['caturl'];?>"><?php echo $v['catname'];?></a></td>
<td align="left">&nbsp;<a href="?file=<?php echo $file;?>&action=doc&sub_action=show&itemid=<?php echo $v['itemid'];?>"><?php echo $v['title'];?></a><?php if($v['thumb']) {?> <a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="admin/image/img.gif" width="10" height="10" title="标题图,点击预览" alt=""/></a><?php } ?></td>
<?php if($timetype == 'add') {?>
<td class="px11" title="更新时间<?php echo $v['editdate'];?>"><?php echo $v['adddate'];?></td>
<?php } else { ?>
<td class="px11" title="添加时间<?php echo $v['adddate'];?>"><?php echo $v['editdate'];?></td>
<?php } ?>
<td class="px11"><?php echo $v['hits'];?></td>
<td>
<a href="?file=<?php echo $file;?>&action=doc&sub_action=edit&itemid=<?php echo $v['itemid'];?>"><img src="<?php echo DT_PATH;?>admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?file=<?php echo $file;?>&action=doc&sub_action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="<?php echo DT_PATH;?>admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>

</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<script type="text/javascript">
function check() {
    Go('<?php echo $doc_url;?>?file=cloud&action=doc&kw=' + Dd("kw").value + '&catid=' + Dd("catid_1").value);
    return true;
}
</script>
<?php include tpl('footer');?>
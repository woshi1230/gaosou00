<?php
echo '1';
$v = $db->query("SELECT * FROM ywb2b.keke_witkey_task");
var_dump($v);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
</head>
<body>
<div class="detail">
	<form action="#" id="frm_list" method="post">
		<input type="hidden" value="1" name="page">
		<input type="hidden" name="w['page_size']" value="10">
		<div id="ajax_dom"><input type="hidden" value="1" name="page">
			<table cellpadding="0" cellspacing="0">
				<tbody>
				<tr>
					<th>编号</th>

					<th width="27%">任务标题</th>

					<th width="15%">任务金额</th>
					<th width="10%">发布者</th>
					<th width="10%">任务状态</th>
					<th width="25%">处理</th>
				</tr>
				<tr class="item">
					<td class="td25"><?php echo $v['task_id'];?></td>
					<td class="td28">
						<a href="../index.php?do=task&amp;id=58" target="_blank"><?php echo $v['task_title'];?></a>
					</td>

					<td>￥<?php echo $v['task_cash'];?></td>
					<td><?php echo $v['username'];?></td>
					<td><?php echo $v['task_status'];?></td>
					<td>
						<!--
                                                    <a href="index.php?do=model&model_id=1&view=list&task_id=58&ac=pass&page=1" onclick="return cpass(this,'',1);" class="button"><span class="check icon"></span>审核通过</a>
    <a href="index.php?do=model&model_id=1&view=list&task_id=58&ac=nopass&page=1" onclick="return cpass(this,'',2);" class="button"><span class="cross icon"></span>审核失败</a>
                         -->
						<a href="index.php?do=model&amp;model_id=1&amp;view=list&amp;task_id=58&amp;ac=pass&amp;page=1" onclick="return cpass(this,'',1,0);" class="button"><span class="check icon"></span>审核通过</a>
						<!-- <a href="index.php?do=model&model_id=1&view=list&task_id=58&ac=nopass&page=1" onclick="return cpass(this,'',2);" class="button"><span class="cross icon"></span>11审核失败</a> -->
						<a href='javascript:lookinfo("index.php?do=model&model_id=1&view=list&task_id=58&ac=nopass&page=1&uid=11");' class="button"><span class="cross icon"></span>审核失败</a>

						<a href="index.php?do=model&amp;model_id=1&amp;view=edit&amp;task_id=58&amp;page=1" class="button dbl_target"><span class="pen icon"></span>查看</a>
					</td>
				</tr>

						<!--
                                                 -->

						<a href="index.php?do=model&amp;model_id=1&amp;view=edit&amp;task_id=27&amp;page=1" class="button dbl_target"><span class="pen icon"></span>查看</a>
						<a href="index.php?do=model&amp;model_id=1&amp;view=list&amp;ac=del&amp;task_id=27&amp;page=1" class="button" onclick="return cdel(this);"><span class="trash icon"></span>删除</a>
					</td>
				</tr>

				<tr>
					<td colspan="7">
						<div class="page fl_right"><li><span> 1 / 2页 </span></li> <li class="active"><a>1</a></li><li><a href="javascript:;" onclick="ajaxpage('ajax_dom','index.php?do=model&amp;model_id=1&amp;view=list&amp;w[task_id]=&amp;w[task_title]=&amp;w[task_status]=&amp;ord[0]=&amp;ord[1]=&amp;page=1&amp;page_size=10&amp;page=2','2','1')">2</a></li><li><a href="javascript:;" onclick="ajaxpage('ajax_dom','index.php?do=model&amp;model_id=1&amp;view=list&amp;w[task_id]=&amp;w[task_title]=&amp;w[task_status]=&amp;ord[0]=&amp;ord[1]=&amp;page=1&amp;page_size=10&amp;page=2','2','1')">»&gt;&gt;</a></li></div>


					</td>
				</tr>
				</tbody>
			</table></div>
	</form>
</div>
</body>
</html>

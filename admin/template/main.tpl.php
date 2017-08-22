<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div id="tips_update" style="display:none;">
<div class="tt">更新提示</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td><div style="padding:20px 30px 20px 20px;" title="当前版本V<?php echo DT_VERSION; ?> 更新时间<?php echo DT_RELEASE;?>"><img src="admin/image/tips_update.gif" width="32" height="32" align="absmiddle"/>&nbsp;&nbsp; <span class="f_red">您的当前软件版本有新的更新，请注意升级</span>&nbsp;&nbsp;&nbsp;&nbsp;最新版本：V<span id="last_v"><?php echo DT_VERSION; ?></span>&nbsp;&nbsp;更新时间：<span id="last_r"><?php echo DT_RELEASE; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="?file=cloud&action=update" class="t">[立即检查]</a></div></td>
</tr>
</table>
</div>
<div class="tt"><span class="f_r">IP:<?php echo $user['loginip']; ?> <?php echo ip2area($user['loginip']);?>&nbsp;&nbsp;</span>欢迎管理员，<?php echo $_username;?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">管理级别</td>
<td width="30%">&nbsp;<?php echo $_admin == 1 ? ($CFG['founderid'] == $_userid ? '网站创始人' : '超级管理员') : ($_aid ? '<span class="f_blue">'.$AREA[$_aid]['areaname'].'站</span>管理员' : '普通管理员'); ?></td>
<td class="tl">登录次数</td>
<td width="30%">&nbsp;<?php echo $user['logintimes']; ?> 次</td>
</tr>
<tr>
<td class="tl">快捷操作</td>
<td>
    &nbsp;&nbsp;&nbsp;<a href="<?php echo $MODULE[2]['linkurl'].'message.php';?>" target="_blank">收件箱[<?php echo $_message ? '<strong class="f_red">'.$_message.'</strong>' : $_message;?>]</a>
    &nbsp;&nbsp;&nbsp;<a href="<?php echo $MODULE[2]['linkurl'].'message.php';?>" target="_blank">待审核任务[<?php echo $arrTaskrr[2] ? '<strong class="f_red">'.$arrTaskrr[2].'</strong>' : $arrTaskrr[2];?>]</a>
    &nbsp;&nbsp;&nbsp;<a href="?moduleid=3&file=report&type=2">举报[<?php echo $arrTaskrr[2] ? '<strong class="f_red">'.$arrTaskrr[2].'</strong>' : $arrTaskrr[2];?>]</a>
    &nbsp;&nbsp;&nbsp;<a href="?moduleid=3&file=report&type=1">维权[<?php echo $arrTaskrr[1] ? '<strong class="f_red">'.$arrTaskrr[1].'</strong>' : $arrTaskrr[1];?>]</a>
    &nbsp;&nbsp;&nbsp;<a href="<?php echo $MODULE[2]['linkurl'].'message.php';?>" target="_blank">留言[<?php echo $arrTaskrr[2] ? '<strong class="f_red">'.$arrTaskrr[2].'</strong>' : $arrTaskrr[2];?>]</a>
</td>
<td class="tl">登录时间</td>
<td>&nbsp;<?php echo timetodate($user['logintime'], 5); ?> </td>
</tr>
<tr>
<td class="tl">账户余额</td>
<td>&nbsp;<?php echo $_money; ?></td>
<td class="tl">会员<?php echo $DT['credit_name'];?></td>
<td>&nbsp;<?php echo $_credit; ?> </td>
</tr>
<?php if($_admin == 1) { ?>
<form action="?">
<tr>
<td class="tl">后台搜索</td>
<td colspan="2">
<input type="hidden" name="file" value="search"/>
<input type="text" style="width:98%;color:#444444;" name="kw" value="请输入关键词" onfocus="if(this.value=='请输入关键词')this.value='';"/></td>
<td>&nbsp;<input type="submit" name="submit" value="搜 索" class="btn"/>
</td>
</tr>
</form>
<?php } ?>
<form method="post" action="?">
<tr>
<td class="tl">工作便笺</td>
<td colspan="2">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<textarea name="note" style="width:98%;height:50px;overflow:visible;color:#444444;"><?php echo $note;?></textarea></td>
<td>&nbsp;<input type="submit" name="submit" value="保 存" class="btn"/>
</td>
</tr>
</form>
</table>
<?php if($_founder) {?>
<div id="gaosou"></div>
<div class="tt">系统信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">程序信息</td>
<td>&nbsp;<a href="?file=cloud&action=update" class="t">GAOSOU B2B Version <?php echo DT_VERSION;?> Release <?php echo DT_RELEASE;?> <?php echo DT_CHARSET;?> <?php echo strtoupper(DT_LANG);?> [检查更新]</a></td>
</tr>
<tr>
<td class="tl">软件版本</td>
<?php if($edition == '&#20010;&#20154;&#29256;') { ?>
<td id="gaosou_edition">&nbsp;<span class="f_blue"><?php echo $edition;?></span> <span class="f_red">(未授权)</span>&nbsp;&nbsp;<a href="?file=cloud&action=buy" target="_blank" class="t">[购买授权]</a></td>
<?php } else { ?>
<td id="gaosou_edition">&nbsp;<span class="f_blue">商业<?php echo $edition;?></span>&nbsp;&nbsp;<a href="?file=cloud&action=biz" target="_blank" class="t" title="技术支持">[技术支持]</a></td>
<?php } ?>
</tr>
<tr>
<td class="tl">安装时间</td>
<td>&nbsp;<?php echo $install;?></td>
</tr>
<tr>
<td class="tl">官方网站</td>
<td>&nbsp;<a href="http://www.gaosou.net/?tracert=AdminMain" target="_blank">http://www.gaosou.net</a></td>
</tr>
<tr>
<td class="tl">支持论坛</td>
<td>&nbsp;<a href="http://bbs.gaosou.com/?tracert=AdminMain" target="_blank">http://bbs.gaosou.com</a></td>
</tr>
<tr>
<td class="tl">使用帮助</td>
<td>&nbsp;<a href="http://help.gaosou.com/?tracert=AdminMain" target="_blank">http://help.gaosou.com</a></td>
</tr>
<tr>
<td class="tl">服务器时间</td>
<td>&nbsp;<?php echo timetodate($DT_TIME, 'Y-m-d H:i:s l');?></td>
</tr>
<tr>
<td class="tl">服务器信息</td>
<td>&nbsp;<?php echo PHP_OS.'&nbsp;'.$_SERVER["SERVER_SOFTWARE"];?> [<?php echo gethostbyname($_SERVER['SERVER_NAME']);?>:<?php echo $_SERVER["SERVER_PORT"];?>] <a href="?file=doctor" class="t">[系统体检]</a></td>
</tr>
<tr>
<td class="tl">数据库版本</td>
<td>&nbsp;MySQL <?php echo $db->version();?></td>
</tr>
<tr>
<td class="tl">站点路径</td>
<td>&nbsp;<?php echo DT_ROOT;?></td>
</tr>
<tr>
<td class="tl">上次备份</td>
<td>&nbsp;<a href="?file=database" title="点击备份数据库"><?php echo $backtime;?><?php if($backdays > 5) { ?> (<span class="f_red"><?php echo $backdays;?></span>天以前)<?php } ?></a></td>
</tr>
</table>
<div class="tt">使用协议</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td style="padding:10px;"><textarea style="width:100%;height:100px;" onmouseover="this.style.height='600px';" onmouseout="this.style.height='100px';"><?php echo file_get(DT_ROOT.'/license.txt');?></textarea></td>
</tr>
</table>
<!--<script type="text/javascript" src="--><?php //echo $notice_url;?><!--"></script>-->
<script type="text/javascript">
    var gaosou_lastrelease = "2015-12-22";
    var gaosou_lastversion = "6.0";
    try{
        document.getElementById("gaosou").innerHTML='<div class="tt">官方消息</div>' +
            '<table cellpadding="2" cellspacing="1" class="tb">' +
            '<tr><td width="50%">&nbsp;&bull; [2015-12-09]&nbsp;&nbsp;&nbsp;<a href="http://www.gaosou.net/product/news/33.html" target="_blank" style="color:blue;">商业用户安卓手机客户端开放申请</a></td><td>&nbsp;&bull; [2015-12-22]&nbsp;&nbsp;&nbsp;<a href="http://bbs.gaosou.com/thread-72214-1-1.html" target="_blank">V6.0 R20151222 更新</a> <img src="admin/image/new.gif" title="NEW" alt="" align="absmiddle"/></td></tr>' +
            '<tr><td width="50%">&nbsp;&bull; [2015-09-16]&nbsp;&nbsp;&nbsp;<a href="http://bbs.gaosou.com/thread-70640-1-1.html" target="_blank">GAOSOU B2B V6.0正式版发布</a></td><td>&nbsp;&bull; [2015-11-25]&nbsp;&nbsp;&nbsp;<a href="http://bbs.gaosou.com/thread-71882-1-1.html" target="_blank">V6.0 R20151125 更新</a></td></tr>' +
            '<tr><td width="50%">&nbsp;&bull; [2014-03-10]&nbsp;&nbsp;&nbsp;<a href="http://www.gaosou.net/buy/?tracert=Notice" target="_blank">购买商业版即赠送精美网站模版</a></td><td>&nbsp;&bull; [2015-11-10]&nbsp;&nbsp;&nbsp;<a href="http://bbs.gaosou.com/thread-71637-1-1.html" target="_blank">V6.0 R20151110 更新</a></td></tr>' +
            '</table>';
    }catch(e){}
</script>
<script type="text/javascript">
var gaosou_release = <?php echo DT_RELEASE;?>;
var gaosou_version = <?php echo DT_VERSION;?>;
if(typeof gaosou_lastrelease != 'undefined') {
	var lastrelease = parseInt(gaosou_lastrelease.replace('-', '').replace('-', ''));
	if(gaosou_lastversion == gaosou_version && gaosou_release < lastrelease) {
		$('#last_v').html(gaosou_lastversion);
		$('#last_r').html(gaosou_lastrelease);
		$('#tips_update').show('slow');
	}
}
</script>
<?php } ?>
<script type="text/javascript">Menuon(0);</script>
<?php include tpl('footer');?>
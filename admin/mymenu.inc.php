<?php
/*
	[GAOSOU B2B System] Copyright (c) 2016-2017 www.gaosou.net
	This is NOT a freeware, use is subject to license.txt
*/
defined('DT_ADMIN') or exit('Access Denied');
require DT_ROOT.'/admin/admin.class.php';
$do = new admin;
$menus = array (
    array('我的面板', '?file='.$file),
);
if($submit) {
	if($do->update($_userid, $right, $_admin)) dmsg('更新成功', '?file='.$file.'&update=1');
	msg($do->errmsg);
} else {
	$dmenus = $do->get_menu($_userid);
	include tpl('mymenu');
}
?>
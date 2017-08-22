<?php
defined('DT_ADMIN') or exit('Access Denied');
$menu = array(
	array('高手列表', '?moduleid=42'),
	array(VIP.'管理', '?moduleid=42&file=vip'),
	array('行业分类', '?file=category&mid=42'),
	array('荣誉资质', '?moduleid=2&file=honor'),
	array('高手动态', '?moduleid=2&file=news'),
	array('高手单页', '?moduleid=2&file=page'),
	array('友情链接', '?moduleid=2&file=link'),
	array('高手模板', '?moduleid=2&file=style'),
	array('更新数据', '?moduleid=42&file=html'),
	array('模块设置', '?moduleid=42&file=setting'),
);
?>
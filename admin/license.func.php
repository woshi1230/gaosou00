<?php
/*
	[GAOSOU B2B System] Copyright (c) 2016-2017 www.gaosou.net
	This is NOT a freeware, use is subject to license.txt
*/
defined('DT_ADMIN') or exit('Access Denied');
function edition($k = -1) {
	$E = array();
	$E[0] = DT_DOMAIN;
	$E[1] = '&#20010;&#20154;&#29256;';
	return $k >= 0 ? $E[$k] : $E;
}
?>
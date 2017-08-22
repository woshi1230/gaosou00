<?php
/*
	[GAOSOU B2B System] Copyright (c) 2016-2017 www.gaosou.net
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_GAOSOU') or exit('Access Denied');
if($DT_BOT) return;
if($page == 1) {
	if($DT['cache_hits']) {
		 cache_hits($moduleid, $itemid);
	} else {
		$update .= ',hits=hits+1';
	}
}
if($update) $db->query("UPDATE LOW_PRIORITY {$table} SET ".substr($update, 1)." WHERE itemid=$itemid", 'UNBUFFERED');	
?>
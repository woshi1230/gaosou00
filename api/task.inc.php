<?php
defined('IN_GAOSOU') or exit('Access Denied');
if($DT_BOT) {
	//
} else {
	include template('line', 'chip');
	$db and $db->close();
}
?>
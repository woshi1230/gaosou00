<?php
defined('IN_GAOSOU') or exit('Access Denied');
$time = $today_endtime - 30*86400;
$db->query("DELETE FROM {$DT_PRE}admin_log WHERE logtime<$time");
?>
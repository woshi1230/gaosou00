<?php
defined('IN_GAOSOU') or exit('Access Denied');
$time = $today_endtime - 90*86400;
$db->query("DELETE FROM {$DT_PRE}sms WHERE sendtime<$time");
?>
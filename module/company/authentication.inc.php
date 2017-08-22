<?php 
defined('IN_GAOSOU') or exit('Access Denied');
//$table = $DT_PRE.'honor';
$table = $DT_PRE.'witkey_mark_rule';
stristr($DT_URL, "type=1") ? $type = 1 : $type = 2;
$result = $db->query("SELECT * FROM {$table}");
while($r = $db->fetch_array($result)) {
	$lists[] = $r;
//	var_dump($lists);exit('1');
}
include template('authentication', $template);

?>
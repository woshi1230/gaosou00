<?php
if($itemid) {
	$t = $db->get_one("SELECT content FROM {$table_data} WHERE itemid=$itemid");
	$content = $t['content'];
} else {
	$content_table = content_table(4, $userid, is_file(DT_CACHE.'/4.part'), $DT_PRE.'company_data');
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE userid=$userid");
	$content = $t['content'];
}

$incomeCash = $db->get_one("select sum(amount) as cash from " . TB_PRE . "finance_record where to_days(NOW()) - to_days(FROM_UNIXTIME(addtime)) <=90  and amount>0 and (reason='sale_service' or reason='task_bid' or reason='sale_gy') and uid = {$userid}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
$incomeCash = number_format($incomeCash[cash],2);

require_once DT_ROOT.'/lib/table/Yw_witkey_mark_aid_class.php';
require DT_ROOT.'/module/'.$module.'/user_mark_class.php';

$arrSellerMark = user_mark_class::get_user_aid ( $userid, '2', null, '1' );
foreach ($arrSellerMark as $k=>$v) {
	$arrSellerMark[$k]['star'] =intval($v['avg']);
}
?>
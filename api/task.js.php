<?php
@set_time_limit(0);
#@ignore_user_abort(true);
define('DT_TASK', true);
require '../common.inc.php';
check_referer() or exit;
if($DT_BOT) exit;
#header("Content-type:text/javascript");
if ($_userid) {
	$intWaitPay = $db->count(TB_PRE . "witkey_task", "uid=" . intval($_userid) . " and task_status=0");
	$intChoose = $db->count(TB_PRE . "witkey_task", "uid=" . intval($_userid) . " and (task_status=3 or task_status =2)");
//        $intShopPay = db_factory::query("select count(*) as count from " . TB_PRE . "witkey_order a left join " . TB_PRE . "witkey_order_detail b on a.order_id=b.order_id
//		 where a.order_uid=" . intval($gUid) . " and a.order_status='wait' and b.obj_type='service'");
	$intMarkG = $db->count(TB_PRE . "witkey_mark", "mark_status=0 and mark_type=2 and by_uid=" . intval($_userid));
	$intMarkW = $db->count(TB_PRE . "witkey_mark", "mark_status=0 and mark_type=1 and by_uid=" . intval($_userid));
//        $intService = db_factory::get_count("SELECT COUNT(*) as count2 FROM `" . TB_PRE . "witkey_order` AS a  LEFT JOIN " . TB_PRE . "witkey_order_detail AS b ON a.order_id = b.order_id  LEFT JOIN " . TB_PRE . "witkey_service_order AS c ON b.order_id = c.order_id  WHERE  1=1  and a.seller_uid = " . $gUid . " and b.obj_type = 'service' and a.order_status ='seller_confirm' order by b.order_id desc");
//        $intGy = db_factory::get_count("SELECT COUNT(*) as count FROM `keke_witkey_service_order` as a LEFT JOIN keke_witkey_order_detail as b ON a.order_id = b.order_id LEFT JOIN keke_witkey_order as c ON a.order_id = c.order_id WHERE 1=1 and b.obj_type ='gy' and c.seller_uid= 1 and c.order_status!= 'close' and c.order_status ='seller_confirm' order by c.order_time desc");
}
include template('line', 'chip');
$db->linked or exit;
isset($html) or $html = '';
if($html) {
	$task_index = intval($DT['task_index']);
	$task_index > 60 or $task_index = 300;
	$task_list = intval($DT['task_list']);
	$task_list > 300 or $task_list = 1800;
	$task_item = intval($DT['task_item']);
	$task_item > 1800 or $task_item = 3600;
	if($moduleid == 1) {
		if($DT['index_html'] && $DT_TIME - @filemtime(DT_ROOT.'/'.$DT['index'].'.'.$DT['file_ext']) > $task_index) tohtml('index');
	} else {
		include DT_ROOT.'/module/'.$module.'/common.inc.php';
		include DT_ROOT.'/module/'.$module.'/task.inc.php';
	}
}
include DT_ROOT.'/api/cron.inc.php';

$db->close();
?>
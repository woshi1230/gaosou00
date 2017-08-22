<?php	defined('IN_KEKE') or exit('Access Denied');
$task_id = intval($task_id);
if (kekezu::submitcheck(isset($formhash))) {
	$arrSelectPeople = db_factory::query('select uid from ' . TB_PRE . 'witkey_task_work where  task_id=' . $task_id);
	$task_info = db_factory::query('select * from ' . TB_PRE . 'witkey_task where  task_id=' . $task_id);
	$hongbaoSum = $task_info[0]['task_cash'];
	shuffle($cbk);
	$a = '';
	foreach ($arrSelectPeople as $key => $val) {
		$arrSelectPeople[$key] = $val['uid'];
	}
	$cha = array_diff($arrSelectPeople, $cbk);
	foreach ($cha as $k => $v) {
		db_factory::query('update ' . TB_PRE . 'witkey_task_work set work_status=7 where uid="' . $v . '" and task_id=' . $task_id);
	}
	$count = count($cbk);
	foreach ($cbk as $key => $val) {
		do {
			$lcg = lcg_value();
		} while ($lcg < 0.1);
		if (($key + 1) == $count) {
			$selefHongBao[$val] = $hongbaoSum;
		} else {
			$selefHongBao[$val] = number_format($lcg * $hongbaoSum, 2);
		}
		$hongbaoSum -= $selefHongBao[$val];
		$a += $selefHongBao[$val];
	}
	foreach ($selefHongBao as $k => $v) {
		CommonClass::changehongbao($task_id, $task_info[0]['task_cash'], $k, $v, $task_info[0]['task_title']);
	}
	CommonClass::changehongbao('', $task_info[0]['task_cash'], $gUid, $a, $task_info[0]['task_title'], 1);
	db_factory::execute('update '. TB_PRE . 'witkey_task set task_status=8 where task_id=' . $task_id);
	kekezu::show_msg('福袋已发送成功', 'index.php?do=task&id=' . $task_id . '&view=work', NULL, NULL, 'ok');
} else {
	$arrSelectPeople = db_factory::query('select uid,username,work_status from ' . TB_PRE . 'witkey_task_work where 1=1 and task_id=' . intval($id) . ' order by work_status desc');
	$objRelease = hongbao_release_class::get_instance(15, $pub_mode);
	$arrConfig = $objRelease->_task_config;
}

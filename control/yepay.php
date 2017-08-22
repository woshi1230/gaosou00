<?php
$type = strval ( trim ( $type ) );
$id = intval ( trim ( $id ) );
if ($_SESSION ['UserBalance']) {
	$arrUserBalance = explode ( '|', $_SESSION ['UserBalance'] );
	$strUid = $arrUserBalance [0];
	$strIp = $arrUserBalance [1];
	$strSec_code = $arrUserBalance [2];
	$strMd5Pwd = keke_user_class::get_password ( $strSec_code, $gUserInfo ['paysalt'] );
	$arrUserInfo = db_factory::get_one ( sprintf ( "select * from yw_member where userid=%d and payword='%s'", intval ( $strUid ), $strMd5Pwd ) );
	if ($strIp != kekezu::get_ip () || $strUid != $gUid || ! $arrUserInfo) {
		kekezu::show_msg ( '你的支付密码不正确！', 'index.php?do=index', NULL, NULL, 'ok' );
	} else {
		switch ($type) {
			case 'task' :
				$arrTaskInfo = db_factory::get_one ( sprintf ( "select * from %switkey_task where task_id='%d'", TB_PRE, $id ) );
				$modelInfo = $kekezu->_model_list [$arrTaskInfo ['model_id']];
				$className = $modelInfo ['model_code'] . "_task_class";
				if(intval($t)==1){
    				$arrOrderinfo = db_factory::get_one ( sprintf ( "select order_id from %switkey_order_detail where obj_id=%d and obj_type = 'task' and detail_type is NULL", TB_PRE, $id ) );
				}else{
    				$arrOrderinfo = db_factory::get_one ( sprintf ( "select order_id from %switkey_order_detail where obj_id=%d and obj_type = 'task'", TB_PRE, $id ) );
				}
				$obj = new $className ( $arrTaskInfo );
				$arrResult = $obj->dispose_order ( $arrOrderinfo ['order_id'] );
				if(intval($t)==1){
				    $jumpUrl = 'index.php?do=task&id='.$id;
				    db_factory::updatetable(TB_PRE.'witkey_task', array('task_status'=>6), array('task_id'=>intval($id)));
				    $task_info =  db_factory::get_one('select * from '.TB_PRE.'witkey_task where task_id = '.intval($id));
				    $work_info = db_factory::get_one('select * from '.TB_PRE.'witkey_task_work where task_id = '.intval($id).' and work_status=4');
				    $objYj = new yijia_task_class($task_info);
				    $objYj->create_agree_date($work_info);
				}else{
    				$jumpUrl = 'index.php?do=pubtask&id=' . $arrTaskInfo ['model_id'] . '&step=step4&taskId=' . $id . '&status=1';
				}
				kekezu::clearCache();
				header ( 'Location:' . $jumpUrl );
				break;
			case 'service' :
				if ($orderId) { 
					$arrServcie=db_factory::get_one("select * from ".TB_PRE."witkey_service where service_id=".$id."");
					PayitemClass::payPayitemOrder ( $orderId );
					$jumpUrl = 'index.php?do=pubgoods&id=' . $arrServcie ['model_id'] . '&step=step3&serviceId=' . $id ;
					header ( 'Location:' . $jumpUrl );
				}
				break;
			case 'order' :
				;
				break;
		}
	}
}
die ();

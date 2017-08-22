<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
$process_obj=match_report_class::get_instance($report_id,$report_info,$obj_info);
$report_info = $process_obj->_report_info;
$user_info = $process_obj->_user_info;
$to_userinfo  = $process_obj->_to_user_info;
$process_can = $process_obj->_process_can;
$credit_info = $process_obj->_credit_info;
$cash = $process_obj->_obj_info['cash']; 
$url = "index.php?do=trans&view=process&type=$type&report_id=$report_id";
$match_task = $process_obj->_match_task;
$match_work = $process_obj->_match_work;
if(!empty($op_result)){
	switch ($type) {
		case "rights":
			$res=$process_obj->process_rights($op_result,$type);
			break;
		case 'report':
			$res = $process_obj->process_report($op_result,$type);
		break;		
	}
}
require keke_tpl_class::template ( 'task/' . $model_info ['model_dir'] . "/admin/tpl/task_$view");
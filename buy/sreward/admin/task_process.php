<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
$process_obj=sreward_report_class::get_instance($report_id,$report_info,$obj_info,$user_info,$to_userinfo);
if(!empty($op_result)){
	switch ($type){
		case "rights":
			$res=$process_obj->process_rights($op_result,$type);
			break;
		case "report":
			$res=$process_obj->process_report($op_result,$type);
			break;
		case "complaint":
			break;
	}
}else{
	$gz_info  =$process_obj->user_role('gz');
	$wk_info  =$process_obj->user_role('wk');
	$process_can=$process_obj->_process_can;
}
require keke_tpl_class::template ( 'buy/' . $model_info ['model_code'] . '/admin/tpl/task_' . $view );
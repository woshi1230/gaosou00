<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
intval ( $task_id ) or kekezu::admin_show_msg ( $_lang ['param_error'], 'index.php?do=model&model_id=' . $model_id . '&view=list', 3, '', 'warning' );
$ops = array ('basic', 'work', 'comm');
in_array ( $op, $ops ) or $op = 'basic';
keke_lang_class::loadlang('task_edit','task');
if ($op == 'basic') { 
	$task_info = db_factory::get_one ( sprintf ( " select * from %switkey_task where task_id='%d'", TB_PRE, $task_id ) );
	$cash_rule_arr = kekezu::get_table_data ( "*", TB_PRE . "witkey_task_cash_cove", "", "", '', '', "cash_rule_id" );
	$task_sub_time = date('Y-m-d',$task_info['sub_time']);
	$task_end_time = date('Y-m-d',$task_info['end_time']);
	$task_start_time = date('Y-m-d',$task_info['start_time']);
	$task_info['ext_fields'] = CustomClass::getExtDataList($task_id, $task_info['model_id']);
	if ($sbt_edit) { 
		if($ext_fds){
			CustomClass::editExtData($task_id, $model_id, $ext_fds);
		}
		$task_obj = new Keke_witkey_task_class ();
		$task_obj->setWhere(" task_id =".$task_id);
		if($txt_task_day){
			$task_obj->setSub_time(strtotime($txt_task_day));
		}
		$task_obj->setTask_title (kekezu::escape($fields['task_title']) );
		$task_obj->setIndus_id ( $slt_indus_id );
		$task_obj->setTask_cash($fields['task_cash']);
		$task_obj->setTask_desc ($fields['task_desc'] );
		$task_obj->setSeo_title($fields['seo_title']);
		$task_obj->setSeo_keyword($fields['seo_keyword']);
		$task_obj->setSeo_desc($fields['seo_desc']);
		if($_FILES['fle_task_pic']['name']){
			$task_pic = keke_file_class::upload_file("fle_task_pic");
		}else{
			$task_pic = $task_pic_path;
		}
		$task_obj->setTask_pic($task_pic);
		kekezu::admin_system_log ( $_lang['edit_task'].":{$fields['task_title']}" );	
		$res=$task_obj->edit_keke_witkey_task ();
		$v_arr = array($_lang['admin_name']=>$myinfo_arr ['username'],$_lang['time']=>date('Y-m-d H:i:s',time()),$_lang['model_name']=>$model_info['model_name'],$_lang['task_id']=>$task_info ['task_id'],$_lang['task_title']=>$task_info ['task_title']);
		keke_msg_class::notify_user($task_info ['uid'],$task_info ['username'],'task_edit',$_lang['edit_task'],$v_arr,1);
	} elseif($sbt_act){
		switch ($sbt_act){
			case "freeze":
				$res=keke_task_config::task_freeze ( $task_id );
				break;
			case "unfreeze":
				$res=keke_task_config::task_unfreeze ( $task_id );
				break;
			case "pass":
				$res=keke_task_config::task_audit_pass ( array($task_id));
				break;
			case "nopass":
				$res=keke_task_config::task_audit_nopass ( $task_id );
				break;
				case "del" : 
					$res = keke_task_config::task_del($task_id);
					break;
		}
	}else {
		$process_arr = keke_task_config::can_operate ( $task_info ['task_status'],$task_info['is_top'] );
		$file_list = db_factory::query ( sprintf ( " select * from %switkey_file where task_id='%d'  and obj_type='task' ", TB_PRE, $task_id ) );
		$status_arr =  match_task_class::get_task_status ();
		$payitem_list=keke_payitem_class::get_payitem_config('employer');
		$indus_arr = $kekezu->_indus_arr;
		$temp_arr = array ();
		$indus_option_arr = $indus_arr;
		kekezu::get_tree ( $indus_option_arr, $temp_arr, "option", $task_info ['indus_id'] );
		$indus_option_arr = $temp_arr;
	}
	if($res){
		kekezu::admin_show_msg ( $_lang['task_operate_success'], "index.php?do=model&model_id=$model_id&view=list",3,'','success' );
	}
}else{
	require S_ROOT.'/task/'.$model_info ['model_dir'].'/admin/task_misc.php';
}
require $kekezu->_tpl_obj->template ( 'task/' . $model_info ['model_dir'] . '/admin/tpl/task_edit_'.$op );
<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
kekezu::admin_check_role ('m1222' );
$task_config = unserialize ( $model_info ['config'] );
$cash_rule_arr = kekezu::get_table_data ( "*", TB_PRE . "witkey_task_cash_cove", "", "", '', '', "cash_rule_id" );
$model_list = $kekezu->_model_list;
$task_status = match_task_class::get_task_status ();
$table_obj = keke_table_class::get_instance ( 'witkey_task' );
$page and $page=intval ( $page ) or $page = 1;
$page_size and $page_size=intval($page_size) or $page_size =10;
$wh = "model_id={$model_info['model_id']}";
if ($w ['task_id']) {
	$wh .= " and task_id = " . intval($w ['task_id']);
}
if ($w ['task_title']) {
	$wh .= ' and task_title like ' . '"%' . $w ['task_title'] . '%" ';
}
if ($w ['task_status']) {
	$wh .= " and task_status = " . $w ['task_status'];
}
$w ['task_status']==='0' and $wh .= " and task_status = 0" ;
$ord[0]&&$ord[1] and $wh .= " order by {$ord['0']} {$ord['1']}" or $wh .= " order by task_id desc ";
$url_str = "index.php?do=model&model_id=12&view=list&w[task_id]={$w['task_id']}&w[task_title]={$w['task_title']}&w[task_status]={$w['task_status']}&ord[0]={$ord['0']}&ord[1]={$ord['1']}&page=$page&page_size=$page_size";
$table_arr = $table_obj->get_grid ( $wh, $url_str, $page, $page_size, null, 1, 'ajax_dom');
$task_arr = $table_arr ['data'];
$pages = $table_arr ['pages'];
if($task_id){
	$task_audit_arr = get_task_info($task_id);
	$start_time = date("Y-m-d H:i:s",$task_audit_arr['start_time']);
	$end_time = date("Y-m-d H:i:s",$task_audit_arr['end_time']);
	$url = "<a href =\"{$_K['siteurl']}/index.php?do=task&id={$task_audit_arr['task_id']}\" target=\"_blank\" >" . $task_audit_arr['task_title']. "</a>";
}
	switch ($ac) {
		case "del" : 
			$res = keke_task_config::task_del($task_id);
			kekezu::admin_show_msg($_lang['operate_notice'],$url_str,2,$_lang['delete_success'],'success');
			break;
		case "pass" : 
			$res =keke_task_config::task_audit_pass ( $task_id );
			$arr=array();
			$arr['用户名']= $task_audit_arr['username'];
			$arr['网站名称']= $kekezu->_sys_config['website_name'];
			$arr['任务编号']="#".$task_id;
			keke_msg_class::notify_user($task_audit_arr['uid'], $task_audit_arr['username'], 'task_auth_success', '审核通过',$arr);
			kekezu::admin_show_msg($_lang['operate_notice'],$url_str,2,$_lang['audit_success'],'success');
			break;
		case "nopass" : 
			$res =keke_task_config::task_audit_nopass ( $task_id );
			keke_msg_class::send_private_message('审核不通过', '你发布的任务审核未通过', $task_audit_arr['uid'],$task_audit_arr['username']);
			kekezu::admin_show_msg($_lang['operate_notice'],$url_str,2,$_lang['operate_success'],'success');
			break;
		case "freeze" : 
			$res =keke_task_config::task_freeze ( $task_id );
			kekezu::admin_show_msg($_lang['operate_notice'],$url_str,2,$_lang['freeze_task_success'],'success');
			break;
		case "unfreeze" : 
			$res =keke_task_config::task_unfreeze ( $task_id );
			kekezu::admin_show_msg($_lang['operate_notice'],$url_str,2,$_lang['unfreeze_task_success'],'success');
			break;
	}
if ($sbt_action==$_lang['mulit_delete']&&!empty($ckb)) {
	keke_task_config::task_del($ckb);
	kekezu::admin_show_msg($_lang['operate_notice'],$url_str,2,$_lang['mulit_delete_success'],'success');
}
if ($sbt_action==$_lang['mulit_pass']&&!empty($ckb)) {
	keke_task_config::task_audit_pass($ckb);
	kekezu::admin_show_msg($_lang['operate_notice'],$url_str,2,$_lang['mulit_pass_success'],'success');
}
if ($sbt_action==$_lang['mulit_nopass']&&!empty($ckb)) {
	keke_task_config::task_audit_nopass($ckb);
	kekezu::admin_show_msg($_lang['operate_notice'],$url_str,2,$_lang['mulit_nopass_success'],'success');
}
if ($sbt_action==$_lang['mulit_freeze']&&!empty($ckb)) {
	keke_task_config::task_freeze($ckb);
	kekezu::admin_show_msg($_lang['operate_notice'],$url_str,2,$_lang['mulit_freeze_success'],'success');
}
if ($sbt_action==$_lang['mulit_unfreeze']&&!empty($ckb)) {
	keke_task_config::task_unfreeze($ckb);
	kekezu::admin_show_msg($_lang['operate_notice'],$url_str,2,$_lang['mulit_unfreeze_success'],'success');
}
function get_task_info($task_id){
	$task_obj = new Keke_witkey_task_class();
	$task_obj->setWhere("task_id = $task_id");
	$task_info = $task_obj->query_keke_witkey_task();
	$task_info = $task_info ['0'];
	return $task_info;
}
require $kekezu->_tpl_obj->template ( 'task/' . $model_info ['model_dir'] . '/admin/tpl/task_' . $view );
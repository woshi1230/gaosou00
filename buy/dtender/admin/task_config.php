<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
kekezu::admin_check_role ('m59' );
$ops = array ("config", "control", "priv","cash_rule");
in_array ( $op, $ops ) or $op = 'config';
$ac_url="index.php?do=model&model_id=$model_id&view=config&op=$op";
$config = $kekezu->_sys_config;
kekezu::empty_cache();
switch ($op) {
	case "config" : 
		if($sbt_edit){
			$model_obj=keke_table_class::get_instance("witkey_model");
			! empty ( $fds ['indus_bid'] ) and $fds['indus_bid'] = implode ( ",", $fds ['indus_bid'] ) or $fds['indus_bid'] = '';
			$fds['on_time']=time();
			$fds=kekezu::escape($fds);
			$res=$model_obj->save($fds,$pk);
			kekezu::admin_show_msg ($_lang['modified_success'],$ac_url, 3,'','success' );
			}else{
				$indus_arr = $kekezu->_indus_arr;
				$indus_index =kekezu::get_indus_by_index ();
			}
		break;
	case "control" : 
		if($sbt_edit){
			is_array($conf) and $res.=keke_task_config::set_task_ext_config($model_id,$conf);
			kekezu::admin_show_msg ($_lang['modified_success'],$ac_url, 3,'','success');
		}else{
			$confs = unserialize($model_info['config']);
			is_array($confs)&&extract($confs);
			$cash_cove = kekezu::get_cash_cove('dtender');
		}
		break;
	case "priv" : 
		if ($sbt_edit) {
			if ($fds ['allow_times']){
				$perm_item_obj = new Keke_witkey_priv_item_class ();
					foreach ( $fds ['allow_times'] as $k => $v ) {
						$perm_item_obj->setWhere ( " op_id = '$k'" );
						$perm_item_obj->setAllow_times ( intval ( $v ) );
						$perm_item_obj->edit_keke_witkey_priv_item ();
					}
			}
			kekezu::admin_show_msg ( $model_info['model_name'].$_lang['access_config_modified_success'], "$ac_url",'3','','success');
		} else {
			$perm_item = keke_privission_class::get_model_priv_item($model_id);
		}
		break;
	case "cash_rule":
		switch($ac){
			case "del":
				$res = db_factory::execute(sprintf(" delete from %switkey_task_cash_cove where cash_rule_id='%d'",TB_PRE,$rule_id));
				kekezu::admin_show_msg ($_lang['op_success'], "index.php?do=$do&model_id=$model_id&view=config&op=control", 3,'','success' );
				break;
			case "edit":
			case "add":
				if($sbt_edit){
					$fds['on_time']   = time();
					$fds['cove_desc'] = sprintf('%.2f',$fds['start_cove']).$_lang['y'].'-'.sprintf('%.2f',$fds['end_cove']).$_lang['y'];
					$fds['model_code']= $model_info['model_code'];
					if($ac=='edit'){
					$cove_obj = keke_table_class::get_instance("witkey_task_cash_cove");
					$res = $cove_obj->save($fds,$pk);
					}else{
						db_factory::execute("insert into ".TB_PRE."witkey_task_cash_cove(start_cove,end_cove,cove_desc,on_time,model_code) values('".$fds[start_cove]."','".$fds[end_cove]."','".$fds[cove_desc]."','".$fds[on_time]."','".$fds[model_code]."')");
					}
					kekezu::admin_show_msg ($_lang['op_success'], $ac_url.'&op=control', 3,'','success' );
				}else{
					$cash_cove = kekezu::get_cash_cove('dtender');
					$cove_info = $cash_cove[$rule_id];
					$cash_cove = end($cash_cove);
					$end   = intval($cash_cove['end_cove']);
					if($cove_info){
						$start_cove=intval($cove_info['start_cove']);
					}else{
						$start_cove=$end;
					}
					require keke_tpl_class::template('task/'.$model_info['model_dir'].'/admin/tpl/task_cove');
					die();
				}
				break;
		}
		break;
}
if($sbt_edit){
	$file_obj = new keke_file_class();
	$file_obj->delete_files(S_ROOT."./data/data_cache/");
	$log_op_arr = array("config"=>$_lang['basic_config'],"control"=>$_lang['control_config'],"priv"=>$_lang['private_config']);
	$log_msg = $_lang['modified_deposit_bidding_task'].$log_op_arr[$op];
	kekezu::admin_system_log($log_msg);
}
require keke_tpl_class::template ( 'task/' . $model_info ['model_dir'] . '/admin/tpl/task_' . $op );
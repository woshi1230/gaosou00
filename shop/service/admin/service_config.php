<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
$service_config = new shop_service_config_class();
kekezu::admin_check_role ('m715' );
$ops = array ("config", "control", "priv" );
in_array ( $op, $ops ) or $op = 'config';
$ac_url="index.php?do=model&model_id=$model_id&view=config&op=$op";
kekezu::empty_cache();
$indus_arr = $kekezu->_indus_arr; 
$indus_index = kekezu::get_indus_by_index (); 
$config = $service_config->get_service_ext_config();
if($sbt_edit){
	$log_op_arr = array("config"=>$_lang['goods_basic_config'],"control"=>$_lang['goods_flow_config'],"priv"=>$_lang['goods_perimission_config']);
	$log_msg = $_lang['has_update'].$log_op_arr[$op];
	kekezu::admin_system_log($log_msg);
	switch ($op) {
		case "config" : 
				$model_obj=keke_table_class::get_instance("witkey_model");
				! empty ( $fds['indus_bid'] ) and $fds ['indus_bid'] = implode ( ",", $fds['indus_bid'] ) or $fds ['indus_bid'] = '';
				$fds['on_time']=time();
				$fds[model_status] = $fds[model_status];
				$fds[model_desc] = $fds[model_desc];
				$fds[model_intro] = $fds[model_intro];
				$fds=kekezu::escape($fds);
				$res=$model_obj->save($fds,array("model_id"=>"7"));
				kekezu::admin_show_msg ( $_lang['update_success'],$ac_url, 3,'','success' );
			break;
		case "control" : 
			if($filepath){
				copy("../".$filepath,"../tpl/default/img/shop/shop_default_big.png");
			}
				if($overdue_type=='forever'){
					$conf['overdue_type']='forever';
				}elseif($overdue_type=='custom'){
					$conf['overdue_type']='custom';
					$time=time()+60*60*24*30;
					db_factory::execute("update ".TABLEPRE."witkey_service set exist_time='".$time."',overdue_type='custom' where overdue_type='forever'");
				}else{
					$conf['overdue_type']=$overdue_tian;
					$time=time()+60*60*24*(intval($overdue_tian));
					db_factory::execute("update ".TABLEPRE."witkey_service set exist_time='".$time."',overdue_type='".$overdue_tian."' where overdue_type='forever'");
				}
				is_array($conf) and $res = $service_config->set_service_ext_config($conf,$model_info[model_id]);
				kekezu::admin_show_msg ( $_lang['update_success'],$ac_url,3,'','success' );
		break;
		case "priv" : 
			if ($fds ['allow_times']){
				$perm_item_obj = new Keke_witkey_priv_item_class ();
					foreach ( $fds ['allow_times'] as $k => $v ) {
						$perm_item_obj->setWhere ( " op_id = '$k'" );
						$perm_item_obj->setAllow_times ( intval ( $v ) );
						$perm_item_obj->edit_keke_witkey_priv_item ();
					}
			}
			kekezu::admin_show_msg ( $model_info[model_name].$_lang['permissions_config_update_success'], "$ac_url",'3','','success');
			break;
	}
}
require keke_tpl_class::template ( 'shop/'.$model_info['model_dir'].'/admin/tpl/service_' . $view );
<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
$table_obj = keke_table_class::get_instance ( 'witkey_service' );
kekezu::admin_check_role ( 'm714' );
$service_obj = new service_shop_class ();
$status_arr = array (
		"1" => "待审核",
		"2" => "出售中",
		"3" => "已下架",
		"4" => "审核失败" 
);
$wh = "1=1";
$w [service_id] and $wh .= " and service_id= " . $w [service_id];
$w [title] and $wh .= " and title like '%$w[title]%'";
$w [username] and $wh .= " and username like '%$w[username]%' ";
if($w ['service_status'] == 'a1'){
	$wh .= " and edit_status= 1 ";	
}else{
	$w ['service_status'] and $wh .= " and service_status={$w ['service_status']}";
}
$wh .= " and model_id = 7";
intval ( $page ) or $page = 1;
intval ( $page_size ) and $page_size = intval ( $page_size ) or $page_size = '10';
$w [order_status] and $wh .= " and order_status like '%$w[order_status]%' ";
switch ($ord) {
	case 'id-desc':$wh .= " order by service_id desc";	break;
	case 'id-asc' :$wh .= " order by service_id asc" ;	break;
	case 'default':
	default:
		$wh .= " ORDER BY ( CASE service_status WHEN 1 THEN 0 ELSE 1 END ), ( CASE edit_status WHEN 1 THEN 0 ELSE 1 END ), on_time DESC ";
	break;
}
$url_str = "index.php?do=model&model_id=7&view=list&w[service_id]=$w[service_id]&w[service_status]=$w[service_status]&w[title]=$w[title]&w[username]=$w[username]&page=$page&page_size=$page_size";
$table_arr = $table_obj->get_grid ( $wh, $url_str, $page, $page_size, null, 1, 'ajax_dom' );
$service_arr = $table_arr ['data'];
foreach ( $service_arr as $k => $v ) {
	$service_arr [$k] ['edit_info'] = CommonClass::getEditLogInfoByLogTypeAndObjId ( $v ['service_id'], $v ['model_id'] );
}
$pages = $table_arr ['pages'];
if ($service_id) {
	$service_arr = db_factory::get_one ( sprintf ( "select * from %switkey_service where service_id='%d' ", TABLEPRE, $service_id ) );
	$log_ac_arr = array (
			"del" => $_lang ['delete'],
			"use" => $_lang ['use'],
			"pass" => $_lang ['audit'],
			"disable" => $_lang ['disable'] 
	);
	$log_msg = $_lang ['to_witkey_service_name_to'] . $service_arr [title] . $_lang ['in'] . $log_ac_arr [$ac] . $_lang ['operate'];
	kekezu::admin_system_log ( $log_msg );
	switch ($ac) {
		case 'del' :
			$res = keke_shop_class::service_del ( $service_id );
			kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['delete_success'], 'success' );
			break;
		case 'pass' :
		case 'shelves' : 
			$time = time () - $service_arr [on_time];
			keke_payitem_class::update_service_payitem_time ( $service_arr [payitem_time], $time, $service_id );
			$service_obj->service_pass ( $service_id );
			if($ac == 'pass'){
				$v_arr = array (
						'用户名' => $service_arr['username'],
						'作品标题' => $service_arr['title'],
						'网站名称' => $kekezu->_sys_config ['website_name']
				);
				keke_shop_class::notify_user ( $service_arr ['uid'], $service_arr['username'], 'zp_auth_success', "作品审核通过", $v_arr );
			}
			kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['service_audit_success'], 'success' );
			break;
		case 'nopass' : 
			if ($is_submit == "1") {
				$res = goods_shop_class::set_service_status ( $service_id, 4 );
				$res and PayitemClass::refundPayitem ( $service_id, 'goods' );
				$v_arr = array (
						'用户名' => $service_arr ['username'],
						'作品标题' => $service_arr ['title'],
						'网站名称' => $kekezu->_sys_config ['website_name'],
						"审核原因" => $reason 
				);
				keke_shop_class::notify_user ( $service_arr ['uid'], $service_arr ['username'], 'service_auth_fail', "服务审核失败", $v_arr );
				kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, '服务审核不通过成功', 'success' );
			} else {
				$strUsername = sreward_task_class::getUsername ( $service_arr ['uid'] );
				$strTittle = sreward_task_class::getSeverTitle ( $service_id );
				require keke_tpl_class::template ( 'shop/goods/admin/tpl/goods_tp' );
				die ();
			}
			break;
		case 'view_info' : 
			if ($acc) {
				if ($acc == 'spass') {
				    $arrLogInfo = CommonClass::getEditLogInfoByLogId($logId);
				    keke_shop_release_class::updateEditStatusBySid($service_id, 3);
				    $arrLogDatas = unserialize($arrLogInfo['log_content']);
				    if($arrLogDatas['custom']){
				        $arrCustom = array('custom'=>$arrLogDatas['custom']);
				        $strCustomSql = 'select a.id,a.extdata,b.f_name,b.f_tips,b.f_fixed_len,b.f_min_len,b.f_max_len,b.f_required,b.f_code from '.TABLEPRE.'witkey_custom_fields_ext a LEFT JOIN '.TABLEPRE.'witkey_custom_fields b ON a.c_id = b.id where a.objid = '.intval($service_id);
				        $arrCustomExt = db_factory::query($strCustomSql);
				        foreach($arrCustom['custom'] as $k=>$v){
				            foreach($arrCustomExt as $i=>$j){
				                if($j['id'] == $k){
				                    $arrExtdata = unserialize($j['extdata']);
				                    $arrExtdata[$j['f_code']]['content'] = $v;
				                    $strExtdata = serialize($arrExtdata);
				                    $strExtdataSql = "update ".TABLEPRE."witkey_custom_fields_ext set extdata = '$strExtdata' where id = ".intval($k);
				                    db_factory::execute($strExtdataSql);
				                }
				            }
				        }
				        unset($arrLogDatas['custom'],$arrLogDatas['old_custom']);
				    }
				    $arrLogInfo['log_content'] = $arrLogDatas;
					CommonClass::applyEdit ( $arrLogInfo, $service_id );
					CommonClass::cancleEdit ( $service_id, 7 );
					keke_shop_release_class::updateEditStatusBySid($service_id, 3);
					$arrServiceInfo = db_factory::get_one ( 'select * from ' . TABLEPRE . 'witkey_service where service_id = ' . intval ( $service_id ) );
					if ($arrServiceInfo ['service_status'] == '1') {
						$time = time () - $service_arr [on_time];
						keke_payitem_class::update_service_payitem_time ( $service_arr [payitem_time], $time, $service_id );
						$service_obj->service_pass ( $service_id );
					}
					keke_msg_class::send_private_message ( '服务审核通知', '您编辑的商品信息<a href="index.php?do=goods&id=' . $service_id . '">' . $arrServiceInfo ['title'] . '</a>已通过管理员审核，目前已生效！', $arrServiceInfo ['uid'], $arrServiceInfo ['username'] );
				}
				if ($acc == 'snopass') {
					CommonClass::cancleEdit ( $service_id, 7 );
					keke_shop_release_class::updateEditStatusBySid($service_id, 4);
					keke_msg_class::send_private_message ( '服务审核通知', '您编辑的商品信息<a href="index.php?do=goods&id=' . $service_id . '">' . $arrServiceInfo ['title'] . '</a>未通过管理员的审核，如有疑问请联系网站管理员！', $arrServiceInfo ['uid'], $arrServiceInfo ['username'] );
				}
				kekezu::echojson ( '操作成功', 1 );
			} else {
				$editInfo = CommonClass::getEditLogInfoByLogTypeAndObjId ( $service_id, 7 );
				$arrTopIndustrys = $kekezu->_indus_goods_arr;
				$arrIndustrys = CommonClass::getIndustryByPid ( $editInfo ['log_content_data'] ['indus_pid'] );
				$arrOldImageLists = CommonClass::getFileArrayByPath ( ',', $editInfo ['log_content_data'] ['old_pic'] );
				$arrImageLists = CommonClass::getFileArrayByPath ( ',', $editInfo ['log_content_data'] ['pic'] );
				$arrOldFileLists = CommonClass::getFileArrayByPath ( ',', $editInfo ['log_content_data'] ['old_file_path'] );
				$arrFileLists = CommonClass::getFileArrayByPath ( ',', $editInfo ['log_content_data'] ['file_path'] );
				require keke_tpl_class::template ( 'shop/service/admin/tpl/service_updateinfo' );
				die ();
			}
			break;
		case 'off_shelf' : 
			if ($is_submit == "1") {
				$serviceInfo = db_factory::get_one ( "select * from " . TABLEPRE . "witkey_service where service_id=" . intval ( $service_id ) );
				keke_msg_class::send_private_message ( '商品下架', '您的商品<a href="index.php?do=goods&id=' . $service_id . '">' . $arrServiceInfo ['title'] . '</a>被管理员下架，下架原因:' . $reason, $serviceInfo ['uid'], $serviceInfo ['username'] );
				goods_shop_class::set_service_status ( $service_id, 3 );
				kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['goods_disable_success'], 'success' );
			} else {
				require keke_tpl_class::template ( 'shop/' . $model_info ['model_dir'] . '/admin/tpl/service_reason' );
				die ();
			}
			break;
	}
}
if ($sbt_action) {
	$keyids = $ckb;
	if (is_array ( $keyids )) {
		$log_mac_arr = array (
				"more_del" => $_lang ['mulit_delete'],
				"more_use" => $_lang ['mulit_use'],
				"more_pass" => $_lang ['mulit_pass'],
				"disable" => $_lang ['mulit_disable'] 
		);
		$log_msg = $_lang ['to_witkey_service_has_in'] . $log_mac_arr [$sbt_action] . $_lang ['operate'];
		kekezu::admin_system_log ( $log_msg );
		switch ($sbt_action) {
			case $_lang ['mulit_delete'] : 
				$res = keke_shop_class::service_del ( $keyids );
				kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['mulit_delete_success'], 'success' );
				break;
			case $_lang ['mulit_pass'] :
				foreach ( $keyids as $v ) {
					$service_info = kekezu::get_table_data ( "*", "witkey_service", "service_id = $v" );
					$service_info = $service_info ['0'];
					$add_time = time () - $service_info ['on_time'];
					keke_payitem_class::update_service_payitem_time ( $service_info ['payitem_time'], $add_time, $v );
				}
				$res = goods_shop_class::set_service_status ( $keyids, 2 );
				$action = $_lang ['mulit_pass'];
				break;
			case $_lang ['mulit_nopass'] :
				$res = goods_shop_class::set_service_status ( $keyids, 4 );
				foreach ( $keyids as $v ) {
					PayitemClass::refundPayitem ( $v, 'goods' );
				}
				$action = '批量审核不通过';
				break;
			case $_lang ['batch_shelves'] : 
				foreach ( $keyids as $v ) {
					$service_info = kekezu::get_table_data ( "*", "witkey_service", "service_id = $v" );
					$service_info = $service_info [0];
					$add_time = time () - $service_info [on_time];
					keke_payitem_class::update_service_payitem_time ( $service_info [payitem_time], $add_time, $v );
				}
				$service_obj->service_pass ( $keyids ) and kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['mulit_pass_success'], 'success' );
				break;
			case $_lang ['batch_off_the_shelf'] : 
				$service_obj->service_down ( $keyids ) and kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['mulit_use_success'], 'success' );
				break;
		}
	}
}
require keke_tpl_class::template ( 'shop/' . $model_info ['model_dir'] . '/admin/tpl/service_' . $view );
<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
kekezu::admin_check_role ( 'm611' );
$table_obj = keke_table_class::get_instance ( 'witkey_service' );
$indus_p_arr = $kekezu->_indus_p_arr;
$goods_status_arr = goods_shop_class::get_goods_status ();
$status_arr = array (
		"1" => "待审核",
		"2" => "出售中",
		"3" => "已下架",
		"4" => "审核失败" 
);
$wh = "model_id = 6";
$w ['service_id'] and $wh .= " and service_id= " . $w ['service_id'];
$w ['title'] and $wh .= " and title like '%$w[title]%'";
$w ['username'] and $wh .= " and username like '%$w[username]%' ";
if($w ['service_status'] == 'a1'){
	$wh .= " and edit_status= 1 ";	
}else{
	$w ['service_status'] and $wh .= " and service_status={$w ['service_status']}";
}
switch ($ord) {
	case 'id-desc':$wh .= " order by service_id desc";	break;
	case 'id-asc' :$wh .= " order by service_id asc" ;	break;
	case 'default':
	default:
		$wh .= " ORDER BY ( CASE service_status WHEN 1 THEN 0 ELSE 1 END ), ( CASE edit_status WHEN 1 THEN 0 ELSE 1 END ), on_time DESC";
	break;
}
intval ( $page ) or $page = 1;
intval ( $size ) or $size = 10;
$url_str = "index.php?do=model&model_id=6&view=list&w[service_id]={$w['service_id']}&w[service_status]={$w['service_status']}&w[username]={$w['username']}&w[title]={$w['title']}&ord[0]={$ord['0']}&ord[1]=$ord[1]&page=$page&size={$size}";
$table_arr = $table_obj->get_grid ( $wh, $url_str, $page, $size, null, 1, 'ajax_dom' );
$goods_arr = $table_arr ['data'];
foreach ( $goods_arr as $k => $v ) {
	$goods_arr [$k] ['edit_info'] = CommonClass::getEditLogInfoByLogTypeAndObjId ( $v ['service_id'], $v ['model_id'] );
}
$pages = $table_arr ['pages'];
if ($ac) {
	$service_arr = db_factory::get_one ( sprintf ( "select * from %switkey_service where service_id='%d' ", TABLEPRE, $service_id ) );
	$log_ac_arr = array (
			"del" => $_lang ['delete'],
			"use" => $_lang ['open'],
			"disable" => $_lang ['disable'],
			"pass" => $_lang ['pass_audit'] 
	);
	$log_msg = $_lang ['to_witkey_goods_name_is'] . $service_arr ['title'] . $_lang ['conduct'] . $log_ac_arr [$ac] . $_lang ['operate'];
	kekezu::admin_system_log ( $log_msg );
	switch ($ac) {
		case 'del' :
			goods_shop_class::set_on_sale_num ( $service_id, - 1 );
			$res = keke_shop_class::service_del ( $service_id );
			$res and kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['delete_success'], 'success' ) or kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['delete'] . $_lang ['fail'], 'warning' );
			break;
		case 'pass' : 
		case 'shelves' : 
			$time = time () - $service_arr ['on_time'];
			keke_payitem_class::update_service_payitem_time ( $service_arr ['payitem_time'], $time, $service_id );
			$service_info = db_factory::get_one ( sprintf ( "select * from %switkey_service where service_id=%d", TABLEPRE, $service_id ) );
			goods_shop_class::set_service_status ( $service_id, 2 );
			if($ac == 'pass'){
				$v_arr = array (
						'用户名' => $service_arr['username'],
						'作品标题' => $service_arr['title'],
						'网站名称' => $kekezu->_sys_config ['website_name']
				);
				keke_shop_class::notify_user ( $service_arr ['uid'], $service_arr['username'], 'zp_auth_success', "作品审核通过", $v_arr );
			}
			kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['goods_open_success'], 'success' );
			break;
		case 'nopass' : 
			if ($is_submit == "1") {
				$res = goods_shop_class::set_service_status ( $service_id, 4 );
				$res and PayitemClass::refundPayitem ( $service_id, 'goods' );
				$v_arr = array (
						'用户名' => $service_arr['username'],
						'作品标题' => $service_arr['title'],
						'网站名称' => $kekezu->_sys_config ['website_name'],
						"审核原因" => $reason 
				);
				keke_shop_class::notify_user ( $service_arr ['uid'], $service_arr['username'], 'zp_auth_fail', "作品审核失败", $v_arr );
				kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, '作品审核不通过成功', 'success' );
			} else {
				$strUsername = sreward_task_class::getUsername ( $_GET ['uid'] );
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
					CommonClass::cancleEdit ( $service_id, 6 );
					$arrServiceInfo = db_factory::get_one ( 'select * from ' . TABLEPRE . 'witkey_service where service_id = ' . intval ( $service_id ) );
					if ($arrServiceInfo ['service_status'] == '1') {
						$time = time () - $service_arr ['on_time'];
						keke_payitem_class::update_service_payitem_time ( $service_arr ['payitem_time'], $time, $service_id );
						goods_shop_class::set_service_status ( $service_id, 2 );
					}
					keke_msg_class::send_private_message ( '服务审核通知', '您编辑的商品信息<a href="index.php?do=goods&id=' . $service_id . '">' . $arrServiceInfo ['title'] . '</a>已通过管理员审核，目前已生效！', $arrServiceInfo ['uid'], $arrServiceInfo ['username'] );
				}
				if ($acc == 'snopass') {
					CommonClass::cancleEdit ( $service_id, 6 );
					keke_shop_release_class::updateEditStatusBySid($service_id, 4);
					keke_msg_class::send_private_message ( '服务审核通知', '您编辑的商品信息<a href="index.php?do=goods&id=' . $service_id . '">' . $arrServiceInfo ['title'] . '</a>未通过管理员的审核，如有疑问请联系网站管理员！', $arrServiceInfo ['uid'], $arrServiceInfo ['username'] );
				}
				kekezu::echojson ( '操作成功', 1 );
			} else {
				$editInfo = CommonClass::getEditLogInfoByLogTypeAndObjId ( $service_id, 6 );
				$arrTopIndustrys = $kekezu->_indus_goods_arr;
				$arrIndustrys = CommonClass::getIndustryByPid ( $editInfo ['log_content_data'] ['indus_pid'] );
				$arrOldImageLists = CommonClass::getFileArrayByPath ( ',', $editInfo ['log_content_data'] ['old_pic'] );
				$arrImageLists = CommonClass::getFileArrayByPath ( ',', $editInfo ['log_content_data'] ['pic'] );
				$arrOldFileLists = CommonClass::getFileArrayByPath ( ',', $editInfo ['log_content_data'] ['old_file_path'] );
				$arrFileLists = CommonClass::getFileArrayByPath ( ',', $editInfo ['log_content_data'] ['file_path'] );
				require keke_tpl_class::template ( 'shop/goods/admin/tpl/goods_updateinfo' );
				die ();
			}
			break;
		case 'off_shelf' : 
			if ($is_submit == "1") {
				$serviceInfo = db_factory::get_one ( "select * from " . TABLEPRE . "witkey_service where service_id=" . intval ( $service_id ) );
				$objMsgM = new Keke_witkey_msg_class ();
				$objMsgM->setTo_uid ( $serviceInfo ['uid'] );
				$objMsgM->setTo_username ( $serviceInfo ['username'] );
				$objMsgM->setTitle ( "商品下架" );
				$objMsgM->setContent ( kekezu::str_filter ( kekezu::escape ( "您的商品 " . $serviceInfo [title] . " 被管理员下架，下架原因：$reason" ) ) );
				$objMsgM->setOn_time ( time () );
				$objMsgM->setType ( 2 );
				$objMsgM->create_keke_witkey_msg ();
				goods_shop_class::set_service_status ( $service_id, 3 );
				kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, '商品下架成功', 'success' );
			} else {
				require keke_tpl_class::template ( 'shop/' . $model_info ['model_dir'] . '/admin/tpl/goods_reason' );
				die ();
			}
			break;
	}
}
if (isset ( $sbt_action )) {
	$key_ids = $ckb;
	if (is_array ( $key_ids )) {
		$action = "aa";
		$log_mac_arr = array (
				"del" => $_lang ['delete'],
				"user" => $_lang ['open'],
				"pass" => $_lang ['pass'],
				"disable" => $_lang ['disable'] 
		);
		$log_msg = $_lang ['to_witkey_goods_conduct_mulit'] . $log_mac_arr [$sbt_action] . $_lang ['operate'];
		kekezu::admin_system_log ( $log_msg );
		switch ($sbt_action) {
			case $_lang ['mulit_delete'] :
				$res = keke_shop_class::service_del ( $key_ids );
				$action = $_lang ['delete'];
				break;
			case $_lang ['mulit_pass'] :
				foreach ( $key_ids as $v ) {
					$service_info = kekezu::get_table_data ( "*", "witkey_service", "service_id = $v" );
					$service_info = $service_info ['0'];
					$add_time = time () - $service_info ['on_time'];
					keke_payitem_class::update_service_payitem_time ( $service_info ['payitem_time'], $add_time, $v );
				}
				$res = goods_shop_class::set_service_status ( $key_ids, 2 );
				$action = $_lang ['mulit_pass'];
				break;
			case $_lang ['mulit_nopass'] :
				$res = goods_shop_class::set_service_status ( $key_ids, 4 );
				foreach ( $key_ids as $v ) {
					PayitemClass::refundPayitem ( $v, 'goods' );
				}
				$action = '批量审核不通过';
				break;
			case $_lang ['batch_shelves'] :
				foreach ( $key_ids as $v ) {
					$service_info = kekezu::get_table_data ( "*", "witkey_service", "service_id = $v" );
					$service_info = $service_info ['0'];
					$add_time = time () - $service_info ['on_time'];
					keke_payitem_class::update_service_payitem_time ( $service_info ['payitem_time'], $add_time, $v );
				}
				$res = goods_shop_class::set_service_status ( $key_ids, 2 );
				$action = $_lang ['shelves'];
				break;
			case $_lang ['batch_off_the_shelf'] :
				$res = goods_shop_class::set_service_status ( $key_ids, 3 );
				$action = $_lang ['off_the_shelf'];
				break;
		}
		$res and kekezu::admin_show_msg ( $_lang ['mulit'] . $action . $_lang ['success'], $url_str, 2, $_lang ['mulit'] . $action . $_lang ['success'], 'success' ) or kekezu::admin_show_msg ( $_lang ['mulit'] . $action . $_lang ['fail'], $url_str, 2, $_lang ['mulit'] . $action . $_lang ['fail'], "warning" );
	}
}
require keke_tpl_class::template ( 'shop/' . $model_info ['model_dir'] . '/admin/tpl/goods_' . $view );
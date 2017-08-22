<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
kekezu::admin_check_role ('m713' );
$table_obj = keke_table_class::get_instance('witkey_order');
$service_obj = new service_shop_class();
$arrStatus = $service_obj->get_order_status();
$wh = "1=1";
$w[order_id] and $wh .= " and order_id like '%$w[order_id]%' ";
$w[order_username] and $wh.=" and order_username like '%$w[order_username]%' ";
$wh.=" and model_id = 7 and seller_uid > 0";
intval ( $page ) or $page = 1;
intval ( $w[page_size] ) and $page_size = intval ( $w[page_size] ) or $page_size = '10';
$w[order_status] and $wh.=" and order_status like '%$w[order_status]%' ";
$ord[0]&&$ord[1] and  $wh .=' order by '.$ord[0].' '.$ord[1] or $wh.=" order by order_time desc";
$url_str = "index.php?do=model&model_id=7&view=order&w[order_id]=$w[order_id]&w[order_username]=$w[order_username]&w[order_status]=$w[order_status]&page=$page&page_size=$page_size";
$table_arr = $table_obj->get_grid ( $wh, $url_str, $page, $page_size, null , 1, 'ajax_dom');
$order_arr = $table_arr['data'];
$pages = $table_arr['pages'];
if($ac=="del"){
	$order_obj = new Keke_witkey_order_class();
    $order_obj->setWhere("order_id = $order_id");
    $order_obj->del_keke_witkey_order();
	kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['delete_success'], 'success' );
}
if(isset ( $sbt_action )){
    $order_obj = new Keke_witkey_order_class();
    sizeof ( $ckb ) or kekezu::admin_show_msg ( $_lang['choose_operate_item'], $url,3,'','warning' );
    is_array ( $ckb ) and $ids = implode ( ',', array_filter ( $ckb ) );
    $order_obj->setWhere ( "order_id in ($ids)" );
    if($sbt_action){
        $res = $order_obj->del_keke_witkey_order();
        kekezu::admin_system_log ( $_lang['mulit_recovery_articles'] );
    }
    $res and kekezu::admin_show_msg ( $_lang['mulit_operate_success'], $url,3,'','success' ) or kekezu::admin_show_msg ( $_lang['mulit_operate_fail'], $url,3,'','warning' );
}
require keke_tpl_class::template ( 'shop/' . $model_info ['model_dir'] . '/admin/tpl/service_' . $view );
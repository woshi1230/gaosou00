<?php
defined ( 'ADMIN_KEKE' ) or exit ( 'Access Denied' );
kekezu::admin_check_role ('m610' );
$order_obj = keke_table_class::get_instance ( 'witkey_order' ); 
$goods_obj = keke_table_class::get_instance ( 'witkey_service' ); 
$order_status_arr = goods_shop_class::get_order_status ();
$wh = "model_id = 6 and seller_uid>0";
$w ['order_id'] and $wh .= " and order_id like '%$w[order_id]%' ";
$w ['order_username'] and $wh .= " and order_username like '%$w[order_username]%' ";
$w ['order_status'] and $wh .= " and order_status = '$w[order_status]' ";
$ord ['0'] && $ord ['1'] and $wh .= ' order by ' . $ord ['0'] . ' ' . $ord ['1'] or $wh .= " order by order_time desc";
intval ( $page ) or $page = 1;
intval ( $w ['page_size'] ) and $page_size = intval ( $w ['page_size'] ) or $page_size = '10';
$url_str = "index.php?do=model&model_id=6&view=order&w[order_id]={$w['order_id']}&w[order_username]={$w['order_username']}&w[order_status]={$w['order_status']}&page=$page&w[page_size]=$page_size&ord[0]=$ord[0]&ord[1]=$ord[1]";
$table_arr = $order_obj->get_grid ( $wh, $url_str, $page, $page_size, null, 1, 'ajax_dom' );
$order_arr = $table_arr ['data'];
$pages = $table_arr ['pages'];
switch ($ac) {
	case 'del' :
	    $order_obj = new Keke_witkey_order_class();
	    $order_obj->setWhere("order_id = $order_id");
	    $order_obj->del_keke_witkey_order();
		kekezu::admin_show_msg ( $_lang ['operate_notice'], $url_str, 2, $_lang ['delete_success'], 'success' );
		break;
	case 'confirm':
		$obj = new goods_shop_class();
		$obj->dispose_order($order_id, 'confirm','sys',$url_str,$_SESSION['uid']);
		break;
}
if (isset ( $sbt_action )) {
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
function get_submit_method($order_id) {
	$s_info = db_factory::get_one ( sprintf ( "SELECT s.submit_method,d.obj_id,o.order_id
		FROM `%switkey_service` s
		LEFT JOIN `%switkey_order_detail` d
		ON s.service_id = d.obj_id
		LEFT JOIN `%switkey_order` o
		ON d.order_id = o.order_id WHERE o.order_id = '%d'", TABLEPRE, TABLEPRE, TABLEPRE, $order_id ) );
	return $s_info['submit_method'];
}
require keke_tpl_class::template ( 'shop/' . $model_info ['model_dir'] . '/admin/tpl/goods_' . $view );
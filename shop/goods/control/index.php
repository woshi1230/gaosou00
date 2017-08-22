<?php
$regionCfg =  keke_glob_class::getRegionConfig();  
$arrDistrictInfo=db_factory::get_one("select * from ".TABLEPRE."witkey_service where service_id=".intval($id));
$province = CommonClass::getDistrictById($arrDistrictInfo['province']);    
$city = CommonClass::getDistrictById($arrDistrictInfo['city']);  
$area = CommonClass::getDistrictById($arrDistrictInfo['area']);  
$intSellerGoodsNum = db_factory::get_count ( sprintf ( "select count(service_id) from %switkey_service where model_id=6 and uid=%d and service_status=2", TABLEPRE, $arrOwnerInfo ['uid'] ) );
$intFavorite = db_factory::get_count ( sprintf ( 'select count(*) from %s where uid = %d and obj_id = %d and keep_type = "service"', TABLEPRE . 'witkey_favorite', intval ( $gUid ), intval ( $arrServiceInfo ['service_id'] ) ) );
if ($type == "get") {
	$arrResult1 = keke_user_class::get_user_info ( $uid );
	$objFavorite = keke_table_class::get_instance ( 'witkey_favorite' );
	$arrFields = array (
			'keep_type' => $obj_type,
			'obj_type' => $do,
			'origin_id' => $service_id,
			'obj_id' => $service_id,
			'obj_name' => $arrServiceInfo ['title'],
			'uid' => $uid,
			'username' => $gUsername,
			'on_date' => time ()
	);
	$intResult = $objFavorite->save ( $arrFields );
	die ();
}
if ($type == "getno") {
	$sql1 = "DELETE FROM ".TABLEPRE."witkey_favorite WHERE obj_id =" . $service_id . ' and uid=' . $uid;
	$sql1 .= " and obj_type='" . $do . "'";
	db_factory::query ( $sql1 );
	die ();
}
$intFollow = db_factory::get_count ( sprintf ( 'select count(*) from %s where uid = %d and fuid = %d', TABLEPRE . 'witkey_free_follow', intval ( $gUid ), intval ( $arrServiceInfo ['uid'] ) ) );
if ($gUid && $gUid !== $arrServiceInfo ['uid']) {
	$myOrderInfo = db_factory::get_one ( "select a.order_status from " . TABLEPRE . "witkey_order a left join " . TABLEPRE . "witkey_order_detail b on a.order_id=b.order_id where b.obj_type='service' and b.obj_id=$id and a.order_uid=$gUid" );
}
$page and $intPage = intval ( $page );
intval ( $intPage ) and $p ['page'] = intval ( $intPage ) or $p ['page'] = '1';
intval ( $intPagesize ) and $p ['page_size'] = intval ( $intPagesize ) or $p ['page_size'] = 10;
$objTime = new goods_time_class ();
$objTime->validtaskstatus ();
switch ($view) {
	case "content" :
		break;
	case "sale" :
		$arrStatus = goods_shop_class::get_order_status (); 
		$p ['url'] = $strUrl . "&view=sale&intPagesize=" . $p ['page_size'] . "&intPage=" . $p ['page'];
		$p ['anchor'] = '#pageT';
		$w = array ();
		$w ['a.order_status'] = "confirm";
		$t == 'today' and $ext_condit = 'day(date(from_unixtime(a.order_time)))=day(curdate())';
		$arrSaleArr = keke_shop_class::get_sale_info ( $intId, $w, $p, " a.order_time desc", $ext_condit );
		$arrSaleList = $arrSaleArr ['sale_info'];
		$intCount = count ( $arrSaleList );
		$pages = $arrSaleArr ['pages'];
		break;
	case "comment" :
		$objComment = keke_comment_class::get_instance ( 'service' );
		$arrCommentDatas = $objComment->get_comment_list ( $intId, $strUrl, $intPage );
		$arrCommentLists = $arrCommentDatas ['data'];
		$strPage = $arrCommentDatas ['pages'];
		$arrReplyLists = $objComment->get_reply_info ( $id );
		break;
	case "mark" :
		$arrMarkCount = keke_shop_class::get_mark_count ( $model_code, $sid ); 
		$p ['url'] = $strUrl . "&view=mark&intPagesize=" . $p ['page_size'] . "&intPage=" . $p ['page'];
		$p ['anchor'] = '#pageT';
		$w ['model_code'] = $arrModelInfo ['model_code']; 
		$w ['origin_id'] = $intId; 
		$w ['mark_status'] = $st; 
		$w ['mark_type'] = $ut; 
		$arrMark = keke_user_mark_class::get_mark_info ( $w, $p, ' mark_id desc ', 'mark_status>0' );
		$arrMarkInfo = $arrMark ['mark_info'];
		if (is_array ( $arrMarkInfo )) {
			foreach ( $arrMarkInfo as $k => $v ) {
				$arrMarkInfo [$k] ['aidinfo'] = keke_user_mark_class::get_user_aid ( $v ['by_uid'], $v ['mark_type'], $v ['mark_status'], 2, $v ['model_code'], $v ['obj_id'] );
			}
		}
		$pages = $arrMark ['pages'];
		break;
	default :
		break;
}
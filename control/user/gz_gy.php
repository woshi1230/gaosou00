<?php
$strUrl ="index.php?do=user&view=gz&op=gy";
$intPage and $strUrl .="&intPage=".intval($intPage);
$o and $strUrl .="&o=".intval($o);
$id and $strUrl .="&id=".intval($id);
$s and $strUrl .="&s=".strval($s);
$wkname and $strUrl .="&wkname=".strval($wkname);
$arrStatus = service_shop_class::get_order_status();
$arrListOrder = array(
		'1' =>'编号降序',
		'2' =>'编号升序',
		'3' =>'金额降序',
		'4' =>'金额升序',
);
	$page and $intPage = intval($page);
	$intPage = intval ( $intPage ) ? $intPage : 1;
	$intPagesize = 10;
	$strWhere  = " and  b.obj_type ='gy' and  c.order_uid= ".$gUid;
	if($id){
		$strWhere .= " and a.id=".intval($id);
	}
	if($wkname){
		$strWhere .= " and c.seller_username like '%".kekezu::escape($wkname)."%'";
	}
	if(isset($s)&&$s!=''&&$s>-1&&in_array($s, array_keys($arrStatus))){
		$strWhere .= " and c.order_status ='".strval($s)."'";
	}else{
		$s = -1;
	}
	switch ($o) {
		case '1':	$strWhere .= " order by c.order_id desc";	break;
		case '2':	$strWhere .= " order by c.order_id asc";	break;
		case '3':	$strWhere .= " order by a.price desc";	break;
		case '4':	$strWhere .= " order by a.price asc";	break;
		default:	$strWhere .= " order by c.order_time desc";	break;
	}
	$strSql.= 'SELECT a.id,a.price,c.order_id,c.order_uid,c.order_username,c.seller_uid,c.seller_username,c.order_status,c.order_time FROM `'.TB_PRE.'witkey_service_order` as a
			LEFT JOIN '.TB_PRE.'witkey_order_detail as b ON a.order_id = b.order_id
			LEFT JOIN '.TB_PRE.'witkey_order as c ON a.order_id = c.order_id
			WHERE 1=1 '.$strWhere;
	$arrDatas  = db_factory::query($strSql);
	$arrPageArr = $kekezu->_page_obj->page_by_arr($arrDatas, $intPagesize, $intPage, $strUrl);
	$arrLists = $arrPageArr ['data'];
	$strPages = $arrPageArr ['page'];

<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
$strUrl = "index.php?do=user&view=focus&op=attention";
$objFollowT = keke_table_class::get_instance('witkey_free_follow');
$strWhere = " 1 = 1 ";
$strWhere.= " and f.uid = ".$uid;
if(isset($action)&&$action ==='cancelFocus'){
    if ($intFollowUid) {
		$objFollowT->del ( 'follow_id', intval ($intFollowUid) );
		kekezu::show_msg ( '删除成功', $strUrl, NULL, NULL, 'ok' );
	} else {
		kekezu::show_msg ( '删除失败', NULL, NULL, NULL, 'error' );
	}
}else{
	$page and $intPage = intval($page);
	$intPage = intval ( $intPage ) ? $intPage : 1;
	$intPagesize = intval ( $intPagesize ) ? $intPagesize : 10;
	$strSql  = 'select f.*,s.uid focus_uid,s.username focus_username,s.seller_level,s.skill_ids  from '.TB_PRE.'witkey_free_follow as f' ;
	$strSql.= ' left join yw_company as s on f.fuid = s.userid where '.$strWhere;
	$strSql.= ' order by f.on_time desc ';
	$arrDatas = db_factory::query($strSql);
	$arrPageArr = $kekezu->_page_obj->page_by_arr($arrDatas, $intPagesize, $intPage, $strUrl);
	$arrFollowLists = $arrPageArr ['data'];
	if(is_array($arrFollowLists)){
		foreach($arrFollowLists as $k=>$v){
             $arrFocusData = CommonClass::getMemberFocus($v['focus_uid']);
             $arrFollowLists[$k]['data'] = $arrFocusData;
             $arrShopInfo = CommonClass::getShopInfo($v['focus_uid']);
             $arrFollowLists[$k]['shop_slogans'] = $arrShopInfo['shop_slogans'];
		}
	}
	$strPages = $arrPageArr ['page'];
}

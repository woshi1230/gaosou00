<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
$strUrl = "index.php?do=user&view=focus&op=each";
$objFollowT = keke_table_class::get_instance('witkey_free_follow');
$strWhere = " 1 = 1 ";
$strWhere.=" and a.fuid =  b.uid and a.uid =".$uid;
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
	$strSql  = 'select a.*,b.*,s.uid focus_uid,s.username focus_username,s.seller_level ,s.skill_ids from '.TB_PRE.'witkey_free_follow as a';
	$strSql.= ' left join  '.TB_PRE.'witkey_free_follow as b on a.uid = b.fuid';
	$strSql.= ' left join yw_company as s on a.fuid = s.userid where '.$strWhere;
	$strSql.=  ' order by a.on_time desc ';
	$arrDatas = db_factory::query($strSql);
	$arrPageArr = $kekezu->_page_obj->page_by_arr($arrDatas, $intPagesize, $intPage, $strUrl);
	$arrEachLists = $arrPageArr ['data'];
	if(is_array($arrEachLists)){
		foreach($arrEachLists as $k=>$v){
			$arrFocusData = CommonClass::getMemberFocus($v['focus_uid']);
			$arrEachLists[$k]['data'] = $arrFocusData;
			$arrShopInfo = CommonClass::getShopInfo($v['focus_uid']);
			$arrEachLists[$k]['shop_slogans'] = $arrShopInfo['shop_slogans'];
		}
	}
	$strPages = $arrPageArr ['page'];
}

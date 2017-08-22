<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
$objMsgT = keke_table_class::get_instance ( 'witkey_msg' );
$strUrl = 'index.php?do=user&view=message&op=private';
$intPage and $strUrl .= '&intPage=' . $intPage;
$intPagesize and $strUrl .= '&intPagesize=' . $intPagesize;
$s and $strUrl .= '&s=' . intval($s);
$arrStatus = MsgClass::getMsgReadStatus();
$searchStatus = MsgClass::getMsgSearchStatus();
if (isset ( $action )) {
	switch ($action) {
		case 'mulitDel' :
			if (is_array ( $ckb )) {
				foreach ( $ckb as $v ) {
					list ( $intMsgId, $intStatus ) = explode ( ',', $v );
					if (intval($intStatus) == 0) {
						db_factory::execute ( "update " . TB_PRE . "witkey_msg set msg_status=2 where msg_id = ".intval($intMsgId) );
					} else {
						$objMsgT->del ( 'msg_id', intval($intMsgId) );
					}
				}
				kekezu::show_msg ( '删除成功', $strUrl, NULL, NULL, 'ok' );
			} else {
				kekezu::show_msg ( '删除失败', NULL, NULL, NULL, 'error' );
			}
			break;
		case 'delSingle' :
			if ($objId) {
				if (intval($msgStatus) == 0) {
					db_factory::execute ( "update " . TB_PRE . "witkey_msg set msg_status=2 where msg_id = " . intval ( $objId ) );
				} else {
					$objMsgT->del ( 'msg_id', intval ( $objId ) );
				}
				kekezu::show_msg ( '删除成功', $strUrl, NULL, NULL, 'ok' );
			} else {
				kekezu::show_msg ( '删除失败', NULL, NULL, NULL, 'error' );
			}
			break;
		case 'mulitView' :
			if (is_array ( $ckb )) {
				foreach ( $ckb as $v ) {
					list ( $intMsgId, $intStatus ) = explode ( ',', $v );
					db_factory::execute ( "update " . TB_PRE . "witkey_msg set view_status=1 where msg_id = " . intval ( $intMsgId ) );
				}
			} else {
				kekezu::show_msg ( '设置失败', NULL, NULL, NULL, 'error' );
			}
			kekezu::show_msg ( '设置成功', $strUrl, NULL, NULL, 'ok' );
			break;
	}
} else {
	$strWhere = " msg_status<>2 and to_uid = " . intval ( $gUid ) . " and uid>0 ";
	if($s =='2'){
		$strWhere.=" and view_status = 0";
	}elseif($s =='1'){
		$strWhere.=" and view_status = ". intval($s) ;
	}
	$page and $intPage = intval ( $page );
	$intPage = intval ( $intPage ) ? $intPage : 1;
	$intPagesize = intval ( $intPagesize ) ? $intPagesize : 10;
	$strWhere .= " order by msg_id desc";
	$arrDatas = $objMsgT->get_grid ( $strWhere, $strUrl, $intPage, $intPagesize, null, null, null );
	$arrMessageLists = $arrDatas ['data'];
	$strPages = $arrDatas ['pages'];
}
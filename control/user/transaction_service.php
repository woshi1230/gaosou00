<?php
keke_shop_release_class::checkShopStatus($uid,'index.php?do=user&view=shop&op=setting');
$intModelId&&in_array($intModelId, array(6,7)) and $intModelId = intval($intModelId) or $intModelId =0;
$strUrl ="index.php?do=user&view=transaction&op=service";
$intModelId and $strUrl .="&intModelId=".intval($intModelId);
$intPage and $strUrl .="&intPage=".intval($intPage);
$strOrder and $strUrl .="&strOrder=".strval($strOrder);
$strTitle and $strUrl .="&strTitle=".strval($strTitle);
$arrListOrder = array(
		'service_id desc' =>'编号降序',
		'service_id asc' =>'编号升序'
);
if($intModelId){
    $strModelName = $kekezu->_model_list[$intModelId]['model_code'];
    $arrStatus = call_user_func ( array ($strModelName.'_shop_class', 'get_'.$strModelName.'_status') );
}else{
    $strModelName = $kekezu->_model_list[6]['model_code'];
    $arrStatus = call_user_func ( array ($strModelName.'_shop_class', 'get_'.$strModelName.'_status') );
}
$objServiceT = keke_table_class::get_instance('witkey_service');
$serInfo = db_factory::get_one("select * from ".TB_PRE."witkey_service where service_id =".intval($objId));
if (isset ( $action )) {
	switch ($action) {
		case 'grounding':
			db_factory::execute("update ".TB_PRE."witkey_service set service_status=1 where service_id=".intval($objId));
			kekezu::show_msg ( '请等待管理员审核，该商品重新变成待审核状态，等待管理员审核', $strUrl, NULL, NULL, 'ok' );
			break;
		case 'undercarriage':
			db_factory::execute("update ".TB_PRE."witkey_service set service_status=3 where service_id=".intval($objId));
			kekezu::show_msg ( '操作成功', $strUrl, NULL, NULL, 'ok' );
			break;
		case 'mulitDel' :
			if ($ckb) {
				foreach ($ckb as $k =>$v){
					$serInfo = db_factory::get_one("select * from ".TB_PRE."witkey_service where service_id =".intval($v));
					if($serInfo){
						CommonClass::cancleEdit($v,$serInfo['model_id']);
						$objServiceT->del ( 'service_id', intval($v) );
					}
				}
				kekezu::show_msg ( '删除成功', $strUrl, NULL, NULL, 'ok' );
			} else {
				kekezu::show_msg ( '删除失败', NULL, NULL, NULL, 'error' );
			}
			break;
		case 'delSingle' :
			if ($serInfo) {
				CommonClass::cancleEdit($objId,$serInfo['model_id']);
				$objServiceT->del ( 'service_id', intval($objId) );
				kekezu::show_msg ( '删除成功', $strUrl, NULL, NULL, 'ok' );
			} else {
				kekezu::show_msg ( '删除失败', NULL, NULL, NULL, 'error' );
			}
			break;
		case 'cancel_editSingle' :
			if ($serInfo) {
				CommonClass::cancleEdit($objId,$serInfo['model_id']);
				keke_shop_release_class::updateEditStatusBySid($objId, 2);
				kekezu::show_msg ( '撤销成功', $strUrl, NULL, NULL, 'ok' );
			} else {
				kekezu::show_msg ( '撤销失败', NULL, NULL, NULL, 'error' );
			}
			break;
	}
} else {
$strWhere  = " 1=1 ";
$strWhere  .= " and uid= ".$gUid;
$intModelId and $strWhere  .= " and model_id = ".$intModelId;
	$page and $intPage = intval($page);
	$intPage = intval ( $intPage ) ? $intPage : 1;
	$intPagesize = 10;
	$intId and $strWhere .= " and service_id=".intval($intId);
	$strTitle and $strWhere .= " and title like '%".trim($strTitle)."%' ";
	$strOrder&&in_array($strOrder, array_keys($arrListOrder)) and $strWhere .= " order by ".$strOrder or  $strWhere .= " order by service_id desc";
	$arrDatas = $objServiceT->get_grid ( $strWhere, $strUrl, $intPage, $intPagesize, null,null,null);
	$arrLists = $arrDatas ['data'];
	foreach ($arrLists as $k=>$v){
		$arrLists[$k]['edit_info'] = CommonClass::getEditLogInfoByLogTypeAndObjId($v['service_id'], $v['model_id']);
	}
	$strPages = $arrDatas ['pages'];
}
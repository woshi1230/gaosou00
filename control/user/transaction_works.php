<?php
$strUrl ="index.php?do=user&view=transaction&op=works";
$intModelId and $strUrl .="&intModelId=".intval($intModelId);
$intPage and $strUrl .="&intPage=".intval($intPage);
$strOrder and $strUrl .="&strOrder=".strval($strOrder);
if (isset ( $action )) {
	switch ($action) {
		case 'delSingle' :
			if ($objId&&$intTaskId) {
				$strWorkSql = ' UPDATE `'.TB_PRE.'witkey_task_work` SET `hasdel`=1 WHERE (`work_id`='.intval($objId).')  and task_id = '.intval($intTaskId);
				db_factory::execute($strWorkSql);
				kekezu::show_msg ( '删除成功', $strUrl, NULL, NULL, 'ok' );
			} else {
				kekezu::show_msg ( '删除失败', NULL, NULL, NULL, 'error' );
			}
			break;
	}
} else {
	$strWhere  = " 1=1 ";
	$strWhere  .= " and a.uid= ".$gUid;
	$strWhere  .= " and a.hasdel != 1 ";
	$page and $intPage = intval($page);
	$intPage = intval ( $intPage ) ? $intPage : 1;
	$intPagesize = 10;
	if($intId){
		$strWhereWork = " and work_id=".intval($intId);
	}
	$strUnionSql = ' SELECT uid, work_id id,task_id,work_time ontime,work_status as status,work_file as file FROM '.TB_PRE.'witkey_task_work where uid='.$gUid.'
             union all
             SELECT uid, bid_id id,task_id,bid_time ontime,bid_status as status,hasdel as file FROM '.TB_PRE.'witkey_task_bid where uid='.$gUid;
	$strUnionSql.= '  ORDER BY ontime DESC ';
	$arrDatas  = db_factory::query($strUnionSql);
	$arrPageArr = $kekezu->_page_obj->page_by_arr($arrDatas, $intPagesize, $intPage, $strUrl);
	$arrLists = $arrPageArr ['data'];
	if(is_array($arrLists)){
	    foreach($arrLists as $k=>$v){
	        $arrTaskInfo = db_factory::get_one("select * from ".TB_PRE."witkey_task where task_id=".intval($v['task_id']));
	        if($arrTaskInfo){
	            $arrLists[$k]['task_title'] = $arrTaskInfo['task_title'];
	            $arrLists[$k]['model_id'] = $arrTaskInfo['model_id'];
	            $arrLists[$k]['task_status'] = $arrTaskInfo['task_status'];
	        }else{
	            unset($arrLists[$k]);
	        }
	    }
	}
	$strPages = $arrPageArr ['page'];
}

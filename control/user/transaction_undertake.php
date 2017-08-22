<?php
$intModelId and $intModelId = intval($intModelId) or $intModelId =0;
$strUrl ="index.php?do=user&view=transaction&op=undertake";
$intModelId and $strUrl .="&intModelId=".intval($intModelId);
$strTaskTitle and $strUrl .="&strTaskTitle=".strval($strTaskTitle);
$intTaskStatus and $strUrl .="&intTaskStatus=".intval($intTaskStatus);
$strOrder and $strUrl .="&strOrder=".strval($strOrder);
if (isset ( $action )) {
	$intWorkId = intval ( $objId );
	if ($intWorkId) {
		switch ($action) {
			case "delWork" :
				if($worktype=='bid'){
					$strTabName = "witkey_task_bid";
					$strId = "bid_id";
				}else{
					$strTabName = "witkey_task_work";
					$strId = "work_id";
				}
				$res = db_factory::execute ( sprintf ( " delete from %s".$strTabName." where $strId='%d'", TB_PRE, $intWorkId ) );
				db_factory::execute ( sprintf ( ' delete from %comment where item_id=%d and obj_type="work"', TB_PRE, $intWorkId ) );
				keke_file_class::del_obj_file ( $intWorkId, 'work', true );
				if($res){
					kekezu::show_msg ( '删除成功', $strUrl, NULL, NULL, 'ok' );
				}else{
					kekezu::show_msg ( '删除失败', NULL, NULL, NULL, 'error' );
				}
				break;
		}
	} else {
		kekezu::show_msg ( '删除失败', NULL, NULL, NULL, 'error' );
	}
}
$arrTaskNavs = TaskClass::getEnabledTaskModelList();
$arrListOrder = array(
		'a.task_id desc' =>'编号降序',
		'a.task_id asc' =>'编号升序',
		'b.task_cash desc' =>'金额降序',
		'b.task_cash asc' =>'金额升序'
);
$arrCashCoves = TaskClass::getTaskCashCove();
if($intModelId){
	$arrTaskStatus = call_user_func ( array ($arrTaskNavs[$intModelId]['model_code'] . "_task_class", "get_task_status" ) );;
    $model_info = $model_list [$intModelId];
    switch ($model_info ['model_code']) {
    	case "sreward" :
    	case "mreward" :
    	case "preward" :
    	case "wbzf" :
    	case "wbdj" :
    	case "match" :
    	case "taobao" :
    		$tab_name = "witkey_task_work";
    		$time_fds = "work_time";
    		$id_fds = "work_id";
    		$satus_fds = "work_status";
    		break;
    	case "dtender" :
    	case "tender" :
    		$tab_name = "witkey_task_bid";
    		$time_fds = "bid_time";
    		$id_fds = "bid_id";
    		$satus_fds = "bid_status";
    		break;
    }
$strSql = " select a.$satus_fds,a.$time_fds,a.$id_fds,b.task_id,b.task_cash,b.task_title,b.model_id,b.task_cash_coverage,b.task_status,b.start_time from " . TB_PRE . $tab_name . " a left join " . TB_PRE . "witkey_task b on a .task_id=b.task_id where b.model_id = '$intModelId' and a.uid='$uid'";
$strCountSql = "select a.$id_fds from " . TB_PRE . $tab_name . " a left join " . TB_PRE . "witkey_task b on a .task_id=b.task_id where a.uid='$uid'";
$intModelId and $strCountSql.=" and b.model_id = '$intModelId'";
	$page and $intPage = intval($page);
	$intPage = intval ( $intPage ) ? $intPage : 1;
	$intPagesize = 10;
	$intTaskId and $strWhere .= " and a.task_id=".intval($intTaskId);
	$strTaskTitle and $strWhere .= " and b.task_title like '%".trim($strTaskTitle)."%' ";
	if(isset($intTaskStatus)&&$intTaskStatus!=''&&$intTaskStatus > -1){
		$strWhere .= " and b.task_status=".intval($intTaskStatus);
	}else{
		$intTaskStatus = -1;
	}
	in_array($strOrder, array_keys($arrListOrder))  and $strWhere .= " order by ".$strOrder or  $strWhere .= " order by b.task_id desc";
	$intCount = intval ( db_factory::execute ( $strCountSql . $strWhere ) );
	$strPages = $page_obj->getPages ( $intCount, $intPagesize, $intPage, $strUrl );
	$arrTaskLists = db_factory::query ( $strSql . $strWhere . $strPages ['where'] );
}else{
    $arrTaskStatus = array(
        'W0'=>'未付款',  
        '1'=>'待审核',
        'A2'=>'投稿中',
        'T2'=>'投标中',
        'D2'=>'竞标中',
        'A3'=>'任务选稿',
        'T3'=>'选标中',
        'S4'=>'发起投票',
        'T4'=>'工作中',
        'D4'=>'待托管',
        'B5'=>'公示中',
        'C6'=>'交付中',
        '7'=>'冻结中',
        '8'=>'结束',
        '9'=>'失败',
        '10'=>'审核失败',
        'C11'=>'仲裁中',
        '11'=>'仲裁中',
        'S13'=>'交付冻结'
    );
    $arrListOrder = array(
        'task_id desc' =>'编号降序',
        'task_id asc' =>'编号升序',
        'task_cash desc' =>'金额降序',
        'task_cash asc' =>'金额升序'
    );
    $page and $intPage = intval($page);
    $intPage = intval ( $intPage ) ? $intPage : 1;
    $intPagesize = 10;
    $intTaskId&&$intTaskId!='' and $strWhere = " and task_id=".intval($intTaskId);
    $strTaskTitle and $strWhere .= " and task_title like '%".trim($strTaskTitle)."%' ";
    if($intTaskStatus){
    	if(is_numeric($intTaskStatus) && $intTaskStatus !='-1'){
    		$strWhere .= " and task_status=".intval($intTaskStatus);
    	}else{
    		$sPrefix = substr($intTaskStatus, 0,1);
    		$sValue = substr($intTaskStatus, 1);
    		switch ($sPrefix) {
    			case 'A':$strWhere .= " and task_status=".intval($sValue).' and model_id in(1,2,3)';break;
    			case 'B':$strWhere .= " and task_status=".intval($sValue).' and model_id in(1,2)';break;
    			case 'C':$strWhere .= " and task_status=".intval($sValue).' and model_id in(1,5)';break;
    			case 'D':$strWhere .= " and task_status=".intval($sValue).' and model_id=4';break;
    			case 'T':$strWhere .= " and task_status=".intval($sValue).' and model_id=5';break;
    			case 'S':$strWhere .= " and task_status=".intval($sValue).' and model_id =1 ';break;
    			case 'W':$strWhere .= " and task_status=0 ";break;
    			default:$intTaskStatus = -1;break;
    		}
    	}
    }else{
		$intTaskStatus = -1;
	}
	$strSql = "SELECT task_id, model_id, task_title, task_cash, task_cash_coverage, start_time, task_status FROM `"
			.TB_PRE."witkey_task` WHERE (task_id IN ( SELECT task_id FROM "
			.TB_PRE."witkey_task_bid WHERE uid = ".$gUid." ) OR task_id IN ( SELECT task_id FROM "
			.TB_PRE."witkey_task_work WHERE uid = ".$gUid." ) )";
	$strCountSql = "SELECT count(*) count FROM `"
			.TB_PRE."witkey_task` WHERE ( task_id IN ( SELECT task_id FROM "
			.TB_PRE."witkey_task_bid WHERE uid = ".$gUid." ) OR task_id IN ( SELECT task_id FROM "
			.TB_PRE."witkey_task_work WHERE uid = ".$gUid." ) )";
	in_array($strOrder, array_keys($arrListOrder)) and $strWhere .= " order by ".$strOrder or  $strWhere .= " order by task_id desc";
	$intCount = intval ( db_factory::get_count( $strCountSql . $strWhere ) );
	$strPages = $page_obj->getPages ( $intCount, $intPagesize, $intPage, $strUrl );
	$arrTaskLists = db_factory::query ( $strSql . $strWhere . $strPages ['where'] );
	if($arrTaskLists){
		foreach ($arrTaskLists as $k=>$v){
			if(in_array($v['model_id'], array('4','5'))){
				$bidInfo = db_factory::get_one("SELECT bid_id FROM ".TB_PRE."witkey_task_bid WHERE uid = ".$gUid."  and task_id = ".$v['task_id']." ORDER BY bid_id DESC LIMIT 1");
				$arrTaskLists[$k]['bid_id'] = $bidInfo['bid_id'];
			}else{
				$bidInfo = db_factory::get_one("SELECT work_id FROM ".TB_PRE."witkey_task_work WHERE uid = ".$gUid."  and task_id = ".$v['task_id']." ORDER BY work_id DESC LIMIT 1");
				$arrTaskLists[$k]['work_id'] = $bidInfo['work_id'];
			}
		}
	}
}
function wiki_opera($m_id, $t_id, $w_id, $url) {
	global $kekezu;
	$button = array ();
	$model_code = $kekezu->_model_list [$m_id] ['model_code'];
	$c = $model_code . '_task_class';
	if ($model_code && method_exists ( $c, 'wiki_opera' )) {
		$button = call_user_func_array ( array ($c, 'wiki_opera' ), array ($m_id, $t_id, $w_id, $url ) );
	} else { 
		$button = call_user_func_array ( array ('sreward_task_class', 'wiki_opera' ), array ($m_id, $t_id, $w_id, $url ) );
	}
	return $button;
}
unset($objTaskT);

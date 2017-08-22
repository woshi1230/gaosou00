<?php
$regionCfg =  keke_glob_class::getRegionConfig();  
$arrDistrictInfo=db_factory::get_one("select * from ".TB_PRE."witkey_task where task_id=".intval($id));
$province = CommonClass::getDistrictById($arrDistrictInfo['province']);    
$city = CommonClass::getDistrictById($arrDistrictInfo['city']);  
$area = CommonClass::getDistrictById($arrDistrictInfo['area']);  
$objTask = tender_task_class::get_instance ( $arrTaskInfo );
$arrTaskInfo= $objTask->_task_info;
$objTask->plus_view_num();
$arrTaskFiles = $objTask->get_task_file ();
$arrTimeDesc = $objTask->get_task_timedesc ();
$arrProjectProgress = $objTask->getProjectProgressDesc();
$arrProcess_can = $objTask->process_can ();
$arrWorkStatus = $objTask->get_work_status ();
if (strtoupper ( CHARSET ) == 'GBK') {
	$arrWorkStatus = kekezu::gbktoutf($arrWorkStatus );
}
$jsonWorkStatus = json_encode($arrWorkStatus);
if($arrTaskInfo['task_pic']){
	$arrTaskPics = explode(',',$arrTaskInfo['task_pic']);
}
$arrTaskWorkInfo=db_factory::get_one("select * from ".TB_PRE."witkey_task_bid as a left join yw_company as b on a.uid=b.userid where bid_status=4 and task_id=".intval($id));
if($arrTaskWorkInfo){
$intDeals=TaskClass::getWikiDealbyUid($arrTaskWorkInfo['uid']);
}
$arrPayitemShow = $objTask->getPayitemShow();
$arrCoverCash = kekezu::get_cash_cove ( '', true );
$objTenderTime = new tender_time_class();
$objTenderTime->validtaskstatus();
$Exitworker=db_factory::get_one("select * from ".TB_PRE."witkey_task_bid where task_id = ".$arrTaskInfo['task_id']." and uid=".$gUid);
switch ($view){
	case "work":
		$s === null and $s = 1 or $s = intval($s);
		$arrSearchStatus =  array();
		$arrSearchStatus['1'] = '所有的';
		$arrSearchStatus['2'] 	= '未浏览的';
		$arrSearchStatus['4']	= '中标的';
		$arrSearchStatus['7'] 	= '淘汰的';
		$arrUid = db_factory::get_one("select uid from ".TB_PRE."witkey_task where task_id = '$id'");
		if($gUid != $arrUid['uid']){
		    $arrSearchStatus['9'] = '我的';
		}
		$page and $page = intval($page);
		intval ( $page ) and $p ['page'] = intval ( $page ) or $p ['page']='1';
		intval ( $pagesize ) and $p ['page_size'] = intval ( $pagesize ) or $p['page_size']=10;
		$p['url'] = $strUrl."&view=work&pagesize=".$p ['page_size']."&page=".$p ['page'];
		if($s){
			$p['url'] .="&s=".$s;
		}
		$w['bid_status'] = $s;
		$arrWorkArrs= $objTask->getWorkInfo($w, $p ); 
		$strPages = $arrWorkArrs ['pages'];
		$arrWorkInfo = $arrWorkArrs ['work_info'];
		$arrMark     = $arrWorkArrs['mark'];
//        if(is_array($arrWorkInfo)){
//			foreach ($arrWorkInfo as $k=>$v) {
//				$arrFavorite = db_factory::get_count(sprintf('select count(*) from %s where uid = %d and obj_id = %d and origin_id = %d and keep_type = "work"',TB_PRE.'witkey_favorite',intval($gUid),intval($v['work_id']),intval($arrTaskInfo['task_id'])));
//				if($arrFavorite){
//					$arrWorkInfo[$k]['favorite'] = true;
//				}
//				unset($arrFavorite);
//			}
//		}
		break;
	case 'comment':
		$objComment = yw_comment_class::get_instance('task');
		$strUrl .= "&view=comment";
		$arrCommentDatas = $objComment->get_comment_list($id, $strUrl, $page);
		$arrCommentLists = $arrCommentDatas['data'];
		$strPage = $arrCommentDatas['pages'];
		$arrReplyLists = $objComment->get_reply_info($id);
	    break;
}
function getTaskBid($taskid,$uid){
	$task_bid=db_factory::get_one("select * from ".TB_PRE."witkey_task_bid where task_id='".intval($taskid)."' and uid='".intval($uid)."'");
	return $task_bid;
}
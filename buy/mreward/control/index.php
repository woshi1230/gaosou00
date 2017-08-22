<?php
$regionCfg =  keke_glob_class::getRegionConfig();  
$arrDistrictInfo=db_factory::get_one("select * from ".TB_PRE."witkey_task where task_id=".intval($id));
$province = CommonClass::getDistrictById($arrDistrictInfo['province']);    
$city = CommonClass::getDistrictById($arrDistrictInfo['city']);  
$area = CommonClass::getDistrictById($arrDistrictInfo['area']);  
$page and $page = intval($page) ;
$page = intval ( $page ) ? $page : 1;
$pagesize = intval ( $pagesize ) ? $pagesize : 10;
$objTask = mreward_task_class::get_instance ( $arrTaskInfo );
$arrTaskInfo= $objTask->_task_info;
if($arrTaskInfo['task_pic']){
	$arrTaskPics = explode(',',$arrTaskInfo['task_pic']);
}
$arrWorkPrize = $objTask->get_work_prize();
$arrTaskPrize = $objTask->get_task_prize();
$objTask->plus_view_num();
$arPrizeWorkDate = $objTask->get_prize_work_count();
$arrTaskFiles = $objTask->get_task_file ();
$arrWorkStatus = $objTask->get_work_status ();
if (strtoupper ( CHARSET ) == 'GBK') {
	$arrWorkStatus = kekezu::gbktoutf($arrWorkStatus );
}
$jsonWorkStatus = json_encode($arrWorkStatus);
$arrPayitemShow = $objTask->getPayitemShow();
$jsonWorkStatus = json_encode($arrWorkStatus);
$arrProcess_can = $objTask->process_can ();
$arrProjectProgress = $objTask->getProjectProgressDesc();
$objTime = new mreward_time_class();
$objTime->validtaskstatus();
$prizeDesc = $objTask->getPrizeDesc();
$Exitworker=db_factory::get_one("select * from ".TB_PRE."witkey_task_work where task_id = ".$arrTaskInfo['task_id']." and uid=".$gUid);
switch ($view){
	case "work":
	    $arrUid = db_factory::get_one("select uid from ".TB_PRE."witkey_task where task_id = '$id'");
		intval ( $page ) and $p ['page'] = intval ( $page ) or $p ['page']='1';
		intval ( $pagesize ) and $p ['page_size'] = intval ( $pagesize ) or $p['page_size']=10;
		$p['url'] = $strUrl."&view=work&pagesize=".$p ['page_size']."&page=".$p ['page'];
		if($st){
			$p['url'] .="&st=".$st;
		}
		if($ut){
			$p['url'] .="&ut=".$ut;
		}
		$w['work_status'] = $st;
		$w['work_type']   = $ut;
		$arrWorkArrs= $objTask->get_work_info ($w, $p ); 
		$strPages = $arrWorkArrs ['pages'];
		$arrWorkInfo = $arrWorkArrs ['work_info'];
		$arrMark     = $arrWorkArrs['mark'];
		break;
	case 'comment':
		$objComment = yw_comment_class::get_instance('task');
		$strUrl .= "&view=comment";
		$arrCommentDatas = $objComment->get_comment_list($id, $strUrl, $page);
		$arrCommentLists = $arrCommentDatas['data'];
		$strPage = $arrCommentDatas['pages'];
		$arrReplyLists = $objComment->get_reply_info($id);
	break;
	case "mark":
		$p['page']      = $page;
		$p['page_size'] = $pagesize;
	$p['url'] = $strUrl."&view=".$view."&page=".$p['page']."&pagesize=".$p['page_size'].="&s=".$s;
	$p ['anchor'] = '#detail';
	$w['model_code'] = $arrModelInfo ['model_code'];
	$w['origin_id']   = $id;
	in_array($s, array(1,2,3)) and $w['mark_status'] = $s;
	$s == 101 and $w['mark_type'] =   2;
	$s == 102 and $w['mark_type'] =   1;
	$arrMarks = keke_user_mark_class::get_mark_info($w,$p,' mark_id desc ',"mark_status>0");
	$arrMarkInfo = $arrMarks['mark_info'];
	if(is_array($arrMarkInfo)){
		$arrMarkLists = array();
		foreach($arrMarkInfo as $k=>$v){
			$arrMarkLists[$k] = $v;
			$arrAidInfos = keke_user_mark_class::get_user_aid ( $v['uid'], $v['mark_type'], $v['mark_status'], 1, null, $v['obj_id'] );
			$arrMarkLists[$k]['aid'] = $arrAidInfos;
		}
	}
	$strPages     = $arrMarks['pages'];
}
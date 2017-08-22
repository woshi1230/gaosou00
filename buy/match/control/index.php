<?php
$regionCfg =  keke_glob_class::getRegionConfig();  
$arrDistrictInfo=db_factory::get_one("select * from ".TB_PRE."witkey_task where task_id=".intval($id));
$province = CommonClass::getDistrictById($arrDistrictInfo['province']);    
$city = CommonClass::getDistrictById($arrDistrictInfo['city']);  
$area = CommonClass::getDistrictById($arrDistrictInfo['area']);  
$page and $page = intval($page) ;
$page = intval ( $page ) ? $page : 1;
$pagesize = intval ( $pagesize ) ? $pagesize : 10;
$p['page']      = $page;
$p['page_size'] = $pagesize;
$p['url'] = $strUrl."&view=".$view."&page=".$p['page']."&pagesize=".$p['page_size'].="&s=".$s;
$p['anchor'] = '#detail';
$objTask = match_task_class::get_instance ( $arrTaskInfo );
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
$arrPayitemShow = $objTask->getPayitemShow();
$intGuid      = $arrTaskInfo['uid'];
$arrGinfo = $objTask->_g_userinfo;
$arrBidInfo = $objTask->work_exists (); 
$intWuid      = intval($arrBidInfo['uid']);
$intWuid and $arrWinfo = kekezu::get_user_info($intWuid);
$arrCoverCash = kekezu::get_cash_cove ( '', true );
$objMatchTime = new match_time_class();
$objMatchTime->validtaskstatus();
if($arrTaskInfo['task_status']==11 || $arrTaskInfo['task_status']==7){
	$frontStatus = keke_report_class::getFrontStatus($arrTaskInfo['task_id']);
	if($arrTaskInfo['task_status']==7){
	    $frontStatus=6;
	}
}
if ($arrBidInfo['work_file']){
	$arrFileLists = CommonClass::getFileArray('|', $arrBidInfo['work_file']);
}
switch ($view){
	case "work":
		$s === null and $s = 1 or $s = intval($s);
		$arrSearchStatus =  array();
		$arrSearchStatus['1'] = '所有的';
		$arrSearchStatus['4']	= '中标的';
		$arrSearchStatus['7'] 	= '淘汰的';
		$arrSearchStatus['9'] 	= '放弃的';
		$arrUid = db_factory::get_one("select uid from ".TB_PRE."witkey_task where task_id = '$id'");
		if($gUid != $arrUid['uid']){
		    $arrSearchStatus['11'] = '我的';
		}
		$page and $page = intval($page);
		intval ( $page ) and $p ['page'] = intval ( $page ) or $p ['page']='1';
		intval ( $pagesize ) and $p ['page_size'] = intval ( $pagesize ) or $p['page_size']=10;
		$p['url'] = $strUrl."&view=work&pagesize=".$p ['page_size']."&page=".$p ['page'];
		if($s){
			$p['url'] .="&s=".$s;
		}
		$w['work_status'] = $s;
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
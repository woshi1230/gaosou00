<?php
$stdCacheName = 'task_cache_'.$id.'_' . substr ( md5 ( $gUid ), 0, 6 );
$objRelease = match_release_class::get_instance ($id,$pub_mode);
$arrConfig = $objRelease->_task_config;
$objRelease->get_task_obj ( $stdCacheName ); 
$regionCfg =  keke_glob_class::getRegionConfig();
$objRelease->pub_mode_init( $stdCacheName,$init_info);
$arrPubInfo = $objRelease->_std_obj->_release_info; 
//$userInfo=db_factory::get_one("select * from yw_company where userid=".intval($gUid));
$arrCashCove = $objRelease->_cash_cove;
if ($arrPubInfo['indus_pid']) {
	$arrIndus_pid = CommonClass::getIndustryBrother($arrPubInfo['indus_pid'], 'catid,parentid,catname');
	$arrIndus_id = CommonClass::getIndustryByPid($arrPubInfo['indus_pid'], 'catid,parentid,catname');
	if ($arrPubInfo['indus_id']) {
		$arrIndus_sid = CommonClass::getIndustryByPid($arrPubInfo['indus_id'], 'catid,parentid,catname');
	}
} else {
	$arrIndus_pid = CommonClass::getIndustryByPid($arrPubInfo['fid'], 'catid,parentid,catname');
}
$arrPubInfo['province'] and $arrCities = CommonClass::getDistrictByPid($arrPubInfo['province'],'areaid,parentid,areaname');
$arrPubInfo['city'] and $arrAreas = CommonClass::getDistrictByPid($arrPubInfo['city'],'areaid,parentid,areaname');
switch ($step) {
	case 'step1':
		$intTaskCove = intval($task_cash_cove);
		$intMinDay = time()+ $arrConfig['min_day']*3600*24;
		$strMinDate = date('Y-m-d',$intMinDay);
		$intMaxDay = time()+ 24*3600*$arrConfig['max_day'];
		$strMaxDay = date('Y-m-d',$intMaxDay);
		$strDate = $arrPubInfo['txt_task_day']?$arrPubInfo['txt_task_day']:$strMaxDay;
		$intCover = $arrPubInfo['task_cash_cove']?$arrPubInfo['task_cash_cove']:0;
		if (isset($formhash)&&kekezu::submitcheck($formhash)) {
			$strEndDate = strval(trim($txt_task_day));
			$intTime = date('H',time())*3600+date('i',time())*60+date('s',time());
			$intEndDate = strtotime($strEndDate)+$intTime;
			$strText = $objRelease->check_pub_priv('','json');
			if($strText !== true){
				kekezu::show_msg($strText,NULL,NULL,NULL,'fail');
			}
			if ($intTaskCove <= 0) {
				$tips['errors']['txt_task_cash'] = '请选择您的预算';
				kekezu::show_msg($tips,NULL,NULL,NULL,'error');
			}
			if (($intEndDate < $intMinDay)||($intEndDate > $intMaxDay)) {
				$tips['errors']['txt_task_day'] = '当前预算允许最小天数为:'.intval($arrConfig['min_day']).'天,最大截止时间：'.$strMaxDay;
				kekezu::show_msg($tips,NULL,NULL,NULL,'error');
			}
			$arrPubInfo and $_POST = array_merge ( $arrPubInfo, $_POST );
			$objRelease->save_task_obj ( $_POST, $stdCacheName ); 
			kekezu::show_msg($tips,$strUrl.'&step=step2',NULL,NULL,'ok');
		}
		break;
	case 'step2':
		if (isset($formhash)&&kekezu::submitcheck($formhash)) {
			if($_POST) $_POST = dstripslashes($_POST);
			if (strtoupper ( CHARSET ) == 'GBK') {
				$_POST = kekezu::utftogbk($_POST );
			}
			if($_POST['province'] == 'p'){
				$tips['errors']['province'] = '请选择省份';
				kekezu::show_msg($tips,null,null,null,'error');
			}
//			$_POST['tar_content'] = kekezu::escape($_POST['tar_content']);
			$_POST['tar_content'] = dsafe(addslashes(stripslashes($_POST['tar_content'])));
			if (!$_POST['tar_content']) {
				$tips['errors']['tar_content'] = '请输入需求描述';
				kekezu::show_msg($tips,NULL,NULL,NULL,'error');
			}
			$arrPubInfo and $_POST = array_merge ( $arrPubInfo, $_POST);
			$objRelease->save_task_obj ($_POST, $stdCacheName ); 
//			kekezu::show_msg($tips,$strUrl.'&step=step3',NULL,NULL,'ok');
			header ( 'Location:' . $strUrl.'&step=step3' );
			die();
		}else{
			!$_SESSION[$stdCacheName] and kekezu::show_msg($_lang ['friendly_notice'],"index.php?do=pubtask&id=$id",2,"任务已提交，不可再返回修改！","warning");
			$objRelease->check_access($step, $id, $arrPubInfo);
			$strExtTypes   = kekezu::get_ext_type ();
			$indus_p_arr = $kekezu->_indus_task_arr;
			$indus_arr   = $kekezu->get_classify_indus('task','child');
			$arrPubInfo['tar_content'] = htmlspecialchars_decode(stripslashes($arrPubInfo['tar_content']));
		}
		$arrFileLists = CommonClass::getFileArray('|', $arrPubInfo['file_ids']);
		break;
	case 'step3':
		$intFileCount = 0;
		if($arrPubInfo['file_ids']){
			$intFileCount = count(explode('|',$arrPubInfo['file_ids']));;
		}
		if (isset($formhash)&&kekezu::submitcheck($formhash)) {
			$arrPayitems = array(
					'urgent'=>intval($txt_urgent),
					'tasktop'=>intval($txt_tasktop)&&intval($text_tasktop) ?intval($text_tasktop):0,
					'workhide'=>intval($txt_workhide),
					'seohide'=>intval($txt_seohide),
			);
			$arrPayitems = array_filter($arrPayitems);
			PayitemClass::validPayitemCount($arrPayitems, $arrPubInfo['txt_task_day']);
			$_POST['payitem'] = $arrPayitems;
			$arrPubInfo and $_POST = array_merge ( $arrPubInfo, $_POST );
			$objRelease->save_task_obj ( $_POST, $stdCacheName ); 
			$intTaskId = $objRelease->pub_task (); 
			$objRelease->save_task_match($intTaskId);
			$objRelease->update_task_info ( $intTaskId, $stdCacheName ); 
			kekezu::show_msg($tips,$strUrl.'&step=step4&taskId='.$intTaskId,NULL,NULL,'ok');
		}else{
			!$_SESSION[$stdCacheName] and kekezu::show_msg($_lang ['friendly_notice'],"index.php?do=pubtask&id=$id",2,"任务已提交，不可再返回修改！","warning");
			$objRelease->check_access($step, $id, $arrPubInfo);
//			$strTarComment = htmlspecialchars_decode($arrPubInfo['tar_content']);
			$strTarComment = htmlspecialchars_decode(stripslashes($arrPubInfo['tar_content']));
			$strCommentLen = strlen($strTarComment);
			if($strCommentLen > 1000 ){
				$strPartComment = kekezu::cutstr($strTarComment,1000);
			}
		}
		break;
	case 'step4':
		$taskId = intval($taskId);
		if(0 === $taskId){
			kekezu::show_msg('无权访问',$strUrl,3,NULL,'warning');
		}
		$arrTaskInfo = $objRelease->check_access($step, $id, $arrPubInfo,$taskId);
		$arrPayInfo = $objRelease->checkWhetherToPay($taskId);
		$boolValue = $arrPayInfo['balance_pay'];
		$floatPayCash = $arrPayInfo['total_cash'];
		break;
}
require keke_tpl_class::template ( 'pubtask' );
die();
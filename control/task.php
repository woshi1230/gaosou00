<?php defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
// 原有模块的引入
require 'buy/include.php';

$strNavActive = "tasklist";
$rs_indus  = kekezu::get_classify_indus('task','total');
$nav_active_index = "tasklist";
$intId = intval($id);
if ($intId) {
	$strTaskSql = 'select * from ' . TB_PRE . 'witkey_task where task_id = ' . $intId;
	$strTaskSqlT ='select username from ' . TB_PRE . 'witkey_task_work where task_id = ' . $intId.' group by username';
	$arrTaskTakeMan2 = db_factory::query($strTaskSqlT);//投稿人有哪些
//	var_dump($arrTaskTakeMan2);
//	$arrTaskTakeMan2 =array_column($arrTaskTakeMan2,'username');//php>5.5才有此函数
//	var_dump($arrTaskTakeMan2);
	$len = count($arrTaskTakeMan2);
	foreach($arrTaskTakeMan2 as $k=>$v){
		$arrTaskTakeMan[] .=$v['username'];

	}
	 if(in_array($gUsername,$arrTaskTakeMan)){
		 $judge =1;
	 }
	$arrTaskInfo = db_factory::get_one($strTaskSql);
	$arrTaskInfo or kekezu::show_msg(kekezu::lang("operate_notice"), "index.php?do=tasklist", 2, "对不起，您访问的页面没找到！", "warning");
	$arrTaskInfo['ext_time'] = intval($arrTaskInfo['ext_time']);
	$arrModelInfo = $model_list [$arrTaskInfo ['model_id']];
	if ($arrTaskInfo['uid']) {
		$arrFavorite = db_factory::get_count(sprintf('select count(*) from %s where userid = %d and obj_id = %d and keep_type = "task"', TB_PRE . 'favorite', intval($gUid), intval($arrTaskInfo['task_id'])));
		if ($arrFavorite) {
			$arrTaskInfo['favorite'] = true;
		}
	}
	//$_userid != '1' &&,加此代码是因为管理员审核任务的时候无法查看任务
	$_userid != '1' && $arrTaskInfo ['uid'] != $uid && $gUid != ADMIN_UID && $arrTaskInfo ['task_status'] == 1 and kekezu::show_msg($_lang ['friendly_notice'], 'index.php?do=tasklist', 1, $_lang ['task_auditing'], 'warning');
	$arrTaskInfo ['uid'] != $uid && $gUid != ADMIN_UID && $arrTaskInfo ['task_status'] == 0 and kekezu::show_msg($_lang ['friendly_notice'], 'index.php?do=tasklist', 1, $_lang ['task_not_pay'], 'warning');
	$arrConfig = unserialize($model_list [$arrTaskInfo ['model_id']]['config']);
	if(!$arrModelInfo){
		kekezu::show_msg('页面不存在','index.php?do=tasklist',3,null,'warning');
	}
	if($arrTaskInfo['seohide']==1){
		if(!$gUid){
			kekezu::show_msg('页面不存在','index.php?do=tasklist',3,null,'warning');
		}
	}else{
		if($arrTaskInfo['indus_id']){
			$indusInfo = CommonClass::getIndustryById($arrTaskInfo['indus_id']);
		}elseif ($arrTaskInfo['indus_pid']){
			$indusInfo = CommonClass::getIndustryById($arrTaskInfo['indus_pid']);
		}
		if($arrTaskInfo['seo_title']){
			$strPageTitle = $arrTaskInfo['seo_title'];
		}else{
			if($indusInfo['seo_title']){
				$strPageTitle = $indusInfo['seo_title'];
			}else{
				$strPageTitle = $arrTaskInfo['task_title'].'-'.$indus_arr[$arrTaskInfo['indus_id']]['indus_name'].','.$indus_p_arr[$arrTaskInfo['indus_pid']]['indus_name'].'-'.$_K['html_title'];
			}
		}
		if($arrTaskInfo['seo_keyword']){
			$strPageKeyword = $arrTaskInfo['seo_keyword'];
		}else{
			if($indusInfo['seo_keyword']){
				$strPageKeyword = $indusInfo['seo_keyword'];
			}else{
				$strPageKeyword = $indus_arr[$arrTaskInfo['indus_id']]['indus_name'].','.$indus_p_arr[$arrTaskInfo['indus_pid']]['indus_name'];
			}
		}
		if($arrTaskInfo['seo_desc']){
			$strPageDescription = $arrTaskInfo['seo_desc'];
		}else{
			if($indusInfo['seo_desc']){
				$strPageDescription = $indusInfo['seo_desc'];
			}else{
				$strPageDescription = kekezu::cutstr(htmlspecialchars_decode(stripslashes($arrTaskInfo['task_desc'])),100);
			}
		}
	}
	$arrCashCoves = TaskClass::getTaskCashCove();
	$arrBreadcrumbs = array(
		1=>array('url'=>'index.php?do=tasklist&fd='.$arrTaskInfo['indus_fid'],'name'=>$indus_task_arr[$arrTaskInfo['indus_fid']]['catname']),
	);
	$arrTaskInfo['indus_pid'] and $arrBreadcrumbs[2] = array('url'=>'index.php?do=tasklist&fd='.$arrTaskInfo['indus_fid'].'&pd='.$arrTaskInfo['indus_pid'],'name'=>$indus_arr[$arrTaskInfo['indus_pid']]['catname'] );
	$arrTaskInfo['indus_id'] and $arrBreadcrumbs[3] = array('url'=>'index.php?do=tasklist&fd='.$arrTaskInfo['indus_fid'].'&pd='.$arrTaskInfo['indus_pid'].'&id='.$arrTaskInfo['indus_id'],'name'=>$indus_arr[$arrTaskInfo['indus_id']]['catname'] );
	$arrTaskInfo['indus_sid'] and $arrBreadcrumbs[4] = array('url'=>'index.php?do=tasklist&fd='.$arrTaskInfo['indus_fid'].'&pd='.$arrTaskInfo['indus_pid'].'&id='.$arrTaskInfo['indus_id'].'&sd='.$arrTaskInfo['indus_sid'],'name'=>$indus_arr[$arrTaskInfo['indus_sid']]['catname'] );

	$arrWorkFlag = array(
			1=>array('id'=>2,'style'=>'fa-trophy','name'=>'一等奖'),
			2=>array('id'=>2,'style'=>'fa-trophy','name'=>'二等奖'),
			3=>array('id'=>2,'style'=>'fa-trophy','name'=>'三等奖'),
			4=>array('id'=>4,'style'=>'fa-check-circle','name'=>'中标'),
			5=>array('id'=>5,'style'=>'fa-dot-circle-o','name'=>'入围'),
			6=>array('id'=>6,'style'=>'fa-check-circle','name'=>'合格'),
			7=>array('id'=>7,'style'=>'fa-times-circle','name'=>'淘汰'),
			8=>array('id'=>8,'style'=>'fa-times-circle','name'=>'不可选标'),
			9=>array('id'=>9,'style'=>'fa-times-circle','name'=>'放弃'),
			);
	$strUrl = "index.php?do=task&id=".$intId; 
	$arrView = array('work','comment','mark');
	if(!in_array($view, $arrView)){
		$view = 'work';
	}
	$intDeals=TaskClass::getWikiDealbyUid($arrTaskInfo['uid']);
	$arrWorkService=TaskClass::getWorkServers($intId, $arrTaskInfo ['model_id']);
	$arrUserInfo=keke_user_class::get_user_info($arrTaskInfo['uid']);	
	$strMarkQuerySQl  = " SELECT COUNT(mark_id) FROM `".TB_PRE."witkey_mark` ";
	$strMarkQuerySQl .= " WHERE origin_id = '".$arrTaskInfo['task_id']."' ";
	$strMarkQuerySQl .= " AND mark_status > 0 AND model_code = '".$arrModelInfo['model_code']."'";
	$arrTaskInfo['mark_num'] = db_factory::get_count($strMarkQuerySQl);
	$arrPayitemLists = PayitemClass::getPayitemListDetail('task',$arrTaskInfo['task_id']);
	$arrPayitemListAlls = PayitemClass::getPayitemListForPub('task');
	$arrOrderInfo = array();
	$sql = "SELECT a.*,b.order_status FROM `".TB_PRE."witkey_order_detail` a LEFT JOIN `".TB_PRE."witkey_order` b ON a.order_id= b.order_id WHERE a.obj_type = 'task' and a.obj_id = ".$arrTaskInfo['task_id'];
	$arrOrderInfo = db_factory::get_one($sql);
	if($arrOrderInfo['order_status'] =='ok'){
		$boolIsHosting = true;
	}else{
		$boolIsHosting = false;
	}
	$arrSimpleTasks = db_factory::query("select * from ".TB_PRE."witkey_task where indus_pid=".$arrTaskInfo['indus_pid']." and task_id!=".$arrTaskInfo['task_id']." and task_status not in(0,1,10) order by start_time desc limit 10");
//	$arrRecommShops = db_factory::query ( sprintf ( "select a.username,a.uid,b.indus_id,b.indus_pid,a.shop_name,if(b.seller_total_num>0,b.seller_good_num/b.seller_total_num,0) as good_rate from %switkey_shop a "
//			." left join yw_company b on a.uid=b.userid  where b.recommend=1 and b.status=1 and IFNULL(a.is_close,0)=0 and shop_status=1 order by if(b.indus_pid=%d ,1,0) desc, good_rate desc limit 0,5", TB_PRE,$arrTaskInfo['indus_pid'] ), 1, $intIndexCacheTime );
	if($view == 'mark'){
		$s === null and $s = 100 or $s = intval($s);
		$arrSearchStatus =  array();
		$arrSearchStatus['100'] = '所有的';
		$arrSearchStatus['1']  = '好评';
		$arrSearchStatus['2']  = '中评';
		$arrSearchStatus['3']  = '差评';
		$arrSearchStatus['101'] = '来自雇主';
		$arrSearchStatus['102'] = '来自高手';
	}
if($arrModelInfo['open_custom'] =='1'){
	$c_open = 1;
//	$arrShowCustoms = CustomClass::getExtData($arrTaskInfo['task_id'],$arrModelInfo['model_id']);
	foreach ($arrShowCustoms as $k=>$v){
		if($v['extdata']){
			$arrShowCustoms[$k]['data'] =unserialize($v['extdata']);
		}
	}
}
	require S_ROOT . "/buy/" . $arrModelInfo['model_code'] . "/control/index.php";
	$_SESSION['spread'] = 'index.php?do=task&id='.intval($id);
	require keke_tpl_class::template ( "task/" . $arrModelInfo ['model_code'] . "/index");die;
}

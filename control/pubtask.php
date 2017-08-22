<?php
// 原有模块的引入
require 'buy/include.php';

kekezu::check_login();
$strPageTitle = '发布任务-'.$_K ['html_title'];
$strPageKeyword = '发布任务,'.$_K ['html_title'];
$strPageDescription = $kekezu->_sys_config['index_seo_desc'];
$id = intval($id);
$step = strval(trim($step));
$strRandKf = kekezu::get_rand_kf ();
$is_task_template=db_factory::query("select * from ".TB_PRE."witkey_task_template");
$arrPubProcess = array(
		1=>array('step'=>'step1','desc'=>'选择交易模式'),
		2=>array('step'=>'step2','desc'=>'描述任务需求'),
		3=>array('step'=>'step3','desc'=>'核对交易清单'),
		4=>array('step'=>'step4','desc'=>'成功发布任务')
);
$arrPayitemLists = PayitemClass::getPayitemListForPub();
$arrPayitemPriceLists = PayitemClass::getPayitemPriceList();
$arrDistribution = array(
	1 => '单人中标',
	2 => '多人中标',
	3 => '',
	4 => '单人中标',
	5 => '单人中标',
	12=>'单人中标',
);
$arrTopIndustrys = $kekezu->_indus_task_arr;
//$arrModelLists = kekezu::get_table_data ( '*', TB_PRE . 'witkey_model', " model_type = 'buy' and model_status='1'", 'listorder asc ', '', '', 'model_id', 3600 );
$arrModelLists = Keke_witkey_model_class::query ('*');
if(0 === $id){
	$arrModelIds = array_keys($arrModelLists);
	$id = $arrModelIds['0'];
}
$arrModelInfo = $arrModelLists [$id];
if(empty($arrModelInfo)){
	kekezu::show_msg('不存在该任务模型,请重新选择','index.php?do=pubtask',3,null,'warning');
}
$arrStep = array('step1','step2','step3','step4');
if(!in_array($step, $arrStep)){
	$step = 'step1';
}
$strUrl = "index.php?do=pubtask&id=".$id;
$arrOutFinance=db_factory::query(sprintf("select * from %sfinance_record where amount<0 and obj_id='%d' and uid='%d'",TB_PRE,$taskId,$gUid));
if($arrOutFinance){
	$isReturn=2;
}
if($arrModelInfo['open_custom'] =='1'){
	$c_open = 1;
//	$arrCustoms = CustomClass::getFieldListsByModelId($arrModelInfo['model_id']);
}
$arrProvinces = CommonClass::getDistrictByPid('0','areaid,parentid,areaname');
$gUserInfo['province'] and $arrCities = CommonClass::getDistrictByPid($gUserInfo['province'],'areaid,parentid,areaname');
$gUserInfo['city'] and $arrAreas = CommonClass::getDistrictByPid($gUserInfo['city'],'areaid,parentid,areaname');
$_SESSION['spread'] = 'index.php?do=pubtask';
require S_ROOT . "/buy/" . $arrModelInfo['model_code'] . "/control/pub.php";

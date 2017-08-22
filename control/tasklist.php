<?php
// 原有模块的引入
require 'buy/include.php';

$regionCfg =  keke_glob_class::getRegionConfig();
$strNavActive = 'tasklist';
$arrNewIndusC = $arrNewIndusCt;
$tm = intval($tm);
$s = intval($s);
$r = intval($r);
$o = intval($o);
$fd = intval($fd);
$pd = intval($pd);
$id = intval($id);
$sd = intval($sd);
if (isset ( $ky )) {
	$ky = htmlspecialchars ( $ky );
	$ky = kekezu::escape ( $ky );
//	$arrHwStatus = db_factory::query("select v from ".TB_PRE."witkey_basic_config where k='hot_words_status'");
//	$arrUpdateStatus = db_factory::query("select v from ".TB_PRE."witkey_basic_config where k='update_status'");
//	$arrSearch = db_factory::query("select * from ".TB_PRE."witkey_hotwords where words = '$ky'");
//	if($arrHwStatus[0]['v'] == 'open'){
//	    if($arrUpdateStatus[0]['v'] == 'auto'){
//	        if(count($arrSearch)){
//	            db_factory::updatetable(TB_PRE."witkey_hotwords", array('count'=>$arrSearch[0]['count']+1,'time'=>time()), array('words'=>$arrSearch[0]['words']));
//	        }else{
//	            db_factory::inserttable(TB_PRE."witkey_hotwords", array('words'=>$ky,'time'=>time(),'auto'=>'1'));
//	        }
//	    }else{
//	        if(count($arrSearch)){
//	            db_factory::updatetable(TB_PRE."witkey_hotwords", array('count'=>$arrSearch[0]['count']+1,'time'=>time()), array('words'=>$arrSearch[0]['words'],'auto'=>'0'));
//	        }
//	    }
//	}
}
$page and $intPage = intval($page);
$strUrl ="index.php?do=tasklist";
$tm and $strUrl .="&tm=".$tm;
$s and $strUrl .="&s=".$s;
$r and $strUrl .="&r=".$r;
$fd and $strUrl .="&fd=".$fd;
$pd and $strUrl .="&pd=".$pd;
$id and $strUrl .="&id=".$id;
$sd and $strUrl .="&sd=".$sd;
$o and $strUrl .="&o=".$o;
$p and $strUrl .="&p=".intval($p);
$ky and  $strUrl .="&ky=".$ky;
$intPage and $strUrl .="&intPage=".$intPage;
$intPagesize and $strUrl .="&intPagesize=".intval($intPagesize);
$arrTaskTimeDesc = keke_glob_class::get_taskstatus_desc ();
$arrPayitemConfig = PayitemClass::getPayitemConfig ( null, null, null, 'item_id' );
//$pd and $arrIndusPInfo = kekezu::get_indus_info($pd);
//$i and $arrIndusInfo = kekezu::get_indus_info($i);

//$arrCategory = db_factory::query("SELECT catid, catname, parentid, arrparentid, style FROM " . TB_PRE . "category where moduleid=42 order by listorder");
$arrCategory = db_factory::get_table_data("catid, catname, parentid, arrparentid, child, style", TB_PRE . "category", "moduleid=42", "listorder", "", "", "catid");
if(is_array($arrCategory)){
	$arrCategoryMF = array();
	$arrCategoryMS = array();
	$arrCategoryM = array();

	foreach($arrCategory as $k=>$v){
//		if ($i && $v['catid'] == $i) {
//			$arrIndusInfo = $v;
//		} else if ($pd && $v['catid'] == $pd) {
//			$arrIndusPInfo = $v;
//		}

		$arrid = explode(',', $v['arrparentid']);
		switch (count($arrid)) {
			case 1:
				$arrCategoryMF[$v['catname']] = $v;
				break;
			case 2:
				$arrCategoryMS[$v['catid']] = $v;
				break;
			case 3:
				$v['smenuname'] = $arrCategoryMS[$arrid[2]]['catname'];
				$v['smenuid'] = $arrCategoryMS[$arrid[2]]['catid'];
				$v['smenustyle'] = $arrCategoryMS[$arrid[2]]['style'];
				if ($arrCategory[$k]['child'] == 0) {
					$arrCategoryM[$arrid[1]][$arrid[2]][$k] = $v;
				}
				break;
			case 4:
				$v['smenuname'] = $arrCategory[$arrid[3]]['catname'];
				$arrCategoryM[$arrid[1]][$arrid[2]][$arrid[3]][] = $v;
				break;
		}
	}
}

$arrTaskNavs = TaskClass::getEnabledTaskModelList();
if($tm){
	$arrTaskStatus = call_user_func ( array ($arrTaskNavs[$tm]['model_code'] . "_task_class", "get_task_status" ) );;
}
$arrCashCoves = TaskClass::getTaskCashCove();
$arrModelLabel = array(	0 =>'未知',1=>'单人',	2=>'多人',	3=>'计件',	4=>'招标',	5=>'订金',	6=>'作品',	7=>'服务' ,12=>'速配' ,15=>'福袋' ,16=>'议价');
$arrCityInfo =  CommonClass::getDistrictById($p);
$arrDisplaypro = CommonClass::getDistrictByPid('0','areaid,parentid,areaname');


$arrArea = [];
$len = count($arrDisplaypro);
	for($i=0;$i<$len;$i++){
		$b = $i+1;
		$arrArea[$i] =$arrDisplaypro[$b];
	}
////json
$tr = json_encode($arrCityInfo, JSON_UNESCAPED_UNICODE);
$tr2 = json_encode($arrArea, JSON_UNESCAPED_UNICODE);
$M_PATH = DT_ROOT . '/file/cache/arrCityInfo.json';
$M_PATH2 = DT_ROOT . '/file/cache/arrDisplaypro.json';
file_put_contents($M_PATH, $tr);
file_put_contents($M_PATH2, $tr2);
////json

$objTaskT = keke_table_class::get_instance('witkey_task');
$strWhere  = " 1=1 ";
$intPage = intval ( $intPage ) ? $intPage : 1;
//$intPagesize = intval ( $intPagesize ) ? $intPagesize : 20;
$intPagesize = intval ( $intPagesize ) ? $intPagesize : 60;
$arrTaskModelIds = array_keys($arrTaskNavs);
in_array($tm, $arrTaskModelIds) and $strWhere .= " and a.model_id = ".$tm or $strWhere .= " and a.model_id in(".implode(',', $arrTaskModelIds).") ";

$sd and $strWhere .= " and a.indus_sid = ".$sd or ($id and $strWhere .= " and a.indus_id = ".$id or ($pd and $strWhere .= " and a.indus_pid = ".$pd or ($fd and $strWhere .= " and a.indus_fid = ".$fd)));

switch ($r) {
//	case 1:$strWhere .= " and a.model_id  = 4 ";break;
//	case 2:$strWhere .= " and a.model_id != 4 ";break;
	case 1:$strWhere .= " and a.cash_cost > 0 ";break;
	case 2:$strWhere .= " and a.task_status > 1 and  a.cash_cost < 0 ";break;
}
switch ($s) {
//	case 1:$strWhere .= " and a.task_status=2 or a.task_status=8";break;
	case 1:$strWhere .= " and a.task_status=2";break;//去掉已经结束的任务
//	case 2:$strWhere .= " and a.task_status=3";break;
	case 2:$strWhere .= " and a.task_status=3  and a.work_num>0 ";break;//只显示有高手投稿的任务，？？！！！！！！！w-t-f
//	case 3:$strWhere .= " and a.task_status=6 ";break;
	case 3:$strWhere .= " and (a.task_status=6 or  a.task_status=13)";break;//增加交互冻结
	case 4:$strWhere .= " and a.task_status=8 ";break;
	default:$strWhere .= " and a.task_status not in(0,1,10) ";break;
//李工要求显示未付款任务，将来肯定会改回来，删掉下面一行，取消上面注释即可--已改回可忽略
//	default:$strWhere .= " and a.task_status not in(10) ";break;
}
$whereArea = "";
if (intval ( $p )) {
	$arrCityone =  CommonClass::getDistrictById($p);
	$whereArea = " and locate('".$arrCityone['areaname']."',a.area)=1";
	$two=db_factory::get_table_data("*",TB_PRE . "area","parentid=".intval($p));
}
if (intval ( $twoid )) {
	$arrCitytwo =  CommonClass::getDistrictById($twoid);
	$whereArea = " and locate('".$arrCityone['areaname'].$arrCitytwo['areaname']."',a.area)=1";
	$three=db_factory::get_table_data("*",TB_PRE . "area","parentid=".$twoid);
	$twoid and $strUrl .="&twoid=".intval($twoid);
}
if (intval ( $threeid )) {
	$arrCitythree =  CommonClass::getDistrictById($threeid);
	$whereArea = " and locate('".$arrCityone['areaname'].$arrCitytwo['areaname'].$arrCitythree['areaname']."',a.area)=1";
}
$strWhere .= $whereArea;
$ky and $strWhere .= " and a.task_title like '%$ky%' ";
switch ($o) {
//	case 1:  $strWhere .= " and a.task_status<8 order by a.sub_time desc ";
	case 1:  $strWhere .= "   order by a.sub_time desc ";
		break;
	case 2:  $strWhere .= " and a.task_status<8  order by  a.sub_time asc ";	 	break;
	case 3:  $strWhere .= " order by a.task_cash desc ";	break;
	case 4:  $strWhere .= " order by a.task_cash asc "; 	break;
	case 5:  $strWhere .= " order by a.work_num desc ";   	break;
	case 6:  $strWhere .= " order by a.work_num asc ";	 	break;
	//手机状态排序
	case 7:  $strWhere = "   a.task_status=2 or a.task_status=8 order by a.task_status asc ";	 	break;


	default: $strWhere .= " order by a.tasktop desc,a.task_id desc ";	 	break;
}
$strTaskSql = "select a.*,d.* from " . TB_PRE . "witkey_task as a left join " . TB_PRE . "witkey_task_cash_cove d on a.task_cash_coverage=d.cash_rule_id
		where ";
$intCount = db_factory::execute ( $strTaskSql . $strWhere );
$arrDatas = $page_obj->getPages ( $intCount, 60, $intPage, $strUrl );//
//$t1 = microtime(true);
$arrTaskLists = db_factory::query ( $strTaskSql . $strWhere . $arrDatas ['where'] );
//json
if($_SERVER['QUERY_STRING']=='do=tasklist&intPage=1&o=1') {
	$len = count($arrTaskLists);
	for ($i = 0; $i < $len; $i++) {
		$arrTaskLists[$i]['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($arrTaskLists[$i]['task_desc'])));
		$arrTaskLists[$i]['start_time'] =date('Y-m-d',$arrTaskLists[$i]['start_time']);
		$arrTaskLists[$i]['sub_time'] =date('Y-m-d',$arrTaskLists[$i]['sub_time']);
	};
	$tr = json_encode($arrTaskLists, JSON_UNESCAPED_UNICODE);
	$M_PATH = DT_ROOT . '/file/cache/tasklistDescTime.json';
	file_put_contents($M_PATH, $tr);
}

	if($_SERVER['QUERY_STRING']=='do=tasklist&intPage=1&o=3') {
		$len = count($arrTaskLists);
		for ($i = 0; $i < $len; $i++) {
			$arrTaskLists[$i]['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($arrTaskLists[$i]['task_desc'])));
			$arrTaskLists[$i]['start_time'] =date('Y-m-d',$arrTaskLists[$i]['start_time']);
			$arrTaskLists[$i]['sub_time'] =date('Y-m-d',$arrTaskLists[$i]['sub_time']);

		};
		$tr = json_encode($arrTaskLists, JSON_UNESCAPED_UNICODE);
		$M_PATH = DT_ROOT . '/file/cache/tasklistDescMoney.json';
		file_put_contents($M_PATH, $tr);
	}


if($_SERVER['QUERY_STRING']=='do=tasklist&intPage=1&o=5') {

	$len = count($arrTaskLists);
	for ($i = 0; $i < $len; $i++) {
		$arrTaskLists[$i]['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($arrTaskLists[$i]['task_desc'])));
		$arrTaskLists[$i]['start_time'] =date('Y-m-d',$arrTaskLists[$i]['task_desc']);
		$arrTaskLists[$i]['sub_time'] =date('Y-m-d',$arrTaskLists[$i]['sub_time']);

	};
	$tr = json_encode($arrTaskLists, JSON_UNESCAPED_UNICODE);

	$M_PATH = DT_ROOT . '/file/cache/tasklistDescManuscript.json';
	file_put_contents($M_PATH, $tr);
}

//if($_SERVER['QUERY_STRING'] =='do=tasklist&intPage=1&s=1'){
if($_SERVER['QUERY_STRING'] =='do=tasklist&intPage=1&s=1&o=7'){
	$len = count($arrTaskLists);
	for ($i = 0; $i < $len; $i++) {
		$arrTaskLists[$i]['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($arrTaskLists[$i]['task_desc'])));
		$arrTaskLists[$i]['start_time'] =date('Y-m-d',$arrTaskLists[$i]['start_time']);
		$arrTaskLists[$i]['sub_time'] =date('Y-m-d',$arrTaskLists[$i]['sub_time']);
	};
	$tr = json_encode($arrTaskLists, JSON_UNESCAPED_UNICODE);
	$M_PATH = DT_ROOT . '/file/cache/tasklistState.json';
	file_put_contents($M_PATH, $tr);
}


if($_SERVER['QUERY_STRING'] == 'do=buy'){
	$len = count($arrTaskLists);
	for($i=0;$i<$len;$i++){
		$arrTaskLists[$i]['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($arrTaskLists[$i]['task_desc'])));
		$arrTaskLists[$i]['start_time'] =date('Y-m-d',$arrTaskLists[$i]['start_time']);
		$arrTaskLists[$i]['sub_time'] =date('Y-m-d',$arrTaskLists[$i]['sub_time']);

//	echo $arrTaskLists[$i]['task_desc'].'<br/>';
	};
	$tr = json_encode($arrTaskLists, JSON_UNESCAPED_UNICODE);
	$M_PATH = DT_ROOT . '/file/cache/tasklist.json';
	file_put_contents($M_PATH, $tr);
}
//json





//$t2 = microtime(true);
//echo '1耗时'.round($t2-$t1,3).'秒';
$arrFavorite = db_factory::query(sprintf('select obj_id from %s where userid = %d and keep_type = "task"',TB_PRE.'favorite',intval($gUid)));
if(is_array($arrTaskLists)){
	foreach ($arrTaskLists as $k=>$v) {
		foreach($arrFavorite as $kf=>$vf){
			if ($arrTaskLists[$k]['task_id'] == $vf['obj_id']) {
				$arrTaskLists[$k]['favorite'] = true;
				break;
			}
		}
//		$province = CommonClass::getDistrictById($v['province']);
//		$city = CommonClass::getDistrictById($v['city']);
//		$arrTaskLists[$k]['province_name'] = $province['name'];
//		$arrTaskLists[$k]['city_name'] = $city['name'];
//		$arrTaskLists[$k]['area_name'] = $area['name'];
		unset($arrFollow);
	}
}
$strPages = $arrDatas ['page'];
$arrSJ = array('1'=>'未托管','2'=>'已托管');
$arrTaskS = array('1'=>'工作中','2'=>'选稿中','3'=>'交付中','4'=>'已结束');
$data = array(
	'地区'=>$arrCityone['name'].$arrCitytwo['name'].$arrCitythree['name'],
	'任务模式'=>$arrTaskNavs[$tm]['model_name'],
	'赏金状态'=>$arrSJ[$r],
	'任务状态'=>$arrTaskS[$s],
//	'行业'=>$arrIndusPInfo['indus_name'],
//	'子行业'=>$arrIndusInfo['indus_name']
);
list($strPageTitle,$strPageKeyword,$strPageDescription) =  keke_seo_class::getListSEO($pd, $id, $data,'task',true);
unset($objTaskT);
//最新发布，读keke_witkey_feed表
$arrFeedPubs = array();
$result = $db->query("select task_id,model_id,task_cash,task_cash_coverage,task_title,username,start_time from ".TB_PRE."witkey_task where task_status >= 2 order by task_id desc limit 0, 5", 'CACHE');
while($rec = $db->fetch_array($result)) {
	$arrFeedPubs[] = $rec;
}

$arrRecommMembs = array();
$result = $db->query ( "select userid,username,company,catid,if(seller_total_num>0,seller_good_num/seller_total_num,0) as good_rate from ".TB_PRE."company where 1=1 order by good_rate desc limit 0,5", 'CACHE');
while($rec = $db->fetch_array($result)) {
	$arrRecommMembs[] = $rec;
}

$_SESSION['spread'] = 'index.php?do=tasklist';

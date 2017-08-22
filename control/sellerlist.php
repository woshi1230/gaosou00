<?php
$strNavActive = 'sellerlist';
$i = intval($i);
$pd = intval($pd);
$strUrl = "index.php?do=sellerlist";
$intPage and $strUrl .="&intPage=".intval($intPage);
$o and $strUrl .="&o=".strval($o);
$t and $strUrl .="&t=".intval($t);
$i and $strUrl .="&i=".intval($i);
$c and $strUrl .="&c=".intval($c);
$p and $strUrl .="&p=".intval($p);
$pd and $strUrl .="&pd=".$pd;
$d and $strUrl .="&d=".intval($d);
$r and $strUrl .="&r=".intval($r);
$ky and $strUrl .="&ky=".$ky;
$i and $arrIndusInfo = kekezu::get_indus_info($i);
$pd and $arrIndusPInfo = kekezu::get_indus_info($pd);
$arrModelLabel = array(	0 =>'未知',1=>'单人',	2=>'多人',	3=>'计件',	4=>'招标',	5=>'订金',	6=>'作品',	7=>'服务' ,12=>'速配' ,15=>'福袋' ,16=>'议价');
if (isset ( $ky )) {
	$ky = htmlspecialchars ( $ky );
	$ky = kekezu::escape ( $ky );
	$arrHwStatus = db_factory::query("select v from ".TB_PRE."witkey_basic_config where k='hot_words_status'");
	$arrUpdateStatus = db_factory::query("select v from ".TB_PRE."witkey_basic_config where k='update_status'");
	$arrSearch = db_factory::query("select * from ".TB_PRE."witkey_hotwords where words = '$ky'");
	if($arrHwStatus[0]['v'] == 'open'){
	    if($arrUpdateStatus[0]['v'] == 'auto'){
	        if(count($arrSearch)){
	            db_factory::updatetable(TB_PRE."witkey_hotwords", array('count'=>$arrSearch[0]['count']+1,'time'=>time()), array('words'=>$arrSearch[0]['words']));
	        }else{
	            db_factory::inserttable(TB_PRE."witkey_hotwords", array('words'=>$ky,'time'=>time(),'auto'=>'1'));
	        }
	    }else{
	        if(count($arrSearch)){
	            db_factory::updatetable(TB_PRE."witkey_hotwords", array('count'=>$arrSearch[0]['count']+1,'time'=>time()), array('words'=>$arrSearch[0]['words'],'auto'=>'0'));
	        }
	    }
	}
}
$arrCashCoves = TaskClass::getTaskCashCove();
$arrIndusAll = $kekezu->_indus_arr;
$page and $intPage = intval($page);
$intPage = intval ( $intPage ) ? $intPage : 1;
$intPagesize = intval ( $intPagesize ) ? $intPagesize : 5;
$strSql = "select a.*,b.user_type,b.seller_level,b.skill_ids,b.city,b.province,b.indus_id,b.indus_pid,b.seller_total_num,b.seller_good_num,b.seller_level,e.shop_name,
		if(b.seller_total_num>0,b.seller_good_num/b.seller_total_num,0) as good_rate ,sum(if((d.reason='task_bid' or d.reason='sale_service'),abs(d.amount),0)) as  totalcash
		from " . TB_PRE . "witkey_shop as a left join yw_company b
		on a.uid = b.userid left join ".TB_PRE."witkey_auth_record c on a.uid=c.uid left join ".TB_PRE."finance_record d on a.uid=d.uid left join ".TB_PRE."witkey_shop e on e.uid=a.uid where ";
$strWhere = " 1=1 and a.on_sale >0 and a.is_show = 1 ";
if (intval ( $i )) {
	$strWhere .= " and b.indus_id = ".intval($i);
}
$pd and $strWhere .= " and b.indus_pid = ".$pd;
if (intval ( $t )) {
	if($t =='1'){
		$strWhere .= " and (b.user_type = 1 or b.user_type is null) ";
	}else{
		$strWhere .= " and b.user_type = 2";
	}
}
if (intval ( $p )) {
	$arrCityone =  CommonClass::getDistrictById($p);
	$strWhere .= " and b.province = ".intval($p);
}
if (intval ( $c )) {
	$strWhere .= " and b.city = ".intval($c);
}
$ky and $strWhere .= " and b.username like '%$ky%' or e.shop_name like '%$ky%' or concat(b.username,e.shop_name) like '%$ky%' ";
if (intval($r)) {
	$strWhere .= " and (c.auth_code='enterprise'  or c.auth_code='realname') and c.auth_status=1 ";
}
if (intval($d)) {
	$strWhere .= " and (d.reason ='task_bid' or d.reason='sale_service') and  DATE_SUB(CURDATE(),INTERVAL 90 day) <= date(from_unixtime(d.addtime)) ";
}
$strWhere .= " group by a.uid ";
if(isset($o)){
	switch(intval($o)){
		case '1':
			$strWhere .=" order by b.seller_credit desc ";
			break;
		case '2':
			$strWhere .=" order by b.seller_credit asc ";
			break;
		case '3':
			$strWhere .=" order by if(b.seller_total_num>0,b.seller_good_num/b.seller_total_num,0) desc ";
			break;
		case '4':
			$strWhere .=" order by if(b.seller_total_num>0,b.seller_good_num/b.seller_total_num,0)  asc";
			break;
		case '5':
			$strWhere .=" order by totalcash  desc";
			break;
		case '6':
			$strWhere .=" order by totalcash asc ";
			break;
	}
}else{
	$strWhere .= " order by b.seller_credit desc,b.recommend desc,a.shop_id desc ";
}
$arrCityInfo =  CommonClass::getDistrictById($p);
$intCount = db_factory::execute($strSql . $strWhere );
$strPages = $kekezu->_page_obj->getPages ( $intCount, $intPagesize, $intPage, $strUrl );
$strWhere .= $strPages ['where'];
$arrSellerLists = db_factory::query ( $strSql . $strWhere );
if(is_array($arrSellerLists)){
	$arrNerLists = array();
   foreach($arrSellerLists as $k=>$v){
   	$arrService = db_factory::query("select * from ".TB_PRE."witkey_service where service_status=2 and uid=".intval($v['uid'])." order by sale_num desc limit 0,3");
   	$arrNerLists[$k] = $v;
   	$arrNerLists[$k]['service'] = $arrService;
   	if(is_array($arrNerLists[$k]['service'])){
   		foreach ($arrNerLists[$k]['service'] as $kk=>$vv) {
   			$arrFavorite = db_factory::get_count(sprintf('select count(*) from %s where uid = %d and obj_id = %d and keep_type = "service"',TB_PRE.'witkey_favorite',intval($gUid),intval($vv['service_id'])));
   			if($arrFavorite){
   				$arrNerLists[$k]['service'][$kk]['favorite'] = true;
   			}
   			unset($arrFollow);
   		}
   	}
   	unset($arrService);
	$arrFollow = db_factory::get_count(sprintf('select count(*) from %s where uid = %d and fuid = %d',TB_PRE.'witkey_free_follow',intval($gUid),intval($v['uid'])));
	if($arrFollow){
		$arrNerLists[$k]['follow'] = true;
	}
   	unset($arrFollow);
   }
}
if($arrNerLists){
	foreach ($arrNerLists as $k=>$v) {
		$arrNerLists[$k]['pro_city'] = keke_shop_class::getUserAddress($v['uid'],2,1,1,0);
	}
}
$arrShopIndusC = $kekezu->_indus_c_arr;
$arrShopIndusP = $kekezu->_indus_p_arr;
if(is_array($arrShopIndusC)){
	$arrNewShopIndusC = array();
	foreach($arrShopIndusC as $k=>$v){
		$arrNewShopIndusC[$v['indus_pid']][] = $v;
	}
}
$arrDisplaypro = CommonClass::getDistrictByPid('0','areaid,parentid,areaname');
$arrSellerType = array('1'=>'个人用户','2'=>'企业用户');
$data = array(
	'地区'=>$arrCityone['name'].$arrCitytwo['name'].$arrCitythree['name'],
	'店铺类型'=>$arrSellerType[$t],
	'行业'=>$arrIndusPInfo['indus_name'],
	'子行业'=>$arrIndusInfo['indus_name']
);
list($strPageTitle,$strPageKeyword,$strPageDescription) =  keke_seo_class::getListSEO($pd, $i, $data,'seller',true);
$floatCashLists = kekezu::get_table_data(' uid,sum(abs(amount)) as threeCash',TB_PRE . 'finance_record',"(reason='sale_service' or reason='task_bid') and DATE_SUB(CURDATE(),INTERVAL 90 day) <= date(from_unixtime(addtime))",'','uid','','uid');
function thisurl($keys=''){
	$pars = parse_url($_SERVER["QUERY_STRING"]);
	$pars = explode("&",$pars['path']);
	foreach($pars as $ps){
		$uri = explode("=",$ps);
		$url .= !strstr($keys,$uri[0]) ? "&".$ps : '';
	}
	return $_SERVER['PHP_SELF'].'?'.trim($url,"&");
}
$arrFeedPubs = kekezu::get_feed("(feedtype='pub_task' or feedtype='pub_service')", "feed_time desc", 8 );
$arrRecommShops = db_factory::query ( sprintf ( "select a.username,a.uid,b.indus_id,b.indus_pid,a.shop_name,if(b.seller_total_num>0,b.seller_good_num/b.seller_total_num,0) as good_rate from %switkey_shop a "
		." left join yw_company b on a.uid=b.userid  where b.recommend=1 and b.status=1 and IFNULL(a.is_close,0)=0 and shop_status=1 order by good_rate desc limit 0,5", TB_PRE ), 1, $intIndexCacheTime );
$_SESSION['spread'] = 'index.php?do=sellerlist';
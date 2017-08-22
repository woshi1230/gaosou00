<?php 
defined('IN_GAOSOU') or exit('Access Denied');
$table = $DT_PRE.'page';
$table_data = $DT_PRE.'page_data';
if($itemid) {
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	if(!$item || $item['status'] < 3 || $item['username'] != $username) dheader($MENU[$menuid]['linkurl']);
	extract($item);
	if(!$DT_BOT) $db->query("UPDATE LOW_PRIORITY {$table} SET hits=hits+1 WHERE itemid=$itemid", 'UNBUFFERED');
	$head_title = $title.$DT['seo_delimiter'].$head_title;
	$head_keywords = $title.','.$COM['company'];
	$head_description = get_intro($content, 200);
	if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].'index.php?moduleid=4&username='.$username.'&action='.$file.'&itemid='.$itemid;
} else {
	$COM['thumb'] = $COM['thumb'] ? $COM['thumb'] : DT_SKIN.'image/company.jpg';
	if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].'index.php?moduleid=4&username='.$username.'&action='.$file;
}
$TYPE = array();
$result = $db->query("SELECT itemid,title,style FROM {$table} WHERE status=3 AND username='$username' ORDER BY listorder DESC,addtime DESC");
while($r = $db->fetch_array($result)) {
	$r['alt'] = $r['title'];
	$r['title'] = set_style($r['title'], $r['style']);
	$r['linkurl'] = userurl($username, "file=$file&itemid=$r[itemid]", $domain);
	$TYPE[] = $r;
}

// 取得简介，三月收入，综合评价的值
include DT_ROOT.'/module/'.$module.'/introduce.php';

// 取得能力等级和信誉等级的值
stristr($DT_URL, "type=1") ? $type = 1 : $type = 2;
if($type==2){
	$arrSellerLevel = unserialize($COM[seller_level]);
	$arrSellerLevel['next'] = intval($arrSellerLevel['value'] + $arrSellerLevel['level_up']);
	if($arrSellerLevel['next']){
		$arrSellerLevel['rate'] =intval(($arrSellerLevel['value']/$arrSellerLevel['next'])*100 );
	}else{
		$arrSellerLevel['rate'] = 0;
	}
	$rate = 0;
	if(intval($COM['seller_total_num'])>0){
		$rate = number_format(intval($COM['seller_good_num'])/intval($COM['seller_total_num']),4)*100;
	}
	$arrSellerLevel['favorableRate'] = $rate;

	$arrFoundCount = array();
	$result = $db->query("SELECT sum(abs(amount)) cash,0 credit,count(itemid) count,reason FROM {$DT_PRE}finance_record WHERE uid={$userid} and reason in ('pub_task','task_bid','buy_service','sale_service','sale_gy')");
	while($r = $db->fetch_array($result)) {
		$arrFoundCount[$r['reason']] = $r;
	}
	$arrFoundCount['task'] = number_format($arrFoundCount['task_bid']['cash'],2);
	$arrFoundCount['goods'] = number_format($arrFoundCount['sale_service']['cash']+$arrFoundCount['sale_gy']['cash'],2);
}else{
	$arrBuyerLevel = unserialize ( $COM ['buyer_level'] );
	$arrBuyerLevel['next'] = intval($arrBuyerLevel['value'] + $arrBuyerLevel['level_up']);
	if($arrBuyerLevel['next']){
		$arrBuyerLevel['rate'] =intval(($arrBuyerLevel['value']/$arrBuyerLevel['next'])*100 );
	}else{
		$arrBuyerLevel['rate'] = 0;
	}
	$rate = 0;
	if(intval($COM['buyer_total_num'])>0){
		$rate = number_format(intval($COM['buyer_good_num'])/intval($COM['buyer_total_num']),4)*100;
	}
	$arrBuyerLevel['favorableRate'] = $rate;

	$arrBuyerMark = user_mark_class::get_user_aid ( $userid, '1', null, '1' );
	foreach ($arrSellerMark as $k=>$v) {
		$arrSellerMark[$k]['star'] =intval($v['avg']);
	}

	$arrFoundCount = array();
	$result = $db->query("SELECT sum(abs(amount)) cash,0 credit,count(itemid) count,reason FROM {$DT_PRE}finance_record WHERE uid={$userid} and reason in ('pub_task','task_bid','buy_service','sale_service','buy_gy')");
	while($r = $db->fetch_array($result)) {
		$arrFoundCount[$r['reason']] = $r;
	}
	$arrFoundCount['task'] = number_format($arrFoundCount['pub_task']['cash'],2);
	$arrFoundCount['goods'] = number_format($arrFoundCount['buy_service']['cash']+$arrFoundCount['buy_gy']['cash'],2);
}

// 显示评价列表，支持换页
$demo_url = userurl($username, $url.'&page={gaosou_page}', $domain);
$pagesize = 10;
$offset = ($page-1)*$pagesize;
$condition .= ' uid=' . $userid . ' and mark_status>0 and mark_type='.intval($type);
$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}witkey_mark WHERE $condition", 'CACHE');
$items = $r['num'];
$pages = home_pages($items, $pagesize, $demo_url, $page);
$arrMarkLists = array();
if($items) {
	$result = $db->query("SELECT * FROM {$DT_PRE}witkey_mark WHERE $condition ORDER BY mark_time DESC LIMIT $offset,$pagesize");
	while($r = $db->fetch_array($result)) {
		if(in_array($r['model_code'],array('goods','service'))){
//			if(intval($v['origin_id'])){
//				$arrInfo =db_factory::get_one(sprintf('select title from %s where service_id = %d',TABLEPRE.'witkey_service',intval($v['origin_id'])));
//				$arrMarkLists[$k]['title'] =$arrInfo['title'];
//				$arrMarkLists[$k]['model'] ='商品';
//				$arrMarkLists[$k]['url'] = 'index.php?do=goods&id='.intval($v['origin_id']);
//			}else{
//				$arrInfo =db_factory::get_one(sprintf('select title from %s where order_id = %d',TABLEPRE.'witkey_service_order',intval($v['obj_id'])));
//				$arrMarkLists[$k]['title'] =$arrInfo['title'];
//				$arrMarkLists[$k]['model'] ='雇佣';
//				$arrMarkLists[$k]['url'] = "javascript:void(0);";
//			}
//			$arrMarkLists[$k]['star'] = explode(',', $v['aid_star']);
//			$arrMarkLists[$k]['star'][0] = intval($arrMarkLists[$k]['star'][0]);
//			$arrMarkLists[$k]['star'][1] = intval($arrMarkLists[$k]['star'][1]);
//			$arrMarkLists[$k]['star'][2] = intval($arrMarkLists[$k]['star'][2]);
		}else{
			$arrInfo = $db->get_one(sprintf('select task_title from %s where task_id = %d',$DT_PRE.'witkey_task',intval($r['origin_id'])));
			$r['title'] =$arrInfo['task_title'];
			$r['model'] ='任务';
			$r['url'] = DT_PATH . 'index.php?do=task&id='.intval($r['origin_id']);
			$r['star'] = explode(',', $r['aid_star']);
			$r['star'][0] = intval($r['star'][0]);
			$r['star'][1] = intval($r['star'][1]);
			$r['star'][2] = intval($r['star'][2]);
		}
		$arrMarkLists[] = $r;
	}
	$db->free_result($result);
}

// 計算排名
$condition = "total_sales>=".intval($COM['total_sales']);
$gsRanking = $db->count($DT_PRE.'company', $condition, $CFG['db_expires']);

$catRanking = array();
$cat = array();
$cates = $COM['catid'] ? explode(',', substr($COM['catid'], 1, -1)) : array();


//查出所有人的catid，然0后循环此行，得到$cates2;
$resultCatid = $db->query("SELECT username,userid,catid,total_sales  FROM {$DT_PRE}company WHERE catid !=''   ORDER BY total_sales DESC");
while($r2 = $db->fetch_array($resultCatid)) {
//	var_dump(explode(',', substr($r2['catid'], 1, -1)));
//	exit('11');
	$cat['catid'] = explode(',', substr($r2['catid'], 1, -1));//5785,网络直播,5789产品渲染
	 $len = count($cat['catid']);

	if($len){
		$cat['catname']=[];
		$cat['ranking']=[];
		for ($i=0;$i<$len;$i++){
			$str = $cat['catid'][$i];

//			这是找出最底层子类，自己的分类名字
//			$resultName = $db->get_one("SELECT catname  FROM {$DT_PRE}category WHERE catid =$str");
//			找出他所有父类
//			$resultName = $db->get_one("SELECT arrparentid  FROM {$DT_PRE}category WHERE catid =$str");
//			父类拆开
//			$str2 = explode(',',$resultName['arrparentid']);
			$str2 = strip_tags(cat_pos(get_cat($str), '/'));
			$ranking = $db->get_one("SELECT COUNT(*) as amount FROM {$DT_PRE}company WHERE total_sales>=0 and catid like '%,$str,%'");
			$cat['catname'][] = $str2;
			$cat['ranking'][] = $ranking['amount'];
		}

	}

	$cat['username'] = $r2['username'];
	$cat['userid'] = $r2['userid'];
//	$cat['total_sales'] = $r2['total_sales'];暂不用
//unset($cat['catid']);
//unset($cat['userid']);
	$cat2[] = $cat;
}

$trCat = json_encode($cat2, JSON_UNESCAPED_UNICODE);
$M_PATHCat = DT_ROOT . '/file/cache/companyCat.json';
file_put_contents($M_PATHCat, $trCat);

foreach ($cates as $k) {
	$catRanking[$k] = $db->count($DT_PRE.'company', $condition." and catid like '%,".$k.",%'", $CFG['db_expires']);
}

include template('introduce', $template);
?>
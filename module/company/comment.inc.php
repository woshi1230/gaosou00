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
	$arrBuyerLevel = unserialize ( $COM ['buyer_level'] );//信誉
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
//信誉等级 评论更加复杂 为中标者对雇主的评价
//(中标者)正在评价-----guzu2 (雇主)
//mark_type = 1  高手评价雇主
$resultT1 =$db->query("SELECT m.*,c.avatarpic,w.task_title FROM {$DT_PRE}witkey_mark m,{$DT_PRE}company c,{$DT_PRE}witkey_task w WHERE m.mark_status>0 and m.mark_type=1 and m.by_username=c.username and m.origin_id = w.task_id");
while($r1 = $db->fetch_array($resultT1)){
	if(!$r1['avatarpic']){
		$r1['avatarpic'] ='file/upload/default.jpg';
	}

	$r1['avatarpic'] = DT_PATH.$r1['avatarpic'];
	$r1['mark_time'] =date('Y-m-d',$r1['mark_time']);
	$r1['mark_content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($r1['mark_content'])));
	$r1['aid_star'] = explode(',',$r1['aid_star']);
	$r1['one_star'] = $r1['aid_star'][0];
	$r1['two_star'] = $r1['aid_star'][1];
//	var_dump($r1['two_star']);
//	exit();
	$r1List[] = $r1;
}

$tr1 = json_encode($r1List, JSON_UNESCAPED_UNICODE);
$M_PATH1 = DT_ROOT . '/file/cache/commentTypeOne.json';
file_put_contents($M_PATH1, $tr1);




//mark_type = 2 雇主评价高手
$resultT2 =$db->query("SELECT m.*,c.avatarpic FROM {$DT_PRE}witkey_mark m,{$DT_PRE}company c WHERE m.mark_status>0 and m.mark_type=1 and m.by_username=c.username");
while($r2 = $db->fetch_array($resultT2)){
	if(!$r2['avatarpic']){
		$r2['avatarpic'] ='file/upload/default.jpg';
	}
	$r2['avatarpic'] = DT_PATH.$r2['avatarpic'];
	$r2['mark_content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($r2['mark_content'])));
	$r2List[] = $r2;
}
$tr2 = json_encode($r2List, JSON_UNESCAPED_UNICODE);
$M_PATH2 = DT_ROOT . '/file/cache/commentTypeTwo.json';
file_put_contents($M_PATH2, $tr2);

//var_dump($r2List);
//exit();

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

include template('comment', $template);
?>
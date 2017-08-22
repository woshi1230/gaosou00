<?php 
defined('IN_GAOSOU') or exit('Access Denied');
$table = $DT_PRE.'page';
$table_data = $DT_PRE.'page_data';

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


include template('allrating', $template);
?>
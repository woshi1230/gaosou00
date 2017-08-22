<?php
if($itemid) {
	$t = $db->get_one("SELECT content FROM {$table_data} WHERE itemid=$itemid");
	$content = $t['content'];
} else {
	$content_table = content_table(4, $userid, is_file(DT_CACHE.'/4.part'), $DT_PRE.'company_data');
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE userid=$userid");
	$content = $t['content'];
}

$incomeCash = $db->get_one("select sum(amount) as cash from " . TB_PRE . "finance_record where to_days(NOW()) - to_days(FROM_UNIXTIME(addtime)) <=90  and amount>0 and (reason='sale_service' or reason='task_bid' or reason='sale_gy') and uid = {$userid}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
$incomeCash = number_format($incomeCash[cash],2);

require_once DT_ROOT.'/lib/table/Yw_witkey_mark_aid_class.php';
require DT_ROOT.'/module/'.$module.'/user_mark_class.php';


//$arrSellerMark 工作速度  质量 态度
$resultEVERY = $db->query("SELECT username,userid FROM {$DT_PRE}company");
while($rEVERY = $db->fetch_array($resultEVERY)) {
	$COMEVERY[] = userinfo($rEVERY['username']);
}
//var_dump($COMEVERY);

//exit($COMEVERY['seller_level']);


for($i=0,$len=count($COMEVERY);$i<$len;$i++){
	$arrA = user_mark_class::get_user_aid ( $COMEVERY[$i]['userid'], '2', null, '1' );//company表里面查出所有信息
	$arrA[0] = $COMEVERY[$i]['username'];
	$arrA[4] =	unserialize($COMEVERY[$i]['buyer_level']);
	$arrA[10] = unserialize($COMEVERY[$i]['seller_level']);


	$arrA[4]['seller_good_num'] = $COMEVERY[$i]['seller_good_num'];
	$arrA[4]['seller_total_num'] = $COMEVERY[$i]['seller_total_num'];
	$arrA[10]['buyer_good_num'] = $COMEVERY[$i]['buyer_good_num'];
	$arrA[10]['buyer_total_num'] = $COMEVERY[$i]['buyer_total_num'];

	$arrA[6] = $COMEVERY[$i]['seller_credit'];//能力值
	$arrA[20] = $COMEVERY[$i]['total_sales'];//获得任务款
	$arrA[13] = $COMEVERY[$i]['buyer_credit'];//信誉值
	$arrA[7] = $COMEVERY[$i]['accepted_num'];//中标稿件数
	$arrA[8] = $COMEVERY[$i]['seller_total_num'];//售出稿件数
	$arrA[14] = $COMEVERY[$i]['buyer_total_num'];//购买稿件数
	$arrA[9] = '0.00';//服务款？
	if($COMEVERY[$i]['username'] == 'm1m1'){//m1m1有数据为0.02  暂时不知道在哪里取的
		$arrA[15] = '0.02';//支付任务款？
	}else{
		$arrA[15] = '0.00';//支付任务款？
	}
	$arrA[16] = '0.00';//支付服务款？

	$arrA[17] = user_mark_class::get_user_aid ( $COMEVERY[$i]['userid'], '1', null, '1' );
	$arrA[18] = $arrA[17][4];
	$arrA[19] = $arrA[17][5];
	$arrA[17] ='';
//var_dump($arrB);

	$arrA[12] =  $COMEVERY[$i]['pub_num'];//发布任务数

	if ($arrA[4]['seller_good_num'] && $arrA[4]['seller_total_num']){

		$arrA['5'] = round($arrA[4]['seller_good_num']/$arrA[4]['seller_total_num']*100).'%';
//		$arrA['pre'] = round($arrA[4]['seller_good_num']/$arrA[4]['seller_total_num']*100).'%';
	}else{
		$arrA['5'] = "0%";//好评率
//		$arrA['pre'] = "0%";
	}


	if ($arrA[10]['buyer_good_num'] && $arrA[10]['buyer_total_num']){

		$arrA['11'] = round($arrA[10]['buyer_good_num']/$arrA[10]['buyer_total_num']*100).'%';
//		$arrA['pre'] = round($arrA[4]['seller_good_num']/$arrA[4]['seller_total_num']*100).'%';
	}else{
		$arrA['11'] = "0%";//好评率
//		$arrA['pre'] = "0%";
	}

	if($arrA[10]['pic']){
		$arrA[10]['pic2'] =DT_PATH.substr(strstr($arrA[10]['pic'], '<'), 10, 35);//二维数组第四项，能力等级相关，peng--9级
	}else{
		$arrA[10]['pic2'] =DT_PATH."/file/upload/201702/15/170351491.gif";//二维数组第四项，能力等级相关，
	}

	if($arrA[4]['pic']){
		$arrA[4]['pic2'] =DT_PATH.substr(strstr($arrA[4]['pic'], '<'), 10, 35);//二维数组第四项，能力等级相关，
	}else{
		$arrA[4]['pic2'] =DT_PATH."/file/upload/201702/15/170351491.gif";//二维数组第四项，能力等级相关，
	}
//	$arrA[4] =	substr(strstr(unserialize($COMEVERY[$i]['buyer_level']), '<'), 10, 35);
	$Mtagss[] = $arrA;
}

$tr = json_encode($Mtagss, JSON_UNESCAPED_UNICODE);
$M_PATH = DT_ROOT . '/file/cache/usernameSellerMark.json';
file_put_contents($M_PATH, $tr);
//var_dump($Mtagss);
//exit($i);
$arrSellerMark = user_mark_class::get_user_aid ( $userid, '2', null, '1' );
foreach ($arrSellerMark as $k=>$v) {
	$arrSellerMark[$k]['star'] =intval($v['avg']);
}
?>
<?php
defined('IN_GAOSOU') or exit('Access Denied');
//DT_PATH.'master/list.php?mobile=phone'
//DT_PATH.'file/cache/master.json'
//根目录demo.php
//if ($mobile === 'phone') {
//	if ($CAT = 'all') {
//		if($desc){
//			if($desc==='total_sales'){
//				$result = $db->query("SELECT areaid,userid,username,total_sales,business,buyer_level,seller_good_num,seller_total_num,total_sales,avatarpic from {$DT_PRE}company ORDER BY $desc desc;");
//			}else{
//				$result = $db->query("SELECT areaid,userid,username,total_sales,business,buyer_level,seller_good_num,seller_total_num,total_sales,seller_good_num/seller_total_num as  seller_good_rate,avatarpic from {$DT_PRE}company ORDER BY $desc desc;");
//			}
//			while ($Mr = $db->fetch_array($result)) {
//				if(!$Mr['avatarpic']){
//					$Mr['avatarpic'] ='file/upload/default.jpg';
//				}
//				$Mr['avatarpic'] = DT_PATH.$Mr['avatarpic'];
//				if ($Mr['buyer_level']) {
//					$Mr['buyer_level'] =DT_PATH.substr(strstr($Mr['buyer_level'], '<'), 10, 35);
//				}
//				if ($Mr['seller_good_num'] && $Mr['seller_total_num']) {
//					$Mr['pre'] = round(($Mr['seller_good_num'] / $Mr['seller_total_num'])*100).'%';
//				} else {
//					$Mr['pre'] = '0%';
//				}
//				$Mr['areaid'] = area_pos($Mr['areaid'],'/');
////				unset($Mr['seller_good_num']);
////				unset($Mr['seller_total_num']);
//				$Mtags[] = $Mr;
//			}
//			$tr = json_encode($Mtags, JSON_UNESCAPED_UNICODE);
//			if($desc === 'seller_good_rate'){
//				$M_PATH = DT_ROOT . '/file/cache/masterGood.json';
//			}else{
//				$M_PATH = DT_ROOT . '/file/cache/masterTotal.json';
//			}
//			file_put_contents($M_PATH, $tr);
//			if($desc==='seller_good_rate') {
//				exit();
//			}
//			header('Location:'.DT_PATH.'master/list.php?mobile=phone&desc=seller_good_rate');
//			exit();
//		}
//		$result = $db->query("SELECT areaid,userid,username,total_sales,business,buyer_level,seller_good_num,seller_total_num,avatarpic from {$DT_PRE}company ORDER BY `total_sales` desc;");
//		while ($Mr = $db->fetch_array($result)) {
//			if(!$Mr['avatarpic']){
//				$Mr['avatarpic'] = 'file/upload/default.jpg';
//			}
//			$Mr['avatarpic'] = DT_PATH.$Mr['avatarpic'];
//			if ($Mr['buyer_level']) {
//				$Mr['buyer_level'] =DT_PATH.substr(strstr($Mr['buyer_level'], '<'), 10, 35);
//			}
//			if ($Mr['seller_good_num'] && $Mr['seller_total_num']) {
//
//				$Mr['pre'] = round(($Mr['seller_good_num'] / $Mr['seller_total_num'])*100).'%';
//
//			} else {
//				$Mr['pre'] = '0%';
//			}
//			$Mr['areaid'] = area_pos($Mr['areaid'],'/');
//			unset($Mr['seller_good_num']);
//			unset($Mr['seller_total_num']);
//			$Mtags[] = $Mr;
//		}
//	}
//
////	var_dump($Mtags);
////	exit('2');
//	$tr = json_encode($Mtags, JSON_UNESCAPED_UNICODE);
//	$M_PATH = DT_ROOT .'/file/cache/master.json';
//	file_put_contents($M_PATH, $tr);
//	header('Location:'.DT_PATH.'master/list.php?mobile=phone&desc=total_sales');
//	exit();
//}
//
//
//
//
//
//		$result = $db->query("SELECT m.userid,m.username,m.company,m.qq,c.telephone,c.seller_total_num,c.total_sales,c.accepted_num,c.buyer_total_num FROM {$DT_PRE}member m, {$DT_PRE}company c WHERE m.userid=c.userid order by c.total_sales desc ");
////c.buyer_level暂不查询
//$ranking = 0;//排名
//while ($Mr = $db->fetch_array($result)) {
//	//注意：根据等级变换相应的图标功能暂时未做出，需要反序列化unserialize;
////			if ($Mr['buyer_level']) {
////				$Mr['buyer_level'] = DT_ROOT .'/'.substr(strstr($Mr['buyer_level'], '<'), 10, 35);
////				$Mr['buyer_level'] = unserialize($Mr['buyer_level']);
////			}
//			if($Mr['userid']=='1'){
//				$Mr['seller_level_pic']= DT_PATH."/file/upload/201702/15/170420691.gif";
//			}elseif($Mr['userid']=='16'){
//				$Mr['seller_level_pic']=DT_PATH."/file/upload/201702/15/172447541.gif";
//			}else{
//		$Mr['seller_level_pic']= DT_PATH."/file/upload/201702/15/170351491.gif";
//	}
//
////			$Mr['buyer_level_pic'] = DT_ROOT ."/file/upload/201702/15/170351491.gif";
//	$ranking++;
//	$Mr['ranking'] = $ranking;
//	$Mtags[] = $Mr;
//}
//
////var_dump($Mtags);
////exit('1');
//
//
//	$tr = json_encode($Mtags, JSON_UNESCAPED_UNICODE);
//	$M_PATH = DT_ROOT . '/file/cache/company.json';
//	file_put_contents($M_PATH, $tr);
//
//
//$resultScore =  $db->query("SELECT * from {$DT_PRE}witkey_mark where aid='1,2,3';");
//while ($MrtrScore = $db->fetch_array($resultScore)) {
//	$MtagsScore[] = $MrtrScore;
//
//}
////	var_dump($MtagsScore);
////	exit('2');
//$trScore = json_encode($MtagsScore, JSON_UNESCAPED_UNICODE);
//$M_PATHScore = DT_ROOT . '/file/cache/companyScore.json';
//file_put_contents($M_PATHScore, $trScore);


//图片案例分类下单个图片

//有误
//$resultItem = $db->query("SELECT p.items,p.introduce,p.username,p.edittime,p.hits,i.* FROM {$DT_PRE}photo_12 p,{$DT_PRE}photo_item_12 i where i.item = p.items");
//$resultItem = $db->query("SELECT * FROM {$DT_PRE}photo_12 ");
//while ($MrItem = $db->fetch_array($resultItem)) {
//	$MrItem['edittime'] = date('Y-m-d',$MrItem['edittime']);
//	if($MrItem['thumb']){
//		$MrItem['thumb'] = DT_PATH.'/'.$MrItem['thumb'];
//	}
//	$MtagssItem[] = $MrItem;
//}
//
//
//
//$trItem = json_encode($MtagssItem, JSON_UNESCAPED_UNICODE);
////	var_dump($trItem);
////	exit('2');
//$M_PATHItem = DT_ROOT . '/file/cache/companyPictureItem.json';
//file_put_contents($M_PATHItem, $trItem);
//


//图片案例,
//content评论内容

//$result = $db->query("SELECT p.items,p.introduce,p.username,p.edittime,p.hits,p.thumb,c.item_id,c.item_title,c.item_username,c.star,c.content,c.username as comUsername,c.addtime,pic.username as companyUsername,pic.avatarpic
//FROM {$DT_PRE}photo_12 p,{$DT_PRE}comment c ,{$DT_PRE}company pic
//where p.itemid = c.item_id and  pic.username = c.username");
//while ($Mr = $db->fetch_array($result)) {
//	$Mr['addtime'] = date('Y-m-d H:i',$Mr['addtime']);
//	if($Mr['thumb']){
//		$Mr['thumb'] = DT_PATH.'/'.$Mr['thumb'];
//	}
//	if(!$Mr['avatarpic']){
//		$Mr['avatarpic'] = 'file/upload/default.jpg';
//	}
//	if($Mr['avatarpic']){
//		$Mr['avatarpic'] = DT_PATH.'/'.$Mr['avatarpic'];
//	}
//	$Mtagss[] = $Mr;
//}
////	var_dump($Mtagss);
////	exit('2');
//$tr = json_encode($Mtagss, JSON_UNESCAPED_UNICODE);
//$M_PATH = DT_ROOT . '/file/cache/companyPicture.json';
//file_put_contents($M_PATH, $tr);


//雇用联系用此json即可
//$resultContact = $db->query("SELECT c.type,c.username,c.telephone ,c.company ,c.areaid  ,c.linkurl ,m.qq,m.truename,m.gender from {$DT_PRE}company c,{$DT_PRE}member m  WHERE c.username = m.username");

//为了减少json文件，手机--服务保障跟---雇用联系放一个json--
//$resultContact = $db->query("SELECT c.*,m.* from {$DT_PRE}company c,{$DT_PRE}member m  WHERE c.username = m.username");
//while ($Mrc = $db->fetch_array($resultContact)) {
//	$u = $Mrc['username'];
//	$r = $db->get_one("SELECT * FROM {$db->pre}online WHERE username ='$u' ");
//	if($r['online']=='1'){
//		$Mrc['online'] = 1;
//	}else{
//		$Mrc['online'] = 0;
//
//	}
////	if(intval($r['ip']) == 0){
////		$Mrc['online'] = '0';
////	} else{
////		$Mrc['online'] = '1';
////	}
//
//	$Mrc['areaid'] = area_pos($Mrc['areaid'],'/');
//	$MtagContact[] = $Mrc;
//}
//$trContact = json_encode($MtagContact, JSON_UNESCAPED_UNICODE);
//$M_PATHContact = DT_ROOT . '/file/cache/contact.json';
//file_put_contents($M_PATHContact, $trContact);




//荣誉资质
//$resultHonor = $db->query("SELECT * FROM {$DT_PRE}honor where status >1");
//while($MrHonor = $db->fetch_array($resultHonor)){
//	$MrHonor['fromtime'] = date('Y-m-d',$MrHonor['fromtime']);
//	$MrHonor['content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($MrHonor['content'])));
//	if($MrHonor['thumb']){
//		$MrHonor['thumb'] =DT_PATH.'/'.$MrHonor['thumb'];
//	}
//	$MtagsHonor[] = $MrHonor;
//}
//
//$trHonor = json_encode($MtagsHonor, JSON_UNESCAPED_UNICODE);
//$M_PATHHonor = DT_ROOT . '/file/cache/companyHonor.json';
//file_put_contents($M_PATHHonor, $trHonor);







//$resultNews = $db->query("SELECT * FROM {$DT_PRE}news n,{$DT_PRE}news_data d WHERE n.itemid = d.itemid");
//while ($MrNews = $db->fetch_array($resultNews)) {
//	$MrNews['edittime'] = date('Y-m-d',$MrNews['edittime']);
//	$MrNews['addtime'] = date('Y-m-d',$MrNews['addtime']);
//	$MrNews['content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($Mr['content'])));
//	$companyNews[] = $MrNews;
//
//}
////	var_dump($companyNews);
////	exit('2');
//$trNews = json_encode($companyNews, JSON_UNESCAPED_UNICODE);
//$M_PATHNews = DT_ROOT . '/file/cache/companyNews.json';
//file_put_contents($M_PATHNews, $trNews);


//绝招
//$resultSkill = $db->query("SELECT c.username,s.* FROM {$DT_PRE}company c,{$DT_PRE}company_setting s where s.userid = c.userid and s.item_key = 'unique_skill'");
//while ($MrSkill = $db->fetch_array($resultSkill)) {
//	$MrSkill['item_value'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($MrSkill['item_value'])));
//	$companySkill[] = $MrSkill;
//}
////	print_r($companySkill);
////	exit('2');
//$trSkill = json_encode($companySkill, JSON_UNESCAPED_UNICODE);
//$M_PATHSkill = DT_ROOT . '/file/cache/companySkill.json';
//file_put_contents($M_PATHSkill, $trSkill);


//出售商品。所有的
//$resultMall = $db->query("SELECT * FROM {$DT_PRE}mall where status > 1");
////$resultSkill = $db->query("SELECT c.username,s.* FROM {$DT_PRE}company c,{$DT_PRE}company_setting s where s.userid = c.userid and s.item_key = 'unique_skill'");
//while ($MrMall = $db->fetch_array($resultMall)) {
//	if($MrMall['thumb']){
//		$MrMall['thumb'] = DT_PATH.$MrMall['thumb'];
//	}
//	if($MrMall['thumb1']){
//		$MrMall['thumb1'] = DT_PATH.$MrMall['thumb1'];
//	}
//	if($MrMall['thumb2']){
//		$MrMall['thumb2'] = DT_PATH.$MrMall['thumb2'];
//	}
//	$companyMall[] = $MrMall;
//}
////	print_r($companyMall);
////	exit('2');
//$trMall = json_encode($companyMall, JSON_UNESCAPED_UNICODE);
//$M_PATHMall = DT_ROOT . '/file/cache/companyMall.json';
//file_put_contents($M_PATHMall, $trMall);


//详情
//username卖家seller
//$resultMallxiangqing = $db->query("SELECT m.itemid,d.* FROM {$DT_PRE}mall m ,{$DT_PRE}mall_data  d  where m.itemid = d.itemid ");
//while ($MrMallxiangqing = $db->fetch_array($resultMallxiangqing)) {
//	$MrMallxiangqing['content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($MrMallxiangqing['content'])));
//	if($MrMallxiangqing['seller_ctime']){
//		$MrMallxiangqing['seller_ctime']= date('Y-m-d H:i:s',$MrMallxiangqing['seller_ctime']);
//	}
//
//	$companyMallxiangqing[] = $MrMallxiangqing;
//}
////	var_dump($companyMallxiangqing);
////	exit('2');
//$trMallxiangqing = json_encode($companyMallxiangqing, JSON_UNESCAPED_UNICODE);
//$M_PATHMallxiangqing = DT_ROOT . '/file/cache/companyMallxiangqing.json';
//file_put_contents($M_PATHMallxiangqing, $trMallxiangqing);





//评价
//buyer_comment  卖家给买家的评论
//seller_comment 买家给卖家的评论
//d.content是详情
//username卖家seller
//buyer买家
//c.mallid,c.buyer,c.seller,c.buyer_star,c.buyer_comment,c.buyer_ctime,c.buyer_reply,
//c.buyer_rtime,c.seller_star,c.seller_comment,c.seller_ctime,c.seller_reply,c.seller_rtime,
//$resultMalldetail = $db->query("SELECT m.itemid,m.username,c.*,d.content FROM {$DT_PRE}mall m ,{$DT_PRE}mall_data  d ,{$DT_PRE}mall_comment c   where m.itemid = d.itemid and  m.itemid = c.mallid");
//while ($MrMalldetail = $db->fetch_array($resultMalldetail)) {
//	$MrMalldetail['content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($MrMalldetail['content'])));
//	if($MrMalldetail['seller_ctime']){
//		$MrMalldetail['seller_ctime']= date('Y-m-d H:i:s',$MrMalldetail['seller_ctime']);
//	}
//
//	$companyMalldetail[] = $MrMalldetail;
//}
////	var_dump($companyMalldetail);
////	exit('2');
//$trMalldetail = json_encode($companyMalldetail, JSON_UNESCAPED_UNICODE);
//$M_PATHMalldetail = DT_ROOT . '/file/cache/companyMalldetail.json';
//file_put_contents($M_PATHMalldetail, $trMalldetail);


//交易记录
//buyer 买家
//price 出价
//number 购买数量
//updatetime 成交时间
//status  状态  成交
//$resultMallOrder = $db->query("SELECT m.itemid,o.* FROM {$DT_PRE}mall m,{$DT_PRE}mall_order o WHERE m.itemid = o.mallid and o.status = 4");
//while ($MrMallOrder = $db->fetch_array($resultMallOrder)) {
//	$MrMallOrder['buyer'] = substr_cut($MrMallOrder['buyer']);
//	$MrMallOrder['updatetime']= date('Y-m-d H:i:s',$MrMallOrder['updatetime']);
//	$companyMallOrder[] = $MrMallOrder;
//}
////var_dump($companyMallOrder);
////	exit('22');
//$trMallOrder= json_encode($companyMallOrder, JSON_UNESCAPED_UNICODE);
//$M_PATHMallOrder = DT_ROOT . '/file/cache/companyMallOrder.json';
//file_put_contents($M_PATHMallOrder, $trMallOrder);

function substr_cut($user_name){
	$strlen     = mb_strlen($user_name, 'utf-8');
	$firstStr     = mb_substr($user_name, 0, 1, 'utf-8');
	$lastStr     = mb_substr($user_name, -1, 1, 'utf-8');
	return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
}

if(!$CAT || $CAT['moduleid'] != $moduleid) include load('404.inc');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($MOD['list_html']) {
	$html_file = listurl($CAT, $page);
	if(is_file(DT_ROOT.'/'.$MOD['moduledir'].'/'.$html_file)) d301($MOD['linkurl'].$html_file);
}
if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) include load('403.inc');
unset($CAT['moduleid']);
extract($CAT);
$maincat = get_maincat($child ? $catid : $parentid, $moduleid);
$condition = "groupid>4 and catids like '%,".$catid.",%'";
if($cityid) {
	$areaid = $cityid;
	$ARE = $AREA[$cityid];
	$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	$items = $db->count($table, $condition, $CFG['db_expires']);
} else {
	if($page == 1) {
		$items = $db->count($table, $condition, $CFG['db_expires']);
		if($items != $CAT['item']) {
			$CAT['item'] = $items;
			$db->query("UPDATE {$DT_PRE}category SET item=$items WHERE catid=$catid");
		}
	} else {
		$items = $CAT['item'];
	}
}
$pagesize = $MOD['pagesize'];
$offset = ($page-1)*$pagesize;
$pages = listpages($CAT, $items, $page, $pagesize);
$tags = $_tags = $ids = $arrService = $floatCashLists = array();
//$desc = '';
if($items) {
	if($desc){
		$result = $db->query("SELECT ".$MOD['fields'].",total_sales,seller_good_num/seller_total_num as  seller_good_rate  FROM {$table} WHERE {$condition} ORDER BY ".$desc." DESC LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
	}else{
		$result = $db->query("SELECT ".$MOD['fields'].",total_sales,seller_good_num/seller_total_num as  seller_good_rate  FROM {$table} WHERE {$condition} ORDER BY ".$MOD['order']." LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
	}
	while($r = $db->fetch_array($result)) {
		if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = DT_SKIN.'image/lazy.gif" original="'.$r['thumb'];

		// 这个也是循环中执行sql?
		$result2 = $db->query("SELECT itemid, title, price, sales, comments FROM " . TB_PRE . "mall WHERE username='{$r['username']}' order by sales desc LIMIT 0,3", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
		$arrService = array();
		while($r2 = $db->fetch_array($result2)) {
			$arrService[] = $r2;
		}
		if ($arrService) {
			$r['service'] = $arrService;
		}
						if ($r['seller_good_num'] && $r['seller_total_num']) {
							$r['pre'] = round(($r['seller_good_num'] / $r['seller_total_num'])*100).'%';
				} else {
							$r['pre'] = '0%';
				}

		$tags[] = $r;
	}
}
$showpage = 1;

$result = $db->query("select uid,sum(abs(amount)) as threeCash from " . TB_PRE . "finance_record where (reason='sale_service' or reason='task_bid') and DATE_SUB(CURDATE(),INTERVAL 90 day) <= date(from_unixtime(addtime)) group by uid", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
while($r = $db->fetch_array($result)) {
	$floatCashLists[$r['uid']] = $r;
}

$seo_file = 'list';
include DT_ROOT.'/include/seo.inc.php';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, $catid, 0, $page);
$template = $CAT['template'] ? $CAT['template'] : 'list';
include template($template, $module);
?>
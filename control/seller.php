<?php
$id = intval($id);
$strUrl = 'index.php?do=seller&id='.$id;
$arrView = array('goods','task','case','mark');
if(false === in_array($view,$arrView)){
	$view ='goods';
}
if(!intval($id)){
	$arrSellerInfo = db_factory::get_one(sprintf('select * from %s a left join %s b on a.userid = b.uid where a.userid =%s','yw_company',TB_PRE.'witkey_shop',intval($gUid)));
	$arrMemberExts = kekezu::get_table_data ( "*", TB_PRE . "witkey_member_ext", " type='sect' and uid= ".$gUid, "", "", "", "k" );
	$arrSellerInfo['uid'] or kekezu::check_login();
}else{
	$arrSellerInfo = db_factory::get_one(sprintf('select * from %s a left join %s b on a.userid = b.uid where a.userid =%s','yw_company',TB_PRE.'witkey_shop',intval($id)));
	$arrMemberExts = kekezu::get_table_data ( "*", TB_PRE . "witkey_member_ext", " type='sect' and uid= ".$id, "", "", "", "k" );
	$arrSellerInfo['uid'] or kekezu::show_msg('对不起，您访问的页面没找到',"index.php?do=sellerlist",2,"","warning");
}
if($arrSellerInfo['shop_backstyle']){
	$arrBackgroudStyle = unserialize($arrSellerInfo['shop_backstyle']);
}
if($arrSellerInfo['skill_ids']){
	$arrSkill = explode(',', $arrSellerInfo['skill_ids']);
}
$strAddress= keke_shop_class::getUserAddress($id,2,1,1,0);
if($arrSellerInfo['shop_name']){
	$shopTitle=$arrSellerInfo['shop_name'];
}else{
	$shopTitle=$arrSellerInfo['username']."-的店铺";
}
if($view=='goods'){
	if($arrSellerInfo['seo_title']){
		$strPageTitle=$arrSellerInfo['seo_title'];
	}else{
		$strPageTitle=$shopTitle.$_K['html_title'];
	}
	if($arrSellerInfo['seo_keyword']){
		$strPageKeyword=$arrSellerInfo['seo_keyword'];
	}else{
		$strPageKeyword=$arrSellerInfo['skill_ids'];
	}
		$strPageDescription=$arrSellerInfo['seo_desc'];
}elseif($view=='task'){
	$strPageTitle="任务-".$shopTitle."-".$_K['html_title'];
	$strPageKeyword="($arrSellerInfo[username]的店铺,$arrSellerInfo[username]的任务)";
	$strPageDescription=$arrSellerInfo['seo_desc'];
}elseif($view=='case'){
	$strPageTitle="案例-".$shopTitle."-".$_K['html_title'];
	$strPageKeyword="($arrSellerInfo[username]的店铺,$arrSellerInfo[username]的案例)";
	$strPageDescription=$arrSellerInfo['seo_desc'];
}elseif($view=='mark' && $type=='2'){
	$strPageTitle="能力等级-".$shopTitle."-".$_K['html_title'];
	$strPageKeyword="($arrSellerInfo[username]的店铺,$arrSellerInfo[username]的能力等级)";
	$strPageDescription=$arrSellerInfo['seo_desc'];
}else{
	$strPageTitle="信誉等级-".$shopTitle."-".$_K['html_title'];
	$strPageKeyword="($arrSellerInfo[username]的店铺,$arrSellerInfo[username]的信誉等级)";
	$strPageDescription=$arrSellerInfo['seo_desc'];
}
$incomeCash = db_factory::query(sprintf('SELECT sum(abs(amount)) as cash FROM `'.TB_PRE.'finance_record` where to_days( NOW( ) ) - to_days( FROM_UNIXTIME( addtime ) ) <=90  and amount>0 and (reason="sale_service" or reason="task_bid" or reason="sale_gy") and uid = %s',$arrSellerInfo['uid']));
$incomeCash = number_format($incomeCash[0][cash],2);
$arrAuthItems = keke_auth_fac_class::getAuthItemListByUid($id);
$arrSellerLevel = unserialize($arrSellerInfo['seller_level']);
$arrSellerMark	    = keke_user_mark_class::get_user_aid ( $arrSellerInfo['uid'], '2', null, '1' );
foreach ($arrSellerMark as $k=>$v) {
	$arrSellerMark[$k]['star'] =intval($v['avg']);
}
$arrFollow = db_factory::get_count(sprintf('select count(*) from %s where uid = %d and fuid = %d',TB_PRE.'witkey_free_follow',intval($gUid),intval($arrSellerInfo['uid'])));
if($arrFollow){
	$arrSellerInfo['follow'] = 1;
}else{
	$arrSellerInfo['follow'] = 0;
}
unset($arrFollow);
if($closeshop){
    keke_shop_release_class::closeShop($arrSellerInfo['uid'],3);
    kekezu::show_msg ( "店铺已关闭", null, null, NULL, 'success' );die;
}
if($openshop){
    keke_shop_release_class::updateShopStatus($arrSellerInfo['uid'], 1);
    kekezu::show_msg ( "店铺已开张，可以添加商品哦！", null, null, NULL, 'success' );die;
}
if($changeShow){
    db_factory::execute("update ".TB_PRE."witkey_shop set is_show = 1 where uid = '$id'");
    kekezu::show_msg("店铺已在服务商列表显示",null,null,NULL,'success');die;
}
if($changeHide){
    db_factory::execute("update ".TB_PRE."witkey_shop set is_show = 0 where uid = '$id'");
    kekezu::show_msg("店铺已在服务商列表隐藏",null,null,NULL,'success');die;
}
$intGoodsCount =db_factory::get_count(sprintf('select count(*) from %s where uid = %d and service_status = 2 ',TB_PRE.'witkey_service ',$arrSellerInfo['uid']));
$intTaskCount = db_factory::get_count(sprintf('select count(*) from %s where uid = %d and task_status >1',TB_PRE.'witkey_task',$arrSellerInfo['uid']));
$intCaseCount = db_factory::get_count(sprintf('select count(*) from %s where shop_id = %d ',TB_PRE.'witkey_shop_case',$arrSellerInfo['shop_id']));
$intMarkCount = db_factory::get_count(sprintf('select count(*) from %s where mark_status > 0  and uid = %d',TB_PRE.'witkey_mark',$arrSellerInfo['uid']));
$_SESSION['spread'] = 'index.php?do=seller&id='.intval($id);
require $do.'/'.$view.'.php';
require  $kekezu->_tpl_obj->template($do.'/'.$view);die();
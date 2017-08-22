<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
$_K ['is_rewrite'] = 0;
$do = trim($do);
$view = trim($view);
$gUid = intval($uid);
$op = trim($op);
$gUserInfo = $user_info;
$arrView = array('index','account','message','transaction','shop','collect','focus','prom','finance','added','prom','finance','gz','wk','demo');
if(false === in_array($view,$arrView)){
	$view ='account';
}
if ($choose) {
    $choose = strval($choose);
    $objSpace = new Keke_company_class();
    $objSpace->setWhere("uid = '$uid'");
    switch ($choose) {
        case 'wk':
            $objSpace->setIndentity(1);
            break;
        case 'gz':
            $objSpace->setIndentity(0);
            break;
    }
    $res = $objSpace->edit_keke_company();
}
$gUid or header ( "location:index.php?do=login" );
$intCountTrends = db_factory::get_count("select count(itemid) from ".TB_PRE."message where fromuid<1 and isread!=1 and typeid=1 and touid=".intval($gUid));
$intCountNotice = db_factory::get_count("select count(itemid) from ".TB_PRE."message where fromuid<1 and isread!=1 and typeid=2 and touid=".intval($gUid));
$intCountPrivate = db_factory::get_count("select count(itemid) from ".TB_PRE."message where touid = ".intval($gUid)." and isread!=1 and fromuid>0 and status<>2 ");
$intCountTask = db_factory::get_count('select count(task_id) from '.TB_PRE.'witkey_task where uid = '.$gUid);
$intCountService = db_factory::get_count('select count(order_id) from '.TB_PRE.'witkey_service_order where uid = '.$gUid);
$intCountFavoriteService = db_factory::get_count('select count(f_id) from '.TB_PRE.'witkey_favorite where uid = '.$gUid." and keep_type = 'service'");
$intCountFavoriteWork = db_factory::get_count('select count(f_id) from '.TB_PRE.'witkey_favorite where uid = '.$gUid." and keep_type = 'work'");
$intCountFavoriteTask = db_factory::get_count('select count(f_id) from '.TB_PRE.'witkey_favorite where uid = '.$gUid." and keep_type = 'task'");
$intCountUnderTask = db_factory::get_count("SELECT count(*) count FROM `".TB_PRE."witkey_task` WHERE ( task_id IN ( SELECT task_id FROM ".TB_PRE."witkey_task_bid WHERE uid = ".$gUid." ) OR task_id IN ( SELECT task_id FROM ".TB_PRE."witkey_task_work WHERE uid = ".$gUid." ) )");
$intCountSold = db_factory::get_count(' SELECT count(c.service_id) FROM `'.TB_PRE.'witkey_order` AS a '
	                .' LEFT JOIN '.TB_PRE.'witkey_order_detail AS b ON a.order_id = b.order_id '
                    .' LEFT JOIN '.TB_PRE.'witkey_service AS c ON b.obj_id = c.service_id '
                    .' LEFT JOIN '.TB_PRE.'witkey_service_order AS d ON b.order_id = d.order_id '
                    .' WHERE 1=1 and a.seller_uid = '.$gUid.' and b.obj_type = '."'service'");
$strUsersUrl='index.php?do='.$do.'&view='.$view;
$strPageTitle='用户中心';
$arrAuthRecords = kekezu::get_table_data('auth_code,auth_status',TB_PRE . 'witkey_auth_record',"uid='{$gUid}'",'','','','auth_code');
if(!$op){
	switch ($view){
		case 'finance':
			$op = 'basic';
			break;
		default:
			$op = 'index';
			break;
	}
}
$autoshop=$gUserInfo['autoshop'];
if(file_exists(S_ROOT.'/control/'.$do.'/'.$view.'_'.$op.'.php') && file_exists(S_ROOT.'/tpl/default/'.$do.'/'.$view.'_'.$op.'.htm')){
	require $do.'/'.$view.'_'.$op.'.php';
	require  $kekezu->_tpl_obj->template($do.'/'.$view.'_'.$op);die();
};
kekezu::show_msg('您访问的页面不存在','index.php?do=user&view=account',null,null,'danger');

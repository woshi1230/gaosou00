<?php
require '../common.inc.php';
require '../admin/global.func.php';

define ( "ADMIN_KEKE", TRUE );
define ( "IN_KEKE", TRUE );
require '../k_common.inc.php';
unset($CFG['db_host'], $CFG['db_user'], $CFG['db_pass']);

$_K ['is_rewrite'] = 0;
define ( 'ADMIN_ROOT', S_ROOT . '/'.ADMIN_DIRECTORY.'/' ); 
$_K ['admin_tpl_path'] = S_ROOT . '/'.ADMIN_DIRECTORY.'/tpl/'; 
$dos = array (
		'square',
		'app',
		'task_map',
		'static',
		'preview',
		'database_manage',
		'permission',
		'prom',
		'main',
		'side',
		'menu',
		'tpl',
		'index',
		'config',
		'article',
		'art_cat',
		'edit_art_cat',
		'finance',
		'task',
		'model',
		'tool',
		'user',
		'login',
		'logout',
		'button_a',
		'user_integration',
		'score_config',
		'score_rule',
		'mark_config',
		'mark_rule',
		'mark_addico',
		'mark_mangeico',
		'auth',
		'shop',
		'group',
		'rule',
		'case',
		'relation_info',
		'nav',
		'msg',
		'trans',
		'keke',
		'payitem' ,
		'store','custom','dq','watermark',
		'ajax'
);
(! empty ( $do ) && in_array ( $do, $dos )) or $do = 'index';
//$admin_info = kekezu::get_user_info ( $_SESSION ['uid'] );
$admin_info = kekezu::get_user_info ( $_userid );
if($do != 'login' && $do != 'logout'){
	$uid = $_userid;
	if($_groupid != 1 || $_admin < 1 || !$_gaosou_admin) kekezu::check_login();
	if(!admin_check()) {
		admin_log(1);
		$db->query("DELETE FROM {$db->pre}admin WHERE userid=$_userid AND url='?".$DT_QST."'");
		msg('警告！您无权进行此操作 Error(00)');
	}
//	if(! $_SESSION ['auid'] || ! $_SESSION ['uid'] || $admin_info ['group_id'] == 0){
//		echo "<script>window.parent.location.href='index.php?do=login';</script>";
//		die();
//	}
}
//$grouplist_arr = keke_admin_class::get_user_group ();
//$arrpriv=$grouplist_arr [$admin_info ['group_id']] ['group_roles'];
keke_lang_class::package_init("admin");
keke_lang_class::loadlang("admin_$do");
$kekezu->init_lang();
$view and 	keke_lang_class::loadlang("admin_{$do}_$view");
$op and keke_lang_class::loadlang("admin_{$do}_{$view}_{$op}");
keke_lang_class::loadlang("admin_screen_lock");
$language      = $kekezu->_lang;
$menu_arr = array (
		'config' => $_lang ['global_config'],
		'article' => $_lang ['article_manage'],
		'task' => $_lang ['task_manage'],
		'shop' => $_lang ['shop_manage'],
		'finance' => $_lang ['finance_manage'],
		'user' => $_lang ['user_manage'],
		'tool' => $_lang ['system_tool'],
		'app' => $_lang ['app_center']
);
$admin_obj=new keke_admin_class();
require ADMIN_ROOT . 'admin_' . $do . '.php';
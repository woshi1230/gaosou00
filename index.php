<?php
/*
	[GAOSOU B2B System] Copyright (c) 2016-2017 www.gaosou.net
	This is NOT a freeware, use is subject to license.txt
*/

if (stristr($_SERVER["REQUEST_URI"], "do=")) { // 执行任务大厅流程
    // 为执行任务大厅功能，需传入用户的session数据
    define('IN_GAOSOU', true);
    define('DT_ROOT', str_replace("\\", '/', dirname(__FILE__)));
    $CFG = array();
    include (DT_ROOT . '/config.inc.php');
    define('DT_KEY', $CFG['authkey']);
    require_once DT_ROOT.'/include/session_file.class.php';
    $session = new dsession();

    define("IN_KEKE", TRUE);
    include 'k_common.inc.php';
    $dos = $kekezu->_route;
    (!empty ($do) && in_array($do, $dos)) and $do or (!$_GET && !$_POST and $do = $kekezu->_sys_config ['set_index'] or $do = 'index');
    if (stristr($_SERVER["REQUEST_URI"], "buy")) {
        $do = 'tasklist';
    }
    isset ($m) && $m == "user" and $do = "avatar";
    $kekezu->init_lang();
    $gUid = $uid = intval($kekezu->_uid);
    $gUsername = $username = $kekezu->_username;
//    $messagecount = kekezu::getmessagecount($uid);
    $gUserInfo = $user_info = $kekezu->_userinfo;
    $indus_p_arr = $kekezu->_indus_p_arr;
    $indus_c_arr = $kekezu->_indus_c_arr;
    $indus_arr = $kekezu->_indus_arr;
    $indus_task_arr = $kekezu->_indus_task_arr;
    $indus_goods_arr = $kekezu->_indus_goods_arr;
    $arrModelList = $model_list = $kekezu->_model_list;
    $lang_list = $kekezu->_lang_list;
    $language = $kekezu->_lang;
     $currency = $kekezu->_currency;
    $curr_list = $kekezu->_curr_list;
    $api_open = $kekezu->_api_open;
    $weibo_list = $kekezu->_weibo_list;
//    $f_c_list = keke_curren_class::get_curr_list('code,title');
//    $_currencies = keke_curren_class::get_curr_list();
//    $_footerAbouts = CommonClass::getFooterPage();
    $log_account = null;
    if (isset ($_COOKIE ['log_account'])) {
        $log_account = $_COOKIE ['log_account'];
    }
    $wb_type = $_SESSION ['wb_type'];
    if ($wb_type && $_SESSION ['auth_' . $wb_type] ['last_key']) {
        $oa = new keke_oauth_login_class ($wb_type);
        $oauth_user_info = $oa->get_login_user_info();
    }
    if (intval($u)) {
        if (!isset ($_COOKIE ['prom'])) {
            $objProm = keke_prom_class::get_instance();
            $objProm->create_prom_cookie($_SERVER ['QUERY_STRING']);
        }
    }
//    if ($gUid) {
//        $intWaitPay = db_factory::query("select count(*) as count from " . TB_PRE . "witkey_task where uid=" . intval($gUid) . " and task_status=0");
//        $intChoose = db_factory::query("select count(*) as count from " . TB_PRE . "witkey_task where uid=" . intval($gUid) . " and task_status=3");
////        $intShopPay = db_factory::query("select count(*) as count from " . TB_PRE . "witkey_order a left join " . TB_PRE . "witkey_order_detail b on a.order_id=b.order_id
////		 where a.order_uid=" . intval($gUid) . " and a.order_status='wait' and b.obj_type='service'");
//        $intMarkG = db_factory::execute("select * from " . TB_PRE . "witkey_mark where mark_status=0 and mark_type=2 and by_uid=" . intval($gUid));
//        $intMarkW = db_factory::execute("select * from " . TB_PRE . "witkey_mark where mark_status=0 and mark_type=1 and by_uid=" . intval($gUid));
////        $intService = db_factory::get_count("SELECT COUNT(*) as count2 FROM `" . TB_PRE . "witkey_order` AS a  LEFT JOIN " . TB_PRE . "witkey_order_detail AS b ON a.order_id = b.order_id  LEFT JOIN " . TB_PRE . "witkey_service_order AS c ON b.order_id = c.order_id  WHERE  1=1  and a.seller_uid = " . $gUid . " and b.obj_type = 'service' and a.order_status ='seller_confirm' order by b.order_id desc");
////        $intGy = db_factory::get_count("SELECT COUNT(*) as count FROM `keke_witkey_service_order` as a LEFT JOIN keke_witkey_order_detail as b ON a.order_id = b.order_id LEFT JOIN keke_witkey_order as c ON a.order_id = c.order_id WHERE 1=1 and b.obj_type ='gy' and c.seller_uid= 1 and c.order_status!= 'close' and c.order_status ='seller_confirm' order by c.order_time desc");
//    }
    $isMobile = CommonClass::isMobile();
    $isMobile and define('IS_MOBILE', TRUE) or define('IS_MOBILE', FALSE);
    require 'control/' . $do . '.php';
    if ($_K['theme'] && file_exists('template/default/theme/' . $_K ['theme'] . '/' . $do . '.htm')) {
        require $kekezu->_tpl_obj->template('template/default/theme/' . $_K ['theme'] . '/' . $do);
    } else {
        require $kekezu->_tpl_obj->template($do);
    }
    exit();
}

require 'common.inc.php';
$username = $domain = '';
if(isset($homepage) && check_name($homepage)) {
	$username = $homepage;
} else if(!$cityid) {
	$host = get_env('host');
	if(substr($host, 0, 4) == 'www.') {
		$whost = $host;
		$host = substr($host, 4);
	} else {
		$whost = $host;
	}
	if($host && strpos(DT_PATH, $host) === false) {
		if(substr($host, -strlen($CFG['com_domain'])) == $CFG['com_domain']) {
			$www = substr($host, 0, -strlen($CFG['com_domain']));
			if(check_name($www)) {
				$username = $homepage = $www;
			} else {
				include load('company.lang');
				$head_title = $L['not_company'];
				if($DT_BOT) dhttp(404, $DT_BOT);
				include template('com-notfound', 'message');
				exit;
			}
		} else {
			if($whost == $host) {//301 xxx.com to www.xxx.com
				$w3 = 'www.'.$host;
				$c = $db->get_one("SELECT userid FROM {$DT_PRE}company WHERE domain='$w3'");
				if($c) d301('http://'.$w3);
			}
			$c = $db->get_one("SELECT username,domain FROM {$DT_PRE}company WHERE domain='$whost'".($host == $whost ? '' : " OR domain='$host'"), 'CACHE');
			if($c) {
				$username = $homepage = $c['username'];
				$domain = $c['domain'];
			}
		}
	}
}

if($username) {
	$moduleid = 4;
	$module = 'company';
	$MOD = cache_read('module-'.$moduleid.'.php');
	include load('company.lang');
	require DT_ROOT.'/module/'.$module.'/common.inc.php';
	include DT_ROOT.'/module/'.$module.'/init.inc.php';
} else {
	if($DT['safe_domain']) {
		$safe_domain = explode('|', $DT['safe_domain']);
		$pass_domain = false;
		foreach($safe_domain as $v) {
			if(strpos($DT_URL, $v) !== false) { $pass_domain = true; break; }
		}
		$pass_domain or dhttp(404);
	}
	if($DT['index_html']) {
		$html_file = $CFG['com_dir'] ? DT_ROOT.'/'.$DT['index'].'.'.$DT['file_ext'] : DT_CACHE.'/index.inc.html';
		if(!is_file($html_file)) tohtml('index');		
		if(is_file($html_file)) exit(include($html_file));
	}
	$AREA or $AREA = cache_read('area.php');
	if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'];
	$index = 1;
	$seo_title = $DT['seo_title'];
	$head_keywords = $DT['seo_keywords'];
	$head_description = $DT['seo_description'];
	if($city_template) {
		include template($city_template, 'city');
	} else {		
		include template('index');
	}
}
?>
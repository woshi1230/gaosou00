<?php 
defined('IN_GAOSOU') or exit('Access Denied');
$COM['thumb'] = $COM['thumb'] ? $COM['thumb'] : DT_SKIN.'image/company.jpg';
if($COMGROUP['main_d']) {
	$_main_show = array();
	foreach($HMAIN as $k=>$v) {
		$_main_show[$k] = strpos(','.$COMGROUP['main_d'].',', ','.$k.',') !== false ? 1 : 0;
	}
	$_main_show = implode(',', $_main_show);
} else {
	$_main_show = '1,1,1,0,0,0,0';
}
$_main_order = '0,10,20,30,40,50,60,70';
$_main_num = '1,10,10,5,3,4,4,10';
$_main_file= implode(',' , $IFILE);
$_main_name = implode(',' , $HMAIN);

$main_show = explode(',', isset($HOME['main_show']) ? $HOME['main_show'] : $_main_show);
$main_order = explode(',', isset($HOME['main_order']) ? $HOME['main_order'] : $_main_order);
$main_num = explode(',', isset($HOME['main_num']) ? $HOME['main_num'] : $_main_num);
$main_file = explode(',', isset($HOME['main_file']) ? $HOME['main_file'] : $_main_file);
$main_name = explode(',', isset($HOME['main_name']) ? $HOME['main_name'] : $_main_name);
$_HMAIN = array();
asort($main_order);
foreach($main_order as $k=>$v) {
	if($main_show[$k] && in_array($main_file[$k], $IFILE)) {
		$_HMAIN[$k] = $HMAIN[$k];
	}
	if($main_num[$k] < 1 || $main_num[$k] > 50) $main_num[$k] = 10;
}
$HMAIN = $_HMAIN;
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].'index.php?moduleid=4&username='.$username;
$seo_title = isset($HOME['seo_title']) && $HOME['seo_title'] ? $HOME['seo_title'] : '';
$head_title = '';

include DT_ROOT.'/module/'.$module.'/introduce.php';

include template('index', $template);
if(isset($update) && $db->cache_ids && ($username == $_username || $_groupid == 1 || $domain)) {
	foreach($db->cache_ids as $v) {
		$dc->rm($v);
	}
	dheader($COM['linkurl']);
}
?>
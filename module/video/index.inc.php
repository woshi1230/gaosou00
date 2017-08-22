<?php 
defined('IN_GAOSOU') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($MOD['index_html']) {	
	$html_file = DT_ROOT.'/'.$MOD['moduledir'].'/'.$DT['index'].'.'.$DT['file_ext'];
	if(!is_file($html_file)) tohtml('index', $module);
	if(is_file($html_file)) exit(include($html_file));
}
if(!check_group($_groupid, $MOD['group_index'])) include load('403.inc');
$maincat = get_maincat(0, $moduleid, 1);
include DT_ROOT.'/include/seo.inc.php';
$seo_file = 'index';
include DT_ROOT.'/include/seo.inc.php';
$template = $MOD['template_index'] ? $MOD['template_index'] : 'index';
$gaosou_task = "moduleid=$moduleid&html=index";
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, 0, $page);
include template($template, $module);
?>
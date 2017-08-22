<?php 
defined('IN_GAOSOU') or exit('Access Denied');
$fileroot = DT_ROOT.'/'.$MOD['moduledir'].'/';
$filename = $fileroot.$DT['index'].'.'.$DT['file_ext'];
if(!$MOD['index_html']) {
	if(is_file($filename)) unlink($filename);
	return false;
}
$maincat = get_maincat(0, $moduleid, 1);
$seo_file = 'index';
include DT_ROOT.'/include/seo.inc.php';
$gaosou_task = "moduleid=$moduleid&html=index";
ob_start();
include template('index', $module);
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
return true;
?>
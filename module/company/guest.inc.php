<?php 
defined('IN_GAOSOU') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$head_title = $L['guest_title'];
include template('guest', 'message');
?>
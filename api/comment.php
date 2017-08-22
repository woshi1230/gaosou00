<?php
header("Access-Control-Allow-Origin:*");
header('Content-type:text/html;charset=utf-8');
$moduleid = 3;
require '../common.inc.php';
require DT_ROOT.'/module/'.$module.'/comment.inc.php';
?>
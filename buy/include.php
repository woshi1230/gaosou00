<?php
require 'buy/config.inc.php';
require 'common.inc.php';
$gaosou_task = "moduleid=$moduleid&html=index";
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, 0, $page);

?>
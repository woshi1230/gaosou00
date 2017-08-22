<?php
define ( "IN_KEKE", TRUE );
include '../app_comm.php';
if(in_array($type, array('sina','qq','taobao','renren','douban','baidu','wx'))){
	$oauth_obj = OAuthClass::factory($type);
	$oauth_obj->requestAuthorize();
}else{
	exit('type参数错误');
}

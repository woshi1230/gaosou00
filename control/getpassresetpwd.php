<?php
defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
$uid and header ( "location:index.php" );
$strPageTitle = '重置密码' . '- ' . $_K ['html_title'];
$authstatus = false;
$validInfo = keke_user_class::getPwdAuth($authsid, $encrypteuid);
if($_SESSION['retrieve']['validinfo']['http_agent'] == $_SERVER['HTTP_USER_AGENT'] && is_array($validInfo) && $validInfo && $authsid == $_SESSION['retrieve']['validinfo']['authsid']){
	$authstatus = true;
}
$validInfo['userinfo'] = kekezu::get_user_info($validInfo['get_uid']);
if (kekezu::submitcheck ( $formhash )) {
	$newpwd = trim($newpwd);
	$newpwd2 = trim($newpwd2);
	if($newpwd != $newpwd2){
		$tips ['errors'] ['newpwd'] = '您输入的密码与确认密码不一致';
		kekezu::show_msg ( $tips, NULL, NULL, NULL, 'error' );
	}
	$user_code = md5 ( $newpwd );
	$sql1 = sprintf ( "update yw_member set password = '%s'  where userid=%d", $user_code, $validInfo['userinfo'] ['uid'] );
	db_factory::execute ( $sql1 );
	$sql2 = sprintf ( "update yw_company set  password = '%s' where userid=%d", $user_code,  $validInfo['userinfo'] ['uid'] );
	db_factory::execute ( $sql2 );
	keke_user_class::user_edit ( $validInfo['userinfo'] ['username'], '', $newpwd, '', 1 );
	keke_user_class::updateGetPwdStatusByGetUid($validInfo['userinfo'] ['uid'], 1);
	unset($_SESSION['retrieve']);
	unset($_SESSION);
	kekezu::show_msg ( '密码修改成功', "index.php?do=login", NULL, NULL, 'ok' );
}

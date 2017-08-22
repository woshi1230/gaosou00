<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
$strUrl = 'index.php?do=user&view=account&op=password';
if (isset($formhash)&&kekezu::submitcheck($formhash)) {
	$old_pass 		= kekezu::escape(trim($old_password));
	$new_pass 		= kekezu::escape(trim($new_password));
	$confirm_pass 	= kekezu::escape(trim($confirm_password));
	if (md5 ( $old_pass ) != $gUserInfo ['password']) {
		$title['errors']['old_password'] = '登录密码错误';
		kekezu::show_msg($title,NULL,NULL,NULL,'error');
	}
	if ($old_pass === $new_pass) {
		$title['errors']['new_password'] = '新密码与当前密码相同';
		kekezu::show_msg($title,NULL,NULL,NULL,'error');
	}
	if ($new_pass != $confirm_pass) {
		$title['errors']['confirm_password'] = '两次输入密码不一致';
		kekezu::show_msg($title,NULL,NULL,NULL,'error');
	}
	$intRes1 = db_factory::updatetable('yw_company', array('password'=>md5 ( $new_pass )), array('userid'=>$gUid));
	$intRes2 = db_factory::updatetable('yw_member', array('password'=>md5 ( $new_pass )), array('userid'=>$gUid));
	$flag = keke_user_class::user_edit ( $gUserInfo ['username'], $old_pass, $new_pass, '', 0 ) > 0 ? 1 : 0;
	if ($flag && $intRes1 === 1&&$intRes2 ===1 ){
		kekezu::admin_system_log($_SESSION['username'].'于'.date("Y-m-d H:i:s").'修改了密码');
		keke_msg_class::notify_user($gUserInfo['uid'], $gUserInfo ['username'], 'update_password', '修改密码',array ('新密码' => $new_pass,'网站名称' => $kekezu->_sys_config['website_name'],'用户名' =>  $gUserInfo ['username']),2);
		setcookie('rememberme','');
		unset ( $_SESSION ,$_SESSION['uid'],$_SESSION['username']);
		unset ( $_COOKIE['rememberme'] );
		session_destroy();
		kekezu::show_msg('新密码已生效','index.php?do=login',NULL,NULL,'ok');
	}
}
<?php
$uid and header ( "location:index.php" );
$type = strval(trim($type));
$arrOauthType = UserCenter::getOauthType();
$strPageTitle = 'oauth注册-'.$_K ['html_title'];
$strPageKeyword = 'oauth注册,'.$_K ['html_title'];
$strPageDescription = $kekezu->_sys_config['index_seo_desc'];
if(!$_SESSION[$type.'_oauthInfo']){
	kekezu::show_msg ( '缺少参数', 'index.php?do=login', 3, NULL, 'warning' );
}
$arrOauthInfo =$_SESSION[$type.'_oauthInfo'];
if (strtoupper ( CHARSET ) == 'GBK') {
	$arrOauthInfo = kekezu::utftogbk($arrOauthInfo);
}
$objLogin = new keke_user_login_class();
$arrBindInfo = keke_register_class::is_oauth_bind ( $type, $arrOauthInfo ['account'] );
if ($_SESSION[$type.'_oauthInfo'] && $arrBindInfo) {
	$_SESSION[$type.'_oauthInfo'] = null;
	unset($_SESSION[$type.'_oauthInfo']);
	$arrUserInfo = kekezu::get_user_info ( $arrBindInfo ['uid'] );
	$loginUserInfo = $objLogin->oauth_user_login ( $arrUserInfo ['username'], $arrUserInfo ['password'], null, 1 );
	$objLogin->save_user_info ( $loginUserInfo, 1 );
}
$objReg = new keke_register_class();
$arrApiNames = keke_glob_class::get_open_api();
if (isset($formhash)&&kekezu::submitcheck($formhash)){
	if (keke_user_class::user_checkemail ( $email )!=1) {
		$tips['errors']['email'] = '该email非法或已经被注册';
		kekezu::show_msg ( $tips, NULL, NULL, NULL, 'error' );
	}
	if (strtoupper ( CHARSET ) == 'GBK') {
		$account = kekezu::utftogbk( $account );
	}
	$strNameCheck =  keke_user_class::check_username ( $account );
	if ($strNameCheck!=1) {
		$tips['errors']['account'] = $strNameCheck;
		kekezu::show_msg ( $tips, NULL, NULL, NULL, 'error' );
	}
	if (intval($agree)==0) {
		$tips['errors']['agree'] = '请先同意注册协议';
		kekezu::show_msg ( $tips, NULL, NULL, NULL, 'error' );
	}
	if(!$arrBindInfo){
		$intRegUid = $objReg->user_register($account, $password, $email,$code,false,$password);
		$arrUserInfo = keke_user_class::get_user_info($intRegUid);
		UserCenter::bindingAccount($arrUserInfo['uid'], $arrUserInfo['username'], $arrOauthInfo);
		$_SESSION[$type.'_oauthInfo'] = null;
		unset($_SESSION[$type.'_oauthInfo']);
		$objReg->register_login($arrUserInfo);
	}
}

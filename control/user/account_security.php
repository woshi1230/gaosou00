<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
if (isset($formhash)&&kekezu::submitcheck($formhash)) {
	$strOldCode 		= kekezu::escape(trim($old_code));
	$strNewCode 		= kekezu::escape(trim($new_code));
	$strConfirmCode 	= kekezu::escape(trim($confirm_code));
	$strMd5Pwd = keke_user_class::get_password ( $strOldCode, $gUserInfo ['passsalt'] );
	if ($strMd5Pwd != $gUserInfo ['sec_code']) {
		$title['errors']['old_code'] = '支付密码错误';
		kekezu::show_msg($title,NULL,NULL,NULL,'error');
	}
	if ($strNewCode == $strOldCode) {
		$title['errors']['new_code'] = '新支付密码与当前支付密码相同';
		kekezu::show_msg($title,NULL,NULL,NULL,'error');
	}
	if ($strNewCode != $strConfirmCode) {
		$title['errors']['confirm_password'] = '两次输入支付密码不一致';
		kekezu::show_msg($title,NULL,NULL,NULL,'error');
	}
	$strNewMd5Pwd =  keke_user_class::get_password ( $strNewCode, $gUserInfo ['passsalt'] );
	$intRes = db_factory::updatetable('yw_company', array('sec_code'=>$strNewMd5Pwd), array('userid'=>$gUid));
	if($intRes){
		$message_obj = new keke_msg_class ();
		$message_obj->send_message (
				$gUserInfo ['uid'],
				$gUserInfo ['username'],
				'update_sec_code',
				'修改支付密码',
				array ('支付密码' => $strNewCode ),
				$gUserInfo ['email'],
				$gUserInfo ['mobile'],2
		);
		kekezu::admin_system_log($_SESSION['username'].'于'.date("Y-m-d H:i:s").'修改了支付密码');
		kekezu::show_msg('新支付密码已生效',NULL,NULL,NULL,'ok');
	}else{
		kekezu::show_msg('支付密码修改失败',NULL,NULL,NULL,'fail');
	}
}
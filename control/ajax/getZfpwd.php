<?php
if($opajax == 'getzfpwd'){
	if(!$gUid){
		kekezu::echojson('用户未登录','error');
	}
	$email = $gUserInfo['email'];
	if(!$email){
		kekezu::echojson('请确保您的邮箱有效可用','error');
	}
	$strNewCode = kekezu::randomkeys(8);
	$strNewMd5Pwd =  keke_user_class::get_password ( $strNewCode, $gUserInfo ['passsalt'] );
	$intRes = db_factory::updatetable('yw_company', array('sec_code'=>$strNewMd5Pwd), array('userid'=>$gUid));
	if($intRes){
		$message_obj = new keke_msg_class ();
		$message_obj->send_message (
				$gUserInfo ['uid'],
				$gUserInfo ['username'],
				'update_sec_code','找回支付密码',array ('支付密码' => $strNewCode ),
				$gUserInfo ['email'],
				$gUserInfo ['mobile'],2
		);
		kekezu::admin_system_log($gUserInfo['username'].'于'.date("Y-m-d H:i:s").'找回了支付密码');
		kekezu::echojson('支付密码已发到您的邮箱','success');
	}else{
		kekezu::echojson('支付密码找回失败','fail');
	}
	die();
}
exit('no access');
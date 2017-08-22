<?php
$excite_uid and $intExciteUid = intval($excite_uid);
$excite_code and $strExciteCode = strval($excite_code);
$arrUserInfo = kekezu::get_user_info($intExciteUid);
if($arrUserInfo){
	$strMd5Code = md5($arrUserInfo['uid'].','.$arrUserInfo['username'].','.$arrUserInfo['email']);
	if($arrUserInfo['status']=='3'){
		if($strMd5Code==$strExciteCode){
			$intRes = db_factory::execute(sprintf("update yw_company set status='1' where userid='%d'",$intExciteUid));
			if($intRes){
                $arrAuthDatas = array('email_a_id'=>null,
                                        'uid'=>$arrUserInfo['uid'],
                						'username'=>$arrUserInfo['username'],
                						'email'=>$arrUserInfo['email'],
                						'auth_time'=>time(),
                						'auth_status'=>'1');
                db_factory::inserttable(TB_PRE."witkey_auth_email", $arrAuthDatas);
                $arrRecordDatas = array('record_id'=>null,
                                        'auth_code'=>'email',
                						'uid'=>$arrUserInfo['uid'],
                						'username'=>$arrUserInfo['username'],
                						'auth_status'=>'1');
               db_factory::inserttable(TB_PRE."witkey_auth_record", $arrRecordDatas);
               $objMessage = new keke_msg_class ();
               if ($objMessage->validate ( 'reg' )) {
               	$objMessage->send_message ( $arrUserInfo ['uid'], $arrUserInfo ['username'], 'reg','注册成功', array (), $arrUserInfo ['email'],'',2 );
               }
			}
		}
	}
}else{
	kekezu::show_msg($_lang['operate_notice'],'index.php',3,'待激活的账号不存在','warning');
}
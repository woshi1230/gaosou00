<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
$strUrl = 'index.php?do=user&view=account&op=contact';
$objSpaceT = keke_table_class::get_instance('company');
$arrMemberExts = kekezu::get_table_data ( "*", TB_PRE . "witkey_member_ext", " type='sect' and uid= ".$gUid, "", "", "", "k" );
$boolEmailAuth = keke_auth_fac_class::auth_check ( 'email', $gUid );
$boolMobileAuth = keke_auth_fac_class::auth_check ( 'mobile', $gUid );
$arrProvinces = CommonClass::getDistrictByPid('0','areaid,parentid,areaname');
if($gUserInfo['city']){
	$arrCity = CommonClass::getDistrictByPid($gUserInfo['province'],'areaid,parentid,areaname');
}
if($gUserInfo['area']){
	$arrArea = CommonClass::getDistrictByPid($gUserInfo['city'],'areaid,parentid,areaname');
}
if (isset($formhash)&&kekezu::submitcheck($formhash)) {
	if($gUserInfo['uid'] != $pk['uid']){
		kekezu::show_msg('无权操作',NULL,NULL,NULL,'error');
		return false;
	}
	$arrData =array(
		'email'	=>$email,
		'mobile'=>$mobile,
		'qq'	=>$qq,
		'msn'	=>$msn,
		'phone'	=>$phone,
		'province'=>$province,
		'city'=>$city,
		'area'=>$area
	);
	$intRes = $objSpaceT->save($arrData,$pk);
	if ($sect) {
		foreach ( $sect as $k => $v ) {
		    $type = array("phone","msn","qq","mobile","email");
		    if (!in_array($k, $type)){
		        return false;
		    }
			if ($arrMemberExts [$k])
			    db_factory::execute("update ".TB_PRE."witkey_member_ext set v1 = '{$v}' where k = '{$k}' and uid = '{$gUid}'");
			else {
				$ext_obj = new Keke_witkey_member_ext_class ();
				$ext_obj->setK ( $k );
				$ext_obj->setV1 ( kekezu::escape ( $v ) );
				$ext_obj->setUid ( $gUid );
				$ext_obj->setType ( 'sect' );
				$ext_obj->create_keke_witkey_member_ext ();
			}
		}
	}
	unset($objSpaceT);
	kekezu::show_msg('已保存',NULL,NULL,NULL,'ok');
}

<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
$strUrl = 'index.php?do=user&view=account&op=basic';
$arrTopIndustrys = $indus_p_arr;
$arrAllIndustrys = $indus_arr;
$objSpaceT = keke_table_class::get_instance('company');
$intUserRole = intval($gUserInfo['user_type']);
$arrMemberExts = kekezu::get_table_data ( "*", TB_PRE . "witkey_member_ext", " type='sect' and uid= ".$gUid, "", "", "", "k" );
$boolEmailAuth = keke_auth_fac_class::auth_check ( 'email', $gUid );
$boolMobileAuth = keke_auth_fac_class::auth_check ( 'mobile', $gUid );
$arrProvinces = CommonClass::getDistrictByPid('0','areaid,parentid,areaname');
if($gUserInfo['province']){
	$arrCity =  CommonClass::getDistrictByPid($gUserInfo['province'],'areaid,parentid,areaname');
}
if($gUserInfo['city']){
	$arrArea =CommonClass::getDistrictByPid($gUserInfo['city'],'areaid,parentid,areaname');
}
if($intUserRole === 2){
	$intAuthStatus = keke_auth_fac_class::auth_check ( 'enterprise', $gUid );
	$arrEnterPriseInfo = db_factory::get_one ( sprintf ( "select * from %switkey_auth_enterprise where uid='%d'", TB_PRE, $gUid ) );
	if (isset($formhash)&&kekezu::submitcheck($formhash)) {
		if($gUserInfo['uid'] != $pk['uid']){
			kekezu::show_msg('无权操作',NULL,NULL,NULL,'error');
			return false;
		}
		if (strtoupper ( CHARSET ) == 'GBK') {
			$company = kekezu::utftogbk($company );
			$legal = kekezu::utftogbk($legal );
			$address = kekezu::utftogbk($address );
			$summary = kekezu::utftogbk($summary );
		}
		$arrData = array(
			'company'	=>$company,
			'licen_num'	=>$licen_num,
			'legal'		=>$legal,
			'staff_num'	=>$staff_num,
			'run_years'	=>$run_years,
			'url'		=>$url
		);
		$arrData['uid'] = $gUserInfo['uid'];
		$arrData['username'] = $gUserInfo['username'];
		$objAuthEnterpriseT = new keke_table_class ( 'witkey_auth_enterprise' );
		$objAuthEnterpriseT->save ( $arrData, array ('enterprise_auth_id' => $arrEnterPriseInfo ['enterprise_auth_id'] ) );
		unset($objAuthEnterpriseT);
		$arrData = array();
		$arrData = array(
			'indus_pid'	=>$indus_pid,
			'indus_id'	=>$indus_id,
			'address'	=>$address,
			'summary'	=>$summary
		);
		$objSpaceT->save($arrData,array('uid'=>intval($pk['uid'])));
		$arrData = array();
		$arrData =array(
				'email'	=>$email,
				'mobile'=>$mobile,
				'qq'	=>$qq,
				'msn'	=>$msn,
				'phone'	=>$phone,
				'province'=>intval($province),
				'city'=>intval($city),
				'area'=>intval($area),
				'is_perfect'=>$is_perfect,
		);
		$intRes = $objSpaceT->save($arrData,array('uid'=>intval($pk['uid'])));
		if ($sect) {
			foreach ( $sect as $k => $v ) {
			    $type = array("phone","msn","qq","mobile","email");
			    if (!in_array($k, $type)){
			        return false;
			    }
				if ($arrMemberExts [$k])
					db_factory::execute ( sprintf ( " update %switkey_member_ext set v1='%s' where k='%s' and uid='%d'", TB_PRE, $v, $k, $gUid ) );
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
}else{
	$intAuthStatus = keke_auth_fac_class::auth_check ( "realname", $gUid );
	if (isset($formhash)&&kekezu::submitcheck($formhash)) {
		if($gUserInfo['uid'] != $pk['uid']){
			kekezu::show_msg('无权操作',NULL,NULL,NULL,'error');
			return false;
		}
		if (strtotime($birthday)>=strtotime(date('Y-m-d',time()))) {
			$tips['errors']['birthday'] = '出生日期不得大于或等于当前日期';
			kekezu::show_msg($tips,NULL,NULL,NULL,'error');
		}
		if (strtoupper ( CHARSET ) == 'GBK') {
			$truename = kekezu::utftogbk($truename );
		}
		$arrData = array(
				'indus_pid'	=>$indus_pid,
				'indus_id'	=>$indus_id,
				'truename'	=>$truename,
				'sex'		=>$sex,
				'is_perfect'=>$is_perfect,
				'birthday'	=>$birthday,
		);
		$objSpaceT->save($arrData,array('uid'=>$pk['uid']));
		$arrData = array();
		$arrData =array(
				'email'	=>$email,
				'mobile'=>$mobile,
				'qq'	=>$qq,
				'msn'	=>$msn,
				'phone'	=>$phone,
				'province'=>intval($province),
				'city'=>intval($city),
				'area'=>intval($area)
		);
		$intRes = $objSpaceT->save($arrData,array('uid'=>$pk['uid']));
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
}

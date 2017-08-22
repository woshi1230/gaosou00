<?php
defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
$indus_p_arr = $kekezu->_indus_p_arr;
$objSpaceT = keke_table_class::get_instance ( 'company' );
if($gUserInfo ['indus_id']){
	$arrUserIndus = db_factory::get_one ( sprintf ( " select * from %switkey_industry where indus_id='%d'", TB_PRE, $gUserInfo ['indus_id'] ) );
}
if(isset($ac)&&$ac ==='getSkill'){
	$arrSkill = kekezu::get_skill ();
	isset ( $arrSkill [$indus_id] ) and $get_skill = $arrSkill [$indus_id];
	if (isset ( $arrSkill ) && $get_skill) {
		kekezu::echojson ( '1', '1', $get_skill );
	} else {
		kekezu::echojson ( '1', '0' );
	}
	die ();
}
if (isset($formhash)&&kekezu::submitcheck($formhash)) {
	if (strtoupper ( CHARSET ) == 'GBK') {
		$strUserTags = kekezu::utftogbk($strUserTags );
	}
	if(strval($strUserTags)){
		$strql = sprintf ( "update yw_company set skill_ids = '%s' where userid = '%d'", $strUserTags, $gUid );
		db_factory::execute ( $strql );
	}
	kekezu::show_msg('已保存',NULL,NULL,NULL,'ok');
}

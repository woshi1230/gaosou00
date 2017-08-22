<?php defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
if(TOOL == FALSE){
	kekezu::show_msg ( '无权限', NULL, NULL, NULL, 'warning' );
}
$arrObjInfo = PayitemClass::getObjInfo($type,$objId);
$arrPayitemLists = PayitemClass::getPayitemListDetail($type,$objId);
if($arrObjInfo['task_status']!=2){
	unset($arrPayitemLists['tasktop']);
	unset($arrPayitemLists['workhide']);
}
if (isset ( $formhash ) && kekezu::submitcheck ( $formhash )) {
	$sec_code=kekezu::escape(trim($zfpwd));
	$strMd5Pwd = keke_user_class::get_password ( $sec_code, $gUserInfo ['passsalt'] );
	$arrUserInfo=db_factory::get_one(sprintf("select * from yw_company where userid=%d and sec_code='%s'",intval($gUid),$strMd5Pwd));
	if(!$arrUserInfo){
		$tip['errors']['zfpwd'] = '密码不正确！';
		kekezu::show_msg($tip,NULL,NULL,NULL,'error');
	}
	$arrPayitems = array(
			'urgent'=>intval($txt_urgent),
			'tasktop'=>intval($txt_tasktop)&&intval($text_tasktop) ?intval($text_tasktop):0,
			'workhide'=>intval($txt_workhide),
			'seohide'=>intval($txt_seohide),
	);
	if ($arrPayitems['tasktop']) {
		$arrTaskInfo=db_factory::get_one("select * from ".TB_PRE."witkey_task where task_id=".intval($objId));
		$task_day=date('Y-m-d',$arrTaskInfo['sub_time']);
		$intTopInfo = PayitemClass::getPayitemRecord($type,$objId, 'tasktop');		
		PayitemClass::validPayitemCount($arrPayitems, $task_day,$intTopInfo['end_time']);
	}
	$arrPayitems['goodstop'] =  intval($text_goodstop);
	$arrPayitemBuy = array_filter($arrPayitems);
	if(is_array($arrPayitemBuy)){
		$intOrderId = PayitemClass::creatPayitemOrder($arrPayitemBuy,$type,$objId);
		if($intOrderId){
			$res = PayitemClass::payPayitemOrder($intOrderId);
			if($res===true){
				kekezu::show_msg ( '购买成功', 'index.php?do='.$type.'&id='.intval($objId), NULL, NULL, 'ok' );
			}else{
				kekezu::show_msg ( $res, 'index.php?do=pay&type=payitem&id='.$intOrderId, NULL, NULL, 'fail' );
			}
		}
	}
}
require keke_tpl_class::template ( "tpl/default/ajax/payitem");die;
<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
$strUrl = 'index.php?do=user&view=message&op=send';
if (isset ( $formhash ) && kekezu::submitcheck ( $formhash )) {
	$title  = kekezu::str_filter ( kekezu::escape (strip_tags(htmlspecialchars_decode($title)   ))) ;
	$content  = kekezu::str_filter ( kekezu::escape (strip_tags(htmlspecialchars_decode($content)   ))) ;
	$objMsgM = new Yw_message_class ();
	if (strtoupper ( CHARSET ) == 'GBK') {
		$to_username = kekezu::utftogbk($to_username );
	}
	$arrSpaceInfo = kekezu::get_user_info ( $to_username, 1 );
	if (! $arrSpaceInfo) {
		$tips['errors']['to_username'] = '用户不存在';
		kekezu::show_msg($tips,NULL,NULL,NULL,'error');
	}
	if ($arrSpaceInfo ['uid'] == $gUid) {
		$tips['errors']['to_username'] = '无法给自己发送';
		kekezu::show_msg ( $tips, NULL, NULL, NULL, 'error' );
	}
	if (strtoupper ( CHARSET ) == 'GBK') {
		$title = kekezu::utftogbk($title );
		$content = kekezu::utftogbk($content );
	}
	$objMsgM->setUid ( $gUid );
	$objMsgM->setUsername ( $username );
	$objMsgM->setTo_uid ( $arrSpaceInfo ['uid'] );
	$objMsgM->setTo_username ( $arrSpaceInfo ['username'] );
	$objMsgM->setTitle ($title );
	$objMsgM->setContent ($content);
	$objMsgM->setOn_time ( time () );
	$objMsgM->setType(4);
	$objMsgM->setStatus(3);
	$objMsgM->create_yw_message ();
	unset ( $objMsgM );
	kekezu::show_msg ( '已保存', 'index.php?do=user&view=message&op=outbox', NULL, NULL, 'ok' );
}else{
	$objUid and $intObjUid = intval($objUid);
	$arrObjInfo =  kekezu::get_user_info ( $intObjUid);
}

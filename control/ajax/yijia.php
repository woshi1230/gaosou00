<?php defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
$wid = intval($wid);
$workInfo = db_factory::get_one('select * from '.TB_PRE.'witkey_task_work where work_id='.$wid);
$to_username = $workInfo['username'];
$taskInfo =  db_factory::get_one('select * from '.TB_PRE.'witkey_task where task_id='.intval($workInfo['task_id']));
$url = 'index.php?do=task&id='.$taskInfo['task_id'].'&view=work';
switch($op){
	case 'agree':
		if($gUid == $workInfo['uid']){
			if(intval($a)==1){
				$setArr = array('hasyj'=>3);
				$msg = '已同意';
			}else{
				$setArr = array('hasyj'=>4);
				$msg = '已拒绝';
			}
			$res = db_factory::updatetable(TB_PRE.'witkey_task_work',$setArr,array('work_id'=>$wid));
		}else{
			$msg = '非法操作';
		}
		$arr = array('msg'=>$msg);
        $from_username = $workInfo['username'];
        $to_username = $taskInfo['username'];
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
		$title = '稿件议价';
		$content= '尊敬的'.$to_username.':'.$from_username.$msg.'您的议价。订单详情：<a href="'.$url.'">'.$taskInfo['task_title'].'</a><p>留言：'.$txt_content.'</p>感谢您对高手系统的信任。如有特殊情况，请致电客服 ';
		if (strtoupper ( CHARSET ) == 'GBK') {
		    $title = kekezu::utftogbk($title );
		    $content = kekezu::utftogbk($content );
		}
		$objMsgM->setUid ( $gUid );
		$objMsgM->setUsername ( $username );
		$objMsgM->setTo_uid ( $arrSpaceInfo ['uid'] );
		$objMsgM->setTo_username ( $arrSpaceInfo ['username'] );
		$objMsgM->setTitle ( kekezu::str_filter ( kekezu::escape ( $title ) ) );
		$objMsgM->setContent ( kekezu::str_filter ( kekezu::escape ( $content ) ) );
		$objMsgM->setOn_time ( time () );
		$objMsgM->setType(3);
		$objMsgM->setStatus(3);
		$objMsgM->create_yw_message ();
		unset ( $objMsgM );
		echo json_encode($arr);die;
		break;
}
if (isset ( $formhash ) && kekezu::submitcheck ( $formhash )) {
	$res = db_factory::updatetable ( TB_PRE . "witkey_task_work", array (
							"hasyj" => 2,
							'yjje'=>floatval($account),
							'yjtime'=>time()
					), array (
							"work_id" => $wid
					) );
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
	$title = '稿件议价';
	$content= '尊敬的'.$to_username.':您的稿件被雇主入围，并向你发出了议价请求。订单详情：<a href="'.$url.'">'.$taskInfo['task_title'].'</a><p>留言：'.$txt_content.'</p>感谢您对高手系统的信任。如有特殊情况，请致电客服';
	if (strtoupper ( CHARSET ) == 'GBK') {
		$title = kekezu::utftogbk($title );
		$content = kekezu::utftogbk($content );
	}
	$objMsgM->setUid ( $gUid );
	$objMsgM->setUsername ( $username );
	$objMsgM->setTo_uid ( $arrSpaceInfo ['uid'] );
	$objMsgM->setTo_username ( $arrSpaceInfo ['username'] );
	$objMsgM->setTitle ( kekezu::str_filter ( kekezu::escape ( $title ) ) );
	$objMsgM->setContent ( kekezu::str_filter ( kekezu::escape ( $content ) ) );
	$objMsgM->setOn_time ( time () );
	$objMsgM->setType(3);
	$objMsgM->setStatus(3);
	$objMsgM->create_yw_message ();
	unset ( $objMsgM );
	kekezu::show_msg ( '议价已发送给高手', $url, NULL, NULL, 'ok' );
}
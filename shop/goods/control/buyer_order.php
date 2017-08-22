<?php
kekezu::check_login ();
if ($gUid != $arrServiceInfo ['uid']) {
	$arrOrderProgress = array (
			1 => array (
					'step' => 'step1',
					'state' => '确认订单'
			),
			2 => array (
					'step' => 'step2',
					'state' => '提交订单并支付'
			),
			3 => array (
					'step' => 'step3',
					'state' => '文件交付'
			),
			4 => array (
					'step' => 'step4',
					'state' => '双方互评'
			)
	);
}
switch ($step) {
	case 'step1' :
		if ($arrServiceInfo ['pic']) {
			$arrPics = explode ( ',', $arrServiceInfo ['pic'] );
		}
		if (isset ( $formhash ) && kekezu::submitcheck ( $formhash )) {
			$arrOrderInfo = keke_shop_class::check_has_buy ( $sid, $uid ); 
			if (strtoupper ( CHARSET ) == 'GBK') {
				$tar_content = kekezu::utftogbk ( $tar_content );
			}
			$tar_content and $arrServiceInfo ['leave_message'] = kekezu::escape ( $tar_content ) or $arrServiceInfo ['leave_message'] = '0';
			$resText = keke_shop_class::create_service_order ( $arrServiceInfo, false, null,$step );
			if (0 < intval ( $resText )) {
				kekezu::show_msg ( '订单创建成功', $strUrl . "&step=step2&orderId=" . $resText, 3, null, 'ok' );
			} else {
				kekezu::show_msg ( $resText, $strUrl, 3, null, 'fail' );
			}
		}
		break;
	case 'step2' :
		if (isset ( $action )) {
			switch ($action) {
				case 'confirm_pay' : 
					if ($_SESSION ['UserBalance']) {
						$arrUserBalance = explode ( '|', $_SESSION ['UserBalance'] );
						$strUid = $arrUserBalance [0];
						$strIp = $arrUserBalance [1];
						$strSec_code = $arrUserBalance [2];
						$strMd5Pwd = keke_user_class::get_password ( $strSec_code, $gUserInfo ['rand_code'] );
						$arrUserInfo = db_factory::get_one ( sprintf ( "select * from %switkey_space where uid=%d and sec_code='%s'", TABLEPRE, intval ( $strUid ), $strMd5Pwd ) );
						if ($strIp != kekezu::get_ip () || $strUid != $gUid || ! $arrUserInfo) {
							kekezu::show_msg ( '你的支付密码不正确！', 'index.php?do=index', NULL, NULL, 'ok' );die;
						}
					}
					$objGoods = new goods_shop_class ();
					$resText = $objGoods->dispose_order ( $orderId, 'ok' ); 
					unset ( $objGoods );
					if (true === $resText) {
						kekezu::show_msg ( '订单付款完成，该订单已确认付款', $strUrl . "&step=step3&orderId=" . $orderId, 3, null, 'ok' );
					} else {
						kekezu::show_msg ( $resText, null, null, null, 'fail' );
					}
					break;
				default :
					kekezu::show_msg ( '访问页面不存在', 'index.php', 3, null, 'warning' );
					break;
			}
		}
	case 'step3' :
		if ($arrServiceInfo ['file_path']) {
			$arrFile_path = explode('|',$arrServiceInfo['file_path']);
			foreach($arrFile_path as $v){
				$arrFile = db_factory::query ( 'select file_name,save_name from ' . TABLEPRE . 'witkey_file where save_name ="' . $v . '"' );
				$arrFileLists[] = $arrFile[0];
			}
		}
		if (isset ( $action )) {
			switch ($action) {
				case 'confirm_file' :
					$objGoods = new goods_shop_class ();
					$resText = $objGoods->dispose_order ( $orderId, 'confirm' ); 
					unset ( $objGoods );
					if (true === $resText) {
						kekezu::show_msg ( '确认完成！', $strUrl . "&step=step4&orderId=" . $orderId, 3, null, 'ok' );
					} else {
						kekezu::show_msg ( $resText, null, null, null, 'fail' );
					}
					break;
				default :
					kekezu::show_msg ( '访问页面不存在', 'index.php', 3, null, 'warning' );
					break;
			}
		}
		break;
	case 'step4' :
		$objId = $orderId;
		$toUid = $arrServiceInfo ['uid'];
		$arrMark = keke_user_mark_class::get_mark_info ( array (
				'model_code' => 'goods',
				'obj_id' => $objId,
				'by_uid' => $gUid,
				'uid' => $toUid
		) );
		$markInfo = $arrMark ['mark_info'] ['0'];
		$aidList = keke_user_mark_class::get_mark_aid ( 2 );
		$aidInfo = keke_user_mark_class::get_user_aid ( $markInfo ['by_uid'], $markInfo ['mark_type'], $markInfo ['mark_status'], 2, $markInfo ['model_code'], $objId );
		$strJumpUrl = "index.php?do=goods&id=$sid&view=mark#pageT";
		if ($markInfo ['mark_status'] == '1') {
			kekezu::show_msg ( '操作提示', $strJumpUrl, 3, '评价完成，服务结束', 'success' );
		}
		break;
	default :
		kekezu::show_msg ( '访问页面不存在', 'index.php', 3, null, 'warning' );
		break;
}
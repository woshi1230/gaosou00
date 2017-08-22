<?php
class MsgClass {
	static function SendFeedMsg($receiver,$title,$content,$type='1'){
		$receiverInfo=kekezu::get_user_info(intval($receiver));
		if(!$receiverInfo){return false;}
		$objMsgM = new Yw_message_class ();
		$objMsgM->setType($type);
		$objMsgM->setTo_uid ( $receiverInfo['uid'] );
		$objMsgM->setTo_username ( $receiverInfo ['username'] );
		$objMsgM->setTitle (kekezu::escape($title));
//		$objMsgM->setContent (kekezu::escape($content));
		$objMsgM->setContent ($content);
		$objMsgM->setOn_time ( time () );
		$objMsgM->setType(4);
		$objMsgM->setStatus(3);
		return $objMsgM->create_yw_message ();
	}
	static function getMsgReadStatus(){
		return  array('0'=>'未读','1'=>'已读');
	}
	static function getMsgSearchStatus(){
		return  array('0'=>'全部','1'=>'已读','2'=>'未读');
	}
}
?>
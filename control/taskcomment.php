<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
// 原有模块的引入
require 'buy/include.php';

$objId = intval($objId);
$cid = intval($cid);
$pId = intval($pId);
$content = strval($content);
$objComment = yw_comment_class::get_instance($objType);
switch ($action) {
	case 'add':
	case 'reply':
		$arrData = array (
			"obj_id" 	=> $objId,
			"origin_id" => $originId,
			"obj_type" 	=> $objType,
			"p_id" 		=> $pId,
			"uid" 		=> $gUid,
			"username" 	=> $gUserInfo['username'],
			"content" 	=> kekezu::escape($content),
			"on_time" 	=> time ()
		);
		$intRes = $objComment->save_comment($arrData,$objId,$pId);
		if(!in_array($intRes,array(-1,-2,-3))){
			$arrCommentInfo =  $objComment->get_comment_info($intRes);
			if($action === 'reply'){
				$arrReCommentInfo =  $objComment->get_comment_info($pId);
				$arrCommentInfo['parentcomment'] = $arrReCommentInfo;
			}
			require  $kekezu->_tpl_obj->template('taskcomment');die();
		}
		if ($intRes == -1) {
			echo '你未登录，请登录后再试!';
		} else {
			echo '你操作的太频繁了，请稍后再试!';
		}
		die();
	break;
	case 'del':
		$arrCommentInfo = $objComment->get_comment_info($cid);
		if( $gUid ==ADMIN_UID||$gUserInfo['group_id']==7||$arrCommentInfo['uid'] == $gUid){
			$intRes = $objComment->del_comment($cid,$objId,$arrCommentInfo['qid']);
			kekezu::show_msg('删除成功',null,null,null,'ok');
		}
		kekezu::show_msg('删除失败',null,null,null,'error');
	break;
}
die;

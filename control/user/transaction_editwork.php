<?php
$arrTopIndustrys = $kekezu->_indus_goods_arr;
$objId = intval($objId);
$intTaskId = intval($intTaskId);
$strUrl ="index.php?do=user&view=transaction&op=editwork";
$objId and $strUrl .="&objId=".$objId;
$intTaskId and $strUrl .="&intTaskId=".$intTaskId;
if($intTaskId&&$objId){
	$strTaskSql = 'select indus_id,indus_pid from '.TB_PRE.'witkey_task where task_id = '.$intTaskId;
	$arrTaskInfo = db_factory::get_one($strTaskSql);
	$strJumpUrl ="index.php?do=user&view=transaction&op=works";
	if($arrTaskInfo['uid'] !=$gUid){
		exit('禁止未授权访问');
	}
}
if($objId&&!$intTaskId){
	$strServiceSql = 'select * from '.TB_PRE.'witkey_service where service_id = '.$objId;
	$arrServiceInfo = db_factory::get_one($strServiceSql);
	$strJumpUrl ="index.php?do=user&view=transaction&op=service&intModelId=".$arrServiceInfo['model_id'];
	$strCustomSql = 'select a.id,a.extdata,b.f_name,b.f_tips,b.f_fixed_len,b.f_min_len,b.f_max_len,b.f_required,b.f_code from '.TB_PRE.'witkey_custom_fields_ext a LEFT JOIN '.TB_PRE.'witkey_custom_fields b ON a.c_id = b.id where a.objid = '.$objId;
	$arrCustom = db_factory::query($strCustomSql);
	foreach($arrCustom as $k=>$v){
	    $arrCustomInfo[$k]['id'] = $v['id'];
	    $arrCustomInfo[$k]['f_name'] = $v['f_name'];
	    $arrCustomInfo[$k]['f_tips'] = $v['f_tips'];
	    $arrCustomInfo[$k]['f_fixed_len'] = $v['f_fixed_len'];
	    $arrCustomInfo[$k]['f_min_len'] = $v['f_min_len'];
	    $arrCustomInfo[$k]['f_max_len'] = $v['f_max_len'];
	    $arrCustomInfo[$k]['f_code'] = $v['f_code'];
	    $arrCustomInfo[$k]['f_required'] = $v['f_required'];
	    $arrService = unserialize($v['extdata']);
	    $arrCustomInfo[$k]['extdata'] = $arrService[$v['f_code']]['content'];
	}
	if($arrServiceInfo['uid'] !=$gUid){
		exit('禁止未授权访问');
	}
}
$arrServiceInfo['indus_pid'] and $arrAllIndustrys = CommonClass::getIndustryByPid($arrServiceInfo['indus_pid'],'catid,parentid,catname');
$intModelId = 6;
if($arrServiceInfo['model_id']){
	$intModelId = $arrServiceInfo['model_id'];
}
$strServiceName = '作品';
if($intModelId =='7'){
	$strServiceName = '服务';
}
$objRelease = goods_release_class::get_instance ($intModelId);
$arrPriceUnit = $objRelease->get_price_unit (); 
$arrServiceUnit = $objRelease->get_service_unit();
$arrImageLists = CommonClass::getFileArrayByPath(',', $arrServiceInfo['pic']);
$arrFileLists = CommonClass::getFileArrayByPath(',', $arrServiceInfo['file_path']);
if($action == 'delete_image'){
	$fileid = intval($fileid);
	$strSql = sprintf("select file_id,file_name,save_name from %switkey_file where file_id in(%s)",TB_PRE,$fileid);
	$arrFileInfo = db_factory::get_one($strSql);
	$resText = CommonClass::delFileByFileId($fileid);
	if($resText){
		$array = explode(',', $arrServiceInfo['pic']);
		$newArr = CommonClass::returnNewArr($arrFileInfo['save_name'], $array);
		$_POST['file_ids'] = implode(",", $newArr);
		updateFilepath($arrServiceInfo['service_id'], $_POST['file_ids'], 'pic');
		kekezu::echojson('删除成功',1,array('fileid'=>$fileid,'save_name'=>$arrFileInfo['save_name']));die;
	}
}
if($action == 'delete_goodsfile'){
	$fileid = intval($fileid);
	$strSql = sprintf("select file_id,file_name,save_name from %switkey_file where file_id in(%s)",TB_PRE,$fileid);
	$arrFileInfo = db_factory::get_one($strSql);
	$resText = CommonClass::delFileByFileId($fileid);
	if($resText){
		$array = explode(',', $arrServiceInfo['file_path']);
		$newArr = CommonClass::returnNewArr($arrFileInfo['save_name'], $array);
		$_POST['file_path_2'] = implode(",", $newArr);
		updateFilepath($arrServiceInfo['service_id'], $_POST['file_path_2'], 'file');
		kekezu::echojson('删除成功',1,array('fileid'=>$fileid,'save_name'=>$arrFileInfo['save_name']));die;
	}
}
if (isset($formhash)&&kekezu::submitcheck($formhash)) {
	if($arrServiceInfo['uid'] !=$gUid){
		exit('禁止未授权访问');
	}
	$arrGoodsConfig = unserialize($kekezu->_model_list[6]['config']);
	$goodsprice   = floatval($goodsprice);
	$floatMinCash = floatval($arrGoodsConfig['min_cash']);
	if($floatMinCash&&($goodsprice < $floatMinCash)){
		$tips['errors']['goodsprice'] = '最小金额不能少于'.$floatMinCash.'元';
		kekezu::show_msg($tips,null,NULL,NULL,'error');
	}
	if (strtoupper ( CHARSET ) == 'GBK') {
		$goodsname = kekezu::utftogbk($goodsname );
		$goodsdesc = kekezu::utftogbk($goodsdesc );
		$unite_price = kekezu::utftogbk($unite_price );
	}
	$arrData = array(
			'model_id'		=> $arrServiceInfo['model_id']?$arrServiceInfo['model_id']:6,
			'uid'			=> $gUid,
			'username'		=> $gUserInfo['username'],
			'indus_id'		=> $indus_id,
			'indus_pid'		=> $indus_pid,
			'title'			=> $goodsname,
			'price'		    => $goodsprice,
			'pic'			=> $file_ids,
			'content'		=> $goodsdesc,
			'unite_price'	=> $unite_price,
			'submit_method'	=> $submit_method,
			'file_path'		=> $file_path_2,
			'confirm_max'   => intval($arrGoodsConfig['confirm_max_day']),
	        'service_time'   => $service_time,
	        'unit_time'     => $unit_time
	);
	$arrUpdateParts = array();
	if($arrServiceInfo['indus_id'] !=$indus_id && $indus_id){
		$arrUpdateParts['indus_id'] = $indus_id;
		$arrUpdateParts['old_indus_id'] = $arrServiceInfo['indus_id'];
	}
	if($arrServiceInfo['indus_pid'] !=$indus_pid && $indus_pid){
		$arrUpdateParts['indus_pid'] = $indus_pid;
		$arrUpdateParts['old_indus_pid'] = $arrServiceInfo['indus_pid'];
	}
	if($arrServiceInfo['title'] !=$goodsname && $goodsname){
		$arrUpdateParts['title'] = $goodsname;
		$arrUpdateParts['old_title'] = $arrServiceInfo['title'];
	}
    foreach($arrCustom as $k=>$v){
	    foreach($id as $i=>$j){
	        $arrService = unserialize($v['extdata']);
	        if($arrService[$v['f_code']]['content'] != $extdata[$i]){
	            $arrUpdateParts['custom'][$j] = $extdata[$i];
	            $arrUpdateParts['old_custom'][$j] = $arrService[$v['f_code']]['content'];
	        }
	    }  
	}
	if($arrServiceInfo['price'] !=$goodsprice && $goodsname){
		$arrUpdateParts['price'] = $goodsprice;
		$arrUpdateParts['old_price'] = $arrServiceInfo['price'];
	}
	if($arrServiceInfo['pic'] !=$file_ids && $goodsname){
		$arrUpdateParts['pic'] = $file_ids;
		$arrUpdateParts['old_pic'] = $arrServiceInfo['pic'];
	}
	if($arrServiceInfo['content'] !=kekezu::k_stripslashes($goodsdesc) && $goodsdesc){
		$arrUpdateParts['content'] = kekezu::k_stripslashes($goodsdesc);
		$arrUpdateParts['old_content'] = $arrServiceInfo['content'];
	}
	if($arrServiceInfo['unite_price'] !=$unite_price && $unite_price){
		$arrUpdateParts['unite_price'] = $unite_price;
		$arrUpdateParts['old_unite_price'] = $arrServiceInfo['unite_price'];
	}
	if($arrServiceInfo['submit_method'] !=$submit_method && $submit_method){
		$arrUpdateParts['submit_method'] = $submit_method;
		$arrUpdateParts['old_submit_method'] = $arrServiceInfo['submit_method'];
	}
	if($arrServiceInfo['file_path'] !=$file_path_2 && $file_path_2){
		$arrUpdateParts['file_path'] = $file_path_2;
		$arrUpdateParts['old_file_path'] = $arrServiceInfo['file_path'];
	}
	if($arrServiceInfo['service_time'] !=$service_time && $service_time){
	    $arrUpdateParts['service_time'] = $service_time;
	    $arrUpdateParts['old_service_time'] = $arrServiceInfo['service_time'];
	}
	if($arrServiceInfo['unit_time'] !=$unit_time && $unit_time){
	    $arrUpdateParts['unit_time'] = $unit_time;
	    $arrUpdateParts['old_unit_time'] = $arrServiceInfo['unit_time'];
	}
	if($arrServiceInfo['unite_price'] !=$unite_price && $unite_price){
	    $arrUpdateParts['unite_price'] = $unite_price;
	    $arrUpdateParts['old_unite_price'] = $arrServiceInfo['unite_price'];
	}
	if(!intval($pk['service_id'])){
		$arrData['profit_rate'] = $arrGoodsConfig['service_profit'];
		$arrData['on_time'] = time();
		$arrData['service_status'] = 2;
		$objServiceT = new keke_table_class ( 'witkey_service' );
		$objServiceT->save ( $arrData);
		unset($objServiceT);
	}else{
		if($arrServiceInfo['service_status'] =='1'){
			$objServiceT = new keke_table_class ( 'witkey_service' );
			$objServiceT->save ( $arrData,$pk);
		}else{
			if(!empty($arrUpdateParts)){
				CommonClass::createEditLog($pk['service_id'], $arrServiceInfo['model_id'], serialize($arrUpdateParts));
				keke_shop_release_class::updateEditStatusBySid($pk['service_id'], 1);
			}else{
				kekezu::show_msg($strServiceName.'信息没有更改',$strJumpUrl,NULL,NULL,'ok');
			}
		}
	}
	if ($objId&&$intTaskId) {
		$strBidSql  = ' UPDATE `'.TB_PRE.'witkey_task_bid`  SET `hasdel`=1 WHERE (`bid_id` ='.$objId.')  and task_id = '.$intTaskId;
		$strWorkSql = ' UPDATE `'.TB_PRE.'witkey_task_work` SET `hasdel`=1 WHERE (`work_id`='.$objId.')  and task_id = '.$intTaskId;
		db_factory::execute($strBidSql);
		db_factory::execute($strWorkSql);
	}
	kekezu::show_msg('操作成功',$strJumpUrl,NULL,NULL,'ok');
}
function updateFilepath($serviceId,$filepath,$type){
	if($type == 'pic'){
		$sql = ' update '.TB_PRE.'witkey_service set pic = "'.$filepath.'" where service_id = '.intval($serviceId);
	}else{
		$sql = ' update '.TB_PRE.'witkey_service set file_path = "'.$filepath.'" where service_id = '.intval($serviceId);
	}
	db_factory::execute($sql);
}
require  $kekezu->_tpl_obj->template($do.'/'.$view.'_'.$op);die;
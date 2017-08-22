<?php defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
$stdCacheName = 'service_cache_'.$id.'_' . substr ( md5 ( $gUid ), 0, 6 );
$objRelease = goods_release_class::get_instance ($id);
$objRelease->get_service_obj ( $stdCacheName );
$arrPubInfo = $objRelease->_std_obj->_release_info; 
$arrConfig = $objRelease->_service_config; 
$arrPubInfo['indus_pid'] and $arrAllIndustrys = CommonClass::getIndustryByPid($arrPubInfo['indus_pid'],'indus_id,indus_pid,indus_name');
$userInfo=db_factory::get_one("select * from ".TB_PRE."witkey_space where uid=".intval($gUid));
$province=$userInfo['province'];
$city=$userInfo['city'];
$area=$userInfo['area'];
if($arrPubInfo['onecity']){
    $province=$arrPubInfo['onecity'];
}
if($arrPubInfo['twocity']){
    $city=$arrPubInfo['twocity'];
}
if($arrPubInfo['threecity']){
    $area=$arrPubInfo['threecity'];
}
$arrPubInfo['province'] and $arrCities = CommonClass::getDistrictByPid($arrPubInfo['province'],'id,upid,name');
$arrPubInfo['city'] and $arrAreas = CommonClass::getDistrictByPid($arrPubInfo['city'],'id,upid,name');
switch ($step) {
	case 'step1':
$regionCfg =  keke_glob_class::getRegionConfig();
		$objRelease->check_access ( $step, $id, $arrPubInfo );
		$strExtTypes2   = kekezu::get_ext_type (); 
		$arrPriceUnit = $objRelease->get_price_unit (); 
		$floatPrice = floatval($txt_price);
		if (isset($formhash)&&kekezu::submitcheck($formhash)) {
			if($_POST['province'] == 'p'){
				$tips['errors']['province'] = '请选择省份';
				kekezu::show_msg($tips,null,null,null,'error');
			}
			if (!htmlspecialchars($_POST['tar_content'])) {
				$tips['errors']['tar_content'] = '请输入作品描述';
				kekezu::show_msg($tips,NULL,NULL,NULL,'error');
			}
			$floatMinCash = floatval($arrConfig['min_cash']);
			if ($floatPrice < $floatMinCash) {
				$tips['errors']['txt_price'] = '你的商品价格不能少于￥'.$floatMinCash.'元';
				kekezu::show_msg($tips,NULL,NULL,NULL,'error');
			}
			if($submit_method=='inside'){
				if (!$file_path_2) {
					$tips['errors']['file_path_2'] = '请上传源文件';
					kekezu::show_msg($tips,NULL,NULL,NULL,'error');
				}
			}
			$_POST['tar_content'] = kekezu::escape($tar_content);
			if (!$_POST['tar_content']) {
				$tips['errors']['tar_content'] = '内容不能为空！';
				kekezu::show_msg($tips,NULL,NULL,NULL,'error');
			}
			if (strtoupper ( CHARSET ) == 'GBK') {
				$_POST = kekezu::utftogbk($_POST );
			}
			$arrPubInfo and $_POST = array_merge ( $arrPubInfo, $_POST );
			$_POST['txt_price'] = keke_curren_class::convert($_POST['txt_price'],0,true);
			$objRelease->save_service_obj ( $_POST, $stdCacheName ); 
			kekezu::show_msg($tips,$strUrl.'&step=step2',NULL,NULL,'ok');
		}
		$arrImageLists = CommonClass::getFileArrayByPath(',', $arrPubInfo['pic_patch']);
		$arrFileLists = CommonClass::getFileArrayByPath(',', $arrPubInfo['file_path_2']);
		$arrFileIds = CommonClass::getFileArray('|', $arrPubInfo['fileid1']);
		if(!empty($arrFileIds)){
			$data = array();
			foreach ($arrFileIds as $k=>$v){
				$data[$k] = $v['file_id'];
			}
			$arrPubInfo['fileids'] = implode("|", $data);
		}
		break;
	case 'step2':
		if (isset($formhash)&&kekezu::submitcheck($formhash)) {
			$arrPayitems = array(
					'goodstop'=>intval($txt_goodstop)&&intval($text_goodstop) ?intval($text_goodstop):0,
			);
			$arrPayitems = array_filter($arrPayitems);
			PayitemClass::validPayitemCosts($hdn_total_costs);
			$arrPubInfo['payitem'] = $arrPayitems;
			$arrPubInfo and $_POST = array_merge ( $arrPubInfo, $_POST );
			$objRelease->save_service_obj ( $_POST, $stdCacheName ); 
			$intSid = $objRelease->pub_service (); 
			$objRelease->update_service_info ( $intSid, $stdCacheName ); 
			kekezu::show_msg($tips,$strUrl.'&step=step3&serviceId='.$intSid,NULL,NULL,'ok');
		}else{			
			!$_SESSION[$stdCacheName] and kekezu::show_msg($_lang ['friendly_notice'],"index.php?do=pubgoods&id=$id",2,"该商品已提交，不可再返回修改！","warning");
			$objRelease->check_access($step, $id, $arrPubInfo);
			$strTarComment=kekezu::cutstr(htmlspecialchars_decode($arrPubInfo['tar_content']),1000);
			$strCommentLen = strlen($strTarComment);
			if($strCommentLen > 500){
				$strPartComment = kekezu::cutstr($strTarComment, 500);
			}
		}
		break;
	case 'step3':
		$serviceId = intval($serviceId);
		if(0 === $serviceId){
			kekezu::show_msg('无权访问',$strUrl,3,NULL,'warning');
		}
		$objRelease->del_service_obj ( $stdCacheName ); 
		$objRelease->check_access($step, $id, $arrPubInfo,$serviceId);
		break;
    case 'step4':
			$serviceId = intval($serviceId);
			if(0 === $serviceId){
				kekezu::show_msg('无权访问',$strUrl,3,NULL,'warning');
			}
			$arrPayInfo = $objRelease->checkWhetherToPay($serviceId,'goods');
			$boolValue = $arrPayInfo['balance_pay'];
			$floatPayCash = $arrPayInfo['total_cash'];
			break;
}
require keke_tpl_class::template ( 'pubgoods' );
die();
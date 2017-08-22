<?php
$strUrl = 'index.php?do=user&view=shop&op=setting';
$shopInfo=db_factory::get_one(sprintf(" select * from %switkey_shop where uid='%d' ",TB_PRE,$gUid));
if($ajaxop == 'setstatus'){
	$status = 3;
	if($setstatus =='open'){
		$status = '1';
		keke_shop_release_class::updateShopStatus($uid, $status);
	}else{
		keke_shop_release_class::closeShop($uid,$status);
	}
	die;
}
$arrProvinces = CommonClass::getDistrictByPid('0','areaid,parentid,areaname');
if($shopInfo['city']){
	$arrCity = CommonClass::getDistrictById($shopInfo['city'],'areaid,parentid,areaname');
}
if($shopInfo['area']){
	$arrArea = CommonClass::getDistrictById($shopInfo['area'],'areaid,parentid,areaname');
}
$arrBackgroudStyle = unserialize($shopInfo['shop_backstyle']);
$objShopT = keke_table_class::get_instance('witkey_shop');
if (isset($formhash)&&kekezu::submitcheck($formhash)) {
	if (strtoupper ( CHARSET ) == 'GBK') {
		$shop_name = kekezu::utftogbk($shop_name );
		$shop_slogans = kekezu::utftogbk($shop_slogans );
		$seo_title = kekezu::utftogbk($seo_title );
		$seo_keyword = kekezu::utftogbk($seo_keyword );
		$seo_desc = kekezu::utftogbk($seo_desc );
		$address = kekezu::utftogbk($address);
	}
	$arrData = array(
			'shop_name'	=>$shop_name,
			'shop_slogans'	=>$shop_slogans,
			'province'=>$province,
			'city'=>$city,
			'area'=>$area,
			'address'	=>$address,
			'coordinate'=>$coordinate
	);
	$banner and $arrData['banner'] = $banner;
	$background and $arrData['shop_background'] = $background;
	$repeat and  $arrBackgroudStyle['repeat']= $repeat;
	$position and $arrBackgroudStyle['position']= $position;
	is_array($arrBackgroudStyle) and $arrData['shop_backstyle'] = serialize($arrBackgroudStyle);
	$intRes = $objShopT->save($arrData,array('shop_id'=>$shopInfo['shop_id']));
	unset($objShopT);
	kekezu::show_msg('已保存',NULL,NULL,NULL,'ok');
}

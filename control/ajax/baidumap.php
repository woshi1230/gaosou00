<?php
if($op=='showMap'){
	$shopInfo=db_factory::get_one(sprintf(" select * from %switkey_shop where uid='%d' ",TB_PRE,intval($id)));
	$arrProvinces = CommonClass::getDistrictByPid('0','areaid,parentid,areaname');
	if($shopInfo['province']){
		$province=$arrProvinces[intval($shopInfo['province'])]['name'];
		if($shopInfo['city']){
			$arrCity = CommonClass::getDistrictById($shopInfo['city'],'areaid,parentid,areaname');
			$city = $arrCity['name'];
		}
	}
	$coordinateArr = explode(',', $shopInfo['coordinate']);
	$lng =   $coordinateArr[0];
	$lat =   $coordinateArr[1];
}

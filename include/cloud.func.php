<?php
/*
	[GAOSOU B2B System] Copyright (c) 2016-2017 www.gaosou.net
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_GAOSOU') or exit('Access Denied');
function dcloud($url) {
	$arr = explode('->', $url);
//	$url = 'http://cloud.gaosou.com/'.$arr[0].'/';
	$url = '';
	$par = $arr[1].'&version='.DT_VERSION.'&release='.DT_RELEASE.'&charset='.DT_CHARSET.'&domain='.(DT_DOMAIN ? DT_DOMAIN : DT_PATH).'&uid='.DT_CLOUD_UID.'&auth='.encrypt($arr[1], DT_CLOUD_KEY);
	return dcurl($url, $par);
}

function iplookup($ip) {
	$url = 'http://apistore.baidu.com/microservice/iplookup?ip='.$ip;
	$rec = dcurl($url);
	$area = '';
	if(strpos($rec, 'retData') !== false) {
		$tmp = json_decode($rec, true);
		$arr = $tmp['retData'];
		if(base64_encode($arr['country']) != '5Lit5Zu9') {
			if(isset($arr['country'])) $area .= $arr['country'];
			if(isset($arr['area'])) $area .= $arr['area'];
		}
		if(isset($arr['province'])) $area .= $arr['province'];
		if(isset($arr['city']) && $arr['city'] != $arr['province']) $area .= $arr['city'];
		if(isset($arr['district'])) $area .= $arr['district'];
		if(isset($arr['carrier'])) $area .= ' '.$arr['carrier'];
	}
	return $area ? convert($area, 'UTF-8', DT_CHARSET) : 'Unknown';
}

function mobile2area($mobile) {
	if(!is_mobile($mobile)) return 'Unknown';
	$url = 'http://apistore.baidu.com/microservice/mobilephone?tel='.$mobile;
	$rec = dcurl($url);
	$area = '';
	if(strpos($rec, 'retData') !== false) {
		$tmp = json_decode($rec, true);
		$arr = $tmp['retData'];
		if(isset($arr['supplier'])) $area .= $arr['supplier'].'-';
		if(isset($arr['province'])) $area .= $arr['province'];
		if(isset($arr['city'])) $area .= $arr['city'];
	}
	return $area ? convert($area, 'UTF-8', DT_CHARSET) : 'Unknown';
}

//function mobile2area($mobile) {
//	global $DT_TIME;
//	if(!is_mobile($mobile)) return 'Unknown';
//	$cid = DT_ROOT.'/file/cloud/mobile/'.substr($mobile, 0, 3).'/'.substr($mobile, 3, 4).'/'.$mobile.'.php';
//	if(is_file($cid) && $DT_TIME - filemtime($cid) < 86400*90) {
//		$rec = substr(file_get($cid), 13);
//	} else {
//		$rec = dcloud('mobile->mobile='.$mobile);
//		if(substr($rec, 0, 4) !== 'ERR:') file_put($cid, '<?php exit;? >'.$rec);
//	}
//	return $rec ? convert($rec, 'UTF-8', DT_CHARSET) : 'Unknown';
//}

?>
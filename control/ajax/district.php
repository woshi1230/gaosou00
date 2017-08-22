<?php
if(intval($id)){
	$arrZones = CommonClass::getDistrictByPid($id,'areaid,parentid,areaname');
	if($arrZones){
		$html.='<option value="">请选择</option>';
		foreach ($arrZones as $k=>$v) {
			$html.='<option value='.$v['areaid'].'>'.$v['areaname'].'</option>';
		}
	}else{
		$html.='<option value="">没有了</option>';
	}
}else{
	$id = strval($id);
	if($id == 'p'){
		$html.='<option value="c">选择城市</option>';
	}elseif($id == 'c'){
		$html.='<option value="a">选择区域</option>';
	}
}
echo($html);
die();
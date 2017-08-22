<?php
if(intval($id)){
	$arrData = CommonClass::getIndustryByPid($id,'catid,parentid,catname');
	if($arrData){
		$html.='<option value="">请选择行业分类</option>';
		foreach ($arrData as $k=>$v) {
			$html.='<option value='.$v['catid'].'>'.$v['catname'].'</option>';
		}
	}else{
		$html.='<option value="">请选择行业分类</option>';
	}
	echo($html);
}
die();
<?php
class keke_seo_class{
	static function format($seo,$data){
		foreach($data as $k=>$v){
			if($v){
				$seo = str_replace('{'.$k.'}',$v.'-',$seo);
			}else{
				$seo = str_replace('{'.$k.'}','',$seo);
			}
		}
		return $seo;
	}
	static function getIndusSEO($indus1,$indus2){
		$seoTitle 	= '';
		$seoKeyword = '';
		$seoDesc 	= '';
		$indus1 = (int)$indus1;
		$indus2 = (int)$indus2;
		if($indus1){
			$pInfo1 = CommonClass::getIndustryById($indus1,'seo_title,seo_keywords,seo_description');
			$pInfo1['seo_title'] 	and $seoTitle = $pInfo1['seo_title'];
			$pInfo1['seo_keyword'] 	and $seoKeyword = $pInfo1['seo_keywords'];
			$pInfo1['seo_desc'] 	and $seoDesc = $pInfo1['seo_description'];
		}
		unset($pInfo1);
		if($indus2){
			$pInfo2 = CommonClass::getIndustryById($indus2,'seo_title,seo_keywords,seo_description');
			$pInfo2['seo_title'] 	and $seoTitle 	.= ($seoTitle?'-':'').  $pInfo2['seo_title'];
			$pInfo2['seo_keyword'] 	and $seoKeyword .= ($seoKeyword?'-':'').  $pInfo2['seo_keywords'];
			$pInfo2['seo_desc'] 	and $seoDesc 	.= ($seoDesc?'-':'').  $pInfo2['seo_description'];
		}
		unset($pInfo2);
		$result = array();
		$result['seo_title'] 	= $seoTitle;
		$result['seo_keyword'] 	= $seoKeyword;
		$result['seo_desc'] 	= $seoDesc;
		return $result;
	}
	static function getListSEO($indus1,$indus2,$seodata,$type,$showSiteName = false){
		global $kekezu;
		$indusSEO = self::getIndusSEO($indus1, $indus2);
		$seolist = array();
		if($indusSEO['seo_title']){
			$seolist['seo_title'] =  $indusSEO['seo_title'];
		}else{
			$seolist['seo_title'] =  self::format($kekezu->_sys_config[$type.'_seo_title'],$seodata);
		}
		if($indusSEO['seo_keyword']){
			$seolist['seo_keyword'] =  $indusSEO['seo_keyword'];
		}else{
			$seolist['seo_keyword'] = $kekezu->_sys_config[$type.'_seo_keyword'];
		}
		if($indusSEO['seo_desc']){
			$seolist['seo_desc'] =  $indusSEO['seo_desc'];
		}else{
			$seolist['seo_desc'] =  $kekezu->_sys_config[$type.'_seo_desc'];
		}
		if($showSiteName){
			foreach ($seolist as $k =>$v){
				$seolist[$k] = ($v?$v.'-':''). $kekezu->_sys_config['website_name'];
			}
		}
		return array_values($seolist);
	}
}
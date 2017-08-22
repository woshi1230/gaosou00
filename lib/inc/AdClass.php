<?php
class AdClass {
	static function getAdByAdId($ad_id){
		return db_factory::get_one("SELECT * FROM `".TB_PRE."witkey_ad` WHERE ad_id = '{$ad_id}'");
	}
	static function delAdByAdId($ad_id){
		$info = self::getAdByAdId($ad_id);
		if(!$info){
			return false;
		}
		$ad_file = $info['ad_file'];
		if($ad_file && file_exists(S_ROOT.'/'.$ad_file)){
			unlink(S_ROOT.'/'.$ad_file);
		}
		$adObj = new Keke_witkey_ad_class();
		$adObj->setWhere("ad_id='{$ad_id}'");
		return $adObj->del_keke_witkey_ad();
	}
}
?>
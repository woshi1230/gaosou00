<?php
class CustomClass {
	static function checkCustom($model_id){
		global $kekezu;
		$arrModelInfo = $kekezu->_model_list [$model_id];
		if($arrModelInfo['open_custom'] =='1' ){
			return true;
		}
		return false;
	}
	static function getFieldListsByModelId($model_id){
		if(!self::checkCustom($model_id)) return false;
		return db_factory::query("SELECT * FROM `".TB_PRE."witkey_custom_fields` where model_id = ".intval($model_id).' order by listorder asc ');
	}
	static function getExtCodeByModelId($model_id){
		if(!self::checkCustom($model_id)) return false;
		$result = self::getFieldListsByModelId($model_id);
		$extCode = array();
		if($result){
			foreach ($result as $k=>$v){
				$extCode[]=$v['f_code'];
			}
		}
		return $extCode;
	}
	static function createExtData($objid,$model_id,$data){
		if(!self::checkCustom($model_id)) return false;
		$extCode = CustomClass::getExtCodeByModelId($model_id);
		if($data){
			foreach ($data as $k=>$v){
				if(in_array($k, $extCode)){
					$fieldInfo = self::getFieldName($k);
					$extData = array();
					$extData[$k]['fieldname'] = $fieldInfo['f_name'];
					$extData[$k]['content'] = kekezu::escape($v);
					if($extData){
						$jsondata = serialize($extData);
						$tabObj = keke_table_class::get_instance("witkey_custom_fields_ext");
						$fields = array();
						$fields['c_id']=$fieldInfo['id'];
						$fields['model_id']=$model_id;
						$fields['extdata']=$jsondata;
						$fields['objid']=$objid;
						$tabObj->save($fields);
					}
				}
			}
		}
	}
	static function editExtData($objid,$model_id,$data){
		if(!self::checkCustom($model_id)) return false;
		$extCode = CustomClass::getExtCodeByModelId($model_id);
		if($data){
			foreach ($data as $k=>$v){
				if(in_array($k, $extCode)){
					$fieldInfo = self::getFieldName($k);
					$extData = array();
					$extData[$k]['fieldname'] =$fieldInfo['f_name'];;
					$extData[$k]['content'] = kekezu::escape($v);
					$jsondata = serialize($extData);
					$sql = "UPDATE ".TB_PRE."witkey_custom_fields_ext SET extdata='{$jsondata}' WHERE objid='{$objid}' AND model_id ='{$model_id}' AND c_id = '{$fieldInfo['id']}' ";
					db_factory::execute($sql);
				}
			}
		}
	}
	static function getExtData($objid,$model_id){
		if(!self::checkCustom($model_id)) return false;
		return  db_factory::query("SELECT a.* FROM `".TB_PRE."witkey_custom_fields_ext` a LEFT JOIN `".TB_PRE."witkey_custom_fields` b ON  a.c_id = b.id WHERE a.model_id = ".intval($model_id)." and  a.objid = ".intval($objid).' order by b.listorder asc ');
	}
	static function getExtDataInfo($objid,$model_id){
		if(!self::checkCustom($model_id)) return false;
		$arrShowCustoms = self::getExtData($objid, $model_id);
		if($arrShowCustoms){
			foreach ($arrShowCustoms as $k=>$v){
				if($v['extdata']){
					$arrShowCustoms[$k]['data'] =unserialize($v['extdata']);
				}
			}	
		}
		return $arrShowCustoms;
	}
	static function getExtDataList($objid,$model_id){
		if(!self::checkCustom($model_id)) return false;
		$result  =  db_factory::query("
				SELECT a.id ext_id,a.model_id ext_model_id ,a.extdata, a.objid ,a.c_id,b.* 
				FROM `".TB_PRE."witkey_custom_fields_ext` AS a
				LEFT JOIN  `".TB_PRE."witkey_custom_fields` AS b
				ON a.c_id = b.id 
				WHERE a.objid = '{$objid}' AND a.model_id = '{$model_id}'"
			);
		if($result){
			foreach ($result as $k=>$v){
				if($v['extdata']){
					$result[$k]['data'] =unserialize($v['extdata']);
				}
			}	
		}
		return $result;
	}
	static function getFieldName($fieldcode){
		if(!$fieldcode){
			return false;
		}
		return db_factory::get_one("SELECT * FROM `".TB_PRE."witkey_custom_fields` where f_code = '".$fieldcode."'");
	}
	static function updateExtData($cid){
		$extInfo    = db_factory::get_one("SELECT * FROM `".TB_PRE."witkey_custom_fields_ext` WHERE c_id = ".intval($cid));
		if($extInfo['extdata']){
			$oldData = unserialize($extInfo['extdata']);
			$fieldsInfo = db_factory::get_one("SELECT * FROM `".TB_PRE."witkey_custom_fields` where id = ".intval($cid));
			if($fieldsInfo['f_code']){
				$oldData[$fieldsInfo['f_code']]['fieldname'] = $fieldsInfo['f_name'];
				db_factory::execute("UPDATE `".TB_PRE."witkey_custom_fields_ext` SET `extdata`='".serialize($oldData)."' WHERE (`id`='".intval($extInfo['id'])."')");
			}
		}	
	}
	static function delExtData($cid){
		db_factory::execute("delete FROM `".TB_PRE."witkey_custom_fields_ext` WHERE c_id = ".intval($cid));
	}
	static function delExtDataByObjId($objid,$model_id){
		if(!self::checkCustom($model_id)) return false;
		return db_factory::execute("delete FROM `".TB_PRE."witkey_custom_fields_ext` WHERE objid = ".intval($objid)." and model_id = ".intval($model_id));
	}
}
?>
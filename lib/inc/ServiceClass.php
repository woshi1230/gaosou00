<?php
class ServiceClass {
	public static function getEnabledServiceModelList(){
//		return db_factory::get_table_data('*',TB_PRE . 'witkey_model',' model_status = 1 and model_type = "shop" ',' listorder asc','','','model_id',3600);
		return Keke_witkey_model_class::query("*");
	}
	public static function getShopByObj_id($obj_id){
		return db_factory::get_one("select * from ".TB_PRE."witkey_service where service_id=".intval($obj_id));
	}
	public static function getTaskByObj_id($obj_id){
		return db_factory::get_one("select * from ".TB_PRE."witkey_task where task_id=".intval($obj_id));
	}
}

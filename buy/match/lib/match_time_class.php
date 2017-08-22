<?php
final class match_time_class extends time_base_class {
	function __construct() {
		parent::__construct ();
	}
	function validtaskstatus() {
		$this->task_tb_timeout();
		$this->task_host_timeout();
		$this->task_work_timeout();
		$this->task_confirm_timeout();	
	}
	public function task_tb_timeout() {		
		$task_list = db_factory::query(sprintf("select * from %switkey_task where task_status=2 and sub_time<'%s' and model_id=12",TB_PRE,time()));
		if(is_array($task_list)){
			foreach($task_list as $v){
				$task_obj = new match_task_class($v);
				$task_obj->task_tb_timeout();
			}
		}		
	}
	function task_host_timeout() {
		$task_list = db_factory::query(sprintf("select * from %switkey_task where task_status=3 and end_time<'%s' and model_id=12",TB_PRE,time()));
		if(is_array($task_list)){
			foreach($task_list as $v){
				$task_obj = new match_task_class($v);
				$task_obj->task_host_timeout();
			}
		}
	}
	function task_work_timeout(){
		$task_list = db_factory::query(sprintf("select * from %switkey_task where task_status =5 and end_time<'%s' and model_id=12",TB_PRE,time()));
		if(is_array($task_list)){
			foreach($task_list as $v){
				$task_obj = new match_task_class($v);
				$task_obj->task_other_timeout();
			}
		}
	}
	function task_confirm_timeout() {
		$task_list = db_factory::query(sprintf("select * from %switkey_task where task_status =6 and end_time<'%s' and model_id=12",TB_PRE,time()));
		if(is_array($task_list)){
			foreach($task_list as $v){
				$task_obj = new match_task_class($v);
				$task_obj->task_other_timeout();
			}
		}
	}
}
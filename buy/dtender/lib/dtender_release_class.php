<?php
keke_lang_class::load_lang_class('dtender_release_class');
class dtender_release_class extends keke_task_release_class {
	public $_cash_cove; 
	public static function get_instance($model_id,$pub_mode='professional') {
		static $obj = null;
		if ($obj == null) {
			$obj = new dtender_release_class ( $model_id,$pub_mode);
		}
		return $obj;
	}
	function __construct($model_id,$pub_mode='professional') {
		parent::__construct ( $model_id,$pub_mode);
		$cash = $this->_std_obj->_release_info['txt_task_cash'] = $this->get_dtender_realcash();
		$this->_default_max_day = keke_task_release_class::get_default_max_day($cash, $model_id,$this->_task_config['min_day']);
		$this->get_task_config ();
		$this->priv_init();
		$this->cash_cove_init();
	}
	public function priv_init() {
		$priv_arr = dtender_priv_class::get_priv ('',$this->_model_id, $this->_user_info, '2' );
		$this->_priv = $priv_arr ['pub'];
	}
	public function cash_cove_init(){
		global $kekezu;
		$this->_cash_cove = $kekezu->get_cash_cove('dtender');
	}
	public function get_task_config() {
		global $model_list;
		$model_list [$this->_model_id] ['config'] and $this->_task_config = unserialize ( $model_list [$this->_model_id] ['config'] ) or $this->_task_config = array ();
	}
	function pub_mode_init($std_cache_name, $data = array()) {
		global $kekezu;
		global $_lang;
		$release_info = $this->_std_obj->_release_info;
		switch ($this->_pub_mode) {
			case "professional" :
				break;
			case "guide" :
				break;
			case "onekey" :
				if (! $release_info) {
					$sql = " select model_id,task_title,task_desc,indus_id,indus_pid,
						task_cash,task_cash_coverage,contact from %switkey_task where task_id='%d' and model_id='%d'";
					$task_info = db_factory::get_one ( sprintf ( $sql, TB_PRE, $data ['t_id'] ,$this->_model_id));
					$task_info or kekezu::show_msg($_lang['operate_notice'],$_SERVER['HTTP_REFERER'],3,$_lang['not_exsist_relation_task_and_not_user_onekey'],"warning");
					$release_info = $this->onekey_mode_format($task_info);
					$release_info ['task_cash_cove'] = intval ( $task_info ['task_cash_coverage'] );
					$this->save_task_obj ( $release_info, $std_cache_name ); 
				}
				break;
		}
	}
	public function pub_task() {
		$task_obj = $this->_task_obj;
		$std_obj = $this->_std_obj;
		$this->public_pubtask();
		$task_obj->setReal_cash ($this->get_dtender_realcash() ); 
		$task_obj->setStart_time ( time () ); 
		$time_arr = getdate ();
		$rel_time = $time_arr ['hours'] * 3600 + $time_arr ['minutes'] * 60 + $time_arr ['seconds'];
		$task_obj->setSub_time ( $rel_time + strtotime( $this->_std_obj->_release_info['txt_task_day']) ); 
		if($this->_std_obj->_release_info['budget_radio'] =='2'){
		    $task_cash = $this->_std_obj->_release_info['txt_budget'];
		    $task_obj->setBudget ( $task_cash );
		    $task_obj->setTask_cash_coverage(0);
		}else{
			$task_obj->setBudget ( 0);
		    $task_obj->setTask_cash_coverage($this->_std_obj->_release_info['task_cash_cove']);
		    $cash_cove = $this->_cash_cove;
		    $cove = $cash_cove [$this->_std_obj->_release_info['task_cash_cove']];
		    $task_cash = $cove ['end_cove'];
		    $task_cash or $task_cash = $cove ['start_cove'];
		}
		$task_obj->setTask_cash ( $task_cash );
		$task_id = $task_obj->create_keke_witkey_task ();
		return $task_id;
	}
	public function set_dtask_status($total_cash, $task_cash) {
		global $kekezu;
		$basic_config = $kekezu->_sys_config;
		$balance = $this->_user_info ['balance'];
		$kekezu->_sys_config['credit_is_allow']==1 and $credit = $this->_user_info ['credit'];
		if ($balance + $credit >= $total_cash) { 
			if ($this->_task_config['open_audit']=='close') { 
				$task_status = '2'; 
			} else{ 
				$task_status = "1"; 
			}
			if ($basic_config ['credit_is_allow'] == '2') { 
				$cash_cost = $task_cash;
				$credit_cost = '0';
			} else { 
				if ($credit >= $task_cash) { 
					$credit_cost = $task_cash;
					$cash_cost = '0';
				} else {
						$credit_cost = $credit;
						$cash_cost = $task_cash - $credit;
					}
			}
		} else {
			$task_status = "0"; 
		}
		$this->_task_obj->setTask_status ( $task_status ); 
		$this->_task_obj->setCash_cost ( $cash_cost ); 
		$this->_task_obj->setCredit_cost ( $credit_cost ); 
	}
	public function get_dtender_realcash($task_cash_cove = 0){
		if (!intval($task_cash_cove)){
			$task_cash_cove = $this->_std_obj->_release_info['task_cash_cove'];
		}
		if($this->_task_config['pay_methods'] =='scale'){
			$budget_radio = $this->_std_obj->_release_info['budget_radio'];
			if($budget_radio == '1'){
				$task_cash_cove_info = db_factory::get_one ( "SELECT * FROM `".TB_PRE."witkey_task_cash_cove` WHERE model_code ='dtender'  AND cash_rule_id = '".$task_cash_cove."'");
				if($task_cash_cove_info){
					$cash = intval($task_cash_cove_info['start_cove']) * (intval($this->_task_config['deposit_scale'])/100);
				}else{
					intval($this->_task_config['deposit']) and $cash = intval($this->_task_config['deposit']) or $cash= intval($this->_task_config['min_cash']);
				}
			}else{
				$txt_budget = $this->_std_obj->_release_info['txt_budget'];
				if($txt_budget){
					$cash = intval($txt_budget) * (intval($this->_task_config['deposit_scale'])/100);
				}else{
					intval($this->_task_config['deposit']) and $cash = intval($this->_task_config['deposit']) or $cash= intval($this->_task_config['min_cash']);
				}
			}
		}else{
			intval($this->_task_config['deposit']) and $cash = intval($this->_task_config['deposit']) or $cash= intval($this->_task_config['min_cash']);
		}
		return $cash;
	}
}
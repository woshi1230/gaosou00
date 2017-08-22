<?php
keke_lang_class::load_lang_class('match_release_class');
class match_release_class extends keke_task_release_class {
	public $_cash_cove; 
	public static function get_instance($model_id,$pub_mode='professional') {
		static $obj = null;
		if ($obj == null) {
			$obj = new match_release_class ( $model_id,$pub_mode);
		}
		return $obj;
	}
	function __construct($model_id,$pub_mode='professional') {
		parent::__construct ( $model_id,$pub_mode);
		$this->get_task_config ();
		$this->_default_max_day = date('Y-m-d',time()+$this->_task_config['max_day']*24*3600);
		$this->priv_init();
		$this->cash_cove_init();
	}
	public function cash_cove_init(){
		global $kekezu;
		$this->_cash_cove = $kekezu->get_cash_cove('match');
	}
	public function priv_init() {
		$priv_arr = match_priv_class::get_priv ('',$this->_model_id, $this->_user_info, '2' );
		$this->_priv = $priv_arr ['pub'];
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
						task_cash,work_count,single_cash,contact from %switkey_task where task_id='%d' and model_id='%d'";
					$task_info = db_factory::get_one ( sprintf ( $sql, TB_PRE, $data ['t_id'] ,$this->_model_id));
					$task_info or kekezu::show_msg($_lang['operate_notice'],$_SERVER['HTTP_REFERER'],3,$_lang['not_exsist_relation_task_and_not_user_onekey'],"warning");
					$release_info = $this->onekey_mode_format($task_info);
					$allow_time = $kekezu->get_show_day ( $task_info['task_cash'], $this->_model_id );
					$task_day   = date('Y-m-d',$allow_time*24*3600+time());
					$release_info ['txt_task_day'] = $task_day;
					$release_info ['txt_task_cash'] = intval ( $task_info ['txt_task_cash'] );
					$release_info ['txt_work_count'] = intval ( $task_info ['work_count'] );
					$release_info ['txt_single_cash'] = intval ( $task_info ['single_cash'] );
					$this->save_task_obj ( $release_info, $std_cache_name ); 
				}
				break;
		}
	}
	public function pub_task() {
		$task_obj = $this->_task_obj;
		$release_info =$this->_std_obj->_release_info;
		$this->public_pubtask();
		$task_cash = $release_info['txt_task_cash'];
		$task_obj->setTask_cash_coverage($release_info['task_cash_cove']);
		$task_obj->setTask_cash(0);
		$task_obj->setCash_cost(0);
		$task_obj->setReal_cash($task_cash);
		$task_id = $task_obj->create_keke_witkey_task ();
		return $task_id;
	}
	public function save_task_match($task_id){
		$release_info =$this->_std_obj->_release_info;
		$match_obj    = new Keke_witkey_task_match_class();
		$match_obj->_mt_id=null;
		$match_obj->setHirer_deposit($release_info['txt_task_cash']);
		$match_obj->setDeposit_cash($release_info['txt_task_cash']);
		$match_obj->setTask_id($task_id);
		$match_obj->setDeposit_rate($this->_task_config['deposit_rate']);
		return $match_obj->create_keke_witkey_task_match();
	}
}
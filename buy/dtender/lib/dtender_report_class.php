<?php
keke_lang_class::load_lang_class('dtender_report_class');
class dtender_report_class extends keke_report_class {
	public static function get_instance($report_id, $report_info = null, $obj_info = null,$user_info=null,$to_userinfo=null) {
		static $obj = null;
		if ($obj == null) {
			$obj = new dtender_report_class ( $report_id, $report_info, $obj_info,$user_info,$to_userinfo);
		}
		return $obj;
	}
	public function __construct($report_id, $report_info, $obj_info,$user_info,$to_userinfo) {
		parent::__construct ( $report_id, $report_info, $obj_info,$user_info,$to_userinfo );
		$this->_task_info = $this->get_task_info($this->_report_info['origin_id']);
		$this->_task_obj = new dtender_task_class($this->_task_info);
	}
	public function process_rights($op_result, $type) {
		global $kekezu;
		global $_lang;
		$prom_obj = keke_prom_class::get_instance ();
		$prom_obj = $kekezu->_prom_obj;
		$trans_name = $this->get_transrights_name ( $this->_report_type );
		$op_result = $this->op_result_format ( $op_result ); 
		$g_info = $this->user_role ( 'gz' ); 
		$w_info = $this->user_role ( 'wk' ); 
		switch ($op_result ['action']) {
			case "pass" :
				if ($this->_process_can ['sharing']) { 
					$total_cash = floatval ( $this->_obj_info ['cash'] ); 
					$gz_get = floatval (keke_curren_class::convert($op_result['gz_get'],0,true)); 
					$wk_get = floatval (keke_curren_class::convert($op_result['wk_get'],0,true)); 
					if ($total_cash != $gz_get + $wk_get) {
						kekezu::admin_show_msg ( $_lang['wain_you_give_cash_error_notice'], "index.php?do=trans&view=process&type=$type&report_id=" . $this->_report_id, "3", "", "error" );
					} else {
						$res = keke_finance_class::cash_in ( $g_info ['uid'], $gz_get, 'rights_return' ); 
						$res .= keke_finance_class::cash_in ( $w_info ['uid'], $wk_get, 'rights_return' ); 
						if ($res) {
							$this->process_unfreeze ('pass', $op_result ['process_result'] ); 
							$this->change_status ( $this->_report_id, '4',$op_result, $op_result ['process_result'] ); 
							$objProm = keke_prom_class::get_instance ();
							$w_event = $objProm->get_prom_event ($this->_obj_info['origin_id'], $w_info ['uid'], "bid_task" );
							$objProm->set_prom_event_status ( $w_event ['parent_uid'], $this->_gusername, $w_event ['event_id'], '3' );
							$g_event = $objProm->get_prom_event ($this->_obj_info['origin_id'], $g_info ['uid'], "pub_task" );
							$objProm->set_prom_event_status ( $g_event ['parent_uid'], $this->_gusername, $g_event ['event_id'], '3' );
						}
					}
					$res and kekezu::admin_show_msg ( $trans_name . $_lang['deal_success'], "index.php?do=trans&view=rights&type=$type", "3","","success" ) or kekezu::admin_show_msg ( $trans_name . $_lang['deal_fail'], "index.php?do=trans&view=process&type=$type&report_id=" . $this->_report_id, "3","","warning");
				} else {
					kekezu::admin_show_msg ( $trans_name . $_lang['deal_fail_now_forbit_deal_cash'], "index.php?do=trans&view=process&type=$type&report_id=" . $this->_report_id, "3" ,"warning");
				}
				break;
			case "nopass" :
				$this->process_unfreeze ('nopass',$op_result ['reply'] ); 
				$res=$this->change_status ( $this->_report_id, '3', $op_result, $op_result ['reply'] ); 
				$res and kekezu::admin_show_msg ( $trans_name . $_lang['deal_success'], "index.php?do=trans&view=rights&type=$type", "3","","success"  ) or kekezu::admin_show_msg ( $trans_name . $_lang['deal_fail'], "index.php?do=trans&view=process&type=$type&report_id=" . $this->_report_id, "3","","warning" );
				break;
		}
	}
	public function process_report($op_result, $type) {
		global $_lang;
		$trans_name = $this->get_transrights_name ( $this->_report_type );
		$op_result ['result'] = $op_result ['process_result'];
		$op_result = $this->op_result_format ( $op_result ); 
		if($op_result ['action']){
			switch ($op_result ['task']) {
				case 1:
					$res = $this->_task_obj->dispose_task_return();
					$this->_task_obj->set_task_status(9);
					$v_arr = array ($_lang ['username'] => $this->_task_obj->_gusername, $_lang ['model_name'] => $this->_task_obj->_model_name, $_lang ['task_id'] => $this->_task_obj->_task_id, $_lang ['task_title'] => $this->_task_obj->_task_title, 'reason' => $_lang ['trust_cash_timeout'], 'explain' => $_lang ['trust_cash_timeout_and_return'] . $res ['return_cash'] . $_lang ['yuan'] . CREDIT_NAME . ":" . $res ['return_credit'] );
					keke_msg_class::notify_user ( $this->_task_obj->_guid, $this->_task_obj->_gusername, 'task_fail', $_lang ['task_fail_notice'], $v_arr,1 );
					$this->process_notify ( 'pass', $this->_report_info, $this->_user_info, $this->_to_user_info, $op_result ['result'] ); 
					$res = $this->change_status ( $this->_report_id, '4', $op_result, $op_result ['result'] ); 
					break;
				case 2:
					kekezu::admin_show_msg ( '操作提示', "index.php?do=trans&view=report&type=$type", "3","该任务不能进行此操作");
					break;
				case 3:
					$this->process_notify ( 'nopass', $this->_report_info, $this->_user_info, $this->_to_user_info, $op_result ['result'] , $op_result ['reply'] ); 
					$res = $this->change_status ( $this->_report_id, '3', $op_result, $op_result, $op_result ['result'] ); 
					break;
				case 4:
					$res = $this->shield_work($this->_obj_info ['obj_id']);
					$this->_task_obj->set_task_status(2);
					$this->process_notify ( 'pass', $this->_report_info, $this->_user_info, $this->_to_user_info, $op_result ['result'] ); 
					$res = $this->change_status ( $this->_report_id, '4', $op_result, $op_result ['result'] ); 
					break;
				case 5:
					$this->cancel_bid( $this->_obj_info ['obj_id']);
					$this->_task_obj->set_task_status(2);
					$this->process_notify ( 'pass', $this->_report_info, $this->_user_info, $this->_to_user_info, $op_result ['result'] ); 
					$res = $this->change_status ( $this->_report_id, '4', $op_result, $op_result ['result'] ); 
					break;
				case 6:
					$this->disablePeople();
					$this->process_notify('pass',$this->_report_info, $this->_user_info, $this->_to_user_info,$op_result ['process_result']);
					$res=$this->change_status ( $this->_report_id, '4', $op_result,$op_result ['process_result'] ); 
					$res and kekezu::admin_show_msg ( $trans_name . $_lang['deal_success'], "index.php?do=trans&view=rights&type=$type", "3",'','success' ) or kekezu::admin_show_msg ( $trans_name . $_lang['deal_fail'], "index.php?do=trans&view=process&type=$type&report_id=" . $this->_report_id, "3",'','warning' );
			}
			if($res){
				kekezu::admin_show_msg ( $trans_name . $_lang['deal_success'], "index.php?do=trans&view=report&type=$type", "3","","success" );
			}else{
				kekezu::admin_show_msg ( $trans_name . $_lang['deal_fail'], "index.php?do=trans&view=process&type=$type&report_id=" . $this->_report_id, "3","","warning" );
			}
		}
	}
}
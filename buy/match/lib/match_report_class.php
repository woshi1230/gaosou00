<?php
class match_report_class extends keke_report_class {
	public $_match_task;
	public $_match_work;
	public static function get_instance($report_id, $report_info = null, $obj_info = null) {
		static $obj = null;
		if ($obj == null) {
			$obj = new match_report_class ( $report_id, $report_info, $obj_info );
		}
		return $obj;
	}
	public function __construct($report_id, $report_info, $obj_info) {
		parent::__construct ( $report_id, $report_info, $obj_info );
		$this->_task_info = $this->get_task_info($this->_report_info['origin_id']);
		$this->_task_obj = new match_task_class($this->_task_info);
		$this->_match_task = db_factory::get_one ( sprintf ( " select * from %switkey_task_match where task_id='%d'", TB_PRE, $this->_obj_info ['origin_id'] ) );
		$this->_match_work = db_factory::get_one ( sprintf ( " select b.* from %switkey_task_work a left join %switkey_task_match_work b on a.work_id=b.work_id where a.task_id='%d' and a.work_status=4", TB_PRE, TB_PRE, $this->_obj_info ['origin_id'] ) );
	}
	function process_report($op_result, $type) {
		keke_lang_class::load_lang_class ( 'match_report_class' );
		global $_lang;
		$config = $this->_task_obj->_task_config;
		$op_result ['result'] = $op_result ['process_result'];
		$op_result = $this->op_result_format ( $op_result );
		$trans_name = $this->get_transrights_name ( $this->_report_info ['report_type'] );
		if($op_result ['action']){
			switch ($op_result ['task']) {
				case 1:
					if($this->_task_obj->_task_status == 2){
						$this->_task_obj->set_task_status( 9 );
						$rate = $config ['deposit_rate'];
						$profit =  $rate ;
						$return_cash = floatval($this->_task_info['real_cash']-$rate);
						$return_cash >0  and keke_finance_class::cash_in ( $this->_task_obj->_guid, $return_cash, 'deposit_return', '', 'task', $this->_task_obj->_task_id, $profit );
						$g_notify = array ($_lang ['description'] => $_lang ['task_has_failed_and_deposit_cash_will_be_return'], $_lang ['task_title'] => $this->_task_obj->_notice_url );
						$this->_task_obj->notify_user ( 'match_task', $_lang ['work_hand_expired_notice'], $g_notify );
					}elseif ($this->_task_obj->_task_status == 3){
						db_factory::execute ( sprintf ( " update %sfinance_record set site_profit='%.2f' where obj_id='%d' and amount<0 and reason='pub_task'", TB_PRE, $this->_task_info ['hirer_deposit'], $this->_task_obj->_task_id ) );
						$g_notify = array ($_lang ['description'] => $_lang ['host_reward_expired_and_task_failed'], $_lang ['task_title'] => $this->_task_obj->_notice_url );
						$this->_task_obj->notify_user ( 'match_task', $_lang ['host_expired_notice'], $g_notify );
						$work_info = $this->_task_obj->work_exists ();
						$match_info = $this->_task_obj->get_match_work ( $work_info ['work_id'] );
						if(intval($match_info['wiki_deposit'])){
							keke_finance_class::cash_in ( $work_info ['uid'], $match_info ['deposit_cash'],  'deposit_return', '', 'task', $this->_task_obj->_task_id );
						}
						$w_notify = array ($_lang ['description'] => $_lang ['hirer_host_reward_expired_and_task_failed'], $_lang ['task_title'] => $this->_task_obj->_notice_url );
						$this->_task_obj->notify_user ( 'match_task', $_lang ['host_expired_notice'], $w_notify, 2, $work_info ['uid'] );
						$this->_task_obj->set_task_status ( 9 );
					}
					$this->process_notify ( 'pass', $this->_report_info, $this->_user_info, $this->_to_user_info, $op_result ['result'] ); 
					$res = $this->change_status ( $this->_report_id, '4', $op_result, $op_result ['process_result'] ); 
					break;
				case 2:
					kekezu::admin_show_msg ( '操作提示', "index.php?do=trans&view=process&type=$type&report_id=" . $this->_report_id, "3","该任务不可系统选稿","warning" );
					break;
				case 3:
					$this->process_notify ( 'nopass', $this->_report_info, $this->_user_info, $this->_to_user_info, $op_result ['result'] , $op_result ['reply'] ); 
					$res = $this->change_status ( $this->_report_id, '3', $op_result, $op_result, $op_result ['process_result'] ); 
					break;
				case 4:
					$res = $this->shield_work($this->_obj_info ['obj_id']);
					$this->_task_obj->set_task_status(2);
					$this->process_notify ( 'pass', $this->_report_info, $this->_user_info, $this->_to_user_info, $op_result ['result'] ); 
					$res = $this->change_status ( $this->_report_id, '4', $op_result, $op_result ['process_result'] ); 
					break;
				case 5:
					$this->cancel_bid ( $this->_obj_info ['obj_id']);
					$this->_task_obj->set_task_status(2);
					$match_info = $this->_task_obj->get_match_work ( $this->_obj_info ['obj_id'] );
					$work_info = $this->_task_obj->get_task_work($this->_obj_info ['obj_id']);
					if($match_info['wiki_deposit']){
						keke_finance_class::cash_in ( $work_info ['uid'], $match_info ['deposit_cash'], 'deposit_return', '', 'task', $this->_obj_info ['origin_id'] );
					}
					$this->process_notify ( 'pass', $this->_report_info, $this->_user_info, $this->_to_user_info, $op_result ['result'] ); 
					$res = $this->change_status ( $this->_report_id, '4', $op_result, $op_result ['process_result'] ); 
					break;
			}
			if($res){
				kekezu::admin_show_msg ( $trans_name . $_lang['deal_success'], "index.php?do=trans&view=report&type=$type", "3","","success" );
			}else{
				kekezu::admin_show_msg ( $trans_name . $_lang['deal_fail'], "index.php?do=trans&view=process&type=$type&report_id=" . $this->_report_id, "3","","warning" );
			}
		}
	}
	function process_rights($op_result, $type) {
		global $kekezu,$_K,$_lang;
		$prom_obj = $objProm = keke_prom_class::get_instance ();
		$trans_name = $this->get_transrights_name ( $this->_report_type );
		$op_result = $this->op_result_format ( $op_result ); 
		$g_info = $this->user_role ( 'gz' ); 
		$w_info = $this->user_role ( 'wk' ); 
		$match_task= $this->_match_task;
		$match_work = $this->_match_work;
		switch ($op_result ['action']) {
			case "pass" :
				if ($this->_process_can ['sharing']) { 
					$hire  = $op_result['hire_deposit'];
					$wiki  = $op_result['wiki_deposit'];
					$host  = $op_result['host_amount'];
					switch ($hire){
						case 1:
							$g_noti = $_lang['deposit_cash_all_refund'];
							$res  = keke_finance_class::cash_in($g_info['uid'],$match_task['deposit_cash'],'deposit_return','','task',$match_task['task_id']);
							break;
						case 2:
							$g_noti = $_lang['deposit_cash_part_defund'];
							$rate   = $match_task['deposit_rate'];
							$cash   = floatval($match_task['deposit_cash']- $rate);
							$profit = $rate;
							$res  = keke_finance_class::cash_in($g_info['uid'],$cash,'deposit_return','','task',$match_task['task_id'],$profit);
							break;
						case 3:
							$g_noti = $_lang['deposit_cash_all_deduct'];
							$res = db_factory::execute ( sprintf ( " update %sfinance_record set site_profit='%.2f' where obj_id='%d' and amount<0 and reason='pub_task'", TB_PRE, $match_task ['hirer_deposit'],$match_task['task_id']) );
							break;
					}
					switch ($wiki){
						case 1:
							$w_noti = $_lang['deposit_cash_all_refund'];
							$res  = keke_finance_class::cash_in($w_info['uid'],$match_work['deposit_cash'],'deposit_return','','task',$match_task['task_id']);
							break;
						case 2:
							$w_noti = $_lang['deposit_cash_part_defund'];
							$rate   = $match_task['deposit_rate'];
							$cash   = floatval($match_work['deposit_cash']- $rate);
							$profit = $rate;
							$res  = keke_finance_class::cash_in($w_info['uid'],$cash,'deposit_return','','task',$match_task['task_id'],$profit);
							break;
						case 3:
							$w_noti = $_lang['deposit_cash_all_deduct'];
							$res = db_factory::execute ( sprintf ( " update %sfinance_record set site_profit='%.2f' where obj_id='%d' and amount<0 and reason='host_deposit'", TB_PRE, $match_task ['hirer_deposit'],$match_work['work_id']) );
							break;
					}
					switch ($host){
						case 1:
							$g_noti .= $_lang['host_cash_has_all_been_refund'];
							$data = array(':task_id'=>$match_task['task_id'],':task_title'=>$match_task['task_title']);
				            keke_finance_class::init_mem('host_return', $data);
							$res  .= keke_finance_class::cash_in($g_info['uid'],$match_task['host_cash'],'host_return','','task',$match_task['task_id']);
							break;
						case 2:
							$hire_get = floatval (keke_curren_class::convert($op_result['hire_get'],0,true)); 
							$wiki_get = floatval (keke_curren_class::convert($op_result['wiki_get'],0,true)); 
							$g_noti .= $_lang['host_cash_has_part_been_refund'];
							$data = array(':task_id'=>$match_task['task_id'],':task_title'=>$match_task['task_title']);
				            keke_finance_class::init_mem('host_split', $data);
							$res  .= keke_finance_class::cash_in($g_info['uid'],$hire_get,'host_split','','task',$match_task['task_id']);
							$w_noti .= $_lang['get_part_host_cash'];
							$rate  = db_factory::get_count(sprintf(" select profit_rate from %switkey_task where task_id ='%d'",TB_PRE,$match_task['task_id']));
							$profit= $wiki_get*$rate/100;
							$wiki_get-=$profit;
							$data = array(':task_id'=>$match_task['task_id'],':task_title'=>$match_task['task_title']);
				            keke_finance_class::init_mem('host_split', $data);
							$res  .= keke_finance_class::cash_in($w_info['uid'],$wiki_get,'host_split','','task',$match_task['task_id'],$profit);
							break;
					}
					if ($res) {
						$this->change_status ( $this->_report_id, '4', $op_result, $op_result ['process_result'] ); 
						$w_event = $objProm->get_prom_event ( $this->_obj_info ['origin_id'], $w_info ['uid'], "bid_task" );
						$objProm->set_prom_event_status ( $w_event ['parent_uid'], $this->_gusername, $w_event ['event_id'], '3' );
						$g_event = $objProm->get_prom_event ( $this->_obj_info ['origin_id'], $g_info ['uid'], "pub_task" );
						$objProm->set_prom_event_status ( $g_event ['parent_uid'], $this->_gusername, $g_event ['event_id'], '3' );
						$url = "<a href=\"{$_K['siteurl']}/index.php?do=task&id={$match_task['task_id']}\">{$this->_obj_info['origin_title']}</a>";
						$msg_obj = new keke_msg_class();
						$g_notify = array ($_lang['description'] => $_lang['match_task_trans_result'].$g_noti,$_lang['task_title']=>$url);
						$msg_obj->send_message($g_info['uid'],$g_info['username'],'match_task',$_lang['match_website_deal_notice'],$g_notify,$g_info['email']);
						$w_notify = array ($_lang['description'] => $_lang['match_task_trans_result'].$w_noti,$_lang['task_title']=>$url);
						$msg_obj->send_message($w_info['uid'],$w_info['username'],'match_task',$_lang['match_website_deal_notice'],$w_notify,$w_info['email']);
						db_factory::execute(sprintf(" update %switkey_task set task_status=9 where task_id='%d'",TB_PRE,$match_task['task_id']));
					}
					$res and kekezu::admin_show_msg ( $trans_name . $_lang ['deal_success'], "index.php?do=trans&view=rights&type=$type", "3","","success") or kekezu::admin_show_msg ( $trans_name . $_lang ['deal_fail'], "index.php?do=trans&view=process&type=$type&report_id=" . $this->_report_id,"3","","warning");
				} else {
					kekezu::admin_show_msg ( $trans_name . $_lang ['deal_fail_now_forbit_deal_cash'], "index.php?do=trans&view=process&type=$type&report_id=" . $this->_report_id, "3","","warning" );
				}
				break;
			case "nopass" :
				break;
		}
	}
}
<?php
keke_lang_class::load_lang_class ( 'match_task_class' );
class match_task_class extends keke_task_class {
	public $_task_status_arr;
	public $_work_status_arr;
	public $_cash_cove;
	public $_task_url;
	public $_notice_url;
	public $_host_amount;
	protected $_inited = false;
	public static function get_instance($task_info) {
		static $obj = null;
		if ($obj == null) {
			$obj = new match_task_class ( $task_info );
		}
		return $obj;
	}
	public function __construct($task_info) {
		global $_K;
		parent::__construct ( $task_info );
		$siteurl = preg_replace ( "/localhost/i", "127.0.0.1", $_K ['siteurl'], 1 );
		$this->_task_url = $siteurl . '/index.php?do=task&id=' . $this->_task_id;
		$this->_notice_url = "<a href=\"{$this->_task_url}\">{$this->_task_title}</a>";
		$this->init ();
	}
	public function init() {
		if (! $this->_inited) {
			$this->get_match_init ();
			$this->status_init ();
			$this->wiki_priv_init ();
			$this->get_task_coverage ();
			$this->mark_init ();
		}
		$this->_inited = true;
	}
	public function mark_init() {
		$m = $this->get_mark_count_ext ();
		$t = $this->_task_info;
		$t ['mark'] ['all'] = intval ( $m [1] ['c'] + $m [2] ['c'] );
		$t ['mark'] ['master'] = intval ( $m [2] ['c'] );
		$t ['mark'] ['wiki'] = intval ( $m [1] ['c'] );
		$this->_task_info = $t;
	}
	private function get_match_init() {
		$task_id = $this->_task_id;
		$sql = 'select * from ' . TB_PRE . 'witkey_task_match where task_id=' . $task_id;
		$match_info = db_factory::get_one ( sprintf ( " select * from %switkey_task_match where task_id='%d'", TB_PRE, $this->_task_id ) );
		if ($match_info) {
			$this->_task_info = array_merge ( $match_info, $this->_task_info );
			$match_work = db_factory::get_one(sprintf("select * from %switkey_task_work where task_id='%d' and work_status=4",TB_PRE,$this->_task_id));
			if($match_work){
				$work_detail = db_factory::get_one(sprintf("select * from %switkey_task_match_work where work_id='%d'",TB_PRE,$match_work['work_id']));
				$this->_host_amount = $work_detail['quote'];
			}
		} else {
			die ( 'match_info_not_exists' );
		}
	}
	public function get_task_coverage() {
		$covers = kekezu::get_cash_cove ( 'match' );
		$cover_info = $covers [$this->_task_info ['task_cash_coverage']];
		$this->_cash_cove = $cover_info ['cove_desc'];
	}
	public function status_init() {
		$this->_task_status_arr = $this->get_task_status ();
		$this->_work_status_arr = $this->get_work_status ();
	}
	public function wiki_priv_init() {
		$arr = match_priv_class::get_priv ( $this->_task_id, $this->_model_id, $this->_userinfo );
		$this->_priv = $this->user_priv_format ( $arr );
	}
	public function get_task_timedesc() {
		global $_lang;
		$task_status = $this->_task_status;
		$task_info = $this->_task_info;
		$time_desc = array ();
		switch ($task_status) {
			case "0":
				$time_desc ['ext_desc'] = $_lang['task_nopay_can_not_look'];
				break;
			case '2' :
				$time_desc ['time_desc'] = $_lang ['away_from_the_high_bids_deadline'];
				$time_desc ['time'] = $task_info ['sub_time'];
				$time_desc ['ext_desc'] = '已冻结诚意金，正在接受抢标';
				break;
			case '3' :
				$time_desc ['time_desc'] = $_lang ['away_from_the_consult_deadline'];
				$time_desc ['time'] = $task_info ['end_time'];
				$time_desc ['ext_desc'] = $_lang['bid_and_both_consult'];
				break;
			case '4' :
				$time_desc ['time_desc'] = $_lang ['away_from_the_start_deadline'];
				$time_desc ['time'] = $task_info ['end_time'];
				$time_desc ['ext_desc'] = $_lang['start_confirming'];
				break;
			case '5' :
				$time_desc ['time_desc'] = $_lang ['away_from_the_work_over_deadline'];
				$time_desc ['time'] = $task_info ['end_time'];
				$time_desc ['ext_desc'] = $_lang['bid_witkey_work'];
				break;
			case '6' :
				$time_desc ['time_desc'] = $_lang ['away_from_the_task_accept_deadline'];
				$time_desc ['time'] = $task_info ['end_time'];
				$time_desc ['ext_desc'] = $_lang['work_over_employer_accepting'];
				break;
			case "7" :
				$time_desc ['ext_desc'] = $_lang['task_frozen_can_not_operate'];
				break;
			case "8" :
				$time_desc ['ext_desc'] = $_lang['task_over_congra_witkey'];
				break;
			case "9" :
				$time_desc ['ext_desc'] = $_lang['pity_task_fail'];
				break;
			case "11" :
				$time_desc ['ext_desc'] = $_lang['wait_for_task_arbitrate'];
		}
		return $time_desc;
	}
	public function getProjectProgressDesc() {
		$arrTaskInfo = $this->_task_info;
		$arrProjectProgress = array(
				'1'=>array(
						'status' 	=> -1,
						'desc'   	=> '发布需求',
						'time'   	=> $arrTaskInfo['start_time'],
				),
				'2'=>array(
						'status'   	=> 2,
						'desc'     	=> '高手抢标',
						'time'     	=> $arrTaskInfo['sub_time'],
						'timedesc' 	=> '距离抢标结束时间剩余',
						'timeing'  	=> $arrTaskInfo['sub_time']
				),
				'3'=>array(
						'status'	=> 3,
						'desc'  	=> '协商中',
						'time'  	=> $arrTaskInfo['end_time'],
						'timedesc' 	=> '距离双方协商结束时间剩余',
						'timeing'  	=> $arrTaskInfo['end_time']
				),
				'4'=>array(
						'status'	=> 5,
						'desc'  	=> '工作中',
						'time'  	=> $arrTaskInfo['end_time'],
						'timedesc' 	=> '距离工作结束时间剩余',
						'timeing'  	=> $arrTaskInfo['end_time']
				),
				'5'=>array(
						'status'	=> 6,
						'desc'  	=> '验收中',
						'time'  	=> $arrTaskInfo['end_time'],
						'timedesc' 	=> '距离验收结束时间剩余',
						'timeing'  	=> $arrTaskInfo['end_time']
				),
				'6'=>array(
						'status'	=> 8,
						'desc'  	=> '评价'
				),
		);
		return $arrProjectProgress;
	}
	public function getWorkInfo($w = array(), $p = array()) {
		global $kekezu, $_K, $uid;
		$work_arr = array ();
		$sql = " select a.*,b.seller_credit,b.seller_good_num,b.seller_total_num,b.seller_level,c.quote,c.quote_desc,c.cycle from " . TB_PRE . "witkey_task_work  a left join yw_company b on a.uid=b.userid
				left join ". TB_PRE ."witkey_task_match_work c on a.work_id=c.work_id";
		$count_sql = " select count(a.work_id) from " . TB_PRE . "witkey_task_work a left join yw_company b on a.uid=b.userid";
		$where = " where a.task_id = '$this->_task_id' ";
	if (! empty ( $w )) {
			$intWorkStatus =  intval ( $w ['work_status'] );
				switch($intWorkStatus){
					case'2':
						$where .= " and a.is_view !=1 ";
						break;
					case'4':
					case'7':
					case'9':
						$where .= " and a.work_status = '" . $intWorkStatus . "'";
						break;
					case'11':
						$where .= " and a.uid = '$this->_uid'";
						break;
				}
		}
		$where .= " order by a.work_status asc,work_time desc";
		if (! empty ( $p )) {
			$page_obj = $kekezu->_page_obj;
			$page_obj->setAjax ( 1 );
			$page_obj->setAjaxDom ( "gj_summery" );
			$count = intval ( db_factory::get_count ( $count_sql . $where ) );
			$pages = $page_obj->getPages ( $count, $p ['page_size'], $p ['page'], $p ['url'], $p ['anchor'] );
			$pages ['count'] = $count;
			$where .= $pages ['where'];
		}
		$work_info = db_factory::query ( $sql . $where );
		$work_info = kekezu::get_arr_by_key ( $work_info, 'work_id' );
		$arrWorks ['work_info'] = array();
		if(is_array($work_info)){
			foreach($work_info as $k=>$v){
				$arrWorks ['work_info'][$k] = $v;
				$arrWorks ['work_info'][$k]['comment'] = $this->get_comment ( 'work', $this->_task_id, $v['work_id'], $v['uid'] );
			}
		}
		$arrWorks ['pages'] = $pages;
		$strWorkIds = implode ( ',', array_keys ( $work_info ) );
		$arrWorks ['mark'] = $this->has_mark ( $strWorkIds );
		$arrWorks ['count'] = $count;
		$strWorkIds && $uid == $this->_task_info ['uid'] and db_factory::execute ( 'update ' . TB_PRE . 'witkey_task_work set is_view=1 where work_id in (' . $strWorkIds . ') and is_view=0' );
		return $arrWorks;
	}
	public function process_can() {
		$wiki_priv = $this->_priv;
		$process_arr = array ();
		$status = intval ( $this->_task_status );
		$task_info = $this->_task_info;
		$config = $this->_task_config;
		$g_uid = $this->_guid;
		$uid = $this->_uid;
		switch ($status) {
			case '2' : 
				if ($uid == $g_uid) {
					$process_arr ['tools'] = true;
					$process_arr ['reqedit'] = true;
					$process_arr ['work_comment'] = true;
				} else {
					$process_arr ['work_hand'] = true;
					$process_arr ['task_comment'] = true;
					$process_arr ['task_report'] = true;
				}
				$process_arr ['work_report'] = true;
				break;
			case '3' :
				if ($uid == $g_uid) {
					$process_arr ['work_comment'] = true;
					$process_arr ['work_cancel'] = true;
					$process_arr ['task_host'] = true;
				} else {
					$process_arr ['task_comment'] = true;
					$process_arr ['task_report'] = true;
					$process_arr ['work_give_up'] = true;
					$process_arr ['notify_host'] = true;
					$process_arr ['modify_quote'] = true;
				}
				$process_arr ['work_report'] = true;
				break;
			case '4' :
				if ($uid == $g_uid) {
					$process_arr ['work_comment'] = true;
					$process_arr ['work_trans'] = true;
					$process_arr ['notify_confirm'] = true;
				} else {
					$process_arr ['task_comment'] = true;
					$process_arr ['task_rights'] = true;
					$process_arr ['work_start'] = true;
				}
				break;
			case '5' :
				if ($uid == $g_uid) {
					$process_arr ['work_comment'] = true;
					$process_arr ['task_rights'] = true;
					$process_arr ['notify_over'] = true;
				} else {
					$process_arr ['task_comment'] = true;
					$process_arr ['task_rights'] = true;
					$process_arr ['work_over'] = true;
				}
				break;
			case '6' :
				if ($uid == $g_uid) {
					$process_arr ['work_comment'] = true;
					$process_arr ['task_rights'] = true;
					$process_arr ['task_accept'] = true;
					$process_arr ['notify_modify'] = true;
				} else {
					$process_arr ['task_comment'] = true;
					$process_arr ['task_rights'] = true;
					$process_arr ['work_modify'] = true;
					$process_arr ['notify_accept'] = true;
				}
				break;
			case "7" :
				if ($uid == $g_uid) {
					$process_arr ['work_comment'] = true;
				} else {
					$process_arr ['task_comment'] = true;
				}
				break;
			case '8' :
				if ($uid == $g_uid) {
					$process_arr ['work_comment'] = true;
					$process_arr ['work_mark'] = true;
				} else {
					$process_arr ['task_comment'] = true;
					$process_arr ['task_mark'] = true;
				}
				break;
		}
		$uid != $g_uid and $process_arr ['task_complaint'] = true;
		$process_arr ['work_complaint'] = true;
		if ($user_info ['groupid']) {
			switch ($status) {
				case 1 :
					$process_arr ['task_audit'] = true;
					break;
				case 2 :
					$task_info['is_top'] or $process_arr ['task_recommend'] = true;
					$process_arr ['task_freeze'] = true;
					break;
				default :
					if ($status > 1 && $status < 8) {
						$process_arr ['task_freeze'] = true;
					}
			}
		}
		$this->_process_can = $process_arr;
		return $process_arr;
	}
	public function work_hand($work_desc, $file_ids, $hidework = '2', $url = '', $output = 'normal') {
	}
	public function work_bid($contact,$quote,$tar_content,$cycle,$work_hidden='0') {
	global $_lang;
        $strText = $this->check_if_can_hand ( $url, $output );
		if ($strText === true) {
			$work_obj = new Keke_witkey_task_work_class ();
			$work_obj->setTask_id ( $this->_task_id );
			$work_obj->setUid ( $this->_uid );
			$work_obj->setUsername ( $this->_username );
			$work_obj->setWork_status ( 4 );
			$work_obj->setWork_title ( $this->_task_title );
			$work_obj->setWork_hidden ( $work_hidden );
			$work_obj->setWork_time ( time () );
			if($this->_task_info['workhide']==1){
				$work_obj->setWorkhide ( 1 );
			}
			$work_id = $work_obj->create_keke_witkey_task_work ();
			$consume = kekezu::get_cash_consume ( $this->_task_config ['deposit'] );
			if ($work_id && $this->host_deposit_cash ( $work_id )) {
				$this->set_task_status ( 3 );
				$this->plus_work_num ();
				$this->plus_take_num ();
				$match_obj = new Keke_witkey_task_match_work_class ();
				$match_obj->_mw_id = null;
				$match_obj->setWork_id ( $work_id );
				$match_obj->setWiki_deposit ( $this->_task_config ['deposit'] );
				$match_obj->setDeposit_cash ( $this->_task_config ['deposit'] );
				$match_obj->setWitkey_contact ( $contact  );
				$match_obj->setQuote($quote);
				CHARSET == 'gbk' and $tar_content = kekezu::utftogbk($tar_content);
				$match_obj->setQuote_desc(kekezu::escape($tar_content));
				$match_obj->setCycle(intval($cycle));
				$mw_id = $match_obj->create_keke_witkey_task_match_work ();
				db_factory::execute(sprintf("update %switkey_task set end_time = %d where task_id = %d",TB_PRE,time()+3600*$this->_task_config['tuoguan_hour'],$this->_task_id));
				$g_notice = array ($_lang ['description'] => $_lang ['hav_new_bid_work'], $_lang ['task_title'] => $this->_notice_url );
				$this->notify_user ( 'match_task', $_lang ['work_hand_notice'], $g_notice );
				return true;
			} else {
				$work_obj->setWhere ( " work_id = {$work_id}" );
				$work_obj->del_keke_witkey_task_work ();
				return $_lang ['hand_work_fail_and_operate_agian'];
			}
		} else {
			 return $strText;
		}
	}
	public function work_edit($work_id,$quote,$tar_content,$cycle, $url = '', $output = 'normal'){
		$strNotice = $this->check_if_can_edit ($work_id, $url, $output );
		if ($strNotice === true) {
					$match_obj = new Keke_witkey_task_match_work_class ();
					$match_obj->setWhere("work_id=".$work_id);
					$match_obj->setQuote($quote);
					CHARSET == 'gbk' and $tar_content = kekezu::utftogbk($tar_content);
					$match_obj->setQuote_desc(kekezu::escape($tar_content));
					$match_obj->setCycle(intval($cycle));
					$match_obj->edit_keke_witkey_task_match_work ();
					$g_notice = array ($_lang ['description'] => '修改了报价信息', $_lang ['task_title'] => $this->_notice_url );
					$this->notify_user ( 'match_task', $_lang ['work_hand_notice'], $g_notice );
					return true;
			} else {
				return $strNotice;
			}
	}
	public function check_if_can_edit($work_id,$url = '', $output = 'normal'){
		global $uid;
		if ($this->_task_status == 3) {
		   $work_info = $this->get_work($work_id);
		   if($uid==$work_info['uid']){
		   	return true;
		   }else{
		   	return '无权限进行此操作';
		   }
		}else{
			return '此阶段无法进行此操作';
		}
	}
	public function check_user_can_hand() {
		global $_lang;
		$pass = true;
		if ($this->_task_status == 2) {
				$handed = $this->work_exists ();
				if ($handed) {
					$pass = false;
					$notice = $_lang ['task_had_handed_can_not_bid'];
				} else {
					$m_handed = $this->work_exists ( '', "uid='{$this->_uid}'", - 1 );
					if ($m_handed) {
						$pass = false;
						$notice = $_lang ['you_had_given_up_and_can_not_bid'];
					}
				}
		} else {
			$pass = false;
			$notice = $_lang ['passed_the_bid_stage'];
		}
		if($pass == false){
           return $notice;
		}else{
			return true;
		}
	}
	public function work_choose($work_id, $to_status, $url = '', $output = 'normal', $trust_response = false) {
	}
	public function task_host($host_cash) {
		global $_K, $_lang;
		if ($this->_task_status == 3 && $this->_guid == $this->_uid) {
			$data = array (':model_name' => $this->_model_name, ':task_id' => $this->_task_id, ':task_title' => $this->_task_title );
			keke_finance_class::init_mem ( 'hosted_reward', $data );
			if($host_cash>0){
				$res = keke_finance_class::cash_out ( $this->_guid, $host_cash, "hosted_reward", 0, 'task', $this->_task_id );
				if($res == false){
					return '账户余额不足';
				}
			}
				$match_obj = new Keke_witkey_task_match_class ();
				$match_obj->setWhere ( " task_id='{$this->_task_id}'" );
				$match_obj->setHost_amount ( $host_cash );
				$match_obj->setHost_cash ( $host_cash );
				$res = $match_obj->edit_keke_witkey_task_match ();
				if ($res) {
					$this->set_task_status ( 5 );
					$work_info = $this->work_exists ();
					$work_detail_info = $this->get_match_work($work_info['work_id']);
					db_factory::execute(sprintf("update %switkey_task set end_time = %d where task_id=%d",TB_PRE,time()+$work_detail_info['cycle']*3600*24,$this->_task_id));
					$w_notice = array ($_lang ['description'] => $_lang ['reward_had_been_hosted'], $_lang ['task_title'] => $this->_notice_url );
					$this->notify_user ( 'match_task', $_lang ['reward_host_notice'], $w_notice, 1, $work_info ['uid'] );
					return true;
				}
			}
		return $_lang ['system_is_busy_host_failed'];
	}
	public function host_deposit_cash($work_id) {
		global $_lang;
		if($this->_task_config ['deposit']){
			$data = array (':model_name' => $this->_model_name, ':task_id' => $this->_task_id, ':task_title' => $this->_task_title );
			keke_finance_class::init_mem ( 'host_deposit', $data );
			$res = keke_finance_class::cash_out ( $this->_uid, $this->_task_config ['deposit'], "host_deposit", 0, 'task', $this->_task_id );
			if($res == false){
				$notice = '抢标失败,您的账户余额不足！点击这里<a href="index.php?do=pay&type=task&id='.intval($this->_task_id)."&cash=".$this->_task_config ['deposit'].'">去充值</a>';
			}else{
				$notice = true;
			}
		}else{
			$notice = true;
		}
		return $notice;
	}
	public function work_start($url = '', $output = 'normal') {
		global $_lang;
		$work_info = $this->work_exists ();
		if ($this->_task_status == 4 && $work_info ['uid'] == $this->_uid) {
			$this->set_task_status ( 5 );
			$g_notice = array ($_lang ['description'] => $_lang ['wiki_confirmed_to_start_work'], $_lang ['task_title'] => $this->_notice_url );
			$this->notify_user ( 'match_task', $_lang ['wiki_start_notice'], $g_notice );
			kekezu::keke_show_msg ( $url, $_lang ['confirm_success'], '', $output );
		}
		kekezu::keke_show_msg ( $url, $_lang ['system_is_busy_confirm_failed'], 'error', $output );
	}
	public function work_give_up() {
		global $_K, $_lang;
		$work_info = $this->work_exists ( '', " uid ='{$this->_uid}'" );
		$config = $this->_task_config;
		if ($this->_task_status == 3 && $work_info) {
			$work_id = $work_info ['work_id'];
			$match_info = $this->get_match_work ( $work_id );
			$this->set_work_status ( $work_id, 9 );
			if(intval($match_info ['wiki_deposit'])){
				$rate = floatval($config['deposit_rate']);
				$profit = $match_info ['wiki_deposit'] * $rate / 100;
						if($match_info['deposit_cash']>=$rate){
							$return_cash = floatval($match_info['deposit_cash']-$rate);
						}else{
							$return_cash = 0;
						}
				$res = keke_finance_class::cash_in ( $work_info ['uid'], $return_cash, 'deposit_return', '', 'task', $this->_task_id, $profit );
				if ($res == false) {
					kekezu::show_msg ( $_lang ['financial_system_is_busy_try_later'],"index.php?do=task&id=".$this->_task_id."&view=work",1,'','fail' );
					$res = $this->set_work_status ( $work_id, 4 );
				}
			}
			$this->set_task_status ( 2 );
			$g_notice = array ($_lang ['description'] => $_lang ['task_will_be_restart'], $_lang ['task_title'] => $this->_notice_url );
			$this->notify_user ( 'match_task', $_lang ['wiki_give_up_notice'], $g_notice );
			kekezu::show_msg($_lang ['give_up_success'],"index.php?do=task&id=".$this->_task_id."&view=work",1,'',"ok");
		}
		kekezu::show_msg($_lang ['system_is_busy_give_up_failed'],"index.php?do=task&id=".$this->_task_id."&view=work",1,'',"fail");
	}
	public function work_exists($work_id = '', $wh = ' 1 = 1', $work_status = 4) {
		$sql = " select * from " . TB_PRE . "witkey_task_work where task_id = '{$this->_task_id}' ";
		$work_id && $sql .= " and work_id ='{$work_id}' ";
		$wh && $sql .= " and {$wh} ";
		intval ( $work_status ) > - 1 and $sql .= " and work_status='{$work_status}'";
		return db_factory::get_one ( $sql );
	}
	public function get_match_work($work_id) {
		return db_factory::get_one ( sprintf ( " select * from %switkey_task_match_work where work_id='%d'", TB_PRE, $work_id ) );
	}
	public function get_work($work_id) {
		return db_factory::get_one ( sprintf ( " select * from %switkey_task_work where work_id='%d'", TB_PRE, $work_id ) );
	}
	public function work_cancel() {
		global $_K, $_lang;
		$work_info = $this->work_exists ();
		if ($this->_task_status == 3 && $work_info && $this->_uid == $this->_guid) {
			$work_id = $work_info ['work_id'];
			$this->set_work_status ( $work_id, 7 );
			$match_info = $this->get_match_work ( $work_id );
			if(intval($match_info['wiki_deposit'])){
				$res = keke_finance_class::cash_in ( $work_info ['uid'], $match_info ['deposit_cash'], 'deposit_return', '', 'task', $this->_task_id );
				if ($res == false) {
					kekezu::show_msg ($_lang ['financial_system_is_busy_try_later'], "index.php?do=task&id=".$this->_task_id."&view=work", 1,'', 'fail' );
					$this->set_work_status ( $work_id, 4 );
				}
			}
			$this->set_task_status ( 2 );
			$w_notice = array ($_lang ['description'] => $_lang ['work_canceled_and_deposit_cash_will_be_return'], $_lang ['task_title'] => $this->_notice_url );
			$this->notify_user ( 'match_task', $_lang ['work_cancel_notice'], $w_notice, 1, $work_info ['uid'] );
			kekezu::show_msg($_lang ['cancel_work_success'],"index.php?do=task&id=".$this->_task_id."&view=work",1,'',"ok");
		}
		kekezu::show_msg($_lang ['system_is_busy_calcel_failed'],"index.php?do=task&id=".$this->_task_id."&view=work",1,'',"fail");
	}
	public function work_over($work_desc, $file_id, $modify = 0) {
		global $_K, $_lang;
		$work_info = $this->work_exists ( '', " uid = '{$this->_uid}'" );
		if (in_array ( $this->_task_status, array (5, 6 ) ) && $work_info) {
			$work_obj = new Keke_witkey_task_work_class ();
			if (CHARSET == 'gbk') {
				$work_desc = kekezu::utftogbk ( $work_desc );
			}
			$work_obj->setWhere ( " work_id = '{$work_info['work_id']}'" );
			$work_obj->setWork_desc ( $work_desc );
			$work_obj->setWork_file ( $file_id );
			$res = $work_obj->edit_keke_witkey_task_work ();
			if ($res) {
				if ($modify) {
					$noti = $_lang ['work_modify_success'];
				} else {
					$this->set_task_status ( 6 );
					db_factory::execute(sprintf("update %switkey_task set end_time = %d where task_id=%d",TB_PRE,time()+$this->_task_config['confirm_hour']*3600,$this->_task_id));
					$noti = $_lang ['work_over_success'];
				}
				$g_notice = array ($_lang ['description'] => $_lang ['wiki'] . $noti . $_lang ['please_accept_quickly'], $_lang ['task_title'] => $this->_notice_url );
				$this->notify_user ( 'match_task', $this->_model_name . $noti, $g_notice );
				return true;
			}else{
				return $_lang ['system_is_busy'] . $noti . $_lang ['failed'];
			}
		}else{
			return $_lang ['system_is_busy'] . $noti . $_lang ['failed'];
		}
	}
	public function task_accept() {
		global $_lang;
		if ($this->_task_status == 6 && $this->_guid == $this->_uid) {
			$task_info = $this->_task_info;
			$res = $this->dispose_task ();
			if($res){
				kekezu::show_msg($_lang ['task_completed'],"index.php?do=task&id=".$this->_task_id."&view=work",1,'',"ok");
			}else{
				kekezu::show_msg('系统繁忙,任务验收失败,请稍后再试.',"index.php?do=task&id=".$this->_task_id."&view=work",1,'',"fail");
			}
		} else {
			kekezu::show_msg($_lang ['can_not_acceptance_work'],"index.php?do=task&id=".$this->_task_id."&view=work",1,'',"fail");
		}
	}
	public function send_notice($type, $url = '', $output = 'normal') {
		global $_lang, $username;
		$work_info = $this->work_exists ();
		$user_type = 1;
		switch ($type) {
			case "host" :
				$notice = $_lang ['notice_host_reward'];
				$user_type = 2;
				break;
			case "start" :
				$notice = $_lang ['notice_start_work'];
				$to_uid = $work_info ['uid'];
				break;
			case "over" :
				$notice = $_lang ['notice_confirm_work'];
				$to_uid = $work_info ['uid'];
				break;
			case "modify" :
				$notice = $_lang ['notice_modify_work'];
				$to_uid = $work_info ['uid'];
				break;
			case "accept" :
				$notice = $_lang ['notice_acceptance_work'];
				$user_type = 2;
				break;
		}
		$notify = array ($_lang ['description'] => "【{$username}】" . $notice, $_lang ['task_title'] => $this->_notice_url );
		$this->notify_user ( 'match_task', $_lang ['match_task_notice'], $notify, $user_type, $to_uid );
		kekezu::show_msg ( '发送成功', 'index.php?do=task&id='.$this->_task_id, 3, NULL, 'ok' );
	}
	public function dispose_task() {
		global $_lang;
		$pass = true;
		if ($this->set_task_status ( 8 )) {
			$task_info = $this->_task_info;
			$host_cash = $task_info ['host_amount'];
			$rate = $task_info ['profit_rate'];
			$profit = floatval ( $host_cash * $rate / 100 );
			$get_cash = floatval ( $host_cash - $profit );
			keke_finance_class::cash_in ( $this->_guid, $task_info ['deposit_cash'],  'deposit_return', '', 'task', $this->_task_id );
			$work_info = $this->work_exists ();
			$match_info = $this->get_match_work ( $work_info ['work_id'] );
			$data = array (':model_name' => $this->_model_name, ':task_id' => $this->_task_id, ':task_title' => $this->_task_title );
			keke_finance_class::init_mem ( 'task_bid', $data );
			keke_finance_class::cash_in ( $work_info ['uid'], $get_cash,  'task_bid', '', 'task', $this->_task_id, $profit );
			keke_finance_class::cash_in ( $work_info ['uid'], $match_info ['deposit_cash'],  'deposit_return', '', 'task', $this->_task_id );
			$this->plus_accepted_num ( $work_info ['uid'] );
			keke_user_mark_class::create_mark_log ( $this->_model_code, 1, $work_info ['uid'], $this->_guid, $work_info ['work_id'], $host_cash, $this->_task_id, $work_info ['username'], $this->_gusername );
			keke_user_mark_class::create_mark_log ( $this->_model_code, 2, $this->_guid, $work_info ['uid'], $work_info ['work_id'], $get_cash, $this->_task_id, $this->_gusername, $work_info ['username'] );
			$this->plus_mark_num ();
			$w_notice = array ($_lang ['description'] => $_lang ['hirer_has_acceptance_your_work'], $_lang ['task_title'] => $this->_notice_url ); 
			$this->notify_user ( 'match_task', $_lang ['task_acceptance_ok'], $w_notice, 1, $work_info ['uid'] );
//			$feed_arr = array ("feed_username" => array ("content" => $work_info ['username'], "url" => "index.php?do=seller&id={$work_info['uid']}" ), "action" => array ("content" => $_lang ['match_task_over'], "url" => "" ), "event" => array ("content" => $this->_task_title, "url" => $this->_task_url, 'cash' => number_format($get_cash,'2') ) );
//			kekezu::save_feed ( $feed_arr, $work_info ['uid'], $work_info ['username'], 'work_accept', $this->_task_id );
		} else {
			$pass = false;
		}
		return $pass;
	}
	public function task_tb_timeout() {
		global $_K, $kekezu, $_lang;
		$task_info = $this->_task_info;
		$config = $this->_task_config;
		if ($this->_task_status == 2 && time () > $task_info ['sub_time']) {
			$this->set_task_status ( 9 );
			$rate = $config ['deposit_rate'];
			$profit =  $rate ;
			$return_cash = floatval($task_info['deposit_cash']-$rate);
			keke_finance_class::cash_in ( $this->_guid, $return_cash, 'deposit_return', '', 'task', $this->_task_id, $profit );
			$g_notify = array ($_lang ['description'] => $_lang ['task_has_failed_and_deposit_cash_will_be_return'], $_lang ['task_title'] => $this->_notice_url );
			$this->notify_user ( 'match_task', $_lang ['work_hand_expired_notice'], $g_notify );
		}
	}
	public function task_host_timeout() {
		global $_lang;
		$task_info = $this->_task_info;
		if ($this->_task_status == 3 && time () > $task_info ['end_time']) {
			db_factory::execute ( sprintf ( " update %sfinance_record set site_profit='%.2f' where obj_id='%d' and amount<0 and reason='pub_task'", TB_PRE, $task_info ['hirer_deposit'], $this->_task_id ) );
			$g_notify = array ($_lang ['description'] => $_lang ['host_reward_expired_and_task_failed'], $_lang ['task_title'] => $this->_notice_url );
			$this->notify_user ( 'match_task', $_lang ['host_expired_notice'], $g_notify );
			$work_info = $this->work_exists ();
			$match_info = $this->get_match_work ( $work_info ['work_id'] );
			if(intval($match_info['wiki_deposit'])){
				keke_finance_class::cash_in ( $work_info ['uid'], $match_info ['deposit_cash'],  'deposit_return', '', 'task', $this->_task_id );
			}
			$w_notify = array ($_lang ['description'] => $_lang ['hirer_host_reward_expired_and_task_failed'], $_lang ['task_title'] => $this->_notice_url );
			$this->notify_user ( 'match_task', $_lang ['host_expired_notice'], $w_notify, 2, $work_info ['uid'] );
			$this->set_task_status ( 9 );
		}
	}
	public function task_other_timeout() {
		global $_lang;
		if (in_array ( $this->_task_status, array ( 5, 6 ) ) && time () > $this->_task_info ['end_time']) {
			$this->set_task_status ( 7 );
			$g_notify = array ($_lang ['description'] => $_lang ['task_expired_and_website_intervention'], $_lang ['task_title'] => $this->_notice_url );
			$this->notify_user ( 'match_task', $_lang ['task_frozen_notice'], $g_notify );
			$work_info = $this->work_exists ();
			$w_notify = array ($_lang ['description'] => $_lang ['task_expired_and_website_intervention'], $_lang ['task_title'] => $this->_notice_url );
			$this->notify_user ( 'match_task', $_lang ['task_frozen_notice'], $w_notify, 1, $work_info ['uid'] );
		}
	}
	public static function get_task_status() {
		global $_lang;
		return array ("0" => $_lang ['wait_pay'], "2" => $_lang ['bidding'], "3" => $_lang ['consult'], "4" => $_lang ['confirming'], "5" => $_lang ['working'], "6" => $_lang ['accepting'], "7" => $_lang ['freeze'], "8" => $_lang ['task_over'], "9" => $_lang ['fail'],"11"=>"仲裁中");
	}
	public static function get_work_status() {
		global $_lang;
		return array ('4' => $_lang ['bid'], '8' => $_lang ['task_can_not_choose_bid'], '9' => $_lang ['task_out'], "10" => $_lang ['give_up'] );
	}
	public function set_work_status($work_id, $to_status) {
		return db_factory::execute ( sprintf ( "update %switkey_task_work set work_status='%d' where work_id='%d'", TB_PRE, $to_status, $work_id ) );
	}
	public function dispose_order($order_id) {
		global $kekezu, $_K, $_lang;
		$task_config = $this->_task_config;
		$task_info = $this->_task_info;
		$task_status = $this->_task_status;
		$order_info = db_factory::get_one ( sprintf ( "select order_amount,order_status from %switkey_order where order_id='%d'", TB_PRE, intval ( $order_id ) ) );
		$order_amount = $order_info ['order_amount'];
		if ($order_info ['order_status'] == 'ok') {
			$notice = $_lang ['task_pay_success_and_task_pub_success'];
			return pay_return_fac_class::struct_response ( $_lang ['operate_notice'], $notice, $this->_task_url, 'success' );
		} else {
			$arrOrderDetail = keke_order_class::get_order_detail($order_id);
			foreach($arrOrderDetail as $k=>$v){
				if($v['obj_type']=='task'&&$v['detail_type'] == null){
					$data = array (':model_name' => $this->_model_name, ':task_id' => $this->_task_id, ':task_title' => $this->_task_title );
					keke_finance_class::init_mem ( 'pub_task', $data );
					$res = keke_finance_class::cash_out ( $task_info ['uid'], $v['price'], 'pub_task', 0, 'task', $this->_task_id  );
				}else{
					PayitemClass::createPayitemRecord($v['detail_type'],$v['num'],$v['obj_type'],$v['obj_id']);
				}
			}
			if ($res) {
//				$objProm = keke_prom_class::get_instance ();
//				if ($objProm->is_meet_requirement ( "pub_task", $this->_task_id )) {
//					$objProm->create_prom_event ( "pub_task", $this->_guid, $this->_task_id, $this->_task_info ['task_cash'] );
//				}
				keke_order_class::update_fina_order ( $res, $order_id );
				db_factory::execute ( sprintf ( " update %switkey_task set cash_cost='%s' where task_id='%d'", TB_PRE,$task_info ['real_cash'], $this->_task_id ) );
				db_factory::updatetable ( TB_PRE . "witkey_order", array ("order_status" => "ok" ), array ("order_id" => "$order_id" ) );
				$this->set_task_status ( 2 );
//				$feed_arr = array ("feed_username" => array ("content" => $task_info ['username'], "url" => "index.php?do=seller&id={$task_info['uid']}" ), "action" => array ("content" => $_lang ['pub_task'], "url" => "" ), "event" => array ("content" => "{$task_info['task_title']}", "url" => "index.php?do=task&id={$task_info['task_id']}" ,"cash" => $task_info['task_cash_coverage']?$task_info['task_cash_coverage']:$task_info['task_cash'],"model_id" => "$this->_model_id") );
//				kekezu::save_feed ( $feed_arr, $task_info ['uid'], $task_info ['username'], 'pub_task', $task_info ['task_id'] );
				$status_arr = self::get_task_status(); 
				$url = '<a href="' . $_K ['siteurl'] . '/index.php?do=task&id=' . $task_info['task_id'] . '"  target="_blank">' . $task_info['task_title'] . '</a>';
				$v = array ('model_name'=>$this->_model_name,'task_id' => $task_info['task_id'], $_lang['task_title'] =>$task_info['task_title'] ,$_lang['task_id']=>$task_info['task_id'], $_lang ['task_link'] => $url, $_lang ['task_status'] => $status_arr [2], '开始时间' => date ( 'Y-m-d H:i:s', $task_info['start_time'] ), '投稿结束时间' => date ( 'Y-m-d H:i:s', $task_info['sub_time'] ), '选稿结束时间' => date ( 'Y-m-d H:i:s', $task_info['end_time'] ) );
				$this->notify_user("task_pub", '任务发布通知', $v, $notify_type = 1, $task_info ['uid']);
				db_factory::execute ( sprintf ( " update %switkey_task_match set deposit_cash='%.2f' where task_id='%d'", TB_PRE, $task_info ['real_cash'], $this->_task_id ) );
				return pay_return_fac_class::struct_response ( $_lang ['operate_notice'], $_lang ['task_pay_success_and_task_pub_success'], $this->_task_url, 'success' );
			} else {
				$pay_url = $_K ['siteurl'] . "/index.php?do=pay&order_id=$order_id";
				return pay_return_fac_class::struct_response ( $_lang ['operate_notice'], $_lang ['task_pay_error_and_please_repay'], $pay_url, 'warning' );
			}
		}
	}
	public static function master_opera($m_id, $t_id, $url,$t_cash) {
		global $uid, $_K, $do, $view, $_lang,$user_info;
		$status = db_factory::get_count ( sprintf ( ' select task_status from %switkey_task where task_id=%d and uid=%d', TB_PRE, $t_id, $uid ), 0, 'task_status', 600 );
		$arrTaskInfo = db_factory::get_one ( sprintf ( ' select * from %switkey_task where task_id=%d and uid=%d', TB_PRE, $t_id, $uid ) );
		$order_info = db_factory::get_one(sprintf("select order_id from %switkey_order_detail where obj_id=%d",TB_PRE,$t_id));
		$site = $_K ['siteurl'] . '/';
		$button = array ();
		$button ['view'] = array ('href' => $site . 'index.php?do=task&id=' . $t_id, 'desc' => '查看', 'ico' => 'book' );
		$button ['del'] = array (
				'href' => $site . $url . '&action=delSingle&objId=' . $t_id,
				'desc' => $_lang ['delete'],
				'click' => 'return opSingle(this);',
        );
		switch ($status) {
			case 0 :
				$url='index.php?do=pubtask&id='.$arrTaskInfo['model_id'].'&step=step4&taskId='.$t_id;
				$button ['pay'] = array (
						'href' => $url,
						'desc' => $_lang ['payment'],
				);
				break;
			case 2 :
				 if(TOOL === TRUE){
				$button ['tool'] = array (
						'href'=>"javascript:payitem('task','{$t_id}','{$uid}');void(0);",
						'desc' => '增值工具'
								);
				}
				break;
			case 3 :
				if(TOOL === TRUE){
					$button ['tool'] = array (
							'href'=>"javascript:payitem('task','{$t_id}','{$uid}');void(0);",
							'desc' => '增值工具'
									);
				}
				$button ['host'] = array (
						'href'=> "javascript:taskHost('{$t_id}');void(0);",
						'desc' => '托管赏金'
								);
				break;
			case 6 :
				$button ['confirm_work'] = array (
						'href'=> "javascript:taskAccept('{$t_id}');void(0);",
						'desc' => '验收工作'
								);
				break;
		}
		if (! in_array ( $status, array (0, 8, 9, 10 ) )) {
			unset ( $button ['del'] );
		}
		return $button;
	}
	public static function wiki_opera($m_id, $t_id, $w_id, $url) {
		global $uid, $_K, $do, $view, $_lang;
		$status = db_factory::get_count ( sprintf ( ' select task_status from %switkey_task where task_id=%d', TB_PRE, $t_id, $uid ), 0, 'task_status', 600 );
		$site = $_K ['siteurl'] . '/';
		$button = array ();
		$button['view'] = array(
				'href'=>$site.'index.php?do=task&id='.$t_id.'&view=work&ut=my',
				'desc'=>$_lang['view_work'],
				'ico'=>'book');
		switch ($status) {
			case 2 :
				break;
			case 5 :
				$button ['workover'] = array (
						'href'=>"javascript:workOver(0,'{$t_id}');void(0);",
						'desc' => '工作完成'
								);
               break;
			case 8 :
			case 9 :
				$button['del'] = array(
						'click'=>"confirmOp('确定删除？','$site$url&action=delWork&objId=$w_id',true)",
						'desc'=>$_lang ['delete'].'稿件',
						'href'=>'javascript:void(0);'
				);
				break;
		}
		return $button;
	}
}
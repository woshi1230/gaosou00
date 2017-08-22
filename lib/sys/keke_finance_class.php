<?php
keke_lang_class::load_lang_class('keke_finance_class');
class keke_finance_class {
	public static $_basic_config;
	public static $_cash;
	public static $_type;
	public static $_action;
	public static $_obj_type;
	public static $_obj_id;
	public static $_mem;
	public static function init($uid = null) {
		global $kekezu;
		global $_lang;
		global $user_info;
		$user_info = keke_user_class::get_user_info($uid);
		self::$_basic_config =$kekezu->_sys_config;
		if ($user_info) {
			try{
				return $user_info;
			}catch (Exception $e){
				keke_exception::handler($e);
			}
		}
	}
	public static function cash_out($id, $cash, $action, $profit = 0, $obj_type = null, $obj_id = null) {
		$user_info = db_factory::get_one ("select a.*,b.money from yw_company a left join yw_member b on a.userid=b.userid where a.userid = ".intval($id));
		$res = false;
		$fo = new Keke_finance_record_class ();
		$fo->setReason( $action );
//		$fo->setFina_type ( "out" );
		$fo->setObj_type ( $obj_type );
		$fo->setObj_id ( $obj_id );
		$fo->setSite_profit ( $profit );
		$fo->setUid ( $user_info ['userid'] );
		$fo->setUsername ( $user_info ['username'] );
		if(empty(self::$_mem)){
			$action_arr = keke_glob_class::get_finance_action($action);
			self::$_mem =$action_arr[$action];
		}
		$fo->setNote(self::$_mem);
		$fo->setBank('站内');
		$fo->setEditor('system');
		$user_balance = $user_info ['money'];
		if ($cash && $action) {
			try{
				if ($user_balance < $cash) {
					return false;
				}
				db_factory::execute ( "update yw_member set money = money-" . abs ( floatval ( $cash ) ) . " where userid ='{$user_info['userid']}'" );
				if (strpos(self::$_mem, '退款') !== false) {
					db_factory::execute ( "update yw_company set total_sales = total_sales-" . abs ( floatval ( $cash ) ) . " where userid ='{$user_info['userid']}'" );
				}
				$fo->setAmount( $cash * (-1) );
				$fo->setBalance ( $user_balance - abs ( $cash ) );
				$fo->setAddtime( time () );
				$res = $fo->create_keke_finance_record ();
			}catch (Exception $e){
				keke_exception::handler($e);
			}
		}
		return $res;
	}
	public static function cash_in($uid, $cash, $action, $source = null, $obj_type = null, $obj_id = null, $profit = 0, $charge = null) {
		$res = false;
		$user_info = self::init ($uid);
		$sys_config = self::$_basic_config;
		$fo = new Keke_finance_record_class ();
		$fo->setReason( $action );
//		$fo->setFina_type ( "in" );
		$fo->setObj_type ( $obj_type );
		$fo->setObj_id ( $obj_id );
		$fo->setAmount( $cash );
		if(empty(self::$_mem)){
			$action_arr = keke_glob_class::get_finance_action($action);
			self::$_mem =$action_arr[$action];
		}
		$fo->setNote(self::$_mem);
		$fo->setBalance ( $user_info ['money'] + $cash );
		$fo->setUid ( $user_info ['userid'] );
		$fo->setUsername ( $user_info ['username'] );
//		$fo->setFina_source ( $source );
		$fo->setSite_profit ( $profit );
		$fo->setBank('站内');
		$fo->setEditor('system');
//		$fo->setRecharge_cash ( $charge !== null ? floatval ( $charge ) : null );
		try{
			db_factory::execute( "update yw_member set money = ifnull(money,0)+" . $cash . " where userid ='{$user_info['userid']}'" );
			if (strpos(self::$_mem, '参与任务') !== false) {
				db_factory::execute ( "update yw_company set total_sales = ifnull(total_sales,0)+" . $cash . " where userid ='{$user_info['userid']}'" );
			}
			$fo->setAddtime( time () );
			$res = $fo->create_keke_finance_record ();
		}catch (Exception $e){
			keke_exception::handler($e);
		}
		return $res;
	}
	public static function finance_trust($data = array(), $trust_type = 'alipay_trust', $fina_type = 'in') {
		$fina_obj = keke_table_class::get_instance ( "finance_record" );
//		$data ['is_trust'] = 1;
//		$data ['trust_type']=$data ['fina_source'] = $trust_type;
//		$data ['fina_type']  =$fina_type;
		$fina_id = $fina_obj->save ( $data );
		$sql = "update " . TB_PRE . "finance_record set unique_num = CONCAT('88',LPAD(LAST_INSERT_ID(),8,'0')) where itemid = last_insert_id() ";
		db_factory::execute ( $sql );
		return $fina_id;
	}
	public static function insert_trust($fina_type,$fina_action,$uid,$fina_cash,$user_balance,$obj_id) {
		$objTrust = keke_table_class::get_instance('finance_record');
		$usernames=CommonClass::getuseName($uid);
		$fina_type == 'in' ? $fina_type = 1 : $fina_type = -1;
		$arrFields = array(
//			'fina_type'=>$fina_type,
			'reason'=>$fina_action,
			'uid'=>$uid,
			'amount'=>$fina_cash * $fina_type,
			'balance'=>$user_balance,
			'addtime'=>time(),
			'username'=>$usernames,
			'obj_id'=>$obj_id
		);
		$intResult = $objTrust->save($arrFields);
	}
	public static function get_to_cash($cash){
		$config_info = kekezu::get_table_data("*",TB_PRE . "witkey_pay_config"," k in('per_charge','per_low','per_high')",'','','','k');
		$min_cash = $config_info['per_low']['v'];
		$middle_profit = $config_info['per_charge']['v'];
		$max_cash = $config_info['per_high']['v'];
		$withdraw_min_cash = $config_info['withdraw_min']['v'];
		if($cash<$withdraw_min_cash){
			return 0;
		}
		if ($cash < 200){
			$real_cash = abs($cash - $min_cash);
		} elseif ($cash >200) {
			if ($cash*$middle_profit/100 > $max_cash){
				$real_cash = $cash - $max_cash;
			} else{
				$real_cash = $cash - $cash*$middle_profit/100;
			}
		}
		return $real_cash;
	}
	public static function alipayjs_format_moneys($cash){
		$website_cash = keke_finance_class::get_to_cash($cash);
		$alipay_per_charge = 0.5;
		$alipay_per_low = 1;
		$alipay_per_high = 25;
		if($website_cash<=1){
			return $website_cash;
		}
		if($website_cash<=200){
			$real_website_cash  = $website_cash;
		}elseif($website_cash>200&&$website_cash<=5000){
			$real_website_cash = $website_cash;
		}elseif($website_cash>5000){
			$real_website_cash = $website_cash;
		}
		return $real_website_cash;
	}
	public static function init_mem($action,$data){
		$action_arr = self::get_action_lang();
		$action_str = $action_arr[$action];
		if(!$action_str) return false;
		if(is_array($data)){
			self::$_mem = strtr($action_str,$data);
		}else{
			self::$_mem = $data;
		}
	}
	public static function get_action_lang() {
		global $_lang, $CFG;
		return array (
			'pub_task' => $_lang ['release'] . ':model_name' . $_lang ['task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>',
			'task_delay' => $_lang ['extension_task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>',
			'buy_service' => $_lang ['purchase_service_goods'] . ': <a href="'.$CFG['url'].'index.php?do=goods&id=:service_id">:title</a>',
			'buy_gy' => '雇佣服务 :title',
			'payitem' => $_lang ['purchase'] . ':item_name' . $_lang ['value_add_services'],
			'payitem_refund' => ':payitem_refund_item订单退款',
			'hosted_reward' => $_lang ['managed'] . ':model_name' . $_lang ['task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>' . $_lang ['bounty'],
			'task_fail' => ':model_name' . $_lang ['task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>' . $_lang ['failure_refund'],
			'host_deposit' => $_lang ['managed'] . ':model_name' . $_lang ['task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>' . $_lang ['earnest_money'],
			'task_bid' => $_lang ['involved_task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>，' . $_lang ['manuscript_selected_success'],
			'task_auto_return' => ':model_name' . $_lang ['task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>' . $_lang ['automate_return_remain'],
			'sale_service' => $_lang ['sell_services_goods'] . ': <a href="'.$CFG['url'].'index.php?do=goods&id=:service_id">:title</a>' . $_lang ['income'],
			'sale_gy' => '出售雇佣服务 :title',
			'task_remain_return' => ':model_name' . $_lang ['task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>' . $_lang ['settlement_balance_return'],
			'task_hosted_return' => ':model_name' . $_lang ['task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>' . $_lang ['managed_balance_return'],
			'order_cancel' => $_lang ['order'] . ':order_id' . $_lang ['terminate_rebate'],
			'host_return' => $_lang ['task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>' . $_lang ['managed_commission_refund'],
			'host_split' => $_lang ['task'] . ': <a href="'.$CFG['url'].'index.php?do=task&id=:task_id">:task_title</a>' . $_lang ['managed_commission_allocate'],
			'withdraw' => ':pay_way' . $_lang ['account'] . ':pay_account' . $_lang ['user'] . ':pay_name' . $_lang ['to_cash'],
			'withdraw_fail' => ':pay_way' . $_lang ['account'] . ':pay_account' . $_lang ['user'] . ':pay_name' . $_lang ['cash_failed_return_refund']
		);
	}
	static function get_pay_config($paymentname = "", $pay_type = 'online'){
		$where = " 1=1 ";
		$paymentname and $where  .= " and payment='$paymentname' ";
		$pay_type and  $where .= " and type = '$pay_type' ";
		$list=  kekezu::get_table_data ( '*', TB_PRE . "witkey_pay_api", $where, "pay_id asc", '', '', '', null );
		$tmp = array();
		foreach ($list as $k=>$v){
			if($v['config']){
				$config = unserialize( stripslashes($v['config']) );
				if(is_array($config)){
					$v = array_merge($v,$config);
				}
			}
			$tmp[$v ['payment']] = $v;
		}
		foreach ($tmp as $k=>$v){
			$tmp[$k]['config'] = stripslashes($v['config']);
		}
		return $tmp;
	}
	function get_ten_bank_type(){
		static $bank = array(
			"1001"=>"17",
			"1002"=>"10",
			"1003"=>"2",
			"1004"=>"9",
			"1005"=>"1",
			"1006"=>"4",
			"1008"=>"8",
			"1009"=>"27",
			"1010"=>"18",
			"1020"=>"5",
			"1021"=>"7",
			"1022"=>"3",
			"1024"=>"20",
			"1025"=>"22",
			"1027"=>"6",
			"1032"=>"11",
			"1033"=>"14",
			"1052"=>"19",
			"8001"=>"logo",
		);
		return $bank;
	}
}
?>
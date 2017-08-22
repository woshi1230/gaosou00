<?php
keke_lang_class::load_lang_class ( 'keke_privission_class' );
abstract class keke_privission_class {
	public $_model_id;
	public function __construct($model_id) {
		$this->_model_id = $model_id;
	}
	public static function get_priv_item($model_id) {
		global $kekezu;
		$priv_item = $kekezu->_cache_obj->get ( "priv_rule_item_" . $model_id );
		if (! $priv_item) {
			$sql = " select a.*,b.g_title,b.m_title,c.rule,c.r_id,c.mark_rule_id from " . TB_PRE . "witkey_priv_rule c left join " . TB_PRE . "witkey_priv_item
		a on c.item_id = a.op_id left join " . TB_PRE . "witkey_mark_rule b on c.mark_rule_id = b.mark_rule_id where a.model_id = '$model_id' order by c.mark_rule_id asc";
			$item = db_factory::query ( $sql );
			$priv_item = array ();
			foreach ( $item as $v ) {
				$priv_item [$v ['op_code']] [$v ['mark_rule_id']] = $v;
			}
			$kekezu->_cache_obj->set ( "priv_rule_item_" . $model_id, $priv_item );
		}
		return $priv_item;
	}
	public static function check_condit_priv($uinfo, $priv, $model_name, $notice) {
		global $_lang;
		$uid = $uinfo ['uid'];
		$item_list = []; //email, 邮箱认证; enterprise, 企业认证,;bank, 银行认证,;realname, 实名认证,;mobile, 手机认证,;alipayjs, 支付宝认证,
//		$item_list = keke_auth_base_class::get_auth_item ( '', 'auth_code,auth_open,auth_title' );
		// $priv的值是 op_id = "1"；model_id = "1"；op_code = "pub"；op_name = "发布任务"； allow_times = "0"； limit_obj = "2"； condit = ""； g_title = "一级雇主"； m_title = "一级威客"； rule = "0"； r_id = "1"； mark_rule_id = "1"
		// $priv ['condit']是需要认证项目的列表
		$condition = array_filter ( explode ( ",", $priv ['condit'] ) );
		$priv_return = array (
				"pass" => true,
				"notice" => $notice
		);
		if ($uid) {
			if (empty ( $condition )) { 
				return $priv_return;
			} else { 
				$priv_return ['notice'] .= "。" . $model_name . $_lang ['need_pass'];
				$i=0;
				foreach ( $condition as $k => $v ) {
					if ($item_list [$v] && $item_list [$v] ['auth_open'] == '1') { 
						$pass = keke_auth_fac_class::auth_check ( $v, $uid );
						if (!$pass) {
							if ($v == 'realname' || $v=='enterprise') {
								$i++;
								if($i==2){
									$priv_return ['pass'] = false;
									$priv_return ['notice'] .= "实名或企业认证，";
								}
							} else {
								$priv_return ['pass'] = false;
								$priv_return ['notice'] .= $item_list [$v] ['auth_title'] . "，";
							}
						}
					}
				}
			}
		} else {
			$priv_return ['pass'] = false;
			$priv_return ['notice'] = $_lang ['user_not_login'];
		}
		return $priv_return;
	}
	public static function check_item_priv($task_id, $uid, $priv, $model_name, $notice) {
		global $_lang;
		strpos ( $notice, $model_name ) !== FALSE or $notice .= ";" . $model_name;
		$priv_return = array (
				"pass" => true,
				"notice" => $notice
		);
		if ($uid) {
			switch ($priv ['allow_times']) {
				case "1" : 
					if ($priv ['rule'] > 0) { 
						$times = self::get_operate_num ( $task_id, $uid, $priv ['op_code'], $priv );
						if ($times >= $priv ['rule']) { 
							$priv_return ['pass'] = false; 
							$priv_return ['notice'] .= $_lang ['in_24_hours'] . $priv ['op_name'] . $_lang ['times_no_more_than'] . $priv ['rule'] . $_lang ['times'] . ";";
						}
					} elseif ($priv ['rule'] == - 1) {
						$priv_return ['pass'] = false; 
					}
					break;
				case "0" : 
						$priv_return ['pass'] = true;
					break;
			}
		} else {
			$priv_return ['pass'] = false;
			$priv_return ['notice'] = $_lang ['user_not_login'];
		}
		return $priv_return;
	}
	public static function get_priv($task_id, $model_id, $user_info, $role = '1') {
		global $kekezu;
		global $_lang;
		$model_name = $kekezu->_model_list [$model_id] ['model_name']; 
		$priv_arr = array (); 
		$pass = false; 
		$priv_item = self::get_priv_item ( $model_id );
		if ($role == '1') {
			$credit_name = "seller_credit";
			$leve_name = "seller_level";
			$c_name = $_lang ['witkey'];
		} else {
			$credit_name = "buyer_credit";
			$leve_name = "buyer_level";
			$c_name = $_lang ['employer'];
		}
		$level_info = unserialize ( $user_info [$leve_name] );
		// $level_info = 'a:8:{s:8:"score_id";s:1:"1";s:5:"value";s:1:"0";s:5:"title";s:12:"一级威客";s:5:"level";i:1;s:8:"level_up";i:200;s:10:"level_name";s:6:"等级";s:10:"grade_rate";s:4:"0.00";s:3:"pic";s:148:"<img src="data/uploads/sys/mark/309044f3b07ef87c95.gif" align="absmiddle" title="头衔 ：一级威客&#13;&#10;能力值：0&#13;&#10;等级：1">";}'
		foreach ( $priv_item as $op_code => $v ) {
			// 取得用户等级
			$level = $level_info ['level'];
			// 此等级的认证项目
			$priv = $v [$level]; 
			$notice = $_lang ['you_current_is'] . $level . $_lang ['level'] . $c_name;
			switch ($op_code) { 
				case "pub" : 
					$priv_return = self::check_priv ( $task_id, $user_info, $priv, $model_name, $notice );
					$priv_arr ['pub'] ['pass'] = $priv_return ['pass'];
					$priv_arr ['pub'] ['notice'] = $priv_return ['notice'];
					break;
				case "work_hand" : 
					if ($role == '1') {
						$priv_return = self::check_priv ( $task_id, $user_info, $priv, $model_name, $notice );
						$priv_arr ['work_hand'] ['pass'] = $priv_return ['pass'];
						$priv_arr ['work_hand'] ['notice'] = $priv_return ['notice'];
					} else {
						$priv_arr ['work_hand'] ['pass'] = true;
						$priv_arr ['work_hand'] ['notice'] = $_lang ['employer_is_not'] . $priv ['op_name'] . $_lang ['limit'];
					}
					break;
				case "comment" : 
					if ($role == '1') {
						$priv_return = self::check_priv ( $task_id, $user_info, $priv, $model_name, $notice );
						$priv_arr ['comment'] ['pass'] = $priv_return ['pass'];
						$priv_arr ['comment'] ['notice'] = $priv_return ['notice'];
					} else {
						$priv_arr ['comment'] ['pass'] = true;
						$priv_arr ['comment'] ['notice'] = $_lang ['employer_is_not'] . $priv ['op_name'] . $_lang ['limit'];
					}
					break;
				case "report" : 
					if ($role == '1') {
						$priv_return = self::check_priv ( $task_id, $user_info, $priv, $model_name, $notice );
						$priv_arr ['report'] ['pass'] = $priv_return ['pass'];
						$priv_arr ['report'] ['notice'] = $priv_return ['notice'];
					} else {
						$priv_arr ['report'] ['pass'] = true;
						$priv_arr ['report'] ['notice'] = $_lang ['employer_is_not'] . $priv ['op_name'] . $_lang ['limit'];
					}
					break;
			}
		}
		return $priv_arr;
	}
	public static function check_priv($task_id, $user_info, $priv, $model_name, $notice) {
		global $_lang;
		$pass = true; 
		if ($user_info) {
			switch (intval ( $user_info ['groupid'] )) {
				case "1" : 
					$priv_return ['pass'] = true;
					$priv_return ['notice'] = $_lang ['admin_customer_service_no_limit'];
					break;
				case "0" : 
					$condit_return = self::check_condit_priv ( $user_info, $priv, $model_name, $notice );
					$item_return = self::check_item_priv ( $task_id, $user_info ['userid'], $priv, $model_name, $condit_return ['notice'] );
					$condit_return ['notice'] = $item_return ['notice'];
					$condit_return ['pass'] && $item_return ['pass'] and $priv_return ['pass'] = true or $priv_return ['pass'] = false;
					$priv_return ['notice'] = $item_return ['notice'];
					break;
				default :
					$priv_return ['pass'] = true;
					$priv_return ['notice'] = $_lang ['admin_customer_service_no_limit'];
					break;
			}
		} else {
			$priv_return ['pass'] = false;
			$priv_return ['notice'] = $_lang ['current_user_not_login'];
		}
		return $priv_return;
	}
	public static function get_model_priv_item($model_id, $op_code = null, $fds = null, $pk = null) {
		$condition = " model_id = '$model_id'";
		$op_code and $condition .= " and op_code = '$op_code' ";
		$fds and $field = $fds or $field = "*";
		return kekezu::get_table_data ( $field, TB_PRE . "witkey_priv_item", $condition, ' op_id asc ', '', '', $pk );
	}
	public static function get_operate_num($task_id, $uid, $op_code, $priv) {
		global $kekezu;
		$model_info = $kekezu->_model_list [$priv ['model_id']];
		$model_id = $priv ['model_id'];
		switch ($op_code) {
			case "pub" :
				$pk = 'a.task_id';
				$table = TB_PRE . 'witkey_task';
				$time_fields = 'a.start_time';
				$join_pk = "a.task_id";
				break;
			case "work_hand" :
				if (in_array ( $model_info ['model_code'], array (
						'tender',
						'dtender'
				) )) {
					$table = TB_PRE . 'witkey_task_bid';
					$pk = 'a.bid_id';
					$time_fields = 'a.bid_time';
					$join_pk = "a.task_id";
				} else {
					$table = TB_PRE . 'witkey_task_work';
					$pk = 'a.work_id';
					$time_fields = 'a.work_time';
					$join_pk = "a.task_id";
				}
				break;
			case "comment" :
				$pk = 'a.comment_id';
				$table = TB_PRE . 'comment';
				$time_fields = 'a.on_time';
				$join_pk = "a.origin_id";
				break;
			case "report" :
				$pk = 'a.report_id';
				$table = TB_PRE . 'witkey_report';
				$time_fields = 'a.on_time';
				$join_pk = "a.origin_id";
				break;
		}
		$task_id and $sql = sprintf ( " select count(%s) from %s a left join %switkey_task b on %s=b.task_id where a.uid='%d' and b.model_id='%d' and %s>%d and b.task_id='%d'", $pk, $table, TB_PRE, $join_pk, $uid, $model_id, $time_fields, time () - 24 * 3600, $task_id ) or $sql = sprintf ( " select count(%s) from %s a left join %switkey_task b on %s=b.task_id where a.uid='%d' and b.model_id='%d' and %s>%d", $pk, $table, TB_PRE, $join_pk, $uid, $model_id, $time_fields, time () - 24 * 3600 );
		return db_factory::get_count ( $sql );
	}
}
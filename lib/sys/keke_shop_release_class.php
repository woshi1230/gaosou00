<?php
keke_lang_class::load_lang_class ( 'keke_shop_release_class' );
abstract class keke_shop_release_class {
	public $_uid;
	public $_username;
	public $_user_info; 
	public $_kf_info; 
	public $_priv; 
	public $_model_id; 
	public $_model_info; 
	public $_service_config; 
	public $_inited = false;
	public $_service_obj; 
	public $_std_obj; 
	function __construct($model_id) {
		global $kekezu;
		$this->_service_obj = new Keke_witkey_service_class ();
		$this->_model_id = $model_id;
		$this->_model_info = $kekezu->_model_list [$model_id];
		$this->_std_obj = new stdClass ();
		$this->_std_obj->_release_info = array (); 
		$this->init ();
	}
	function init() {
		if (! $this->_inited) {
			$this->user_info_init ();
			$this->get_rand_kf ();
		}
		$this->_inited = true;
	}
	public function get_rand_kf() {
		$this->_kf_info = kekezu::get_rand_kf ();
	}
	public function get_bind_indus() {
		global $kekezu;
		if ($this->_model_info ['indus_bid']) {
			$bind_indus = implode ( ',', array_filter ( explode ( ',', $this->_model_info ['indus_bid'] ) ) );
			return kekezu::get_table_data ( '*', TB_PRE . "witkey_industry", "indus_id in (select indus_pid from " . TB_PRE . "witkey_industry where indus_id in({$bind_indus}))", 'CASE WHEN listorder = 0 THEN 9999999 WHEN listorder > 0 THEN listorder END', '', '', 'indus_id', null );
		} else {
			return $this->_indus_arr = $kekezu->_indus_p_arr;
		}
	}
	function user_info_init() {
		global $user_info, $uid, $username;
		$this->_user_info = $user_info;
		$this->_uid = $uid;
		$this->_username = $username;
	}
	public function get_service_indus($indus_pid = '', $ajax = '') {
		global $kekezu;
		global $_lang;
		if ($indus_pid > 0) {
			$indus_ids = kekezu::get_table_data ( '*', TB_PRE . "witkey_industry", " indus_pid = $indus_pid", 'CASE WHEN listorder = 0 THEN 9999999 WHEN listorder > 0 THEN listorder END', '', '', 'indus_id', null );
			switch ($ajax == 'show_indus') {
				case "0" :
					return $indus_ids;
					break;
				case "1" :
					$option .= '<option value=""> ' . $_lang ['please_choose_son_industry'] . ' </option>';
					foreach ( $indus_ids as $v ) {
						$option .= '<option value=' . $v [indus_id] . '>' . $v [indus_name] . '</option>';
					}
					CHARSET == 'gbk' and $option = kekezu::gbktoutf ( $option );
					echo $option;
					die ();
					break;
			}
		} else {
			return false;
		}
	}
	public function get_service_bind_indus($indus_pid = '', $ajax = '') {
		global $kekezu;
		global $_lang;
		if ($indus_pid > 0) {
			if ($this->_model_info ['indus_bid']) {
				$indus_ids = kekezu::get_table_data ( '*', TB_PRE . "witkey_industry", "indus_id in ({$this->_model_info['indus_bid']}) and indus_pid = $indus_pid", 'CASE WHEN listorder = 0 THEN 9999999 WHEN listorder > 0 THEN listorder END', '', '', 'indus_id', null );
			} else {
				$indus_ids = kekezu::get_table_data ( '*', TB_PRE . "witkey_industry", " indus_pid = $indus_pid", 'CASE WHEN listorder = 0 THEN 9999999 WHEN listorder > 0 THEN listorder END', '', '', 'indus_id', null );
			}
			switch ($ajax == 'show_indus') {
				case "0" :
					return $indus_ids;
					break;
				case "1" :
					$option .= '<option value=""> ' . '请选择子行业' . ' </option>';
					foreach ( $indus_ids as $v ) {
						$option .= '<option value=' . $v [indus_id] . '>' . $v [indus_name] . '</option>';
					}
					echo $option;
					die ();
					break;
			}
		} else
			return false;
	}
	function save_service_file($service_id, $title) {
		$release_info = $this->_std_obj->_release_info;
		if ($release_info ['file_ids']) {
			$file_obj = new Keke_witkey_file_class ();
			$file_arr = array_filter ( explode ( ',', $release_info ['file_ids'] ) );
			foreach ( $file_arr as $v ) {
				$file_obj->setFile_id ( $v );
				$file_obj->setUid ( $this->_uid );
				$file_obj->setUsername ( $this->_username );
				$file_obj->setObj_id ( $service_id );
				$file_obj->setTask_title ( $title );
				$file_obj->edit_keke_witkey_file ();
			}
		}
	}
	public function notify_user($service_id, $service_status = '2') {
		global $_K;
		global $_lang;
		$service_obj = $this->_service_obj;
		$model_code = $this->_model_info ['model_code'];
		switch ($model_code) {
			case "goods" :
				$status_arr = goods_shop_class::get_goods_status (); 
				break;
			case "service" :
				$status_arr = service_shop_class::get_service_status (); 
				break;
		}
		$message_obj = new keke_msg_class ();
		$url = "<a href=\"" . $_K ['siteurl'] . "/index.php?do=goods&id=" . $service_id . "\">" . $service_obj->getTitle () . "</a>";
		$v = array (
				$_lang ['service_type'] => $this->_model_info ['model_name'],
				$_lang ['goods_link'] => $url,
				$_lang ['goods_status'] => $status_arr [$service_status],
				$_lang ['pub_time'] => date ( 'Y-m-d H:i:s', $service_obj->getOn_time () ) 
		);
		$message_obj->send_message ( $this->_uid, $this->_username, "service_pub", $this->_model_info ['model_name'] . $_lang ['release_tips'], $v, $this->_user_info ['email'], $this->_user_info ['mobile'] );
	}
	public function set_service_status($service_cash) {
		$audit_cash = $this->_service_config ['audit_cash']; 
		if ($audit_cash) { 
			if ($service_cash >= $audit_cash) { 
				$service_status = '2'; 
			} else {
				$service_status = '1'; 
			}
		} else {
			$service_status = '2'; 
		}
		$this->_service_obj->setService_status ( $service_status ); 
	}
	public function public_pubservice() {
		$std_obj = $this->_std_obj; 
		$release_info = $std_obj->_release_info; 
		$service_obj = $this->_service_obj; 
		$txt_service_title = kekezu::str_filter ( $release_info ['txt_title'] ); 
		$service_obj->setTitle ( $txt_service_title );
		$service_obj->setModel_id ( $this->_model_id ); 
		if ($release_info [submit_method] == 'inside') {
			$service_obj->setFile_path ( $release_info [file_path_2] );
		}
		$tar_content = kekezu::str_filter ( $release_info ['tar_content'] );
		$service_obj->setContent ( kekezu::escape ( $tar_content ) );
		$service_obj->setIndus_id ( $release_info [indus_id] );
		$service_obj->setIndus_pid ( $release_info ['indus_pid'] );
		$service_obj->setCity ( $release_info ['city'] );
		$service_obj->setProvince ( $release_info ['province'] );
		$service_obj->setArea ( $release_info ['area'] );
		$shop_id = db_factory::get_count ( sprintf ( " select shop_id from %switkey_shop where uid ='%d'", TB_PRE, $this->_uid ) );
		$service_obj->setShop_id ( $shop_id ); 
		$service_obj->setUid ( $this->_uid );
		$service_obj->setUsername ( $this->_username );
		$service_obj->setPrice ( $release_info ['txt_price'] ); 
		$service_obj->setUnite_price ( $release_info ['unite_price'] ); 
		$service_obj->setService_time ( $release_info ['service_time'] ); 
		$service_obj->setUnit_time ( $release_info ['unit_time'] ); 
		$service_obj->setProfit_rate ( $this->_service_config ['service_profit'] ); 
		$service_obj->setConfirm_max ( $this->_service_config ['confirm_max_day'] ); 
		$release_info ['pic_patch'] and $service_obj->setPic ( $release_info ['pic_patch'] );
		$service_obj->setOn_time ( time () ); 
	}
	public function update_service_info($service_id, $obj_name) {
		global $_K;
		global $_lang, $uid, $username;
		$std_obj = $this->_std_obj;
		$release_info = $std_obj->_release_info; 
		$user_info = $this->_user_info; 
		$service_obj = $this->_service_obj; 
		if ($service_id) {
			$service_status = $service_obj->getService_status (); 
			$service_title = $service_obj->getTitle ();
			$service_cash = $service_obj->getPrice ();
			switch ($service_status) {
				case "2" : 
					$feed_arr = array (
							"feed_username" => array (
									"content" => $this->_username,
									"url" => "index.php?do=seller&id=$this->_uid" 
							),
							"action" => array (
									"content" => $_lang ['has_pub_goods'],
									"url" => "" 
							),
							"event" => array (
									"content" => "$service_title",
									"url" => "index.php?do=goods&id=$service_id",
									"cash" => $service_cash,
									"model_id" => "$this->_model_id" 
							) 
					);
					kekezu::save_feed ( $feed_arr, $this->_uid, $this->_username, 'pub_service', $service_id );
					db_factory::execute ( ' update ' . TB_PRE . 'witkey_shop set on_sale=on_sale+1 where shop_id=' . $service_obj->getShop_id () );
					break;
				case "1" : 
					break;
			}
			CustomClass::createExtData($service_id, $this->_model_id, $release_info);
			if (!empty($release_info ['payitem']) ) {
				$orderId = $this->createPayitemOrder ( $service_id, $release_info ['payitem'] );
				kekezu::show_msg ( '该商品的增值服务需要支付！', "index.php?do=pubgoods&id=" . $service_obj->_model_id . "&serviceId=".$service_id."&step=step4&orderId=" . $orderId, 3, null, 'ok' );
			} else {
				$this->del_service_obj ( $obj_name ); 
				kekezu::show_msg ( '订单付款完成，该订单已确认付款', "index.php?do=pubgoods&id=" . $service_obj->_model_id . "&serviceId=".$service_id."&step=step3", 3, null, 'ok' );
			}
			$this->notify_user ( $service_id, $service_status );
		}
	}
	public abstract function get_service_config();
	public abstract function pub_service();
	public function createPayitemOrder($service_id, $att_info) {
		if (! empty ( $att_info )) {
			return PayitemClass::creatPayitemOrder ( $att_info, 'goods', $service_id );
		}
		return false;
	}
	public function save_service_obj($release_info = array(), $obj_name) {
		global $kekezu;
		if ($release_info ['step1'] == 'step1') {
			if ($_POST ['fileid1']) {
			    $fileIdArr = explode('|', $_POST ['fileid1']);
			    if(is_array($fileIdArr)){
			        foreach ($fileIdArr as $k=>$v){
			            $fileIdArr[$k] = "'$v'";
			        }
			        $fileIdStr = implode(',', $fileIdArr);
			        $filePathArr = db_factory::query('select save_name from '.TB_PRE.'witkey_file where file_id in ('.$fileIdStr.')');
			        if($filePathArr){
			            foreach ($filePathArr as $v) {
			                $filePathStr.=','.$v['save_name'];
			            }
			            $filePathStr = substr($filePathStr, 1);
			            $pic = kekezu::escape ( $filePathStr );
			            $release_info ['pic_patch'] = $pic; 
			        }
			    }else{
			        $filePathArr = db_factory::get_one('select save_name from '.TB_PRE.'witkey_file where file_id = '.intval($_POST ['fileid1']));
			        $filePathStr = $filePathArr['save_name'];
			        $pic = kekezu::escape ( $filePathStr );
			        $release_info ['pic_patch'] = $pic; 
			    }
			}
		}
		empty ( $release_info ) or $this->_std_obj->_release_info = $release_info; 
		$_SESSION [$obj_name] = serialize ( $this->_std_obj ); 
	}
	public function get_service_obj($obj_name) {
		$_SESSION [$obj_name] and $this->_std_obj = unserialize ( $_SESSION [$obj_name] );
	}
	public function del_service_obj($obj_name) {
		if (isset ( $_SESSION [$obj_name] )) {
			unset ( $_SESSION [$obj_name] );
		}
		if (isset ( $_SESSION ['formhash'] )) {
			unset ( $_SESSION ['formhash'] );
		}
	}
	public function check_access($r_step, $model_id, $release_info, $service_id = null, $output = 'normal') {
		global $_lang, $gUid, $uid;
		switch ($r_step) {
			case "step1" : 
				break;
			case "step2" : 
				if (! $release_info ['step1']) {
					kekezu::keke_show_msg ( "index.php?do=pubgoods&id=$model_id&step=step2", $_lang ['no_input_goods_need_notice'], "error", $output );
				}
				break;
			case "step3" : 
				$sql = sprintf ( " select uid,service_status,service_id from %switkey_service where service_id = '%d' and on_time>%d", TB_PRE, $service_id, time () - 600 );
				$service_info = db_factory::get_one ( $sql );
				if ($service_info ['uid'] != $uid) {
					kekezu::keke_show_msg ( "index.php?do=pubgoods", '你没有权限访问该页面', "error", $output );
				}
				$service_info or kekezu::keke_show_msg ( "index.php?do=pubgoods", $_lang ['page_expired_notice'], "error", $output );
				return $service_info;
				break;
		}
	}
	public function checkWhetherToPay($objId,$objType) {
		$floatBalance = floatval ( $this->_user_info ['balance'] );
		$payitemOrderInfo = PayitemClass::getPayitemOrderAmountByObjId ( $objId ,$objType);
		if (floatval ( $payitemOrderInfo ['order_amount'] ) > 0) {
			$arrInfo['total_cash'] = floatval ( $payitemOrderInfo ['order_amount'] );
		} 
		if ($floatBalance >= $floatTotalCash) {
			$arrInfo ['balance_pay'] = true;
		} else {
			$arrInfo ['balance_pay'] = false;
		}
		return $arrInfo;
	}
	public static function get_price_unit() {
		global $_lang;
		return array (
				$_lang ['ge'],
				$_lang ['pieces'],
				$_lang ['times'],
				$_lang ['copy'] 
		);
	}
	public static function get_service_unit() {
		global $_lang;
		return array (
				$_lang ['hour'],
				$_lang ['day'],
				$_lang ['week'],
				$_lang ['month'] 
		);
	}
	public static function get_service_edit_status() {
		return array (
				'1'=>'更新待审核',
				'2'=>'无更新',
				'3'=>'更新已通过',
				'4'=>'更新未通过'
		);
	}
	public static function updateEditStatusBySid($service_id,$status) {
		return db_factory::execute("UPDATE `".TB_PRE."witkey_service` SET `edit_status`='{$status}' WHERE (`service_id`='{$service_id}')");
	}
	public static function checkShopStatus($uid,$redirect_url=''){
		$return = db_factory::get_one("SELECT * FROM `".TB_PRE."witkey_shop` WHERE uid = '{$uid}'");
		if($return['shop_status'] !='1'){
			if($redirect_url){
				kekezu::show_msg ( '您需要先开启店铺', $redirect_url, NULL, NULL, 'warning' );
			}
			if($_SERVER['HTTP_REFERER']){
				kekezu::show_msg ( '您需要先开启店铺', $_SERVER['HTTP_REFERER'], NULL, NULL, 'warning' );
			}else{
				kekezu::show_msg ( '您需要先开启店铺', 'index.php', NULL, NULL, 'warning' );
			}
		}
	}
	public static function updateShopStatus($uid,$status){
		db_factory::execute("update yw_company set autoshop=1 where userid='{$uid}'");
		return db_factory::execute("UPDATE `".TB_PRE."witkey_shop` SET `shop_status`='{$status}' WHERE (`uid`='{$uid}')");
	}
	public static function closeShop($uid ,$status = '3'){
		$res = self::updateShopStatus($uid, $status);
		if($res){
			$shop_info = db_factory::get_one("SELECT * FROM `".TB_PRE."witkey_shop` WHERE uid = '{$uid}'");
			db_factory::execute("update ".TB_PRE."witkey_service set service_status=3 where uid='{$uid}'");
			db_factory::execute("update yw_company set autoshop=2 where userid='{$uid}'");
			$v_arr = array('用户名'=>"{$shop_info['username']}",'店铺名称'=>$shop_info['shop_name']);
			keke_shop_class::notify_user($shop_info['uid'], $shop_info['username'], 'shop_close', '店铺关闭',$v_arr);
			return true;
		}
		return false;
	}
}
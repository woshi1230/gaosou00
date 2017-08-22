<?php
keke_lang_class::load_lang_class ( 'goods_pay_return_class' );
final class goods_pay_return_class extends pay_return_base_class {
	function __construct($charge_type, $model_id = '', $uid = '', $obj_id = '', $order_id = '', $total_fee = '') {
		parent::__construct ( $charge_type, $model_id, $uid, $obj_id, $order_id, $total_fee );
	}
	function order_charge() {
		global $_K;
		$order_id = $this->_order_id;
		$sid = $this->_obj_id;
		$uid = $this->_uid;
		$user_info = $this->_userinfo;
		$order_info = db_factory::get_one ( sprintf ( " select order_status,order_uid,order_username,seller_uid,seller_username from %switkey_order where order_id='%d'", TABLEPRE, $order_id ) );
		$url = $_K ['siteurl'] . "/index.php?do=user&view=finance&op=order&obj_type=service&role=2&order_id=" . $order_id;
		$s_order_link = "<a href=\"" . $_K ['siteurl'] . "/index.php?do=user&view=finance&op=order&obj_type=service&role=1&order_id=" . $order_id . "\">" . $order_info ['order_name'] . "</a>";
		$b_order_link = "<a href=\"" . $_K ['siteurl'] . "/index.php?do=user&view=finance&op=order&obj_type=service&role=2&order_id=" . $order_id . "\">" . $order_info ['order_name'] . "</a>";
		if ($order_info ['order_status'] == 'wait') {
			$service_info = keke_shop_class::get_service_info ( $sid ); 
			$service_status = db_factory::get_count ( sprintf ( " select service_status from %switkey_service where service_id='%d'", TABLEPRE, $sid ) );
			if ($service_status == '2') { 
				$data = array (
						':service_id' => $service_info ['service_id'],
						':title' => $service_info ['title'] 
				);
				keke_finance_class::init_mem ( 'buy_service', $data );
				$this->_total_fee > 0 and $res = keke_finance_class::cash_out ( $uid, $this->_total_fee, 'buy_service', '0', 'service', $order_id );
				if ($res) {
					db_factory::execute ( sprintf ( " update %switkey_order set order_status='ok' where order_id='%d'", TABLEPRE, $order_id ) );
					$v_arr = array (
							'用户名' => $order_info ['order_username'],
							'网站名称' => $kekezu->_sys_config['website_name'],
							'用户' => $_lang ['you'],
							'动作' => $_lang ['haved_confirm_pay'],
							'订单编号' => $order_id,
							'订单链接' => $b_order_link 
					);
					keke_shop_class::notify_user ( $order_info ['order_uid'], $order_info ['order_username'], "order_change", $_lang ['goods_order_confirm_pay'], $v_arr );
					$v_arr = array (
							'用户名' => $order_info ['order_username'],
							'网站名称' => $kekezu->_sys_config['website_name'],
							'用户' => $order_info ['order_username'],
							'动作' => $_lang ['haved_confirm_pay'],
							'订单编号' => $order_id,
							'订单链接' => $s_order_link 
					);
					keke_shop_class::notify_user ( $order_info ['seller_uid'], $order_info ['seller_username'], "order_change", $_lang ['goods_order_confirm_pay'], $v_arr );
					$notice = $_lang ['goods_pay_success'];
					$type = 'success';
				} else {
					$notice = $_lang ['goods_pay_fail'];
					$type = 'warning';
				}
			} else { 
				db_factory::execute ( sprintf ( " update %switkey_order set order_status='close' where order_id='%d'", TABLEPRE, $order_id ) );
				$v_arr = array (
						'用户名' => $order_info ['seller_username'],
						'网站名称' => $kekezu->_sys_config['website_name'],
						"用户" => $_lang ['system'],
						'动作' => $_lang ['stop_your_order_and_your_cash_return'],
						'订单编号' => $order_id,
						'订单链接' => $s_order_link 
				);
				keke_shop_class::notify_user ( $order_info ['seller_uid'], $order_info ['seller_username'], "order_change", $_lang ['goods_order_close'], $v_arr );
				$v_arr = array (
						'用户名' =>$order_info ['order_username'],
						'网站名称' => $kekezu->_sys_config['website_name'],
						"用户" => $_lang ['system'],
						'动作' => $_lang ['stop_your_order_and_your_cash_return'],
						'订单编号' => $order_id,
						'订单链接' => $b_order_link 
				);
				keke_shop_class::notify_user ( $order_info ['order_uid'], $order_info ['order_username'], "order_change", $_lang ['goods_order_close'], $v_arr );
				$notice = $_lang ['goods_pay_fail'];
				$type = 'warning';
			}
		} else {
			$notice = $_lang ['goods_pay_success'];
			$type = 'success';
		}
		return pay_return_fac_class::struct_response ( $_lang ['operate_notice'], $notice, $url, $type );
	}
}
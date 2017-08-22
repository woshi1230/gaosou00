<?php
ini_set('date.timezone','Asia/Shanghai');
$oid = trim($id);
$order_info = db_factory::get_one ( sprintf ( " select * from %switkey_order_charge where out_trade_no='%s' and uid='%d'", TB_PRE, $oid, $uid ) );
$data = array();
if($order_info ['order_status'] == 'ok'){
	list ( $_, $charge_type, $uid, $obj_id, $order_id, $model_id ) = explode ( '-', $order_info['attach'], 6 );
	if($charge_type=='user_charge'){
		$show_url = 'index.php?do=recharge&cash='.$order_info['pay_money'].'&status=1';
		$_SESSION['chargecash'] = $order_info['pay_money'];
	}elseif($charge_type=='payitem_charge'){
		if(! in_array($model_id, array(6,7))){
			$show_url = 'index.php?do=task&id='.$obj_id;
		}else{
			$show_url =  'index.php?do=goods&id='.$obj_id;
		}
	}else{
		if(! in_array($model_id, array(6,7))){
			$arrOrderDetail = keke_order_class::get_order_detail($order_id);
			if($arrOrderDetail[0]['obj_type']=='hosted'){
				$show_url = 'index.php?do=task&id='.$obj_id;
			}else{
				$show_url = 'index.php?do=pay&type=task&id='.$obj_id.'&status=1';
			}
		}else{
			$show_url =  'index.php?do=pay&type=order&id='.$order_id.'&status=1';
		}
	}
	$data['url'] = $show_url;
	kekezu::echojson('已支付成功','0',$data);
}else{
	kekezu::echojson('未支付','1');
}

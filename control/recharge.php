<?php
$strUrl = 'index.php?do=recharge&cash='.$cash;
$arrPayConfig = kekezu::get_table_data ( "k,v", TB_PRE . "witkey_pay_config", '', '', '', '', 'k' );
$referUrl = $_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'-1';
$arrOnlinePayList = keke_finance_class::get_pay_config ( '', 'online' );
$pay_open_status= 0;
foreach ($arrOnlinePayList as $k => $v){
	if($v['pay_status']=='1'){
		$pay_open_status = 1;
	}
}
if(floatval($_SESSION['chargecash']) != floatval($cash)){
	kekezu::show_msg('充值金额错误',null,null,null,'danger');
	exit('金额错误');
}
if (isset($formhash)&&kekezu::submitcheck($formhash)) {
		$payTitle = $username . '(' . $_K ['html_title'] . '在线充值' . trim ( sprintf ( "%10.2f", $cash ) ) .'元)';
		$bankConfig = kekezu::get_payment_config($bank);
		require S_ROOT . "/include/payment/" . $bank . "/order.php";
		$form = get_pay_url('user_charge',$cash, $bankConfig, $payTitle, time(),'0','0',$service,'MD5','form','index.php?do=recharge&status=1&cash='.$cash);
		if($bank == 'wxpay'){
			$wxpayUrl 		= $form['url'];
			$wxpayOrderId 	= $form['out_trade_no'];
			$_SESSION['wxpay'] = 1;
		}else{
			echo $form;die();
		}
}

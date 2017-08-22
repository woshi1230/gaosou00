<?php
$strPageTitle = '在线支付' . '-' . $kekezu->_sys_config ['index_seo_title'];
$arrOnlinePayList = keke_finance_class::get_pay_config ( '', 'online' );
$pay_open_status= 0;
foreach ($arrOnlinePayList as $k => $v){
	if($v['pay_status']=='1'){
		$pay_open_status = 1;
	}
}
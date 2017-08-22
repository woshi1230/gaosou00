<?php
defined('IN_KEKE') or exit('Access Denied');
$strUrl = "index.php?do=user&view=finance&op=basic&page=$page&pageSize=$pageSize&ord=$ord&type=$type";
$arrSort = array(
    '1' => '编号升序',
    '2' => '编号降序',
    '3' => '时间升序',
    '4' => '时间降序'
);
$w = " username  = '$gUsername'";
$page and $page = intval($page);
$pageSize and $pageSize = intval($pageSize) or $pageSize = 10;
$bank_arr = keke_glob_class::get_bank();
$onlinePay = keke_glob_class::get_online_pay();
if($type == 'charge'){
    $charge_type_arr=keke_glob_class::get_charge_type();
    $status_arr = keke_order_class::get_order_status();
    $intFinaId and $w .= " and order_id ='".intval($intFinaId)."'";
    switch ($ord){
    	case 1: $w.=' order by order_id asc';break;
    	case 2: $w.=' order by order_id desc';break;
    	case 3: $w.=' order by pay_time asc';break;
    	case 4: $w.=' order by pay_time desc';break;
    }
    $strSql = "select * from " . TB_PRE . "witkey_order_charge where ";
    if(!$ord){
        $w .= ' order by order_id desc';
    }
    $strSql .= $w;
}elseif($type == 'withdraw'){
    $status_arr  = keke_glob_class::withdraw_status();
    $intFinaId and $w .= " and withdraw_id ='".intval($intFinaId)."'";
    switch ($ord){
    	case 1: $w.=' order by withdraw_id asc ';break;
    	case 2: $w.=' order by withdraw_id desc ';break;
    	case 3: $w.=' order by process_time asc ';break;
    	case 4: $w.=' order by process_time desc ';break;
    }
    $strSql = "select * from " . TB_PRE . "witkey_withdraw where ";
    if(!$ord){
        $w .= ' order by withdraw_id desc';
    }
    $strSql .= $w;
}else{
    $intFinaId and $w .= " and fina_id = '" . intval($intFinaId) . "' ";
    if($type == 'in'){
        $w .= " and fina_type = 'in'";
    }elseif($type == 'out'){
        $w .= "and fina_type = 'out'";
    }
    switch ($ord){
    	case 1: $w.=' order by fina_id asc ';break;
    	case 2: $w.=' order by fina_id desc ';break;
    	case 3: $w.=' order by fina_time asc ';break;
    	case 4: $w.=' order by fina_time desc ';break;
    }
    $fina_action_arr = keke_glob_class::get_finance_action();
    $strSql = "select fina_action,fina_id,fina_type,fina_cash,user_balance,fina_time from " . TB_PRE . "witkey_finance where ";
    if(!$ord){
        $w .= ' order by fina_time desc';
    }
    $strSql .= $w;
}
$arrData = db_factory::query($strSql);
$arrPageArr = $kekezu->_page_obj->page_by_arr($arrData, $pageSize, $page, $strUrl);
$arrData = $arrPageArr['data'];
$strPages = $arrPageArr['page'];

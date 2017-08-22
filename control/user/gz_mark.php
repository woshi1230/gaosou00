<?php
$strUrl = 'index.php?do=user&view=gz&op=mark';
$page and $strUrl .= "&page=$page";
$type and $strUrl .= "&type=$type";
$obj and $strUrl .= "&obj=$obj";
$page and $page = intval($page) or $page = 1;
$mark_obj = keke_table_class::get_instance('witkey_mark');
$arrObj = array(
	'goods'=>'商品',
	'gy'=>'雇佣',
	'sreward'=>'任务',
	'mreward'=>'任务',
	'preward'=>'任务',
	'tender'=>'任务',
	'dtender'=>'任务'
);
$arrMarkStatus = array(
	'0'=>'尚未评价',
	'1'=>'好评',
	'2'=>'中评',
	'3'=>'差评'
);
$w1 = ' 1 = 1 ';
if($type){
	switch ($type){
		case 1: 
			$w1 .= " and a.mark_status='0' and ((a.by_uid='$gUid' and a.mark_type = '2' )) ";
			$w2 .= " and a.mark_status='0' and ((a.by_uid='$gUid' and a.mark_type = '2' )) ";
			break;
		case 2: 
			$w1 .= " and a.by_uid='$gUid' and a.mark_type = '2' ";
			$w2 .=" and a.by_uid='$gUid' and a.mark_type = '2' ";
			break;
		case 3: 
			$w1 .= " and a.uid = '$gUid' and a.mark_type = '1' ";
			$w2 .=" and a.uid='$gUid' and a.mark_type = '1' ";
			break;
	}
}else{
	$w1 .= " and ((a.uid = '$gUid' and a.mark_type = '1') or (a.by_uid='$gUid' and a.mark_type = '2' )) ";
	$w2 .= " and ((a.uid = '$gUid' and a.mark_type = '1') or (a.by_uid='$gUid' and a.mark_type = '2' )) ";
}
if($obj){
	switch ($obj){
		case 'goods': 
			$w1 .= " and a.model_code = 'goods' ";
			$w2 .= " and c.obj_type = 'goods'";
			break;
		case 'task':
			$w1 .= " and a.model_code in ('sreward','mreward','preward','tender','dtender') ";
			$w2 .= " and c.obj_type in ('sreward','mreward','preward','tender','dtender') "; 
			break;
		case 'gy': 	
			$w1 .= " and a.model_code = 'gy' ";
			$w2 .= " and c.obj_type = 'gy'"; 
			break;
	}
}else{
	$w1 .= " and (a.model_code = 'goods' or a.model_code in ('sreward','mreward','preward','tender','dtender')) ";
	$w2 .= " and c.obj_type = 'gy'";
}
$strOrder = ' order by mark_id desc';
$strSql1 = "select a.mark_id,a.model_code,a.origin_id,a.obj_id,a.mark_status,a.uid,a.by_uid,a.mark_content,a.mark_time,a.mark_count,b.agree_id from ".TB_PRE."witkey_mark as a
				left join ".TB_PRE."witkey_agreement as b
					on a.origin_id = b.task_id
						left join ".TB_PRE."witkey_order_detail as c
							on a.obj_id = c.order_id
								where ".$w1;
$strSql2 = "select a.mark_id,c.obj_type,a.origin_id,a.obj_id,a.mark_status,a.uid,a.by_uid,a.mark_content,a.mark_time,a.mark_count,b.agree_id from ".TB_PRE."witkey_mark as a
				left join ".TB_PRE."witkey_agreement as b
					on a.origin_id = b.task_id
						left join ".TB_PRE."witkey_order_detail as c
							on a.obj_id = c.order_id
								where a.model_code='service' and a.origin_id='0' ".$w2.$strOrder;
$strSql = $strSql1.' UNION ALL '.$strSql2;
$arrDatas = db_factory::query($strSql);
$d = $kekezu->_page_obj->page_by_arr($arrDatas, 10, $page, $strUrl);
$arrData = $d['data'];
$strPages = $d['page'];

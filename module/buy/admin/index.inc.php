<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/buy.class.php';
$do = new buy($moduleid);
$menus = array (
 //   array('添加'.$MOD['name'], '?moduleid='.$moduleid.'&action=add'),
    array($MOD['name'].'列表', '?moduleid='.$moduleid),
    array('待审核'.$MOD['name'], '?moduleid='.$moduleid.'&action=check'),
//    array('过期'.$MOD['name'], '?moduleid='.$moduleid.'&action=expire'),
    array('审核失败'.$MOD['name'], '?moduleid='.$moduleid.'&action=reject'),
//    array('回收站', '?moduleid='.$moduleid.'&action=recycle'),
//    array('移动分类', '?moduleid='.$moduleid.'&action=move'),
	array('单人悬赏', '?moduleid='.$moduleid.'&action=sreward'),//sreward 单人悬赏
	array('多人悬赏', '?moduleid='.$moduleid.'&action=mreward'),//mreward 多人悬赏
	array('计件悬赏', '?moduleid='.$moduleid.'&action=preward'),//preward 计件悬赏
	array('普通招标', '?moduleid='.$moduleid.'&action=tender'),//tender,普通招标
	array('定金招标', '?moduleid='.$moduleid.'&action=dtender'),//dtender，订金招标
	array('速配任务', '?moduleid='.$moduleid.'&action=match'),//match，速配任务
);
//if(in_array($action, array('add', 'edit'))) {
//	$FD = cache_read('fields-'.substr($table, strlen($DT_PRE)).'.php');
//	if($FD) require DT_ROOT.'/include/fields.func.php';
//	isset($post_fields) or $post_fields = array();
//	$CP = $MOD['cat_property'];
//	if($CP) require DT_ROOT.'/include/property.func.php';
//	isset($post_ppt) or $post_ppt = array();
//}

if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';

//if(in_array($action, array('', 'check', 'expire', 'reject', 'recycle'))) {
if(in_array($action, array('', 'check', 'reject','sreward', 'mreward', 'preward', 'tender', 'dtender', 'match'))) {
	$sfields = array('模糊', '标题', '产品名称', '需求数量', '价格要求', '包装要求', '简介', '公司名', '联系人', '联系电话', '联系地址', '电子邮件', '联系MSN', '联系QQ', '会员名', '编辑', 'IP', '参数名1', '参数名2', '参数名3', '参数值1', '参数值2', '参数值3', '文件路径', '内容模板');
	$dfields = array('task_title', 'title', 'tag', 'amount', 'price', 'pack', 'introduce', 'company', 'truename', 'telephone', 'address', 'email', 'msn', 'qq','username', 'editor', 'ip', 'n1', 'n2', 'n3', 'v1', 'v2', 'v3', 'filepath', 'template');
	$sorder  = array( 'ID降序', 'ID升序','开始时间降序', '开始时间升序', '交稿/选稿时间降序', '交稿/选稿时间升序');
	$dorder  = array('task_id DESC','task_id ASC','start_time DESC', 'start_time ASC', 'sub_time DESC', 'sub_time ASC',);

//	$level = isset($level) ? intval($level) : 0;
//	$typeid = isset($typeid) ? ($typeid === '' ? -1 : intval($typeid)) : -1;
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	
	isset($datetype) && in_array($datetype, array('sub_time', 'start_time', 'totime')) or $datetype = 'sub_time';
	$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
	$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
	$todate = isset($todate) && is_date($todate) ? $todate : '';
	$totime = $todate ? strtotime($todate.' 23:59:59') : 0;

	$areaid = isset($areaid) ? intval($areaid) : 0;
//	$thumb = isset($thumb) ? intval($thumb) : 0;
//	$guest = isset($guest) ? intval($guest) : 0;
	$task_id or $task_id = '';
	$task_id = isset($task_id) ? intval($task_id) : '';
	$minvip = isset($minvip) ? intval($minvip) : '';
	$minvip or $minvip = '';
	$maxvip = isset($maxvip) ? intval($maxvip) : '';
	$maxvip or $maxvip = '';

	//$fields_select = dselect($sfields, 'fields', '', $fields);
//	$type_select = dselect($TYPE, 'typeid', $MOD['name'].'类型', $typeid);
//	$level_select = level_select('level', '级别', $level, 'all');
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = '';
	if($_childs) $condition .= " AND catid IN (".$_childs.")";//CATE
	if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($AREA[$areaid]['child']) ? " AND areaid IN (".$AREA[$areaid]['arrchildid'].")" : " AND areaid=$areaid";
//	if($typeid >=0 ) $condition .= " AND typeid=$typeid";
//	if($level) $condition .= $level > 9 ? " AND level>0" : " AND level=$level";
//	if($fromtime) $condition .= " AND `$datetype`>=$fromtime";
//	if($totime) $condition .= " AND `$datetype`<=$totime";
//	if($thumb) $condition .= " AND thumb<>''";
//	if($guest) $condition .= " AND username=''";
//	if($minvip) $condition .= " AND vip>=$minvip";
//	if($maxvip) $condition .= " AND vip<=$maxvip";
	if($task_id) $condition .= " AND task_id=$task_id";

	//$timetype = strpos($dorder[$order], 'add') !== false ? 'add' : '';
	$timetype = strpos($dorder[$order], 'sub') !== false ? 'sub' : '';
}
switch($action) {
	case 'check':
		if($task_id && !$psize) {
			$do->check($task_id);
			dmsg('审核成功', $forward);
		} else {
			//$lists = $do->get_list('status=2'.$condition, $dorder[$order]);
			$lists = $do->get_list('task_status=1'.$condition,$dorder[$order]);
			$menuid = 1;
			include tpl('index', $module);
		}
		break;

	case 'sreward'://sreward 单人悬赏
		$lists = $do->get_list('model_id =1'.$condition, $dorder[$order]);
		$menuid = 3;
		include tpl('index', $module);
		break;

	case 'mreward'://mreward 多人悬赏
		$lists = $do->get_list('model_id=2'.$condition, $dorder[$order]);
		$menuid =4 ;
		include tpl('index', $module);
		break;

	case 'preward'://preward 计件悬赏
		$lists = $do->get_list('model_id=3'.$condition, $dorder[$order]);
		$menuid =5 ;
		include tpl('index', $module);
		break;

	case 'tender'://tender,普通招标
		$lists = $do->get_list('model_id=4'.$condition, $dorder[$order]);
		$menuid =6 ;
		include tpl('index', $module);
		break;

	case 'dtender'://dtender，订金招标
		$lists = $do->get_list('model_id=5'.$condition, $dorder[$order]);
		$menuid = 7;
		include tpl('index', $module);
		break;

	case 'match'://match，速配任务
		$lists = $do->get_list('model_id=12'.$condition, $dorder[$order]);
		$menuid = 8;
		include tpl('index', $module);
		break;

	case 'reject':
		if($task_id && !$psize) {
			$do->reject($task_id);
			dmsg('拒绝成功', $forward);
		} else {
			//	$lists = $do->get_list('task_status=10'.$condition, $dorder[$order]);
			$lists = $do->get_list('task_status=10'.$condition,$dorder[$order]);
			$menuid = 2;
			include tpl('index', $module);
		}
		break;
	case 'delete':
		$task_id or msg('请选择'.$MOD['name']);
		isset($recycle) ? $do->recycle($task_id) : $do->delete($task_id);
		dmsg('删除成功', $forward);
		break;

	case 'add':message();


	default:
		$lists = $do->get_list('task_status<14'.$condition,$dorder[$order]);//exit($condition);//task_status<14应该换另外的限制条件
		$menuid = 0;
		include tpl('index', $module);
	break;
}
//		if($submit) {
//			if($do->pass($post)) {
//				if($FD) fields_check($post_fields);
//				if($CP) property_check($post_ppt);
//				$do->add($post);
//				if($FD) fields_update($post_fields, $table, $do->task_id);
//				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->task_id);
//				if($MOD['show_html'] && $post['status'] > 2) $do->tohtml($do->task_id);
//				dmsg('添加成功', '?moduleid='.$moduleid.'&action='.$action.'&catid='.$post['catid']);
//			} else {
//				msg($do->errmsg);
//			}
//		} else {
//			foreach($do->fields as $v) {
//				isset($$v) or $$v = '';
//			}
//			$content = '';
//			$status = 3;
//			$start_time = timetodate($DT_TIME);
//			$totime = '';
//			$username = $_username;
//			$typeid = 0;
//			$item = array();
//			$menuid = 0;
//			isset($url) or $url = '';
//			if($url) {
//				$tmp = fetch_url($url);
//				if($tmp) extract($tmp);
//			}
//			include tpl('edit', $module);
//		}
//	break;
//	case 'edit':
//		$task_id or msg();
//		$do->task_id = $task_id;
//		if($submit) {
//			if($do->pass($post)) {
//				if($FD) fields_check($post_fields);
//				if($CP) property_check($post_ppt);
//				if($FD) fields_update($post_fields, $table, $do->task_id);
//				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->task_id);
//				$do->edit($post);
//				dmsg('修改成功', $forward);
//			} else {
//				msg($do->errmsg);
//			}
//		} else {
//			$item = $do->get_one();
//			extract($item);
//			$start_time = timetodate($start_time);
//			$totime = $totime ? timetodate($totime, 3) : '';
//			$menuon = array('5', '4', '2', '1', '3');
//			$menuid = $menuon[$status];
//			include tpl($action, $module);
//		}
//	break;
//	case 'move':
//		if($submit) {
//			$fromids or msg('请填写来源ID');
//			if($tocatid) {
//				$db->query("UPDATE {$table} SET catid=$tocatid WHERE `{$fromtype}` IN ($fromids)");
//				dmsg('移动成功', $forward);
//			} else {
//				msg('请选择目标分类');
//			}
//		} else {
//			$task_id = $task_id ? implode(',', $task_id) : '';
//			$menuid = 6;
//			include tpl($action);
//		}
//	break;
//	case 'update':
//		is_array($task_id) or msg('请选择'.$MOD['name']);
//		foreach($task_id as $v) {
//			$do->update($v);
//		}
//		dmsg('更新成功', $forward);
//	break;
//	case 'tohtml':
//		is_array($task_id) or msg('请选择'.$MOD['name']);
//		foreach($task_id as $task_id) {
//			tohtml('show', $module);
//		}
//		dmsg('生成成功', $forward);
//	break;
//	case 'delete':
//		$task_id or msg('请选择'.$MOD['name']);
//		isset($recycle) ? $do->recycle($task_id) : $do->delete($task_id);
//		dmsg('删除成功', $forward);
//		break;
//	case 'restore':
//		$task_id or msg('请选择'.$MOD['name']);
//		$do->restore($task_id);
//		dmsg('还原成功', $forward);
//	break;
//	case 'refresh':
//		$task_id or msg('请选择'.$MOD['name']);
//		$do->refresh($task_id);
//		dmsg('刷新成功', $forward);
//	break;
//	case 'clear':
//		$do->clear();
//		dmsg('清空成功', $forward);
//	break;
//	case 'level':
//		$task_id or msg('请选择'.$MOD['name']);
//		$level = intval($level);
//		$do->level($task_id, $level);
//		dmsg('级别设置成功', $forward);
//	break;
//	case 'type':
//		$task_id or msg('请选择'.$MOD['name']);
//		$tid = intval($tid);
//		array_key_exists($tid, $TYPE) or $tid = 0;
//		$do->type($task_id, $tid);
//		dmsg('类型设置成功', $forward);
//	break;
//	case 'recycle':
//		$lists = $do->get_list('status=0'.$condition, $dorder[$order]);
//		$menuid = 5;
//		include tpl('index', $module);
//	break;

//	case 'expire':
//		if(isset($refresh)) {
//			if(isset($extend)) {
//				$days = isset($days) ? intval($days) : 0;
//				$days or msg('请填写天数');
//				$task_id or msg('请选择信息');
//				foreach($task_id as $v) {
//					$db->query("UPDATE {$table} SET totime=totime+$days*86400,status=3 WHERE itask_id='$v' AND totime>0");
//				}
//				$do->expire();
//				dmsg('延时成功', $forward);
//			} else {
//				$do->expire();
//				dmsg('刷新成功', $forward);
//			}
//		} else {
//			$lists = $do->get_list('status=4'.$condition);
//			$menuid = 3;
//			include tpl('index', $module);
//		}
//	break;

//	default:
//		$lists = $do->get_list('task_status<14'.$condition,$dorder[$order]);//exit($condition);//task_status<14应该换另外的限制条件
//		$menuid = 0;
//		include tpl('index', $module);
//	break;
//}
?>


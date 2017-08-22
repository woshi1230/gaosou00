<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/doc.class.php';
$do = new doc($moduleid);
$doc_url = strchr($DT_URL,"?",true);
$menus = array (
	array('添加分类', DT_PATH.'admin_yw.php?file=category&action=add&mid=99&parentid=0'),
	array('管理分类', DT_PATH.'admin_yw.php?file=category&mid=99'),
	array('添加'.$MOD['name'], $doc_url.'?file=cloud&action=doc&sub_action=add'),
	array($MOD['name'].'列表', $doc_url.'?file=cloud&action=doc&sub_action=list'),
);

if(in_array($action, array('add', 'edit'))) {
	$FD = cache_read('fields-'.substr($table, strlen($DT_PRE)).'.php');
	if($FD) require DT_ROOT.'/include/fields.func.php';
	isset($post_fields) or $post_fields = array();
	$CP = $MOD['cat_property'];
	if($CP) require DT_ROOT.'/include/property.func.php';
	isset($post_ppt) or $post_ppt = array();
}

if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';

if(in_array($action, array('', 'add', 'edit', 'list', 'check', 'reject', 'recycle'))) {
	$dfields = array('keyword', 'title', 'tag', 'introduce', 'author', 'copyfrom', 'fromurl', 'username', 'editor', 'ip', 'filepath', 'template');
	$dorder  = array($MOD['order'], 'addtime DESC', 'addtime ASC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'itemid DESC', 'itemid ASC');

	isset($order) && isset($dorder[$order]) or $order = 0;
	$catid = isset($catid) ? intval($catid) : -1;
//	$types = '安装升级|系统使用|模板风格|环境搭建|开发指南|高级技巧';
//	$types = $types ? explode('|', trim($types)) : array();
//	$cat_select = dselect($types, 'post[catid]', '选择分类', $catid, ' id="catid_1"');

	$itemid or $itemid = '';

	$condition = '';
	if($keyword) $condition .= " AND $dfields[0] LIKE '%$keyword%'";
	if($catid >= 0) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";

	if($level) $condition .= $level > 9 ? " AND level>0" : " AND level=$level";
	if($itemid) $condition .= " AND itemid=$itemid";

	$timetype = strpos($dorder[$order], 'add') === false ? 'edit' : '';
}
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				$do->add($post);
				if($FD) fields_update($post_fields, $db->pre.$table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				if($MOD['show_html'] && $post['status'] > 2) $do->tohtml($do->itemid);
				dmsg('添加成功', '?moduleid='.$moduleid.'&action='.$action.'&catid='.$post['catid']);
			} else {
				msg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$content = '';
			$status = 3;
			$addtime = timetodate($DT_TIME);
			$item = array();
			$menuid = 2;
			isset($url) or $url = '';
			if($url) {
				$tmp = fetch_url($url);
				if($tmp) extract($tmp);
			}
			$pagebreak = 0;
			$forward = DT_PATH.'module/doc/index.php'.$menus[2][1];
			include tpl('edit', $module);
		}
	break;
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $db->pre.$table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$item = $do->get_one();
			extract($item);
			$pagebreak = strpos($item['content'], '<hr class="de-pagebreak" />') === false ? 0 : 1;
			$addtime = timetodate($addtime);
			$menuon = array('4', '3', '2', '1');
			$menuid = '3'; //$menuon[$status];
			include tpl($action, $module);
		}
	break;
	case 'show':
		$itemid or msg();
		$do->itemid = $itemid;

        $db->query("UPDATE {$db->pre}{$table} SET hits=hits+1 WHERE itemid=$itemid");

        $item = $do->get_one();
        extract($item);
        $pagebreak = strpos($item['content'], '<hr class="de-pagebreak" />') === false ? 0 : 1;
        $addtime = timetodate($addtime);
        $menuon = array('4', '3', '2', '1');
        $menuid = $menuon[$status];

        $content = $item['content'];
        $editdate = timetodate($edittime, 3);
        if($lazy) $content = img_lazy($content);
        if($MOD['keylink']) $content = keylink($content, $moduleid);

        include tpl($action, $module);
	break;
	case 'move':
		if($submit) {
			$fromids or msg('请填写来源ID');
			if($tocatid) {
				$db->query("UPDATE {$db->pre}{$table} SET catid=$tocatid WHERE `{$fromtype}` IN ($fromids)");
				dmsg('移动成功', $forward);
			} else {
				msg('请选择目标分类');
			}
		} else {
			$itemid = $itemid ? implode(',', $itemid) : '';
			$menuid = 5;
			include tpl($action);
		}
	break;
	case 'update':
		is_array($itemid) or msg('请选择'.$MOD['name']);
		foreach($itemid as $v) {
			$do->update($v);
		}
		dmsg('更新成功', $forward);
	break;
	case 'tohtml':
		is_array($itemid) or msg('请选择'.$MOD['name']);
		$html_itemids = $itemid;
		foreach($html_itemids as $itemid) {
			tohtml('show', $module);
		}
		dmsg('生成成功', $forward);
	break;
	case 'delete':
		$itemid or msg('请选择'.$MOD['name']);
		isset($recycle) ? $do->recycle($itemid) : $do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'restore':
		$itemid or msg('请选择'.$MOD['name']);
		$do->restore($itemid);
		dmsg('还原成功', $forward);
	break;
	case 'clear':
		$do->clear();
		dmsg('清空成功', $forward);
	break;
	case 'level':
		$itemid or msg('请选择'.$MOD['name']);
		$level = intval($level);
		$do->level($itemid, $level);
		dmsg('级别设置成功', $forward);
	break;
	case 'recycle':
		$lists = $do->get_list('status=0'.$condition, $dorder[$order]);
		$menuid = 4;
		include tpl('index', $module);
	break;
	case 'reject':
		if($itemid && !$psize) {
			$do->reject($itemid);
			dmsg('拒绝成功', $forward);
		} else {
			$lists = $do->get_list('status=1'.$condition, $dorder[$order]);
			$menuid = 3;
			include tpl('index', $module);
		}
	break;
	case 'check':
		if($itemid && !$psize) {
			$do->check($itemid);
			dmsg('审核成功', $forward);
		} else {
			$lists = $do->get_list('status=2'.$condition, $dorder[$order]);
			$menuid = 2;
			include tpl('index', $module);
		}
	break;
	case 'author':
		$condition = "status=3";
		if($keyword) $condition .= " AND `author` LIKE '%$keyword%'";
		$lists = array();
		$result = $db->query("SELECT COUNT(`author`) AS num,author FROM {$db->pre}{$table} WHERE $condition GROUP BY `author` ORDER BY num DESC LIMIT 0,50");
		$lists[]['author'] = '本站原创';
		$lists[]['author'] = '佚名';
		while($r = $db->fetch_array($result)) {
			if(!$r['author']) continue;
			$lists[] = $r;
		}
		include tpl('author', $module);
	break;
	case 'from':
		$condition = "status=3";
		if($keyword) $condition .= " AND (`copyfrom` LIKE '%$keyword%' OR `fromurl` LIKE '%$keyword%')";
		$lists = array();
		$result = $db->query("SELECT COUNT(`copyfrom`) AS num,copyfrom,fromurl FROM {$db->pre}{$table} WHERE $condition GROUP BY `copyfrom` ORDER BY num DESC LIMIT 0,50");
		while($r = $db->fetch_array($result)) {
			if(!$r['copyfrom']) continue;
			$lists[] = $r;
		}
		include tpl('from', $module);
	break;
	default:
		$lists = $do->get_list('status=3'.$condition, $dorder[$order]);
		$menuid = 3;
		include tpl('index', $module);
	break;
}
?>
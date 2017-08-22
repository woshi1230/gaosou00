<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/report.class.php';
$do = new report();

isset($type) or $type = "2";
$type == "2" ? $menuid=0 : $menuid=1;
$menus = array (
    array('举报列表', '?moduleid='.$moduleid.'&file='.$file.'&type=2'),
    array('维权列表', '?moduleid='.$moduleid.'&file='.$file.'&type=1')
);
if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';
if(in_array($action, array('', 'check'))) {
	$sfields = array('按条件', '举报原因', '举报编号', '举报类型', '举报人', '被举报人');
	$dfields = array('report_desc','report_desc','report_id','report_reason','username','to_username');
	$sorder  = array('结果排序方式', '举报类型');
	$dorder  = array('report_id DESC', 'report_reason');

	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = 'report_type='.$type;
	if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
}
switch($action) {
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$addtime = timetodate($addtime);
			include tpl('report_edit', $module);
		}
	break;
	case 'check':
		$itemid or msg('请选择留言');
		$do->check($itemid, $status);
		dmsg('设置成功', $forward);
	break;
	case 'delete':
		$itemid or msg('请选择留言');
		$do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	default:
		$lists = $do->get_list($condition, $dorder[$order]);
		include tpl('report', $module);
	break;
}
?>
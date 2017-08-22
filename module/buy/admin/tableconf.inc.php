<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/mark_rule.class.php';
$do = new mark_rule($moduleid);

$tab = isset($tab) ? intval($tab) : 0;
$all = isset($all) ? intval($all) : 0;
if($submit) {
	switch($tab) {
		case 0:
			$dbdata = array ();
			foreach($tab0 as $k => $v){
				$dbdata [$k] = array("k"=>$k, "v"=>$v);
			}
			$sData = "\$dbdata = " . var_export($dbdata, true) . ";";

			if(!is_write(DT_ROOT.'/lib/table/Keke_witkey_basic_config_class.php')) msg('/lib/table/Keke_witkey_basic_config_class.php无法写入，请设置可写权限');
			$tmp = file_get(DT_ROOT.'/lib/table/Keke_witkey_basic_config_class.php');
			$sTag = '$dbdata = array';
			$eTag = ');';
			$sPos = strpos($tmp, $sTag);
			$ePos = strpos($tmp, $eTag, $sPos) + strlen($eTag);
			if ($ePos && $ePos > $sPos) {
				$sStr = substr($tmp, 0, $sPos);
				$eStr = substr($tmp, $ePos);
			}

			file_put(DT_ROOT.'/lib/table/Keke_witkey_basic_config_class.php', $sStr.$sData.$eStr);
			$id = '';
			break;
		case 1:
			require_once DT_ROOT.'/lib/table/Keke_witkey_model_class.php';
			$dbdata = Keke_witkey_model_class::query ();

			$tab1['config'] = stripslashes($tab1['config']);
			$tab1['model_desc'] = dsafe(addslashes(nl2br(stripslashes($tab1['model_desc']))));
			$dbdata[$tab1['model_id']] = $tab1;
			$sData = "\$dbdata = " . var_export($dbdata, true) . ";";

			if(!is_write(DT_ROOT.'/lib/table/Keke_witkey_model_class.php')) msg('/lib/table/Keke_witkey_model_class.php无法写入，请设置可写权限');
			$tmp = file_get(DT_ROOT.'/lib/table/Keke_witkey_model_class.php');
			$sTag = '$dbdata = array';
			$eTag = ');';
			$sPos = strpos($tmp, $sTag);
			$ePos = strpos($tmp, $eTag, $sPos) + strlen($eTag);
			if ($ePos && $ePos > $sPos) {
				$sStr = substr($tmp, 0, $sPos);
				$eStr = substr($tmp, $ePos);
			}

			file_put(DT_ROOT.'/lib/table/Keke_witkey_model_class.php', $sStr.$sData.$eStr);
			$id = '&action=detail&id='.$tab1['model_id'];
			break;
		case 2:
			require_once DT_ROOT.'/lib/table/Yw_witkey_mark_config_class.php';
			$dbdata = Yw_witkey_mark_config_class::query ();

			$dbdata[$tab2['mark_config_id']] = $tab2;
			$sData = "\$dbdata = " . var_export($dbdata, true) . ";";

			if(!is_write(DT_ROOT.'/lib/table/Yw_witkey_mark_config_class.php')) msg('/lib/table/Yw_witkey_mark_config_class.php无法写入，请设置可写权限');
			$tmp = file_get(DT_ROOT.'/lib/table/Yw_witkey_mark_config_class.php');
			$sTag = '$dbdata = array';
			$eTag = ');';
			$sPos = strpos($tmp, $sTag);
			$ePos = strpos($tmp, $eTag, $sPos) + strlen($eTag);
			if ($ePos && $ePos > $sPos) {
				$sStr = substr($tmp, 0, $sPos);
				$eStr = substr($tmp, $ePos);
			}

			file_put(DT_ROOT.'/lib/table/Yw_witkey_mark_config_class.php', $sStr.$sData.$eStr);
			$id = '&action=detail&id='.$tab2['mark_config_id'];
			break;
		case 3:
			$do->itemid = $tab3['mark_rule_id'];
			if(!$do->edit($tab3)) {
				msg($do->errmsg);
			}
			$id = '&action=detail&id='.$tab3['mark_rule_id'];
			break;
		case 4:
			require_once DT_ROOT.'/lib/table/Keke_witkey_tag_class.php';
			$dbdata = Keke_witkey_tag_class::query ();

			$tab4['code'] = dsafe(addslashes(nl2br(stripslashes($tab4['code']))));
			$dbdata[$tab4['tag_id']] = $tab4;
			$sData = "\$dbdata = " . var_export($dbdata, true) . ";";

			if(!is_write(DT_ROOT.'/lib/table/Keke_witkey_tag_class.php')) msg('/lib/table/Keke_witkey_tag_class.php无法写入，请设置可写权限');
			$tmp = file_get(DT_ROOT.'/lib/table/Keke_witkey_tag_class.php');
			$sTag = '$dbdata = array';
			$eTag = ');';
			$sPos = strpos($tmp, $sTag);
			$ePos = strpos($tmp, $eTag, $sPos) + strlen($eTag);
			if ($ePos && $ePos > $sPos) {
				$sStr = substr($tmp, 0, $sPos);
				$eStr = substr($tmp, $ePos);
			}

			file_put(DT_ROOT.'/lib/table/Keke_witkey_tag_class.php', $sStr.$sData.$eStr);
			$id = '&action=detail&id='.$tab4['tag_id'];
			break;
	}
	dmsg('更新成功', '?moduleid='.$moduleid.'&file='.$file.'&tab='.$tab.$id);
} else {
	if($kw) {
		$all = 1;
		ob_start();
	}

	require_once DT_ROOT.'/lib/table/Keke_witkey_basic_config_class.php';
	$dbdata0 = Keke_witkey_basic_config_class::query ();

	require_once DT_ROOT.'/lib/table/Keke_witkey_model_class.php';
	$dbdata1 = Keke_witkey_model_class::query ();
	if (isset($id) && $action == 'detail') {
		$dbdata1 = $dbdata1[$id];
	}

	require_once DT_ROOT.'/lib/table/Yw_witkey_mark_config_class.php';
	$dbdata2 = Yw_witkey_mark_config_class::query ();
	if (isset($id) && $action == 'detail') {
		$dbdata2 = $dbdata2[$id];
	}

	if (isset($id) && $action == 'detail') {
		$do->itemid = $id;
		$dbdata3 = $do->get_one();
	} else {
		$dbdata3 = $do->get_list();
	}

	require_once DT_ROOT.'/lib/table/Keke_witkey_tag_class.php';
	$dbdata4 = Keke_witkey_tag_class::query ();
	if (isset($id) && $action == 'detail') {
		$dbdata4 = $dbdata4[$id];
	}

	include tpl('tableconf', $module);
	if($kw) {
		$data = $content = ob_get_contents();
		ob_clean();
		$data = preg_replace('\'(?!((<.*?)|(<a.*?)|(<strong.*?)))('.$kw.')(?!(([^<>]*?)>)|([^>]*?</a>)|([^>]*?</strong>))\'si', '<span class=highlight>'.$kw.'</span>', $data);
		$data = preg_replace('/<span class=highlight>/', '<a name=high></a><span class=highlight>', $data, 1);
		echo $data ? $data : $content;
	}
}
?>
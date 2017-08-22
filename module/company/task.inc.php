<?php
defined('IN_GAOSOU') or exit('Access Denied');
if($html == 'list') {
	$catid or exit;
	if($MOD['list_html'] && $task_list && $CAT) {
		$num = 1;
		$totalpage = max(ceil($CAT['item']/$MOD['pagesize']), 1);
		$demo = DT_ROOT.'/'.$MOD['moduledir'].'/'.listurl($CAT, '{DEMO}');
		$fid = $page;
		if($fid >= 1 && $fid <= $totalpage && $DT_TIME - @filemtime(str_replace('{DEMO}', $fid, $demo)) > $task_list) tohtml('list', $module);
		$fid = $page + 1;
		if($fid >= 1 && $fid <= $totalpage && $DT_TIME - @filemtime(str_replace('{DEMO}', $fid, $demo)) > $task_list) tohtml('list', $module);
		$fid = $totalpage + 1 - $page;
		if($fid >= 1 && $fid <= $totalpage && $DT_TIME - @filemtime(str_replace('{DEMO}', $fid, $demo)) > $task_list) tohtml('list', $module);
	}
} else if($html == 'index') {
	if($DT['cache_hits']) {
		$file = DT_CACHE.'/hits-'.$moduleid;
		if($DT_TIME - @filemtime($file.'.dat') > $DT['cache_hits'] || @filesize($file.'.php') > 102400) update_hits($moduleid, $table);
	}
	if($MOD['index_html']) {
		$file = DT_ROOT.'/'.$MOD['moduledir'].'/index.inc.html';
		if($DT_TIME - @filemtime($file) > $task_index) tohtml('index', $module);
	}
} else {
	stristr($DT_URL, "type=1") ? $type = 1 : $type = 2;
	$page =str_replace('page=','',strstr($DT_URL, "page"));
    $page = intval($page)?$page:1;
    if($type == 2) {//高手接收的任务";
        $table = 'yw_witkey_task_work';
        $tableTask = 'yw_witkey_task';
        $condition = "username='$username'";
        $r = $db->get_one("SELECT COUNT(DISTINCT b.task_id) AS num FROM $tableTask AS b LEFT JOIN  $table AS a on   a.task_id = b.task_id WHERE a.$condition");//一些任务存在$table表中，在$tableTask中却没有（删除无用任务？），导致分页问题，所以做此修改
        $offset = ($page-1)*$pagesize;
        $pages = pages($r['num'], $page, $pagesize);
        $orders = $r['num'];
        $lists = array();
        $result = $db->query("SELECT a.task_id,a.end_time,a.model_id,a.task_status,a.task_cash,a.task_title,a.start_time,a.username FROM $tableTask AS a LEFT JOIN  $table as b  ON a.task_id = b.task_id   WHERE  b.$condition   GROUP BY  a.task_id ORDER BY a.task_id DESC LIMIT $offset,$pagesize");
        $amount = $fee = $money = 0;
        while($arr = $db->fetch_array($result)) {
            $r['task_id'] = $arr['task_id'];
            $r['model_id'] = $arr['model_id'];
            $r['task_status'] = $arr['task_status'];
            $r['task_cash'] = $arr['task_cash'];
            $r['task_title'] = $arr['task_title'];
            if (!$r['task_title']) continue;
            $r['start_time'] = $arr['start_time'];
            $r['usernameB'] = $arr['username'];
            $r['end_time'] = $arr['end_time'];
            $r['gone'] = $DT_TIME - $r['start_time'];
            if ($r['status'] == 3) {
                if ($r['gone'] > ($MOD['trade_day'] * 86400 + $r['add_time'] * 3600)) {
                    $r['lefttime'] = 0;
                } else {
                    $r['lefttime'] = secondstodate($MOD['trade_day'] * 86400 + $r['add_time'] * 3600 - $r['gone']);
                }
            }
            $r['par'] = '';
            if (strpos($r['note'], '|') !== false) list($r['note'], $r['par']) = explode('|', $r['note']);
            $r['work_time'] = str_replace(' ', '<br/>', timetodate($r['work_time'], 5));
            $r['start_time'] = str_replace(' ', '<br/>', timetodate($r['start_time'], 5));
            $r['updatetime'] = str_replace(' ', '<br/>', timetodate($r['updatetime'], 5));
            $r['linkurl'] = DT_PATH . 'api/redirect.php?mid=' . $r['mid'] . '&task_id=' . $r['mallid'];
            $r['dstatus'] = $_status[$r['status']];
            $r['money'] = $r['amount'] + $r['fee'];
            $r['money'] = number_format($r['money'], 2, '.', '');
            $amount += $r['amount'];
            $fee += $r['fee'];
            $lists[] = $r;
        }
        $money = $amount + $fee;
        $money = number_format($money, 2, '.', '');
        $head_title = $L['trade_order_title'];
        define("S_ROOT", DT_ROOT . '/');
        include DT_ROOT . '/lib/inc/keke_lang_class.php';
        include DT_ROOT . '/lib/inc/keke_glob_class.php';
        include DT_ROOT . '/lib/inc/keke_search_class.php';
        include DT_ROOT . '/lib/table/Keke_witkey_model_class.php';
        $arrTaskNavs = Keke_witkey_model_class::query("*");
        $arrTaskTimeDesc = keke_glob_class::get_taskstatus_desc();
    }else if($type == 1) {//发布的任务";
        $condition = "username='$username'";
        $r = $db->get_one("SELECT COUNT(*) AS num FROM yw_witkey_task WHERE  $condition");//echo $condition;var_dump($r);echo $table;
        $offset = ($page-1)*$pagesize;
        $pages = pages($r['num'], $page, $pagesize);
        $lists = array();
        $result = $db->query("SELECT task_id,sub_time,model_id,task_status,task_cash,task_title,sp_end_time,end_time FROM yw_witkey_task WHERE  $condition ORDER BY task_id DESC LIMIT $offset,$pagesize");
        $amount = $fee = $money = 0;
        while($r = $db->fetch_array($result)) {
            $lists[] = $r;
        }
        $money = $amount + $fee;
        $money = number_format($money, 2, '.', '');
        $head_title = $L['trade_order_title'];
        define("S_ROOT", DT_ROOT . '/');
        include DT_ROOT . '/lib/inc/keke_lang_class.php';
        include DT_ROOT . '/lib/inc/keke_glob_class.php';
        include DT_ROOT . '/lib/inc/keke_search_class.php';
        include DT_ROOT . '/lib/table/Keke_witkey_model_class.php';
        $arrTaskNavs = Keke_witkey_model_class::query("*");
        $arrTaskTimeDesc = keke_glob_class::get_taskstatus_desc();
    }
    include template('task', $template);
}
?>
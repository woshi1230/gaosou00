<?php
defined('IN_GAOSOU') or exit('Access Denied');
login();
require DT_ROOT . '/module/' . $module . '/common.inc.php';
require DT_ROOT . '/include/post.func.php';
include load('order.lang');
$timenow = timetodate($DT_TIME, 3);
$memberurl = $MOD['linkurl'];
$myurl = userurl($_username);
$task_id = intval($_GET['task_id']);
$work_id = intval($_GET['work_id']);
$mark_id = intval($_GET['mark_id']);
$table = 'yw_witkey_task';
$STARS = $L['star_type'];
if ($action == 'update') {
    $task_id or message();
    $td = $db->get_one("SELECT * FROM {$table} WHERE task_id=$task_id");
    $td or message($L['trade_msg_null']);
    if ($td['buyer'] != $_username && $td['seller'] != $_username) message($L['trade_msg_deny']);
    $td['adddate'] = timetodate($td['addtime'], 5);
    $td['updatedate'] = timetodate($td['updatetime'], 5);
    $td['linkurl'] = DT_PATH . 'api/redirect.php?mid=' . $td['mid'] . '&task_id=' . $td['mallid'];
    $td['par'] = '';
    if (strpos($td['note'], '|') !== false) list($td['note'], $td['par']) = explode('|', $td['note']);
    $mallid = $td['mallid'];
    $nav = $_username == $td['buyer'] ? 'action_order' : 'action';
} else if ($action == 'delgj') {//删除稿件
    $work_id or message();
    $td = $db->query("DELETE FROM `yw_witkey_task_work` WHERE `work_id`=$work_id");
    dmsg('删除成功', $forward);
} else if ($action == 'delrw') {//删除任务
    $task_id or message();
    $td = $db->query("DELETE FROM `yw_witkey_task` WHERE `task_id`=$task_id");
    dmsg('删除成功', $forward);
} else if ($action == 'delpl') {//删除评论
    $mark_id or message();
    $td = $db->query("DELETE FROM `yw_witkey_mark` WHERE `mark_id`=$mark_id");
    dmsg('删除成功', $forward);
} else if ($action == 'order') {
//我发布的任务";
    $nav = isset($nav) ? intval($nav) : -1;
    $moudleId = isset($moudleId) ? intval($moudleId) : 0;
    $status = isset($status) && isset($dstatus[$status]) ? intval($status) : '';
    $condition = "username='$_username'";
    if ($status !== '') $condition .= " AND status='$status'";
    if ($task_id) $condition .= " AND task_id='$task_id'";
    if ($cod) $condition .= " AND cod=1";
    if (in_array($moudleId, array(1, 2, 3, 4, 5, 6))) {
        $conditionB = 'model_id =' . $moudleId;
    } else {
        $conditionB = '1=1';
    }
    $r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $conditionB AND $condition");
//    echo $condition;var_dump($r);echo $table;
    $pages = pages($r['num'], $page, $pagesize);
    $lists = array();
    $result = $db->query("SELECT * FROM {$table} WHERE $conditionB AND $condition ORDER BY task_id DESC LIMIT $offset,$pagesize");
    $amount = $fee = $money = 0;
    while ($arr = $db->fetch_array($result)) {
        $r['task_id'] = $arr['task_id'];
        $r['task_status'] = $arr['task_status'];
        $r['task_cash'] = $arr['task_cash'];
        $r['task_title'] = $arr['task_title'];
        $r['start_time'] = $arr['start_time'];
        $r['end_time'] = $arr['end_time'];
        $r['usernameB'] = $arr['username'];
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
        $r['sub_time'] = str_replace(' ', '<br/>', timetodate($r['sub_time'], 5));
        $r['start_time'] = str_replace(' ', '<br/>', timetodate($r['start_time'], 5));
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
} else if ($action == 'waitpay') {
    $cod = isset($cod) ? intval($cod) : 0;
    $nav = isset($nav) ? intval($nav) : -1;
    $status = isset($status) && isset($dstatus[$status]) ? intval($status) : '';
    $condition = "username='$_username'";
    if ($task_id) $condition .= " AND task_id='$task_id'";
    if ($cod) $condition .= " AND cod=1";
    $r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition and task_status =0");//echo 11111; echo $condition;var_dump($r);echo $table;
    $pages = pages($r['num'], $page, $pagesize);
    $lists = array();
    $result = $db->query("SELECT * FROM {$table} WHERE $condition and task_status =0 ORDER BY task_id DESC LIMIT $offset,$pagesize");
    $amount = $fee = $money = 0;
    while ($r = $db->fetch_array($result)) {
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
        $r['sub_time'] = str_replace(' ', '<br/>', timetodate($r['sub_time'], 5));
        $r['start_time'] = str_replace(' ', '<br/>', timetodate($r['start_time'], 5));
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
} else if ($action == 'waitselect') {
    $nav = isset($nav) ? intval($nav) : -1;
    $status = isset($status) && isset($dstatus[$status]) ? intval($status) : '';
    $condition = "username='$_username'";
    $r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition and (task_status =3 or task_status =2)");//echo 11111; echo $condition;var_dump($r);echo $table;
    $pages = pages($r['num'], $page, $pagesize);
    $lists = array();
    $result = $db->query("SELECT * FROM {$table} WHERE $condition and (task_status =3 or task_status =2) ORDER BY task_id DESC LIMIT $offset,$pagesize");
    $amount = $fee = $money = 0;
    while ($r = $db->fetch_array($result)) {
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
        $r['sub_time'] = str_replace(' ', '<br/>', timetodate($r['sub_time'], 5));
        $r['start_time'] = str_replace(' ', '<br/>', timetodate($r['start_time'], 5));
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
} else if ($action == 'waitjudge') {
    $table = 'yw_witkey_mark';
    $nav = isset($nav) ? intval($nav) : -1;
    $status = isset($status) && isset($dstatus[$status]) ? intval($status) : '';
    $conditionB = " by_username = '$_username'";
    if ($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
    if ($fromtime) $condition .= " AND addtime>" . (strtotime($fromtime . ' 00:00:00'));
    if ($totime) $condition .= " AND addtime<" . (strtotime($totime . ' 23:59:59'));
    if ($status !== '') $condition .= " AND status='$status'";
    if ($task_id) $condition .= " AND task_id='$task_id'";
    if ($mallid) $condition .= " AND mallid=$mallid";
    if ($seller) $condition .= " AND seller='$seller'";
    if ($cod) $condition .= " AND cod=1";
    if ($nav == 0) {
        $condition .= " AND mark_status = 0";
    } else if ($nav == 1) {
        $condition .= " AND mark_status <>0  ";//mark_type=1发布任务
    } else if ($nav == 2) {
        $conditionB = " username = '$_username'";
        $condition .= " AND mark_status <>0 ";//mark_type接受任务
    } else {
        $conditionB = " username = '$_username' or by_username = '$_username'";
        $condition .= 'AND 1=1';
    }
    $rA = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $conditionB $condition");
    $pages = pages($rA['num'], $page, $pagesize);
    $lists = array();
    $result = $db->query("SELECT a.*,b.agree_id FROM  yw_witkey_mark AS a LEFT JOIN  yw_witkey_agreement as b  ON a.origin_id = b.task_id   WHERE   a.$conditionB  $condition  ORDER BY b.task_id DESC LIMIT $offset,$pagesize;");
    $amount = $fee = $money = 0;
    while ($r = $db->fetch_array($result)) {
        $r['gone'] = $DT_TIME - $r['start_time'];
        //以 下  几行是为查agreeId(链接雇佣之间相互评价时，需要此参数，eg.index.php?do=agreement&taskId=131&agreeId=34)
        $r['agreeId'] = $r['agree_id'];
        //以 上
        $r['par'] = '';
        if (strpos($r['note'], '|') !== false) list($r['note'], $r['par']) = explode('|', $r['note']);
        $r['sub_time'] = str_replace(' ', '<br/>', timetodate($r['sub_time'], 5));
        $r['mark_max_time'] = str_replace(' ', '<br/>', timetodate($r['mark_max_time'], 5));
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
} else if ($action == 'index' or $action == '') {
    $table = 'yw_witkey_task_work';
    $tableTask = 'yw_witkey_task';





    //take承接任务 -phone
    $resultTake = $db->query("SELECT a.task_id,a.task_desc,a.work_num,a.model_id,a.area,a.task_status,a.task_cash,a.task_title,a.start_time, b.username FROM yw_witkey_task AS a LEFT JOIN  yw_witkey_task_work as b  ON b.task_id = a.task_id   ORDER BY a.task_id DESC");
    $amount = $fee = $money = 0;
    while ($arr = $db->fetch_array($resultTake)) {
        $r['task_id'] = $arr['task_id'];
        $r['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($arr['task_desc'])));
        $r['work_num'] = $arr['work_num'];
        $r['model_id'] = $arr['model_id'];
        $r['area'] = $arr['area'];
        $r['task_status'] = $arr['task_status'];
        $r['task_cash'] = $arr['task_cash'];
        $r['task_title'] = $arr['task_title'];
        if (!$r['task_title']) continue;
        $r['start_time'] = $arr['start_time'];
//        $r['end_time'] = $arr['end_time'];
        $r['username'] = $arr['username'];
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
//        $r['linkurl'] = DT_PATH . 'api/redirect.php?mid=' . $r['mid'] . '&task_id=' . $r['mallid'];
//        $r['dstatus'] = $_status[$r['status']];
        $r['money'] = $r['amount'] + $r['fee'];
        $r['money'] = number_format($r['money'], 2, '.', '');
        $amount += $r['amount'];
        $fee += $r['fee'];
        $arrTaskLists[] = $r;
    }
//    var_dump($arrTaskLists);
//
//    function array_unique_fb($array2D){
//        foreach ($array2D as $v){
//            $v = join(",",$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
//            $temp[] = $v;
//        }
//        $temp =array_unique($temp);   //去掉重复的字符串,也就是重复的一维数组
//        foreach ($temp as $k => $v){
//            $temp[$k] = explode(",",$v);  //再将拆开的数组重新组装
//        }
//        return $temp;
//    }
//    $aa = array(
//        array('id' => 123, 'name' =>'张三'),
//        array('id' => 123, 'name' =>'李四'),
//        array('id' => 124, 'name' =>'王五'),
//        array('id' => 123, 'name' =>'李四'),
//        array('id' => 126, 'name' =>'赵六')
//    );
//    $arrTaskLists=array_unique_fb($arrTaskLists);
//    print_r($bb);

//    $arrTaskLists = array_flip($arrTaskLists);
//    var_dump($arrTaskLists);
//    exit('23');
//    var_dump($arrTaskLists);

    $trTake = json_encode($arrTaskLists, JSON_UNESCAPED_UNICODE);
    $M_PATHTake = DT_ROOT . '/file/cache/takeTask.json';
    file_put_contents($M_PATHTake, $trTake);
    //end phone


    $nav = isset($nav) ? intval($nav) : -1;
    $moudleId = isset($moudleId) ? intval($moudleId) : 0;
    $status = isset($status) && isset($dstatus[$status]) ? intval($status) : '';
    $condition = "username='$_username'";
    if (in_array($moudleId, array(1, 2, 3, 4, 5, 6))) {
        $conditionB = 'model_id =' . $moudleId;
    } else {
        $conditionB = '1=1';
    }
    $r = $db->get_one("SELECT COUNT(DISTINCT b.task_id) AS num FROM $tableTask AS b LEFT JOIN  $table AS a on   a.task_id = b.task_id WHERE a.$condition");//一些任务存在$table表中，在$tableTask中却没有（删除无用任务？），导致分页错误，所以做此修改
    $pages = pages($r['num'], $page, $pagesize);
    $orders = $r['num'];
    $lists = array();
    $result = $db->query("SELECT a.task_id,a.end_time,a.task_status,a.task_cash,a.task_title,a.start_time,a.username FROM $tableTask AS a LEFT JOIN  $table as b  ON a.task_id = b.task_id   WHERE $conditionB AND b.$condition   GROUP BY  a.task_id ORDER BY a.task_id DESC LIMIT $offset,$pagesize");
    $amount = $fee = $money = 0;
    while ($arr = $db->fetch_array($result)) {
        $r['task_id'] = $arr['task_id'];
        $r['task_status'] = $arr['task_status'];
        $r['task_cash'] = $arr['task_cash'];
        $r['task_title'] = $arr['task_title'];
        if (!$r['task_title']) continue;
        $r['start_time'] = $arr['start_time'];
        $r['end_time'] = $arr['end_time'];
        $r['usernameB'] = $arr['username'];
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
    $resultAll = $db->query("SELECT task_id FROM {$table} WHERE $condition ORDER BY task_id DESC");
    while ($rAll = $db->fetch_array($resultAll)) {
        $r_task_id = $rAll['task_id'];
        $rtask_id[] = $r_task_id;
    }
    $rtask_id = implode(",", $rtask_id);
    $rtask_id = empty($rtask_id) ? 0 :$rtask_id;
    $money = $amount + $fee;
    $money = number_format($money, 2, '.', '');
    $head_title = $L['trade_title'];
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

} else {
    message();
}
include template('witkey', $module);
?>
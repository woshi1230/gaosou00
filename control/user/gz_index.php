<?php
$strUrl = "index.php?do=user&view=gz";
$objFollowT = keke_table_class::get_instance('witkey_free_follow');
if (isset($action) && $action === 'cancelFocus') {
    if ($intFollowUid) {
        $objFollowT->del('follow_id', intval($intFollowUid));
        kekezu::show_msg('删除成功', $strUrl, NULL, NULL, 'ok');
    } else {
        kekezu::show_msg('删除失败', NULL, NULL, NULL, 'error');
    }
}
$arrAuthItems = keke_auth_fac_class::getAuthItemListByUid($gUid);
$arrSellerLevel = unserialize($gUserInfo['seller_level']);
$arrBuyerLevel = unserialize($gUserInfo['buyer_level']);
$floatPubTask = db_factory::query("select sum(a.fina_cash) as cash from " . TB_PRE . "witkey_finance a left join " . TB_PRE . "witkey_order b on a.order_id=b.order_id
		 where a.uid=" . intval($gUid) . " and a.fina_action = 'pub_task' and b.order_status='ok'");
$floatBidTask = db_factory::query("select sum(fina_cash) as cash from " . TB_PRE . "witkey_finance
		 where uid=" . intval($gUid) . " and fina_action = 'task_bid' ");
$floatPayService = db_factory::query("select sum(a.fina_cash) as cash,count('a.fina_id') as count from " . TB_PRE . "witkey_finance a left join " . TB_PRE . "witkey_order b on a.order_id=b.order_id where a.uid=" . intval($gUid) . " and a.fina_action in ('buy_service','buy_gy') and b.order_status in ('confirm','complete')");
$floatSaleService = db_factory::query("select sum(fina_cash) as cash,count(fina_id) as count from " . TB_PRE . "witkey_finance
		 where uid=" . intval($gUid) . " and fina_action in ('sale_service','sale_gy') ");
$arrTaskModels = TaskClass::getEnabledTaskModelList();
$strModelIds = implode(',', array_keys($arrTaskModels));
$arrGoodsModels = db_factory::get_table_data('*', TB_PRE . 'witkey_model', ' model_status = 1 and model_type = "shop" ', ' listorder asc', '', '', 'model_id', 3600);
$strServiceIds = implode(',', array_keys($arrGoodsModels));
$strModelIds and $arrTaskCount = kekezu::get_table_data('count(task_id) as count,task_status', TB_PRE . 'witkey_task', 'uid=' . intval($gUid) . ' and task_status in (0,3) and model_id in (' . $strModelIds . ')', '', 'task_status', '', 'task_status', '');
$strServiceIds and $arrServiceWait = db_factory::query("SELECT  count(a.order_id) as count FROM `" . TB_PRE . "witkey_order` AS a  LEFT JOIN " . TB_PRE . "witkey_order_detail AS b ON a.order_id = b.order_id  LEFT JOIN " . TB_PRE . "witkey_service AS c ON b.obj_id = c.service_id  WHERE  1=1  and a.seller_uid = $uid and c.model_id in (" . $strServiceIds . ") and b.obj_type = 'service'
		 and a.order_status ='seller_confirm'");
$strServiceIds and $strServiceComp = $arrGoodsWait = db_factory::query("SELECT  count(a.order_id) as count FROM `" . TB_PRE . "witkey_order` AS a  LEFT JOIN " . TB_PRE . "witkey_order_detail AS b ON a.order_id = b.order_id  LEFT JOIN " . TB_PRE . "witkey_service AS c ON b.obj_id = c.service_id  WHERE  1=1  and a.seller_uid = $uid and c.model_id in (" . $strServiceIds . ") and b.obj_type = 'service'
		 and a.order_status ='confirm_complete'");
$arrCashCoves = TaskClass::getTaskCashCove();
$strArr = "'task_tur_bei','task_baoming_bei','buy_goods','buy_service','pub_task','gy'";
$strsqls = "select * from " . TB_PRE . "witkey_feed where uid=" . $gUid . " and  feedtype in (" . $strArr . ")  order by feed_time desc limit 0,5";
$arrMyFeeds = db_factory::query($strsqls);
if ($arrMyFeeds) {
    foreach ($arrMyFeeds as $key => $v) {
        $arrDt = unserialize($v ['title']);
        if (is_array($arrDt)) {
            foreach ($arrDt as $k1 => $v1) {
                $arrDt [$k1] = $v1;
            }
        }
        switch ($v['feedtype']) {
            case 'task_tur_bei' :
                $a = "<a href='" . $arrDt['feed_username']['url'] . "'>" . $arrDt['feed_username']['content'] . "</a>向你的任务<a href='" . $arrDt['event']['url'] . "'>" . $arrDt['event']['content'] . "</a>投递了稿件";
                break;
            case 'task_baoming_bei' :
                $a = "<a href='" . $arrDt['feed_username']['url'] . "'>" . $arrDt['feed_username']['content'] . "</a>报名了你的任务<a href='" . $arrDt['event']['url'] . "'>" . $arrDt['event']['content'] . "</a>";
                break;
            case 'buy_goods' :
                $a = "你购买了<a href='" . $arrDt['feed_username']['url'] . "'>" . $arrDt['feed_username']['content'] . "</a>的文件<a href='" . $arrDt['event']['url'] . "'>" . $arrDt['event']['content'] . "</a>";
                break;
            case 'buy_service' :
                $a = "你购买了<a href='" . $arrDt['feed_username']['url'] . "'>" . $arrDt['feed_username']['content'] . "</a>的服务<a href='" . $arrDt['event']['url'] . "'>" . $arrDt['event']['content'] . "</a>";
                break;
            case 'pub_task' :
                $a = "你发布了任务<a href='" . $arrDt['event']['url'] . "'>" . $arrDt['event']['content'] . "</a>";
                break;
            case 'gy' :
                $a = "你向<a href='" . $arrDt['feed_username']['url'] . "'>" . $arrDt['feed_username']['content'] . "</a>发起了雇佣";
                break;
        }
        $arr[$key]['dongtai'] = $a;
        $arr[$key]['time'] = $v['feed_time'];
    }
}
if ($strFriends[0]['fuids']) {
    $arrFeeds = kekezu::get_feed(" uid in (" . $strFriends[0]['fuids'] . ") and (feedtype='pub_task' or feedtype='pub_service')", 'feed_time desc', '5');
}
$strSql = " select * from " . TB_PRE . "witkey_favorite where keep_type = 'service' and uid=" . $gUid . " order by on_date desc limit 0,3";
$arrFavorite = db_factory::query($strSql);
$arrTaskStatus = '3,4,5,6,7,8';
$strSql = "select a.work_id,a.task_id,a.uid,a.username,b.start_time,b.task_title,b.task_cash from " . TB_PRE . "witkey_task_work as a left join " . TB_PRE . "witkey_task as b on a.task_id=b.task_id where b.task_status in (" . $arrTaskStatus . ") and b.uid=" . intval($gUid) . " order by a.work_id desc limit 3";
$arrTaskWorkInfo = db_factory::query($strSql);
foreach ($arrTaskWorkInfo as $k => $v) {
    $arrRecord[$v['start_time']]['objname'] = $v['task_title'];
    $arrRecord[$v['start_time']]['url'] = 'index.php?do=task&id=' . $v['task_id'];
    $arrRecord[$v['start_time']]['cash'] = $v['task_cash'];
    $arrRecord[$v['start_time']]['wiki_uid'] = $v['uid'];
    $arrRecord[$v['start_time']]['wiki_username'] = $v['username'];
}
$strSql = "select a.bid_id,a.task_id,a.uid,a.username,b.start_time,b.task_title,b.task_cash from " . TB_PRE . "witkey_task_bid as a left join " . TB_PRE . "witkey_task as b on a.task_id=b.task_id where b.task_status in (" . $arrTaskStatus . ") and b.uid=" . intval($gUid) . " order by a.bid_id desc limit 3";
$arrTaskBidInfo = db_factory::query($strSql);
foreach ($arrTaskBidInfo as $k => $v) {
    $arrRecord[$v['start_time']]['objname'] = $v['task_title'];
    $arrRecord[$v['start_time']]['url'] = 'index.php?do=task&id=' . $v['task_id'];
    $arrRecord[$v['start_time']]['cash'] = $v['task_cash'];
    $arrRecord[$v['start_time']]['wiki_uid'] = $v['uid'];
    $arrRecord[$v['start_time']]['wiki_username'] = $v['username'];
}
$order_status = "'wait','ok','working','confirm_complete','complete'";
$strSql = "SELECT a.title,a.id,a.price,c.order_id,c.order_uid,c.order_username,c.seller_uid,c.seller_username,c.order_status,c.order_time FROM `" . TB_PRE . "witkey_service_order` as a LEFT JOIN " . TB_PRE . "witkey_order_detail as b ON a.order_id = b.order_id LEFT JOIN " . TB_PRE . "witkey_order as c ON a.order_id = c.order_id	WHERE 1=1  and c.order_uid= " . intval($gUid) . "  and c.order_status in (" . $order_status . ") and b.obj_type='gy' order by c.order_id desc limit 3";
$arrGyInfo = db_factory::query($strSql);
foreach ($arrGyInfo as $k => $v) {
    $arrRecord[$v['order_time']]['objname'] = $v['title'];
    $arrRecord[$v['order_time']]['url'] = '#';
    $arrRecord[$v['order_time']]['cash'] = $v['price'];
    $arrRecord[$v['order_time']]['wiki_uid'] = $v['seller_uid'];
    $arrRecord[$v['order_time']]['wiki_username'] = $v['seller_username'];
}
$order_status = "'ok','working','confirm_complete','complete'";
$strSql = "select b.title,b.price,c.order_time,b.username,b.uid,b.service_id from " . TB_PRE . "witkey_service_order as a left join " . TB_PRE . "witkey_service as b on a.service_id=b.service_id left join " . TB_PRE . "witkey_order as c on a.order_id=c.order_id where a.uid=" . intval($gUid) . " and c.order_status in (" . $order_status . ") order by a.id desc limit 3";
$arrService = db_factory::query($strSql);
foreach ($arrService as $k => $v) {
    $arrRecord[$v['order_time']]['objname'] = $v['title'];
    $arrRecord[$v['order_time']]['url'] = 'index.php?do=goods&id=' . $v['service_id'];
    $arrRecord[$v['order_time']]['cash'] = $v['price'];
    $arrRecord[$v['order_time']]['wiki_uid'] = $v['uid'];
    $arrRecord[$v['order_time']]['wiki_username'] = $v['username'];
}
$order_status = "'ok','confirm'";
$strSql = "select c.title,a.order_amount,a.order_time,a.seller_username,a.seller_uid,c.service_id from " . TB_PRE . "witkey_order as a left join " . TB_PRE . "witkey_order_detail as b on a.order_id=b.order_id left join " . TB_PRE . "witkey_service as c on b.obj_id=c.service_id where a.order_uid=" . intval($gUid) . " and a.order_status in (" . $order_status . ") and a.model_id=6 order by a.order_id desc limit 3";
$arrShop = db_factory::query($strSql);
foreach ($arrShop as $k => $v) {
    $arrRecord[$v['order_time']]['objname'] = $v['title'];
    $arrRecord[$v['order_time']]['url'] = 'index.php?do=goods&id=' . $v['service_id'];
    $arrRecord[$v['order_time']]['cash'] = $v['order_amount'];
    $arrRecord[$v['order_time']]['wiki_uid'] = $v['seller_uid'];
    $arrRecord[$v['order_time']]['wiki_username'] = $v['seller_username'];
}
krsort($arrRecord);
$arrRec = array_slice($arrRecord, 0, 3);
$strWhere = " 1 = 1 ";
$strWhere .= " and f.uid = " . $uid;
$strSql = 'select f.*,s.uid focus_uid,s.username focus_username,s.seller_level,s.skill_ids  from ' . TB_PRE . 'witkey_free_follow as f';
$strSql .= ' left join yw_company as s on f.fuid = s.userid where ' . $strWhere;
$strSql .= ' order by f.on_time desc ';
$arrDatas = db_factory::query($strSql);
$arrPageArr = $kekezu->_page_obj->page_by_arr($arrDatas, $intPagesize, $intPage, $strUrl);
$arrFollowLists = $arrPageArr ['data'];
if (is_array($arrFollowLists)) {
    foreach ($arrFollowLists as $k => $v) {
        $arrFocusData = CommonClass::getMemberFocus($v['focus_uid']);
        $arrFollowLists[$k]['data'] = $arrFocusData;
        $arrShopInfo = CommonClass::getShopInfo($v['focus_uid']);
        $arrFollowLists[$k]['shop_slogans'] = $arrShopInfo['shop_slogans'];
    }
}
$userInfo = db_factory::get_one("select `indentity` from yw_company where userid = '$uid'");
$indentity = $userInfo['indentity'];
$_SESSION['userIndentity'] = 'gz';
$intUserRole = intval($gUserInfo['user_type']);
$arrHasAuthItem = keke_auth_fac_class::get_auth ( $gUserInfo );
$arrUserAuthInfo = $arrHasAuthItem ['info'];

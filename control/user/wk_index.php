<?php
$strUrl ="index.php?do=user&view=wk&op=gy";
$strSql=" select * from ".TB_PRE."witkey_favorite where keep_type = 'task' and uid=".$gUid." order by on_date desc limit 0,3";
$arrFavorite=db_factory::query($strSql);
$arrAuthItems = keke_auth_fac_class::getAuthItemListByUid($gUid);
$floatBidTask = db_factory::query("select sum(fina_cash) as cash from ".TB_PRE."witkey_finance where uid=".intval($gUid)." and fina_action = 'task_bid' ");
$floatBidTask = db_factory::query("select sum(fina_cash) as cash from ".TB_PRE."witkey_finance where uid=".intval($gUid)." and fina_action = 'task_bid' ");
$floatSaleService = db_factory::query("select sum(fina_cash) as cash,count(fina_id) as count from ".TB_PRE."witkey_finance where uid=".intval($gUid)." and fina_action in ('sale_service','sale_gy') ");
$strSql="select * from ".TB_PRE."witkey_service where model_id in (6,7) and uid=".$gUid." and sale_num>0 order by sale_num desc,on_time desc limit 3";
$arrGoosRercod=db_factory::query($strSql);
foreach ($arrGoosRercod as $k => $v){
	$arrGoods=db_factory::get_one("select * from ".TB_PRE."witkey_order_detail as a left join ".TB_PRE."witkey_order as b on a.order_id=b.order_id where a.obj_id=".$v['service_id']." order by detail_id desc");
	$arrRercod[$k]['service_id']=$v['service_id'];
	$arrRercod[$k]['title']=$v['title'];
	$arrRercod[$k]['sale_num']=$v['sale_num'];
	$arrRercod[$k]['total_sale']=$v['total_sale'];
	$arrRercod[$k]['buytime']=''.date('Y-m-d',$arrGoods['order_time']);
}
$strArr="'work_accept','task_tur','task_baoming','buy_goods_bei','buy_service_bei','pub_service','gy_bei'";
$strsqls="select * from ".TB_PRE."witkey_feed where uid=".$gUid." and  feedtype in (".$strArr.")  order by feed_time desc limit 0,5";
$arrMyFeeds =db_factory::query($strsqls);
if($arrMyFeeds){
    foreach ($arrMyFeeds as $key => $v){
        $arrDt = unserialize ( $v ['title'] );
        if (is_array ( $arrDt )) {
            foreach ( $arrDt as $k1 => $v1 ) {
                $arrDt [$k1] = $v1;
            }
        }
            switch ($v['feedtype']) {
                case 'task_tur' :
                    $a="你向任务<a href='".$arrDt['event']['url']."'>".$arrDt['event']['content']."</a>投递了稿件";
                    break;
                case 'task_baoming' :
                    $a="你报名了任务<a href='".$arrDt['event']['url']."'>".$arrDt['event']['content']."</a>";
                    break;
                case 'work_accept' :
                    $a="你在任务<a href='".$arrDt['event']['url']."'>".$arrDt['event']['content']."</a>中标了";
                    break;
                case 'buy_goods_bei' :
                    $a="<a href='".$arrDt['feed_username']['url']."'>".$arrDt['feed_username']['content']."</a>购买了你的文件<a href='".$arrDt['event']['url']."'>".$arrDt['event']['content']."</a>";
                    break;
                case 'buy_service_bei' :
                    $a="<a href='".$arrDt['feed_username']['url']."'>".$arrDt['feed_username']['content']."</a>购买了你的服务<a href='".$arrDt['event']['url']."'>".$arrDt['event']['content']."</a>";
                    break;
                case 'pub_service' :
                    $a="你".$arrDt['action']['content']."<a href='".$arrDt['event']['url']."'>".$arrDt['event']['content']."</a>";
                    break;
                case 'gy_bei' :
                    $a="<a href='".$arrDt['feed_username']['url']."'>".$arrDt['feed_username']['content']."</a>向你发来雇佣申请";
                    break;
            }
            $arr[$key]['dongtai']=$a;
        $arr[$key]['time']=$v['feed_time'];
    }
}
$strTaskSql = "SELECT task_id, model_id, task_title, task_cash, task_cash_coverage, start_time, task_status FROM `"
    .TB_PRE."witkey_task` WHERE (task_id IN ( SELECT task_id FROM "
    .TB_PRE."witkey_task_bid WHERE uid = ".$gUid." ) OR task_id IN ( SELECT task_id FROM "
    .TB_PRE."witkey_task_work WHERE uid = ".$gUid." ) )";
$strWhere .= " order by task_id desc";
$arrTaskLists = db_factory::query ( $strTaskSql . $strWhere  );
$arrTaskNavs = TaskClass::getEnabledTaskModelList();
$_SESSION['userIndentity'] = 'wk';
function wiki_opera($m_id, $t_id, $w_id, $url) {
    global $kekezu;
    $button = array ();
    $model_code = $kekezu->_model_list [$m_id] ['model_code'];
    $c = $model_code . '_task_class';
    if ($model_code && method_exists ( $c, 'wiki_opera' )) {
        $button = call_user_func_array ( array ($c, 'wiki_opera' ), array ($m_id, $t_id, $w_id, $url ) );
    } else { 
        $button = call_user_func_array ( array ('sreward_task_class', 'wiki_opera' ), array ($m_id, $t_id, $w_id, $url ) );
    }
    return $button;
}
$intUserRole = intval($gUserInfo['user_type']);
$arrHasAuthItem = keke_auth_fac_class::get_auth ( $gUserInfo );
$arrUserAuthInfo = $arrHasAuthItem ['info'];
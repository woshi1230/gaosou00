<?php	defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
$arrBreadcrumbs = array(
    1=>array('url'=>'index.php?do=map','name'=>'网站地图')
);
$strSqlP = "select indus_id,indus_name from ".TB_PRE."witkey_industry where indus_pid = '0'";
$arrIndusP = db_factory::query($strSqlP);
foreach ($arrIndusP as $v){
    $strSql = "select indus_id,indus_name from ".TB_PRE."witkey_industry where indus_pid = '".$v['indus_id']."'";
    $arrIndusC[] =  db_factory::query($strSql);
}
$strUrlTask = "index.php?do=tasklist";
$arrCashStatus = array(
    '0'=>'全部',
    '1'=>'未托管',
    '2'=>'已托管'
);
$arrTaskNavs = TaskClass::getEnabledTaskModelList();
$arrTaskStatus = array(
    '0'=>'全部',
    '1'=>'工作中',
    '2'=>'选稿中',
    '3'=>'交付中',
    '4'=>'已结束'
);
$strUrlWeike= "index.php?do=goodslist";
$arrWeike = array(
    '0'=>'全部',
    '7'=>'服务',
    '6'=>'文件'
);
$strUrlSeller = "index.php?do=sellerlist";
$arrSell = array(
    '0'=>'全部',
    '1'=>'个人用户',
    '2'=>'企业用户'
);
$strUrlCase = "index.php?do=case";
$arrCase = array(
    '0'=>'全部',
    '1'=>'任务案例',
    '2'=>'商品案例'
);
$strUrlArticle = "index.php?do=articlelist";
$arrArticle = array(
    '203'=>'安全交易',
    '5'=>'行业动态',
    '4'=>'政策法规',
    '7'=>'媒体报导',
    '17'=>'网站公告',
    '358'=>'新闻列表'
);
$strUrlUser = "index.php?do=user";
$arrIndex = array();
$arrTitle = array();
$arrTransaction = array(
    'released'=>'我发布的任务',
    'undertake'=>'我承接的任务',
    'service'=>'我的商品',
    'orders'=>'我买入的商品'
);
$arrIndex['transaction'] = $arrTransaction;
$arrTitle['transaction'] = '交易管理';
$arrShop = array(
    'setting'=>'店铺设置',
    'caselist'=>'案例管理'
);
$arrIndex['shop'] = $arrShop;
$arrTitle['shop'] = '店铺管理';
$arrCollect = array(
    'task'=>'收藏的任务',
    'work'=>'收藏的稿件',
    'goods'=>'收藏的商品'
);
$arrIndex['collect'] = $arrCollect;
$arrTitle['collect'] = '我的收藏';
$arrFocus = array(
    'attention'=>'全部关注',
    'fans'=>'我的粉丝',
    'each'=>'相互关注'
);
$arrIndex['focus'] = $arrFocus;
$arrTitle['focus'] = '我的关注';
$arrProm = array(
    'code'=>'推广代码',
    'benefit'=>'推广收益'
);
$arrIndex['prom'] = $arrProm;
$arrTitle['prom'] = '我的推广';
$arrFinnace = array(
    'basic'=>'账目明细',
    'rechargeonline'=>'账号充值',
    'withdraw'=>'账号提现'
);
$arrIndex['finance'] = $arrFinnace;
$arrTitle['finance'] = '我的财务';
$arrAccount = array(
    'basic'=>'资料完善',
    'chooseavatar'=>'头像设置',
    'password'=>'安全设置',
    'binding'=>'账号绑定',
    'auth'=>'账号认证',
    'report'=>'交易维权'
);
$arrMessage = array(
    'notice'=>'交易提醒',
    'private'=>'私人短信',
    'outbox'=>'我的发件箱',
    'send'=>'写消息'
);
$arrSeller = array(
    'goods'=>'商品',
    'task'=>'任务',
    'case'=>'案例',
    'mark'=>'评价详情'
);

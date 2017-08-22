<?php	defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
$strNavActive ='index';
$intIndexCacheTime = 3600;
$strPageTitle = $kekezu->_sys_config['index_seo_title'];
$strPageKeyword = $kekezu->_sys_config['index_seo_keyword'];
$strPageDescription = $kekezu->_sys_config['index_seo_desc'];
$_SESSION['spread'] = 'index.php?do=index';
$strThemePath = S_ROOT . SKIN_PATH . '/theme/';
	$arrBulletins = db_factory::query(sprintf("select art_id,art_title,listorder,is_recommend,pub_time from %switkey_article where cat_type='article' and art_cat_id=17 order by is_recommend desc, listorder asc, pub_time desc limit 0,5",TB_PRE),1,$intIndexCacheTime);
	$arrDynamics = kekezu::get_feed ( "feedtype='work_accept'", "feed_time desc", 5 ); 
	$arrWithdraws = db_factory::query(sprintf("select * from %switkey_withdraw where withdraw_status=2 order by process_time desc limit 0,5",TB_PRE),1,$intIndexCacheTime);
	if ($task_open) {
		$arrCashCoverage = kekezu::get_cash_cove ( '', true );
		$final_task = kekezu::get_classify_indus();
		$arrRecommTaskLists = db_factory::query(sprintf("select task_id,task_title,task_cash,task_cash_coverage,username,work_num from %switkey_task where  task_status=2 order by start_time desc limit 21",TB_PRE),1,$intIndexCacheTime);
	}
	if ($shop_open) {
		$final_shop = kekezu::get_classify_indus('shop');
		$arrRecommGoodsLists = db_factory::query(sprintf("select service_id,title,price,unite_price,pic,username from %switkey_service where  service_status=2 order by  on_time desc limit 8",TB_PRE),1,$intIndexCacheTime);;
	}
	$strSql   = ' select a.case_id,a.obj_id,a.obj_type,a.case_img,a.case_title,a.case_price ';
	$task_open and $strSql.=',b.work_num,b.model_id,b.username,b.uid ';
	$strSql.=' from '.TB_PRE.'witkey_case a ';
	$task_open and $strSql.=' left join '.TB_PRE.'witkey_task b ON a.obj_id = b.task_id ';
	$strSql.=' where a.obj_type="task" ';
	$strSql .= " order by a.on_time desc limit 9 ";
	$arrCaseLists1 =  db_factory::query($strSql,1,$intIndexCacheTime);
	$strSql   = ' select a.case_id,a.obj_id,a.obj_type,a.case_img,a.case_title,a.case_price ';
	$shop_open and $strSql.=' ,c.sale_num,c.model_id,c.username,c.uid ';
	$strSql.=' from '.TB_PRE.'witkey_case a ';
	$shop_open and $strSql.=' left join '.TB_PRE.'witkey_service c on  a.obj_id= c.service_id ';
	$task_open or $strSql.=' where a.obj_type="service" ';
	$strSql .= " order by a.on_time desc limit 9 ";
	$arrCaseLists2 =  db_factory::query($strSql,1,$intIndexCacheTime);
	$arrCase = array_merge($arrCaseLists1,$arrCaseLists2);
	foreach($arrCase as $k=>$v){
		if(empty($v['model_id'])){
			unset($arrCase[$k]);
		}
	}
	foreach($arrCase as $v){
		$arrCaseLists[] = $v;
	}
	if(!$basic_config['css_auto_fit']){
		$arrCaseLists = array_merge(array($arrCaseLists[0]),$arrCaseLists);
		if(count($arrCaseLists)>9){
			unset($arrCaseLists[9]);
		}
	}
	$arrDynamicPlays = kekezu::get_feed ( "feedtype='work_accept'", "feed_time desc", 10 ); 
	$arrRecommShops = db_factory::query ( sprintf ( "select a.username,a.uid,b.indus_id,b.indus_pid,a.shop_name,if(b.seller_total_num>0,b.seller_good_num/b.seller_total_num,0) as good_rate from %switkey_shop a "
			." left join yw_company b on a.uid=b.userid  where b.recommend=1 and b.status=1 and IFNULL(a.is_close,0)=0 and shop_status=1 order by good_rate desc limit 0,6", TB_PRE ), 1, $intIndexCacheTime );
	$arrArticleTop = db_factory::get_one("select * from ".TB_PRE."witkey_article where cat_type='article' and  LENGTH(art_pic)>20 order by pub_time desc limit 1",1,$intIndexCacheTime);
	$arrArticleLists = db_factory::query("select * from ".TB_PRE."witkey_article where cat_type='article' and art_id !='".$arrArticleTop['art_id']."' order by pub_time desc limit 6",1,$intIndexCacheTime);
	$arrPubToday = db_factory::query("select count(*) as count from ".TB_PRE."witkey_task where date(from_unixtime(start_time)) = curdate() and task_status>=2",1,$intIndexCacheTime);
	$arrAcceptTask = db_factory::query("SELECT obj_id FROM ".TB_PRE."witkey_feed where obj_id>0 and feedtype='work_accept' and date(from_unixtime(feed_time)) = curdate() group by obj_id ; ",1,$intIndexCacheTime);
	$arrAcceptToday = count($arrAcceptTask);
	$arrCashToday = db_factory::query("SELECT sum(abs(amount)) as cash FROM ".TB_PRE."finance_record where (reason='task_bid' or reason='sale_service')  and date(from_unixtime(addtime)) = curdate()  ;",1,$intIndexCacheTime);
	$arrPubAll = db_factory::query("select count(*) as count from ".TB_PRE."witkey_task where task_status>=2",1,$intIndexCacheTime);
	$arrAcceptTasks = db_factory::query("SELECT obj_id FROM ".TB_PRE."witkey_feed where obj_id>0 and feedtype='work_accept'  group by obj_id  ;",1,$intIndexCacheTime);
	$arrAcceptAll = count($arrAcceptTasks);
	$arrCashAll = db_factory::query("SELECT sum(abs(amount)) as cash FROM ".TB_PRE."finance_record where (reason='task_bid' or reason='sale_service')  ;",1,$intIndexCacheTime);
	$arrFlink = kekezu::get_table_data("link_id,link_name,link_url,listorder",TB_PRE . "witkey_link",""," listorder asc","","","",$intIndexCacheTime);

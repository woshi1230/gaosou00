<?php
$objRss = new keke_rss_class ();
$objRss->title = $kekezu->_sys_config ['rss_title'];
$objRss->link = $kekezu->_sys_config ['website_url'];
$objRss->description = $kekezu->_sys_config ['rss_content'];
if ($kekezu->_sys_config ['rss_choice_task'] == '1') {
	$arrTask = db_factory::query ( sprintf ( "select * from %switkey_task where task_status>=2 order by task_id desc limit 10", TB_PRE ) );
	foreach ( $arrTask as $k => $v ) {
		$arrRss [$v ['start_time']] ['title'] = '[任务]' . $v ['task_title'];
		$arrRss [$v ['start_time']] ['link'] = $kekezu->_sys_config ['website_url'] . '/index.php?do=task&id=' . $v ['task_id'];
		$arrRss [$v ['start_time']] ['description'] = kekezu::cutstr ( kekezu::escape ( strip_tags ( htmlspecialchars_decode($v ['task_desc']) ) ), 100 ) . '...';
	}
}
if ($kekezu->_sys_config ['rss_choice_news'] == '1') {
	$arrAct = db_factory::query ( sprintf ( "select * from %switkey_article where cat_type = 'article' order by art_id desc limit 10", TB_PRE ) );
	foreach ( $arrAct as $k => $v ) {
		$arrRss [$v ['pub_time']] ['title'] = '[资讯]' . $v ['art_title'];
		$arrRss [$v ['pub_time']] ['link'] = $kekezu->_sys_config ['website_url'] . '/index.php?do=article&id=' . $v ['art_id'];
		$arrRss [$v ['pub_time']] ['description'] = kekezu::cutstr ( kekezu::escape ( strip_tags ( htmlspecialchars_decode($v ['content']) ) ), 100 ) . '...';
	}
}
  krsort ( $arrRss );
  $arr=array_slice($arrRss,0,10);
foreach ( $arr as $v ) {
	$objItem = new FeedItem ();
	$objItem->title = $v ['title'];
	$objItem->link = $v ['link'];
	$objItem->description = $v ['description'];
	$objRss->addItem ( $objItem );
} 
$objRss->saveFeed ( "RSS2.0", "data/index.xml" );
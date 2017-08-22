<?php defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
$strNavActive = 'articlelist';
$strUrl = $_K['siteurl']."/index.php?do=articlelist";
$catid and $strUrl .="&catid=".intval($catid);
$intPage and $strUrl .="&intPage=".$intPage;
$arrArtCats = kekezu::get_table_data ( "*", TB_PRE . "witkey_article_category", "cat_type='article' and art_cat_pid=1", "listorder asc", "", "", "", null );
$page and $intPage = intval($page);
$intPage = intval ( $intPage ) ? $intPage : 1;
$intPagesize = intval ( $intPagesize ) ? $intPagesize : 20;
intval($catid) and $intCatid = intval($catid) or $intCatid = intval($arrArtCats['0']['art_cat_id']);
$intCatid and $strWhere .= " and a.art_cat_id = ".intval($intCatid);
$strWhere.=" and a.is_show!=2";
$strWhere .=" order by is_recommend desc,a.listorder asc,pub_time desc";
$strSql = "select a.* ,b.cat_name from " . TB_PRE . "witkey_article a left join " . TB_PRE . "witkey_article_category b on a.art_cat_id=b.art_cat_id where b.cat_type='article'  $strWhere";
$strCsql = "select count(a.art_id) as c  from " . TB_PRE . "witkey_article a left join " . TB_PRE . "witkey_article_category b on a.art_cat_id=b.art_cat_id where b.cat_type='article'  $strWhere";
$intCount = intval ( db_factory::get_count ( $strCsql,0,NULL, 10*60 ) );
$kekezu->_page_obj->setStatic($static);
$strPages = $kekezu->_page_obj->getPages ( $intCount, $intPagesize, $intPage, $strUrl );
$arrArticleLists = db_factory::query ( $strSql . $strPages ['where'], 5*60 );
foreach($arrArtCats as $k=>$v){
	intval($v['art_cat_id']) == $intCatid and $articleType = $v['cat_name'];
}
list($strPageTitle,$strPageKeyword,$strPageDescription) =  keke_seo_class::getListSEO(0, 0, array('资讯分类'=>$articleType),'article',true);
$arrHotNews = db_factory::query("select * from ".TB_PRE."witkey_article where cat_type='article'  order by views desc limit 10");
$arrRecommShops = db_factory::query ( sprintf ( "select a.username,a.uid,b.indus_id,b.indus_pid,a.shop_name,if(b.seller_total_num>0,b.seller_good_num/b.seller_total_num,0) as good_rate from %switkey_shop a "
		." left join yw_company b on a.uid=b.userid  where b.recommend=1 and b.status=1 and IFNULL(a.is_close,0)=0 and shop_status=1 order by  good_rate desc limit 0,5", TB_PRE ), 1, $intIndexCacheTime );
$_SESSION['spread'] = 'index.php?do=articlelist';
$sql = "SELECT uid,username,area,count(*) as sum FROM ".TB_PRE."witkey_task_bid GROUP BY username ORDER BY sum DESC LIMIT 0,5";
$arrBid = db_factory::query($sql);
<?php defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
if($id){
	$intId = intval($id);
	$intId and $arrArtInfo = db_factory::get_one(sprintf("select * from %switkey_article where art_id='%d'",TB_PRE,$intId));
}
if($arrArtInfo){
	if(!$_COOKIE["article_".$intId]){
		$strSqlPlus = "update %switkey_article set views = views+1 where art_id = %d";
		db_factory::execute(sprintf($strSqlPlus,TB_PRE,$intId));
	}
	setcookie("article_".$intId,"exist_".$intId,time()+3600*24, COOKIE_PATH, COOKIE_DOMAIN,NULL,TRUE );
	$strPageTitle=$arrArtInfo['art_title'].$arrArtInfo['seo_title'].'- '.$_K['html_title'];
	$strPageKeyword = $arrArtInfo['seo_keyword'];
	$strPageDescription = $arrArtInfo['seo_desc'];
}else{
	kekezu::show_msg(kekezu::lang("operate_notice"),"index.php",2,"系统繁忙，找不到您要的内容","warning");
}
$_SESSION['spread'] = 'index.php?do=single&id='.intval($id);
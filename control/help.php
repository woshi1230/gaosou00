<?php
require 'common.inc.php';
$moduleid = 99;
$module = '';

$arrSidesPrimary  = db_factory::get_table_data('*','yw_category','moduleid=' . $moduleid . ' and parentid=(SELECT catid FROM ywb2b.yw_category where moduleid=' . $moduleid . ' and catname=\'用户帮助\')','listorder asc ','','','catid',3600);
$arrSecondary     = db_factory::get_table_data('*','yw_category','moduleid=' . $moduleid . ' and arrparentid>=(SELECT concat(\'0,\',catid) FROM ywb2b.yw_category where moduleid=' . $moduleid . ' and catname=\'用户帮助\')',' listorder asc ','','','catid',3600);
$arrLastsHelp = db_factory::query('SELECT `itemid`,`catid`,`title` FROM `'.'yw_help` WHERE areaid = "1" ORDER BY itemid desc LIMIT 0,5');
$arrCommonHelp = db_factory::query('SELECT `itemid`,`catid`,`title` FROM `'.'yw_help` WHERE areaid = "1" ORDER BY hits desc LIMIT 0,5');
$arrHotSearch = array (
		'发布任务','认证','提现','充值','发布商品'
);
$id and $id = intval($id);
$Keyword =  strval(trim($word));
$strUrl ="index.php?do=help";
$id and $strUrl .="&id=".intval($id);
$intPage and $strUrl .="&intPage=".intval($intPage);
$intPagesize and $strUrl .="&intPagesize=".intval($intPagesize);
	$objArticleT = keke_table_class::get_instance('help');
	$strWhere .= " areaid = '1' ";
	$page and $intPage = intval($page);
	$intPage = intval ( $intPage ) ? $intPage : 1;
	$intPagesize = intval ( $intPagesize ) ? $intPagesize : 15;
	$id&&$id!='' and $strWhere .= " and catid=".intval($id);
	$Keyword and $strWhere .= " and ( title like '%".trim($Keyword)."%'  or content like '%".trim($Keyword)."%' )";
	$strWhere .= " order by itemid";
	$arrDatas = $objArticleT->get_grid ( $strWhere, $strUrl, $intPage, $intPagesize, null,null,null);
	$arrLists = $arrDatas ['data'];
	$intCount = $arrDatas ['count'];
	$strPages = $arrDatas ['pages'];
unset($objArticleT);
//if($id){
//	$arrHelpKerword = db_factory::get_one("select art_cat_pid from yw_category where catid = ".intval($id));
//	$arrHelpKerword = db_factory::get_one("select seo_title, seo_keyword,seo_desc from ".TB_PRE.'witkey_article_category where art_cat_id = '.intval($arrHelpKerword['art_cat_pid']));
//}else{
//	$arrHelpKerword = db_factory::get_one("select art_cat_pid from ".TB_PRE.'witkey_article_category where art_cat_id = 100');
//}
$strPageTitle = '帮助中心-';//.$arrHelpKerword['seo_title'].'-'.$kekezu->_sys_config['website_name'];
$strPageKeyword = '帮助中心-';//.$arrHelpKerword['seo_keyword'].'-'.$kekezu->_sys_config['website_name'];
$strPageDescription = '帮助中心-';//.$arrHelpKerword['seo_desc'].'-'.$kekezu->_sys_config['website_name'];
$_SESSION['spread'] = 'index.php?do=help';
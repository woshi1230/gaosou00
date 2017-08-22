<?php
//if (isset($catid)) unset($catid);
$url = '';

if (!defined('DT_ROOT')) {
    define('DT_ADMIN', true);
    define('DT_MEMBER', true);

    $DTROOT =  str_replace("\\", '/', dirname(__FILE__));
    $moduleid = 21;
    require $DTROOT.'/../../common.inc.php';
    unset($DTROOT);

    if($DT_BOT) dhttp(403);

    require DT_ROOT.'/admin/global.func.php';
    require DT_ROOT.'/admin/license.func.php';
    require DT_ROOT.'/include/post.func.php';
    require_once DT_ROOT.'/include/cache.func.php';
    isset($file) or $file = 'index';

    $psize = isset($psize) ? intval($psize) : 0;
    if($psize > 0 && $psize != $pagesize) {
        $pagesize = $psize;
        $offset = ($page-1)*$pagesize;
    }
}
$moduleid = 99;

if ((isset($_POST) && isset($_POST['action']))) {
    $action = $_POST['action'];
} else if ((isset($_GET) && isset($_GET['action']))) {
    $action = $_GET['action'];
} else if ((isset($_GET) && isset($_GET['sub_action']))) {
    $action = $_GET['sub_action'];
} else {
    $action = $sub_action;
}
$module = 'doc';

$MOD = array (
    'fee_currency' => 'money',
    'fee_mode' => '1',
    'question_add' => '2',
    'captcha_add' => '2',
    'check_add' => '2',
    'group_color' => '6,7',
    'group_search' => '3,5,6,7',
    'group_show' => '3,5,6,7',
    'group_list' => '3,5,6,7',
    'group_index' => '3,5,6,7',
    'seo_description_show' => '',
    'seo_keywords_show' => '',
    'seo_title_show' => '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}',
    'seo_description_list' => '',
    'seo_keywords_list' => '',
    'seo_title_list' => '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}',
    'seo_description_index' => '',
    'seo_keywords_index' => '',
    'seo_title_index' => '{模块名称}{分隔符}{页码}{网站名称}',
    'php_item_urlid' => '0',
    'htm_item_urlid' => '1',
    'htm_item_prefix' => '',
    'show_html' => '0',
    'php_list_urlid' => '0',
    'htm_list_urlid' => '0',
    'htm_list_prefix' => '',
    'list_html' => '0',
    'index_html' => '0',
    'show_np' => '1',
    'max_width' => '550',
    'page_shits' => '10',
    'page_srec' => '10',
    'page_srecimg' => '4',
    'page_srelate' => '10',
    'page_lhits' => '10',
    'page_lrec' => '10',
    'page_lrecimg' => '4',
    'show_lcat' => '1',
    'page_child' => '6',
    'pagesize' => '20',
    'page_ihits' => '10',
    'page_irecimg' => '6',
    'page_icat' => '6',
    'show_icat' => '1',
    'page_islide' => '3',
    'swfu' => '2',
    'level' => '',
    'fulltext' => '1',
    'split' => '0',
    'keylink' => '1',
    'clear_link' => '0',
    'cat_property' => '0',
    'save_remotepic' => '0',
    'fields' => 'itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,islink',
    'editor' => 'Default',
    'order' => 'addtime desc',
    'introduce_length' => '120',
    'thumb_height' => '90',
    'thumb_width' => '120',
    'template_my' => '',
    'template_search' => '',
    'template_show' => '',
    'template_list' => '',
    'template_index' => '',
    'fee_add' => '0',
    'fee_view' => '0',
    'fee_period' => '0',
    'fee_back' => '0',
    'pre_view' => '500',
    'credit_add' => '2',
    'credit_del' => '5',
    'credit_color' => '100',
    'title_index' => '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}',
    'title_list' => '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}',
    'title_show' => '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}',
    'keywords_index' => '',
    'keywords_list' => '',
    'keywords_show' => '',
    'description_index' => '',
    'description_list' => '',
    'description_show' => '',
    'module' => 'doc',
    'moduleid' => '99',
    'name' => '文档',
    'moduledir' => 'doc',
    'ismenu' => '1',
    'domain' => '',
    'linkurl' => 'http://localhost/ywb2b/doc/',
);

include DT_ROOT.'/module/doc/common.inc.php';
(include MD_ROOT.'/admin/index.inc.php') or msg();
?>
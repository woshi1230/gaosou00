<?php defined ( 'IN_KEKE' ) or exit('Access Denied');
$views = array('upload','district','industry','captcha','message','follow','favorite','banner','spread','changecss','im','chooseday','balance','getZfpwd','baidumap','yijia');
in_array($view,$views) or $view ="index";
require $do.'/'.$view.'.php';
require  $kekezu->_tpl_obj->template( $do.'/'.$view);die();
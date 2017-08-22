<?php
if($_K['css_auto_fit']){
    $_K['sitecss'] .= '-responsive'; 
}
if($do=='user'){
    $css = '<link href="'.DT_STATIC.'skin/default/k_css/user.css" rel="stylesheet" type="text/css" id="active-style-user">';
}elseif($do=='seller'){
    $css = '<link href="'.DT_STATIC.'skin/default/k_css/store.css" rel="stylesheet" type="text/css" id="active-style-store">';
}elseif($do=='index'){
    $css = '<link href="'.DT_STATIC.'static/js/jqplugins/fotorama/fotorama.css" rel="stylesheet" type="text/css">';
    $css.='<link href="'.DT_STATIC.'skin/default/k_css/home.css" rel="stylesheet" type="text/css" id="active-style-home">';
}else{
//		$css='<link href="'.DT_STATIC.'skin/default/k_css/newStyle1.css" rel="stylesheet" type="text/css" id="active-style1">';
//		$css .='<link href="'.DT_STATIC.'skin/default/k_css/newStyle2.css" rel="stylesheet" type="text/css" id="active-style2">';
    $css .='<link href="'.DT_STATIC.'skin/default/task.css" rel="stylesheet" type="text/css">';
}echo($css);

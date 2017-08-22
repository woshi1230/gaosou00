<?php
 if($op=='change'){
 	$objBasicConfig = new Keke_witkey_basic_config_class ();
 	$objBasicConfig->setWhere ( "k = 'sitecss'" );
 	$objBasicConfig->setV (kekezu::k_input($css));
 	$res = $objBasicConfig->edit_keke_witkey_basic_config ();
 	$_SESSION ['showcolor'] = strval($color);
 	if($res){
       kekezu::echojson('',1,'');
 	}
}
die();
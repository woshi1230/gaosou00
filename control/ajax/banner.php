<?php
$arrSellerInfo = db_factory::get_one(sprintf('select * from %s a left join %s b on a.userid = b.uid where a.userid =%s','yw_company',TB_PRE.'witkey_shop',intval($id)));
if($arrSellerInfo['shop_backstyle']){
	$arrBackgroudStyle = unserialize($arrSellerInfo['shop_backstyle']);
}
$arr = array();
if($_R['a']==1){
	$arr['shop_background']="";
	db_factory::updatetable(TB_PRE."witkey_shop", $arr, "uid=".intval($_R['id']));
	kekezu::show_msg('已清除','index.php?do=seller&id='.intval($id),NULL,NULL,'ok');
}elseif($_R['a']==2){
    $arr['banner']="";
    db_factory::updatetable(TB_PRE."witkey_shop", $arr, "uid=".intval($_R['id']));
    kekezu::show_msg('已清除','index.php?do=seller&id='.intval($id),NULL,NULL,'ok');
}
if (isset($formhash)&&kekezu::submitcheck($formhash)) {
	$shopObjT = keke_table_class::get_instance ( 'witkey_shop' );
	$banner and $arrFields['banner'] = $banner;
	$background and $arrFields['shop_background'] = $background;
	$repeat and  $arrBackgroudStyle['repeat']= $repeat;
	$position and $arrBackgroudStyle['position']= $position;
	is_array($arrBackgroudStyle) and $arrFields['shop_backstyle'] = serialize($arrBackgroudStyle);
	$shopObjT->save($arrFields,array('uid'=>intval($id)));
	kekezu::show_msg('已保存','index.php?do=seller&id='.intval($id),NULL,NULL,'ok');
}

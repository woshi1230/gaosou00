<?php
/**
 * Created by PhpStorm.
 * User: xuanke
 * Date: 2016/1/9
 * Time: 13:31
 */
$obj_id = intval($obj_id);
$strUrl = "index.php?do=user&view=transaction&op=downserverfile";
/**
 * 获取作品的文件信息
 */
if($obj_id){
    $serviceInfo = db_factory::get_one('select * from '.TB_PRE.'witkey_service where service_id='.$obj_id);
    $file_path = $serviceInfo['file_path'];
    $arrFile_path = explode('|',$file_path);
    foreach($arrFile_path as $v){
        $info = db_factory::query ( 'select file_name,save_name from ' . TB_PRE . 'witkey_file where save_name ="' . $v . '"' );
        $arrFileLists[] = $info[0];
    }

    require  $kekezu->_tpl_obj->template($do.'/'.$view.'_'.$op);die;
}
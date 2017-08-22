<?php
$intWorkId = intval($workId);
$intTaskId = intval($taskId);
$strUrl ="index.php?do=user&view=transaction&op=downworkfile";
if($intTaskId&&$intWorkId){
	$strWorkSql = 'select * from '.TB_PRE.'witkey_task_work where task_id = '.$intTaskId.' and work_id='.$intWorkId;
	$arrWorkInfo = db_factory::get_one($strWorkSql);
	if($arrWorkInfo['uid'] !=$gUid){
		exit('禁止未授权访问');
	}
}
$arrFileLists = CommonClass::getFileArray(',', $arrWorkInfo['work_file']);
if(is_array($arrFileLists)){
    foreach($arrFileLists as $k=>$v){
        $path = S_ROOT.$v['save_name'];
        $path_parts = pathinfo($path);
        $arrFileLists[$k]['type'] = $path_parts['extension'];
    }
}
require  $kekezu->_tpl_obj->template($do.'/'.$view.'_'.$op);die;
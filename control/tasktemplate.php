<?php
$arr_task_template = db_factory::query ( "select * from " . TB_PRE . "witkey_task_template" );
if($arr_task_template){
	foreach ($arr_task_template as $k=>$v){
		$arr_task_template[$k]['template_content'] = htmlspecialchars_decode($v['template_content']);
	}
}

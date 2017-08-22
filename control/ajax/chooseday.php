<?php
	$id=intval($id);
	$txt_task_cash=floatval($txt_task_cash);
	$model_detail=Keke_witkey_model_class::get_one("select * from ".TB_PRE."witkey_model where model_id = $id", $id);
	$model_detail_config=unserialize($model_detail['config']);
	if(floatval($model_detail_config[min_cash])>floatval($txt_task_cash)){
		echo "你的预算不能少于￥$model_detail_config[min_cash]元";die;
	}
	$task_time=db_factory::query("select * from ".TB_PRE."witkey_task_time_rule where model_id = $id");
	$task_time_num=count($task_time);
	$num=$task_time_num-1;
	for($i=$num;$i>=0;$i--){
		if(floatval($task_time[$i][rule_cash])<=$txt_task_cash){
			echo "<a href=javascript:clicktime();>".$txt_task_cash."元的任务最大发布时间为".$task_time[$i][rule_day]."天</a>";die;
		}
	}
	$objRelease = sreward_release_class::get_instance ($id,$pub_mode);
	$currentday=date("Y-m-d",time());
	$strMaxDay = $objRelease->getMaxDay ( $txt_task_cash );
	$day=strtotime($strMaxDay)-strtotime($currentday);
	$day=$day/3600/24;
	echo "<a href=javascript:clicktime();>".$txt_task_cash."元的任务最大发布时间为".$day."天</a>";die;
	die;

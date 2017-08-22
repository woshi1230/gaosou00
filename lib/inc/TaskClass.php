<?php
class TaskClass {
	public static function getTaskCashCove(){
		return kekezu::get_table_data ( "*", TB_PRE . "witkey_task_cash_cove", "", "", "", "", "cash_rule_id" );
	}
	public static function getEnabledTaskModelList(){
//		return db_factory::get_table_data('*',TB_PRE . 'witkey_model',' model_status = 1 and model_type = "buy" ',' listorder asc','','','model_id',3600);
		return Keke_witkey_model_class::query("*");
	}
	public static function getWorkServers($taskId,$model_id){
	  $arrResult=array();
	  $taskId=intval($taskId);
	  switch (intval($model_id)){
	  	case 2:
	  		$arrResult['WorkWikiTotal']=db_factory::execute("select distinct uid,work_id,task_id from ".TB_PRE."witkey_task_work where task_id=".$taskId." group by uid order by work_id");
	  		$arrResult['WorkBidWikiTotal']=db_factory::execute("select distinct uid,work_id,task_id from ".TB_PRE."witkey_task_work where task_id=".$taskId." and (work_status=1 or work_status=2 or work_status=3) group by uid order by work_id");
	  		break;
	  	case 3:
	  		$arrResult['WorkWikiTotal']=db_factory::execute("select distinct uid,work_id,task_id from ".TB_PRE."witkey_task_work where task_id=".$taskId." group by uid order by work_id");
	  		$arrResult['WorkBidWikiTotal']=db_factory::execute("select distinct uid,work_id,task_id from ".TB_PRE."witkey_task_work where task_id=".$taskId." and work_status=6 group by uid order by work_id");
	  		break;	
	  	case 1:
	  	case 6:
	  	case 15:
	  		$arrResult['WorkWikiTotal']=db_factory::execute("select distinct uid,work_id,task_id from ".TB_PRE."witkey_task_work where task_id=".$taskId." group by uid order by work_id");
	  		$arrResult['WorkBidWikiTotal']=db_factory::execute("select distinct uid,work_id,task_id from ".TB_PRE."witkey_task_work where task_id=".$taskId." and work_status=4 group by uid order by work_id");
	  	break;
	  	case 16:
	  		$arrResult['WorkWikiTotal']=db_factory::execute("select distinct uid,work_id,task_id from ".TB_PRE."witkey_task_work where task_id=".$taskId." group by uid order by work_id");
	  		$arrResult['WorkBidWikiTotal']=db_factory::execute("select distinct uid,work_id,task_id from ".TB_PRE."witkey_task_work where task_id=".$taskId." and work_status=4 group by uid order by work_id");
	  	break;
	  	case 4:
	  	case 5:
	  		$arrResult['WorkWikiTotal']=db_factory::execute("select distinct uid,bid_id,task_id from ".TB_PRE."witkey_task_bid where task_id=".$taskId." group by uid order by bid_id");
	  		$arrResult['WorkBidWikiTotal']=db_factory::execute("select distinct uid,bid_id,task_id from ".TB_PRE."witkey_task_bid where task_id=".$taskId." and bid_status=4 group by uid order by bid_id");
	  		break;
	  }
	  return $arrResult;
	}
    public static function getWikiDealbyUid($uid){
    	$intDeals = db_factory::execute(sprintf('SELECT * FROM `'.TB_PRE.'finance_record` where to_days( NOW( ) ) - to_days( FROM_UNIXTIME( addtime ) ) <=90  and amount>0 and (reason="sale_service" or reason="task_bid" or reason="sale_gy") and uid = %d',intval($uid)));
    	return $intDeals;
    }
    public static function getTaskname($taskId){
    	$arrRuselt=db_factory::get_one("select * from ".TB_PRE."witkey_task where task_id='{$taskId}'");
    	return $arrRuselt['task_title'];
    }
}

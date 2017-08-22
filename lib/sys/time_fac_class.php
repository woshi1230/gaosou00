<?php
class time_fac_class {
	protected $_basic_config;
	function __construct() {
		global $kekezu;
		$this->_basic_config = $kekezu->_sys_config;
	}
	function run() {
		global $_K, $kekezu;
		$shop_time = new goods_time_class();
		$shop_time->validtaskstatus();
		$this->validautoMail();
//		$model_list = $model_list ? $model_list : kekezu::get_table_data ( '*',TB_PRE . 'witkey_model', 'model_status=1', '', null,'', 'model_id' );
		$model_list = $model_list ? $model_list : Keke_witkey_model_class::query("*");

		$this->task_finish_auto_mark();
		foreach ( $model_list as $model_info ) {
			$model_dir = $model_info ['model_code'];
			if (file_exists ( S_ROOT . "./task/$model_dir" ))
				$m = strtolower ( $model_dir ) . "_time_class";
			if (class_exists ( $m )) {
				$time_obj = new $m ();
				$time_obj->validtaskstatus ();
			}
		}
		keke_task_class::hp_timeout(7);
	}
	function task_finish_auto_mark(){
		$nomark_wk_list = db_factory::query(sprintf('select `mark_id` from %switkey_mark where mark_status=0 and mark_max_time<%d and mark_type=1',TB_PRE,time()));
		if(is_array($nomark_wk_list)){
			foreach ($nomark_wk_list as $v){
				keke_user_mark_class::exec_mark_process($v['mark_id'],null,1,"4,5","5.0,5.0");
			}
		}
		$nomark_gz_list = db_factory::query(sprintf('select `mark_id` from %switkey_mark where  mark_status=0 and mark_max_time<%d and mark_type=2',TB_PRE,time()));
		if(is_array($nomark_gz_list)){
			foreach ($nomark_gz_list as $v){
				keke_user_mark_class::exec_mark_process($v['mark_id'],null,1,"1,2,3","5.0,5.0,5.0");
			}
		}
	}
	function validautoMail(){
		$path = S_ROOT . "/data/data_cache/auto_mail.php";
		if(file_exists($path)){
			$validautoMail=getfile($path);
			if(intval($validautoMail['time'])<time()){
				$this->auto_mail();
			}
		}
	}
	function auto_mail(){
		$path = S_ROOT . "/data/data_cache/auto_mail.php";
		$arr_auto_mail=getfile($path);
		if($arr_auto_mail['is_open']=='1'){
			$authlist=trim($arr_auto_mail['authlist'],",");
			$arrauth=explode(",", $authlist);
			if($authlist){
				if(count($arrauth)==1 or (count($arrauth)==2 && strstr($authlist,"realname"))){
					$sql="select uid from ".TB_PRE."witkey_auth_record where 1=1";
					if(strstr($authlist,"realname")){
						$sql.="  and auth_code=('realname' or auth_code='enterprise') and auth_status=1 ";
					}elseif(strstr($authlist,"bank")){
						$sql.="  and auth_code='bank' and auth_status=1 ";
					}elseif(strstr($authlist,"email")){
						$sql.="  and auth_code='email' and auth_status=1 ";
					}else{
						$sql.="  and auth_code='mobile' and auth_status=1 ";
					}
				}else{
					$sql="select uid from ".TB_PRE."witkey_auth_record where 1=1";
					if(strstr($authlist,"realname")){
						$sql.=" and (auth_code='realname' or auth_code='enterprise') and auth_status=1 ";
					}
					if(strstr($authlist,"bank")){
						if(strstr($authlist,"enterprise") || strstr($authlist,"realname")){
							$sql.=" and uid in (select uid from ".TB_PRE."witkey_auth_record where auth_code='bank' and auth_status=1 )";
						}else{
							$sql.="  and auth_code='bank' and auth_status=1 ";
						}
					}
					if(strstr($authlist,"email")){
						if(strstr($authlist,"enterprise") || strstr($authlist,"realname") || strstr($authlist,"bank")){
							$sql.=" and uid in (select uid from ".TB_PRE."witkey_auth_record where auth_code='email' and auth_status=1 )";
						}else{
							$sql.="  and auth_code='email' and auth_status=1 ";
						}
					}
					if(strstr($authlist,"mobile")){
						$sql.=" and uid in (select uid from ".TB_PRE."witkey_auth_record where auth_code='mobile' and auth_status=1 )";
					}
				}
				$authArr=db_factory::query($sql);
			}
			$renwulist=trim($arr_auto_mail['renwulist'],",");
			if($renwulist){
				if($authArr){
					foreach($authArr as $v){
						$authstr.=$v['uid'].",";
					}
					$authstr=trim($authstr,",");
					if(strstr($renwulist,"1") && strstr($renwulist,"2")){
						$taskstr="";
						$taskArr=db_factory::query("select distinct uid from ".TB_PRE."witkey_task where uid in ($authstr)");
						foreach($taskArr as $v){
							$taskstr.=$v['uid'].",";
						}
						$taskstr=trim($taskstr,",");
						if($taskstr){
							$allArr=db_factory::query("select uid from ".TB_PRE."witkey_task_work union select uid from ".TB_PRE."witkey_task_bid where uid in ($taskstr)");
						}
					}elseif(strstr($renwulist,"1")){
						if($authstr){
							$allArr=db_factory::query("select distinct uid from ".TB_PRE."witkey_task where uid in ($authstr)");
						}
					}else{
						if($authstr){
							$allArr=db_factory::query("select uid from ".TB_PRE."witkey_task_work union select uid from ".TB_PRE."witkey_task_bid where uid in ($authstr)");
						}
					}
				}else{
					if(strstr($renwulist,"1") && strstr($renwulist,"2")){
						$workstr="";
						$workArr=db_factory::query("select uid from ".TB_PRE."witkey_task_work union select uid from ".TB_PRE."witkey_task_bid");
						foreach($workArr as $v){
							$workstr.=$v["uid"].",";
						}
						$workstr=trim($workstr,",");
						if($workstr){
							$allArr=db_factory::query("select distinct uid from ".TB_PRE."witkey_task where uid in($workstr)");
						}
					}elseif(strstr($renwulist,"1")){
						$allArr=db_factory::query("select distinct uid from ".TB_PRE."witkey_task");
					}else{
						$allArr=db_factory::query("select uid from ".TB_PRE."witkey_task_work union select uid from ".TB_PRE."witkey_task_bid");
					}
				}
			}
			$time=time();
			$tiantime=$arr_auto_mail['tian']*60*60*24;
			if($allArr){
				$allstr="";
				foreach($allArr as $v){
					$allstr.=$v['uid'].",";
				}
				$allstr=trim($allstr,",");
				$userInfoArr=db_factory::query("select * from yw_company where $time-last_login_time>$tiantime and userid in ($allstr)");
				foreach($userInfoArr as $v2){
					if(!$v2[is_mail]){
						if($v2[email]){
							kekezu::send_mail ($v2[email],$arr_auto_mail['title'],htmlspecialchars_decode(stripslashes($arr_auto_mail['content'])));
							db_factory::execute("update yw_company set is_mail=1 where userid=".intval($v2[uid]));
						}elseif($v2[qq]){
							kekezu::send_mail ($v2[qq],$arr_auto_mail['title'],htmlspecialchars_decode(stripslashes($arr_auto_mail['content'])));
							db_factory::execute("update yw_company set is_mail=1 where userid=".intval($v2[uid]));
						}
					}
				}
			}
			if(!$allArr && $authlist){
				foreach($authArr as $v){
					$authstr.=$v['uid'].",";
				}
				$authstr=trim($authstr,",");
				$userInfoArr=db_factory::query("select * from yw_company where $time-last_login_time>$tiantime and userid in ($authstr)");
				foreach($userInfoArr as $v2){
					if(!$v2[is_mail]){
						if($v2[email]){
							kekezu::send_mail ($v2[email],$arr_auto_mail['title'],htmlspecialchars_decode(stripslashes($arr_auto_mail['content'])));
							db_factory::execute("update yw_company set is_mail=1 where userid=".intval($v2[uid]));
						}elseif($v2[qq]){
							kekezu::send_mail ($v2[qq],$arr_auto_mail['title'],htmlspecialchars_decode(stripslashes($arr_auto_mail['content'])));
							db_factory::execute("update yw_company set is_mail=1 where userid=".intval($v2[uid]));
						}
					}
				}
			}
			$arr_auto_mail['time']=time()+86400;
			file_put_contents ($path, "<?php      return ".$arr_auto_mail.";");
		}
	}
}
function getfile($dataPath){
	return include $dataPath;
}
?>
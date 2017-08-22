<?php
keke_lang_class::load_lang_class('keke_glob_class');
class keke_glob_class {
	public static function get_finance_action() {
		global $_lang;
		return array (
				"buy_service" => $_lang ['buy_service'],
				"buy_gy" => '雇佣服务',
				"pub_task" => $_lang ['task_pub'],
				"hosted_reward" => $_lang ['hosted_reward'],
				"withdraw" => $_lang ['withdraw'],
				"task_delay" => $_lang ['task_delay'],
				"ext_cash" => $_lang ['ext_cash'],
				"offline_charge" => $_lang ['offline_recharge'],
				"task_bid" => $_lang ['task_bid'],
				"task_fail" => $_lang ['task_fail'],
				"task_prom_fail" => $_lang ['task_prom_fail'],
				"sale_service" => $_lang ['sale_service'],
				"sale_gy" => '出售雇佣服务',
				"admin_recharge" => $_lang ['admin_recharge'],
				"withdraw_fail" => $_lang ['withdraw_fail'],
				"report" => $_lang ['report_processs'],
				"payitem" => $_lang ['payitem'],
				"prom_reg" => $_lang ['prom_reg'],
				"task_fj" => $_lang ['task_fj'],
				'rights_return' => $_lang ['rights_return'],
				"task_auto_return" => $_lang ['task_auto_return'],
				'order_cancel' => $_lang ['order_cancel'],
				"online_charge" => $_lang ['online_charge'],
				"order_charge" => $_lang ['order_charge'],
				'prom_pub_task' => $_lang ['prom_pub_task'],
				'user_charge' => $_lang ['user_charge'],
				'prom_bid_task' => $_lang ['prom_bid_task'],
				'prom_service' => $_lang ['prom_service'],
				'prom_bank_auth' => $_lang ['prom_bank_auth'],
				'prom_realname_auth' => $_lang ['prom_realname_auth'],
				'prom_email_auth' => $_lang ['prom_email_auth'],
				'prom_mobile_auth' => $_lang ['prom_mobile_auth'],
				'prom_enterprise_auth' => $_lang ['prom_mobile_auth'],
				'enterprise_auth' => $_lang ['enterprise_auth'],
				'task_remain_return' => $_lang ['task_remain_return'],
				'task_hosted_return' => $_lang ['task_hosted_return'],
				'admin_charge' => $_lang ['admin_charge'],
				'host_deposit' => $_lang ['host_deposit'],
				'deposit_return' => $_lang ['deposit_return'],
				'host_return' => $_lang ['host_return'],
				'cancel_bid' => '撤销中标',
				'host_split' => $_lang ['host_split'],
				"workhide" => $_lang ['workhide'] . '退款',
				"seohide" => $_lang ['seohide'] . '退款',
				"tasktop" => $_lang ['task_top'] . '退款',
				"goodstop" => $_lang ['goods_top'] . '退款',
				"urgent" => $_lang ['task_urgent'] . '退款',
				"finish_task"=>'完成福袋任务',
				"task_xg"=>'任务返还金额',
		);
	}
	public static function get_value_add_type(){
		global $_lang;
			return array ( "workhide" => $_lang['workhide'],
			               "seohide" => $_lang['seohide'],
			               "tasktop" => $_lang['task_top'],
			               "goodstop" => $_lang['goods_top'],
			               "urgent" => $_lang['task_urgent']);
	}
	public static function get_payitem_type(){
		global $_lang;
		return array("task"=>$_lang['task_pub'],"work"=>$_lang['witkey_submit'],"task_service"=>kekezu::lang(task_pub_goods_pub));
	}
	public static function withdraw_status(){
		global $_lang;
		return array("1"=>$_lang['wait_audit'],"2"=>$_lang['has_success'],"3"=>$_lang['has_fail']);
	}
	public static function get_message_send_type(){
		global $_lang;
		return array(
			   array("1"=>"send_sms",
		             "2"=>"send_email",
		             "3"=>"send_mobile_sms"
		             ),
				array("send_sms"=>$_lang['site_msg'],
		             "send_email"=>$_lang['send_email'],
		             "send_mobile_sms"=>$_lang['send_mobile_sms']
		             )
		);
	}
	public static function get_message_send_obj(){
		global $_lang;
		return array("task"=>$_lang['task'],"service"=>$_lang['goods'],"space"=>$_lang['space'],"user"=>$_lang['user'],"found"=>$_lang['funds'],'safe'=>$_lang['safe'],"trans"=>$_lang['rights']);
	}
	public static function get_feed_type(){
		global $_lang;
		return array("pub_task"=>$_lang['pub_task'],
		"join_work"=>$_lang['join_work'],
		"task_pay"=>$_lang['pay_task_cost'],
		"task_prom"=>$_lang['from_prom_task'],
		"vip"=>$_lang['become_vip'],
		"withdraw"=>$_lang['withdraw'],
		"work_accept"=>$_lang['task_bid'],
		"work_delay"=>$_lang['task_delay'],
		"add_service"=>$_lang['create_service'],
		'user_index'=>$_lang['website_feed'],
		"user_talent"=>$_lang['lastest_user_feed'],
		"index_all"=>$_lang['taking_place_in'],
		"bank_auth"=>$_lang['bank_auth'],
		"pub_work"=>$_lang['pub_work'],
		"pub_service"=>$_lang['pub_service'],
		"service"=>$_lang['buy_service'],
		"realname_auth"=>$_lang['realname_auth'],
		"enterprise_auth"=>$_lang['enterprise_auth'],
		"email_auth"=>$_lang['email_auth'],
		"weibo_auth"=>$_lang['weibo_auth'],
		"realname_auth"=>$_lang['realname_auth'],
		"task_pay"=>$_lang['get_commission'],
		"default"=>$_lang['default']);
	}
	public static function get_event_status() {
		global $_lang;
		return array ("0" => $_lang['has_grant'], "1" => $_lang['not_grant'])
		;
	}
    public static function get_tag_type() {
    	global $_lang;
		return array (
		"5" =>array("1"=>$_lang['self_defined_code'],"2"=>"autocode"),
		)
		;
	}
	public static function get_open_api(){
		global $_lang;
		$r = array(
		'qq'=>array('name'=>'腾讯QQ','ico'=>'qq'),
		'wx'=>array('name'=>'微信','ico'=>'wx'),
		'sina'=>array('name'=>'新浪微博','ico'=>'sina'),
		'baidu'=>array('name'=>'百度','ico'=>'baidu'),
		'taobao'=>array('name'=>'淘宝','ico'=>'taobao'),
		'douban'=>array('name'=>'豆瓣','ico'=>'douban'),
		'renren'=>array('name'=>'人人','ico'=>'renren')
	);
		return $r;
	}
	public static function get_bank(){
		global $_lang;
		 return array (
		 'aboc' => $_lang['aboc'],
		 'ccb' => $_lang['ccb'],
		 'icbc' =>$_lang['icbc'],
		 'cmb' => $_lang['cmb'],
		 'bocm' => $_lang['bocm'],
		 'spdb' => $_lang['spdb'],
		 'cmbc' => $_lang['cmbc'],
		 'ccb' => $_lang['ccb'],
		 'psbc' => $_lang['psbc'],
		 'cib' => $_lang['cib'],
		 'huaxia_bank' => $_lang['huaxia_bank'],
		 'boc'=>$_lang['boc'],
		 );
	}
	public static function get_online_pay(){
		global $_lang;
		return array(
			'alipaydual'=>$_lang['alipayjs'].'双功能',
			'alipayjs'=>$_lang['alipayjs'],
			'chinabank'=>$_lang['chinabank'],
			'paypal'=>$_lang['paypal'],
			'tenpay'=>$_lang['tenpay'],
			'wxpay'=>'微信支付',
		);
	}
	public static function get_model_type(){
		global $_lang;
		return array("mreward"=>$_lang['more_reward'],"preward"=>$_lang['piece_reward'],"sreward"=>$_lang['single_reward'],"dtender"=>$_lang['deposit_tender'],"tender"=>$_lang['normal_tender'],"goods"=>$_lang['witkey_goods'],"service"=>$_lang['witkey_service'],"match"=>$_lang['match'],'wbzf'=>$_lang['wbzf'],'wbdj'=>$_lang['wbdj'],'taobao'=>$_lang['taobao']);
	}
	public static function get_charge_type(){
		global $_lang;
		return array("online_charge"=>$_lang['online_recharge'],"offline_charge"=>$_lang['offline_recharge']);
	}
	public static function get_fina_charge_type(){
		global $_lang;
		return array("user_charge"=>$_lang['online_recharge'],
					 "offline_charge"=>$_lang['offline_recharge'],
					 'order_charge'=>$_lang['order_charge'],
					'admin_charge'=>$_lang['admin_charge']);
	}
	public static function get_mark_star(){
		global $_lang;
		return array("1"=>$_lang['one_star'],"2"=>$_lang['two_star'],"3"=>$_lang['three_star'],"4"=>$_lang['four_star'],"5"=>$_lang['five_star']);
	}
	public static function get_oauth_type(){
		global $_lang;
		return array(
		'sina'=>array('name'=>$_lang['sina_weibo'],'ico'=>'sina'),
		'ten'=>array('name'=>$_lang['tenxun_weibo'],'ico'=>'ten'),
		'qq'=>array('name'=>$_lang['tenxun_qq'],'ico'=>'qq'),
		'netease'=>array('name'=>$_lang['wangyi_weibo'],'ico'=>'netease'),
		'sohu'=>array('name'=>$_lang['sohu_weibo'],'ico'=>'sohu'),
		'taobao'=>array('name'=>$_lang['taobao'],'ico'=>'taobao'),
 		'alipay'=>array('name'=>$_lang['alipay'],'ico'=>'alipay'),
		);
	}
	public static function get_task_type(){
		global $_lang;
		return array("1"=>$_lang['single_reward'],"2"=>$_lang['more_reward'],"3"=>$_lang['piece_reward'],"4"=>$_lang['normal_tender'],
				"5"=>$_lang['deposit_tender'],"6"=>$_lang['works'],"7"=>$_lang['service'],"12"=>"速配任务","15"=>"福袋任务","16"=>"议价任务");
	}
	static function get_favor_type(){
		global $_lang;
		return array("task"=>$_lang['task'],"work"=>$_lang['work'],"shop"=>$_lang['shop'],"case"=>$_lang['case'],'service'=>$_lang['goods']);
	}
	public static function  get_e_space_style(){
		global $_lang;
		return array(
					"default"=>"file/upload/space/e_default.jpg",
					"hs"=>"file/upload/space/e_hs.jpg",
					"js"=>"file/upload/space/e_js.jpg",
					"qy"=>"file/upload/space/e_qy.jpg",
					"ty"=>"file/upload/space/e_ty.jpg",
					"zs"=>"file/upload/space/e_zs.jpg");
	}
	public static function  get_e_space_name(){
		global $_lang;
		return array("default"=>$_lang['bule_classic'],"hs"=>$_lang['gray_country'],"js"=>$_lang['golden_boundless'],"qy"=>$_lang['akiba_story'],"ty"=>$_lang['days_wing'],"zs"=>$_lang['purple_country']);
	}
	public static function  get_p_space_style(){
		global $_lang;
		return array("default"=>"file/upload/space/p_default.jpg",
							"bh"=>"file/upload/space/p_bh.jpg",
							"lsjd"=>"file/upload/space/p_lsjd.jpg",
							"lj"=>"file/upload/space/p_lj.jpg",
							"qxy"=>"file/upload/space/p_qxy.jpg",
							"qxyy"=>"file/upload/space/p_qxyy.jpg");
	}
	public static function  get_p_space_name(){
		global $_lang;
		return array("default"=>$_lang['default'],"bh"=>$_lang['lily'],"lsjd"=>$_lang['bule_classic'],"lj"=>$_lang['lj'],"qxy"=>$_lang['qxy'],"qxyy"=>$_lang['qxyy']);
	}
	public static function get_file_type() {
		global $_lang;
		return array (
				"task" => $_lang ['task_attachment'],
				"work" => $_lang ['work_attachment'],
				"agreement" => $_lang ['agreement_attachment'],
				"user_cert" => $_lang ['auth_attachment'],
				"space" => $_lang ['user_space'] ,
				'tools'=>'认证项目图标'
		);
	}
	public static function get_taskstatus_desc(){
		global $_lang;
		return array (
				"2" =>array("desc"=>$_lang['submit_deadline'],"time"=>"sub_time") ,
				"3" =>array("desc"=>$_lang['choose_end'],"time"=>"end_time"),
				"4" =>array("desc"=>$_lang['working'],"time"=>""),
				"5" =>array("desc"=>$_lang['publicity'],"time"=>""),
				"6" =>array("desc"=>$_lang['delivery'],"time"=>""),
				"7" =>array("desc"=>$_lang['freezing'],"time"=>""),
				"8" =>array("desc"=>$_lang['has_end'],"time"=>"end_time"),
				"9" =>array("desc"=>'失败',"time"=>""),
				"11" =>array("desc"=>'交付中',"time"=>""),
				"13" =>array("desc"=>'交付中',"time"=>"")
		);
	}
	public static function get_payitem_arr(){
		$payitem_arr = array("top","urgent");
		return $payitem_arr;
	}
	public static function num2ch($num=''){
		global $_lang;
		$ch_arr = array(1=>$_lang['one'], 2=>$_lang['two'], 3=>$_lang['three'], 4=>$_lang['four'], 5=>$_lang['five'], 6=>$_lang['six'], 7=>$_lang['seven'], 8=>$_lang['eight'], 9=>$_lang['nine'], 10=>$_lang['ten']);
		if ($num!='' && array_key_exists((int)$num, $ch_arr)){
			return $ch_arr[(int)$num];
		}
		return $ch_arr;
	}
	public static function updateLog($content){
		$filename = S_ROOT."/dbTools/file/dbUpdate.log";
		if(file_exists($filename)){
			$fp=fopen($filename,'a');
			fwrite($fp,date("Y-m-d H:i:s",time()).' '.$content."\r\n");
			fclose($fp);
		}
	}
	public static function checkipaddres($ipaddres) {
		$preg = "/^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$/";
		if (preg_match ( $preg, $ipaddres )){
			return true;
		}
		return false;
	}
	public static function showTaskCash($taskid){
		$taskinfo = db_factory::get_one("SELECT * FROM `".TB_PRE."witkey_task` WHERE task_id = ".intval($taskid));
		$data = array();
		if($taskinfo){
			switch ($taskinfo['model_id']) {
				case 4:
				case 5:
				case 12:
					if($taskinfo['model_id']=='4'){
						$arrCoverCash = kekezu::get_cash_cove ( 'tender', true );
					}elseif($taskinfo['model_id']=='5'){
						$arrCoverCash = kekezu::get_cash_cove ( 'dtender', true );
					}else{
						$arrCoverCash = kekezu::get_cash_cove ( '', true );
					}
					if($taskinfo['budget']){
						$data['budget'] =  $data['cash'] =  $taskinfo['budget'];
						$data['display'] =  'fixed';
						$data['display_style'] =  '<sub>￥</sub>'.$taskinfo['budget'];
					}
					if($taskinfo['task_cash_coverage']){
						$data['task_cash_coverage'] =  $taskinfo['budget'];
						$data['start_cash'] =  $arrCoverCash[$taskinfo['task_cash_coverage']]['start_cove'];
						$data['end_cash'] =  $arrCoverCash[$taskinfo['task_cash_coverage']]['end_cove'];
						$data['cash'] =  $arrCoverCash[$taskinfo['task_cash_coverage']]['start_cove']-$arrCoverCash[$taskinfo['task_cash_coverage']]['end_cove'];
						$data['display'] =  'range';
						$data['display_style'] =  '<sub>￥</sub>'.$arrCoverCash[$taskinfo['task_cash_coverage']]['start_cove'].'- <sub>￥</sub>'.$arrCoverCash[$taskinfo['task_cash_coverage']]['end_cove'];
					}
				break;
				default:
					$data['display_style'] = '<sub>￥</sub> '.$taskinfo['task_cash'];
				break;
			}
		}
		return $data['display_style'];
		return $data;
	}
	public static function kee_client_file(){
		return S_ROOT.'/keeClient.php';
	}
	public static function include_kee_client(){
		if(self::check_kee_client_file()){
			include self::kee_client_file();
			return true;
		}
		return false;
	}
	public static function check_kee_client_file(){
		if(file_exists(self::kee_client_file())){
			return true ;
		}
		return false;
	}
	public static function createProjectToKEE($taskid,$tasktitle,$work_id){
		global  $basic_config;
		if($basic_config['kee_switch'] != '1'){
			return false;
		}
		if(true === self::include_kee_client()){
			$workInfo = db_factory::get_one("SELECT * FROM `".TB_PRE."witkey_task_work` WHERE `work_id`='".$work_id."'");
			$userinfo = kekezu::get_user_info($workInfo['uid']);
			$data = array();
			$data['email'] = $userinfo['email'];
			$data['platform'] = $basic_config['website_name'];
			$data['role'] = '2';
			$data['tasktitle'] = $tasktitle;
			$data['taskid'] = $taskid;
			$data['client_url'] = $basic_config['website_url'];;
			$keeClient = new keeClient($basic_config['kee_api_id'], $basic_config['kee_app_secret']);
			$keeClient->createproject($data);
		}
	}
    public static function waterMark($path){
    	global $basic_config; 
		$config = unserialize($basic_config['watermark']);
        if($config['switch'] && file_exists(S_ROOT.$config['img'])){
            $info = pathinfo($path);
            $type = '|gif|jpeg|png|bmp|jpg';
            if(strpos($type, $info['extension'])){
                $waterMark = new keke_watermark_class();
                $waterMark->imgInfo($path);
                if($waterMark->imgH >= $config['hight'] && $waterMark->imgW >= $config['width']){
                    $waterMark->setLocation('right_down');   
                    $waterMark->setWaterImg(S_ROOT.$config['img']);   
                    $waterMark->setMargin(10, 10);  
                    $waterMark->ImgWater();   
                }
            }
        }
    }
    public static function getRegionConfig(){
    	global $basic_config;
    	$config = array();
    	$config['region_search_switch'] = '1';//$basic_config['region_search_switch'];
		if($config['region_search_switch'] =='1'){
			$config['region_search_shop'] = '1';//$basic_config['region_search_shop'];
			$config['region_search_task'] = '1';//$basic_config['region_search_task'];
		}else{
			$config['region_search_shop'] = 0;
			$config['region_search_task'] = 0;
		}
		return $config;
    }
    public static function updateRegionConfig($k,$v){
//    	$result = db_factory::get_one("SELECT * FROM `".TB_PRE."witkey_basic_config` WHERE k ='{$k}'");
//    	if(!$result){
//    		$sql = "INSERT INTO `".TB_PRE."witkey_basic_config` (`k`, `v`) VALUES ('{$k}', '{$v}')";
//    	}else{
//    		$sql = "UPDATE `".TB_PRE."witkey_basic_config` SET `v`='{$v}' WHERE (`k`='{$k}')";
//    	}
//		return db_factory::execute($sql);
    }
}
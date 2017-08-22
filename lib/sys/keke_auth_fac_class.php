<?php
keke_lang_class::load_lang_class('keke_auth_fac_class');
class keke_auth_fac_class {
	public static function user_auth_info($uid) {
		$auth_list = kekezu::get_table_data ( "*,max(auth_status) auth_status", TB_PRE . "witkey_auth_record", "uid='$uid'", '', 'auth_code', '', 'auth_code' );
		return $auth_list;
	}
	public static function get_submit_auth_record($uid,$auth_status='1'){
		$auth_item = keke_auth_base_class::get_auth_item();
		$auth_code = array_keys($auth_item);
		return self::auth_check($auth_code, $uid,$auth_status);
	}
	public static function get_auth_imghtm($auth_code, $uid) {
		global $_lang;
		$auth_list = self::user_auth_info ( $uid );
		$config_list = keke_auth_bank_class::get_auth_item($auth_code,'auth_code,auth_title,auth_small_ico,auth_small_n_ico,auth_open',1);
		$img_list = '';
		foreach ( $config_list as $c ) {
			if (! $c ['auth_open'])
				continue;
			$str = '';
			$str .= '<img src="';
			$str .= $auth_list [$c ['auth_code']] ['auth_status'] ? $c ['auth_small_ico'] : $c ['auth_small_n_ico'];
			$str .= '" align="absmiddle" title="' . $c ['auth_title'];
			$str .= $auth_list [$c ['auth_code']] ['auth_status'] ? $_lang['has_pass'] : $_lang['not_pass'];
			$str .= '" width="15">&nbsp;';
			$img_list .= $str;
		}
		return $img_list;
	}
	public static function install_auth($auth_dir) {
		global $_lang;
		$tab_obj       = keke_table_class::get_instance("witkey_auth_item");
		if ($auth_dir) {
			$file_path = S_ROOT . "./auth/" . $auth_dir . "/admin/auth_config_inc.php";
			if(file_exists ( $file_path )){
				require $file_path;
			$exists    = db_factory::get_count(" select auth_code from ".TB_PRE."witkey_auth_item where auth_dir = '$auth_dir'");
			$exists and kekezu::admin_show_msg($_lang['auth_item_exist_add_fail'],$_SERVER['HTTP_REFERER'],'3','','error');
			$res=$tab_obj->save($auth_config);
			if (file_exists ( S_ROOT . "./auth/" .$auth_dir. "/admin/install_sql.php" )) {
				require S_ROOT . "./auth/" . $auth_dir. "/admin/install_sql.php";
			}
			$res and kekezu::admin_system_log ( $_lang['add_auth_item'] . "$res" );
			$res and kekezu::admin_show_msg($_lang['auth_item_add_success'],$_SERVER['HTTP_REFERER'],'3','','success');
			}else{
				kekezu::admin_show_msg($_lang['unknow_error_add_fail'],$_SERVER['HTTP_REFERER'],'3','','error');
			}
		} else {
			kekezu::admin_show_msg($_lang['unknow_error_add_fail'],$_SERVER['HTTP_REFERER'],'3','','error');
		}
	}
	public static function del_auth($auth_code, $cash_name) {
		global $kekezu;
		global $_lang;
		$auth_item_obj = new Keke_witkey_auth_item_class();
		if (isset ( $auth_code )) {
			switch (is_array ( $auth_code )) {
				case "0" :
					$auth_item     = keke_auth_base_class::get_auth_item($auth_code);
					$auth_item['auth_small_ico']   and keke_file_class::del_file($auth_item['auth_small_ico']);
					$auth_item['auth_small_n_ico'] and keke_file_class::del_file($auth_item['auth_small_n_ico']); 
					$auth_item['auth_big_ico']     and keke_file_class::del_file($auth_item['auth_big_ico']); 
					$auth_item_obj->setWhere ("auth_code='$auth_code'" );
					$res = $auth_item_obj->del_keke_witkey_auth_item ();
					$res and $kekezu->_cache_obj->del ( $cash_name );
					$res and kekezu::admin_system_log ( $_lang['delete_auth_item'] . $auth_item['auth_title'] );
					if (file_exists ( S_ROOT . "./auth/" . $auth_item['auth_dir'] . "/admin/uninstall_sql.php" )) {
						require S_ROOT . "./auth/" . $auth_item['auth_dir'] . "/admin/uninstall_sql.php";
					}
					$res and kekezu::admin_show_msg($_lang['auth_item_delete_success_notice'],'index.php?do=auth&view=item_list','3','','success')	or kekezu::admin_show_msg($_lang['auth_item_delete_fail'],'index.php?do=auth&view=item_list','3','','error');
					break;
				case "1" :
					$auth_code_str=implode(",",$auth_code);
					if (sizeof ( $auth_code_str )) {
						$auth_item_obj->setWhere ( " FIND_IN_SET(auth_code,'$auth_code_str')>0" );
						$res = $auth_item_obj->del_keke_witkey_auth_item ();
						$res and kekezu::admin_system_log ( $_lang['delete_auth_item']."$auth_code_str" );
						$res and kekezu::admin_show_msg($_lang['auth_item_mulit_delete_success'],'index.php?do=auth&view=item_list','3','','success') or $res and kekezu::admin_show_msg($_lang['auth_item_mulit_delete_fail'],'index.php?do=auth&view=item_list','3','','error');
					}
					break;
			}
		}
	}
	public static function edit_item($auth_code,$data,$pk=null,$big_ico_name=null,$small_ico_name=null,$small_n_ico_name=null,$conf=array()){
		global $kekezu;
		global $_lang;
		$auth_item     = keke_auth_base_class::get_auth_item($auth_code);
		$auth_item or kekezu::admin_show_msg($_lang['auth_item_edit_fail_notice'],"index.php?do=auth&view=item_list",'3','','error');
		$tab_obj       = keke_table_class::get_instance("witkey_auth_item");
		$big_ico_name and $data['auth_big_ico'] = $big_ico_name=='delete' ? '' : $big_ico_name;
		$small_ico_name and $data['auth_small_ico'] = $small_ico_name=='delete' ? '' : $small_ico_name; 
		$small_n_ico_name and $data['auth_small_n_ico'] = $small_n_ico_name=='delete' ? '' : $small_n_ico_name; 
		$data['update_time'] = time();
		$res=$tab_obj->save($data,$pk);
		if($res){
			$kekezu->_cache_obj->del('auth_item_cache_list');
			kekezu::admin_system_log($_lang['edit_auth_item'].$auth_item['auth_title']);
			kekezu::admin_show_msg($_lang['auth_item_edit_success'],$_SERVER['HTTP_REFERER'],3,'','success');
		}else{
			kekezu::admin_show_msg($_lang['auth_item_edit_fail'],$_SERVER['HTTP_REFERER'],3,'','warning');
		}
	}
	public static function auth_check($auth_code,$uid,$auth_status='1'){
		if(!is_array($auth_code)){
			$auth_table=TB_PRE."witkey_auth_".$auth_code;
			$data = db_factory::get_one(" select * from ".$auth_table."  where uid ='$uid' and auth_status='$auth_status'");
			return $data;
		}else{
			$t = implode(",",$auth_code);
			return db_factory::query(" select a.auth_code,a.auth_status,b.auth_title,b.auth_small_ico from ".TB_PRE."witkey_auth_record a left join ".TB_PRE."witkey_auth_item b on a.auth_code=b.auth_code where a.uid ='$uid' and FIND_IN_SET(a.auth_code,'$t') and a.auth_status='$auth_status'",1,-1);
		}
	}
	public static function get_auth($user_info){
		$auth_item = keke_auth_base_class::get_auth_item ();
		$auth_temp = array_keys ( $auth_item );
		$user_info ['user_type'] == 2 and $un_code = 'realname' or $un_code = "enterprise";
		$t = implode ( ",", $auth_temp );
		$auth_info = db_factory::query ( " select a.auth_code,a.auth_status,b.auth_title,b.auth_small_ico,b.auth_small_n_ico from " . TB_PRE . "witkey_auth_record a left join " . TB_PRE . "witkey_auth_item b on a.auth_code=b.auth_code where a.uid ='".$user_info['uid']."' and FIND_IN_SET(a.auth_code,'$t')", 1, -1 );
		$auth_info = kekezu::get_arr_by_key ( $auth_info, "auth_code" );
		return array('item'=>$auth_item,'info'=>$auth_info,'code'=>$un_code);
	}
	public static function getAuthItemListByUid($uid){
		$userinfo = kekezu::get_user_info($uid);
		if(!$userinfo){
			return false;
		}
		if($userinfo['user_type']){
			$userinfo['user_type'] == '2' and  $remove_item = 'realname' or $remove_item = 'enterprise';
		}else{
			$remove_item = '';
		}
		$items = db_factory::get_table_data("*",TB_PRE . "witkey_auth_item"," auth_open = '1' AND auth_code NOT IN('{$remove_item}') "," CASE WHEN listorder >0 THEN 1 ELSE 0 END DESC ","","","auth_code",3600);
		if(!$items){
			return false;
		}
		$records = db_factory::get_table_data("*",TB_PRE . "witkey_auth_record"," uid = '{$uid}' AND auth_status = '1' AND auth_code NOT IN('{$remove_item}') ","","","","auth_code",3600);
		foreach ($items as $authcode => $iteminfo){
			$auth_record_status = $records[$authcode]['auth_status']?1:0;
			$auth_item_status = 0;
			if($auth_record_status){
				$tablename = TB_PRE.'witkey_auth_'.$authcode;
				$isExists = db_factory::checkTableIsExists($tablename);
				if($isExists){
					$info = db_factory::get_one("SELECT * FROM `{$tablename}` WHERE uid = '{$uid}' AND auth_status = '1'");
					if($info){
						$auth_item_status = 1;
					}
				}
			}
			if($auth_record_status && $auth_item_status){
				$items[$authcode]['auth_pass'] = 1;
			}else{
				$items[$authcode]['auth_pass'] = 0;
			}
			$items[$authcode]['auth_url'] = "index.php?do=user&view=account&op=auth&code={$authcode}";
		}
		return $items;
	}
}
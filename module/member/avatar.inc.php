<?php 
defined('IN_GAOSOU') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require MD_ROOT.'/member.class.php';
require DT_ROOT.'/include/post.func.php';
$avatar = useravatar($_userid, 'large', 0, 2);
$avatar2=strstr($avatar,'/file');
//$db->query("UPDATE {$DT_PRE}member SET avatarpic='$avatar' WHERE userid=$_userid");
$db->query("UPDATE {$DT_PRE}company SET avatarpic='$avatar2' WHERE userid=$_userid");
//头像&
$picId = intval($_GET['picId']);
switch($action) {
	case 'update':
		$t = $avatar ? 1 : 0;
		$db->query("UPDATE {$DT_PRE}member SET avatar=$t WHERE userid=$_userid");
		dheader('?itemid='.$DT_TIME);
	break;
	case 'upload':
		$_FILES['upfile']['size'] or dheader('?itemid='.$DT_TIME);
		require DT_ROOT.'/include/upload.class.php';
		$ext = file_ext($_FILES['upfile']['name']);
		$name = 'avatar'.$_userid.'.'.$ext;
		$file = DT_ROOT.'/file/temp/'.$name;
		if(is_file($file)) file_del($file);
		$upload = new upload($_FILES, 'file/temp/', $name, 'jpg|jpeg|gif|png');
		$upload->adduserid = false;
		if($upload->save()) {
			$file = DT_ROOT.'/file/temp/'.$name;
			$img_info = @getimagesize($file);
			if(!$img_info || $img_info[0] < 128 || $img_info[1] < 128) file_del($file);
			$img_info or message($L['avatar_img_t']);
			$img_info[0] >= 128 or message($L['avatar_img_w']);
			$img_info[1] >= 128 or message($L['avatar_img_h']);
			$ani = ($ext == 'gif' && strpos(file_get($file), chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0') !== false && $_FILES['upfile']['size'] < 200*1024) ? 1 : 0;
			$md5 = md5($_userid);
			$dir = DT_ROOT.'/file/avatar/'.substr($md5, 0, 2).'/'.substr($md5, 2, 2).'/'.$_userid;
			$img = array();
			$img[1] = $dir.'.jpg';
			$img[2] = $dir.'x48.jpg';
			$img[3] = $dir.'x20.jpg';
			$md5 = md5($_username);
			$dir = DT_ROOT.'/file/avatar/'.substr($md5, 0, 2).'/'.substr($md5, 2, 2).'/_'.$_username;
			$img[4] = $dir.'.jpg';
			$img[5] = $dir.'x48.jpg';
			$img[6] = $dir.'x20.jpg';
			require DT_ROOT.'/include/image.class.php';
			if(!$ani) {
				$image = new image($file);
				$image->thumb(128, 128);
			}
			file_copy($file, $img[1]);
			file_copy($file, $img[4]);
			if(!$ani) {
				$image = new image($file);
				$image->thumb(48, 48);
			}
			file_copy($file, $img[2]);
			file_copy($file, $img[5]);
			if(!$ani) {
				$image = new image($file);
				$image->thumb(20, 20);
			}
			file_copy($file, $img[3]);
			file_copy($file, $img[6]);
			file_del($file);
			dheader('?itemid='.$DT_TIME);
		} else {
			message($upload->errmsg);
		}
	break;
	case 'copy'://选择头像-->系统图片
		$numArr = array();
		for($i=1;$i<21;$i++){//21为系统图片总张数，i是代表图片的数字，其中8_large后面的图片为李工做的
			$numArr[$i]=$i;
		}
		if(in_array($picId,$numArr)){
			$file1 = DT_ROOT.'/file/avatar/sys/'.$picId.'_large.jpg';
			$file2 = DT_ROOT.'/file/avatar/sys/'.$picId.'_middle.jpg';
			$file3 = DT_ROOT.'/file/avatar/sys/'.$picId.'_small.jpg';
			$md5 = md5($_userid);
			$dir = DT_ROOT.'/file/avatar/'.substr($md5, 0, 2).'/'.substr($md5, 2, 2).'/'.$_userid;
			$img = array();
			$img[1] = $dir.'.jpg';
			$img[2] = $dir.'x48.jpg';
			$img[3] = $dir.'x20.jpg';
			file_copy($file1, $img[1]);
			file_copy($file2, $img[2]);
			file_copy($file3, $img[3]);
			$md5 = md5($_username);
			$dir = DT_ROOT.'/file/avatar/'.substr($md5, 0, 2).'/'.substr($md5, 2, 2).'/_'.$_username;
			$img[4] = $dir.'.jpg';
			$img[5] = $dir.'x48.jpg';
			$img[6] = $dir.'x20.jpg';
			file_copy($img[1], $img[4]);
			file_copy($img[2], $img[5]);
			file_copy($img[3], $img[6]);
		}
		dheader('?itemid='.$DT_TIME);
//		dheader('?action=update');
//		} else {
//			message($upload->errmsg);
//		}
		break;
	case 'delete':
		if($avatar) {
			$img = array();
			$img[1] = useravatar($_userid, 'large', 0, 2);
			$img[2] = useravatar($_userid, '', 0, 2);
			$img[3] = useravatar($_userid, 'small', 0, 2);
			$img[4] = useravatar($_username, 'large', 1, 2);
			$img[5] = useravatar($_username, '', 1, 2);
			$img[6] = useravatar($_username, 'small', 1, 2);
			foreach($img as $i) {
				file_del($i);
			}
			if($DT['ftp_remote'] && $DT['remote_url']) {
				require DT_ROOT.'/include/ftp.class.php';
				$ftp = new dftp($DT['ftp_host'], $DT['ftp_user'], $DT['ftp_pass'], $DT['ftp_port'], $DT['ftp_path'], $DT['ftp_pasv'], $DT['ftp_ssl']);
				if($ftp->connected) {
					foreach($img as $i) {
						$t = explode("/file/", $i);
						$ftp->dftp_delete($t[1]);
					}
				}
			}
		}
		$db->query("UPDATE {$DT_PRE}member SET avatar=0 WHERE userid=$_userid");
		dmsg($L['avatar_delete'], 'avatar.php?itemid='.$DT_TIME);
	break;
	case 'edit':
		$do = new member;
		$do->userid = $_userid;
		$do->username = $_username;
		$user = $do->get_one();
		$MFD = cache_read('fields-member.php');
		$CFD = cache_read('fields-company.php');
		isset($post_fields) or $post_fields = array();
		if($MFD || $CFD) require DT_ROOT.'/include/fields.func.php';
		$group_editor = $MG['editor'];
		in_array($group_editor, array('Default', 'gaosou', 'Simple', 'Basic')) or $group_editor = 'gaosou';
		$tab = isset($tab) ? intval($tab) : 0;
		$is_company = $_groupid > 5 || ($_groupid == 4 && $user['regid'] > 5);
//		$_E = ($MOD['edit_check'] && $user['edittime'] > 0 && $is_company) ? explode(',', $MOD['edit_check']) : array();
//		服务中心-》修改资料-》个人介绍，字数限制，审核中需要$_E变量
		$_E = ($MOD['edit_check'] && $user['edittime'] > 0 ) ? explode(',', $MOD['edit_check']) : array();
		if(in_array('capital', $_E)) $_E[] = 'regunit';
		$content_table = content_table(4, $_userid, is_file(DT_CACHE.'/4.part'), $DT_PRE.'company_data');
		$t = $db->get_one("SELECT * FROM {$content_table} WHERE userid=$_userid");
		if($t) {
			$user['content'] = $content = $t['content'];
		} else {
			$user['content'] = $content = '';
			$db->query("REPLACE INTO {$content_table} (userid,content) VALUES ('$_userid','')");
		}
		if($submit) {
			if(DT_MAX_LEN && strlen($_POST['post']['content']) > DT_MAX_LEN)  message('内容过长，限制为20000字符.');
			if($post['password'] && $user['password'] != dpassword($post['oldpassword'], $user['passsalt'])) message($L['error_password']);
			if($post['payword'] && $user['payword'] != dpassword($post['oldpayword'], $user['paysalt'])) message($L['error_payword']);
			$post['groupid'] = $user['groupid'];
			$post['email'] = $user['email'];
//			$post['passport'] = $user['passport'];//昵称
			$post['company'] = $user['company'];
//			$post['school'] = $user['school'];
			$post['domain'] = $user['domain'];
			$post['icp'] = $user['icp'];
			$post['skin'] = $user['skin'];
			$post['template'] = $user['template'];
			$post['edittime'] = $DT_TIME;
			$post['bank'] = $user['bank'];
			$post['banktype'] = $user['banktype'];
			$post['branch'] = $user['branch'];
			$post['account'] = $user['account'];
			$post['validated'] = $user['validated'];
			$post['validator'] = $user['validator'];
			$post['validtime'] = $user['validtime'];
			$post['vemail'] = $user['vemail'];
			$post['vmobile'] = $user['vmobile'];
			$post['vtruename'] = $user['vtruename'];
			$post['vbank'] = $user['vbank'];
			$post['vcompany'] = $user['vcompany'];
			$post['vtrade'] = $user['vtrade'];
			$post['trade'] = $user['trade'];
			$post['support'] = $user['support'];
			$post['inviter'] = $user['inviter'];
			if($post['vmobile']) $post['mobile'] = $user['mobile'];
			if($post['vtruename']) $post['truename'] = $user['truename'];
			$post = dstripslashes($post);
			$post_check = array();
			if($_E) {
				if(in_array('thumb', $_E) || in_array('content', $_E)) clear_upload($post['thumb'].$post['content'], $_userid);
				foreach($_E as $k) {
					if($post[$k] != $user[$k]) {
						$post_check[$k] = $post[$k];
						$post[$k] = $user[$k];
					}
				}
			}
			$post = daddslashes($post);
			$post_check = daddslashes($post_check);
			if($MFD) fields_check($post_fields, $MFD);
			if($CFD) fields_check($post_fields, $CFD);

			if($do->edit($post)) {

				if($MFD) fields_update($post_fields, $do->table_member, $do->userid, 'userid', $MFD);
				if($CFD) fields_update($post_fields, $do->table_company, $do->userid, 'userid', $CFD);
				if($post_check) $do->check_add($post_check);
				if($user['edittime'] == 0 && $user['inviter'] && $MOD['credit_user']) {
					$inviter = $user['inviter'];
					$r = $db->get_one("SELECT itemid FROM {$DT_PRE}finance_credit WHERE note='$_username' AND username='$inviter'");
					if(!$r) {
						credit_add($inviter, $MOD['credit_user']);
						credit_record($inviter, $MOD['credit_user'], 'system', $L['edit_invite'], $_username);
					}
				}
				if($user['edittime'] == 0 && $MOD['credit_edit']) {
					credit_add($_username, $MOD['credit_edit']);
					credit_record($_username, $MOD['credit_edit'], 'system', $L['edit_profile'], $DT_IP);
				}
				if($post['password']) dheader($DT['file_login'].'?auth='.encrypt('LOGIN|'.$_username.'|'.$post['password'].'|'.$DT_TIME, DT_KEY.'LOGIN').'&forward='.urlencode($MOD['linkurl'].'edit.php?success=1&tab='.$tab));
//			dheader('?action=edit');
			dheader('?action=edit&success=1');
			} else {
				message($do->errmsg);
			}
		} else {
			$COM_TYPE = explode('|', $MOD['com_type']);
			$COM_SIZE = explode('|', $MOD['com_size']);
			$COM_MODE = explode('|', $MOD['com_mode']);
			$MONEY_UNIT = explode('|', $MOD['money_unit']);
			$head_title = $L['edit_title'];
			$_U = $_E ? $do->check_get() : array();
			if($_U) {
				foreach($_U as $k=>$v) {
					$user[$k] = $v;
				}
			}
			extract($user);
			$mode_check = dcheckbox($COM_MODE, 'post[mode][]', $mode, 'onclick="check_mode(this, '.$MOD['mode_max'].');"', 0);
			$cates = $catid ? explode(',', substr($catid, 1, -1)) : array();
			$tab = isset($tab) ? intval($tab) : -1;
			if($tab == 2 && !$is_company) $tab = 0;
			//include template('avatar', $module);
		//	include template('edit', $module);
			}
			break;
	default:
		$auth = encrypt($_userid.'|'.$_username, DT_KEY.'AVATAR');
		$head_title = $L['avatar_title'];	
	break;
}
include template('avatar', $module);
?>
<?php
define ( "IN_KEKE", TRUE );
include '../app_comm.php';
if(!in_array($_REQUEST['state'], array('sina','qq','taobao','renren','douban','baidu','wx'))){
	exit('参数错误');
}
if($_REQUEST['state'] && $_REQUEST['code']){
	$oauth_obj = OAuthClass::factory($_REQUEST['state']);
	$token = $oauth_obj->getAccessToken($_REQUEST['code']);
	if($token){
		$_SESSION ['oauth_token'] = $token;
		switch ($_REQUEST['state']) {
			case 'sina':
				$oauth_obj->getAccountUid();
				$oauthInfo = $oauth_obj->getAccountInfo();
				unset ( $oauth_obj ,$_SESSION ['oauth_token']);
				$saveInfo = array (
					'account' => intval ( $oauthInfo ['id'] ),
					'nickname' => $oauthInfo ['name'],
					'gender' => $oauthInfo ['gender'] === 'm' ? '男' : '女',
					'type' => $_REQUEST['state']
				);
			break;
			case 'qq':
				$oauth_obj->getOpenid();
				$oauthInfo = $oauth_obj->getAccountInfo();
				unset ( $oauth_obj ,$_SESSION ['oauth_token']);
				$saveInfo = array (
					'account' => UserCenter::getUnique ( $oauthInfo ),
					'nickname' => $oauthInfo ['nickname'],
					'gender' => $oauthInfo ['gender'],
					'type' =>$_REQUEST['state']
				);
			break;
			case 'renren':
				$oauth_obj->getUserId();
				$oauthInfo = $oauth_obj->getAccountInfo();
				unset ( $oauth_obj ,$_SESSION ['oauth_token']);
				$saveInfo = array (
					'account' => $oauthInfo ['id'],
					'nickname' => $oauthInfo ['name'],
					'gender' => strtoupper($oauthInfo['basicInformation']['sex'])=='MALE'?'男':'女',
					'type' => $_REQUEST['state']
				);
			break;
			case 'douban':
				$oauthInfo = $oauth_obj->getAccountInfo();
				unset ( $oauth_obj ,$_SESSION ['oauth_token']);
				$saveInfo = array (
					'account' => $oauthInfo ['id'],
					'nickname' => $oauthInfo ['name'],
					'gender' => '',
					'type' => $_REQUEST['state']
				);
			break;
			case 'taobao':
				$saveInfo = array (
					'account' => $token['taobao_user_id'],
					'nickname' => urldecode($token['taobao_user_nick']),
					'gender' => $token['taobao_user_gender'],
					'type' => $_REQUEST['state']
				);
			break;
			case 'baidu':
			    $oauthInfo = $oauth_obj->getAccountInfo($token);
			    unset ( $oauth_obj ,$_SESSION ['oauth_token']);
				$saveInfo = array (
					'account' => $oauthInfo['userid'],
					'nickname' => $oauthInfo ['username'],
					'gender' => $oauthInfo ['sex'] ? '男' : '女',
					'type' => $_REQUEST['state']
				);
			break;
			case 'wx':
				$oauthInfo = $oauth_obj->getAccountInfo();
				unset ( $oauth_obj ,$_SESSION ['oauth_token']);
				$saveInfo = array (
					'account' => $oauthInfo ['unionid'] ,
					'nickname' => $oauthInfo ['nickname'],
					'gender' => $oauthInfo ['sex'] === '1' ? '男' : '女',
					'type' => $_REQUEST['state']
				);
			break;
			default:
			break;
		}
		if($gUid){
			UserCenter::bindingAccount($gUid, $gUserInfo['username'], $saveInfo);
			header('Location:'.$basic_config['website_url'].'/index.php?do=user&view=account&op=binding');
		}else{
            $_SESSION[$saveInfo['type'].'_oauthInfo'] = $saveInfo;
			header('Location:'.$basic_config['website_url'].'/index.php?do=oauthregister&type='.$saveInfo['type']);
		}
	}else{
		exit('授权失败');
	}
}else{
	exit('参数错误');
}

<?php
class XuanWuSms {
	private $account ;
	private $passwd ;
	private $url = "http://211.147.239.62/Service/WebService.asmx?wsdl";
	private $port = "";
	private $type = "1";
	private $subid = "";
	private static $single = null;
	function __construct($account,$passwd,$type = 1) {
		$this->account = $account;
		$this->passwd = $passwd;
		if (! class_exists ( "SoapClient" )) {
			die ( "请开启Soap扩展" );
			exit ();
		}
		if (self::$single == null) {
			self::$single = new SoapClient ( $this->url );
		}
	}
	function _postSingle($mobile, $content) {
		$params = array (
				'account' => $this->account,
				'password' => $this->passwd,
				'mobile' => $mobile,
				'content' => $content
		);
		$result = self::$single->PostSingle ( $params );
		return self::_getCodeStatus($result->PostSingleResult);
	}
	function _getAccountInfo(){
		$params = array (
				'account' => $this->account,
				'password' => $this->passwd
		);
		$r = self::$single->GetAccountInfo ($params);
		$data =  array();
		$data =  $this->object2array($r);
		return $data['GetAccountInfoResult'];
	}
	function object2array($object) {
		$array = array();
		if (is_object($object)) {
			foreach ($object as $key => $value) {
				if(is_object($value)){
					$array[$key] = $this->object2array($value);
				}else{
					$array[$key] = $value;
				}
			}
		}else {
			$array = $object;
		}
		return $array;
	}
	static function _getCodeStatus($status) {
		$arrCode = self::reponseCode ();
		return $arrCode [$status];
	}
	private static function reponseCode() {
		return array (
				"0" => "操作成功",
				"-1" => "账号无效",
				"-2" => "参数：无效",
				"-3" => "连接不上服务器",
				"-5" => "无效的短信数据，号码格式不对",
				"-6" => "用户名密码错误",
				"-7" => "旧密码不正确",
				"-9" => "资金账户不存在",
				"-11" => "包号码数量超过最大限制",
				"-12" => "余额不足",
				"-13" => "账号没有发送权限",
				"-99" => "系统内部错误",
				"-100" => "其它错误"
		);
	}
}
?>
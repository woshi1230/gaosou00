<?php
defined('IN_GAOSOU') or exit('Access Denied');
// 请注意服务器是否开通fopen配置
function  log_result($word) {
	log_write($word, 'tenpay');
}
?>
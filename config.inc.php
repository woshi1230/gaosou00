<?php
defined('IN_GAOSOU') or exit('Access Denied');
/*
	[GAOSOU B2B System] Copyright (c) 2016-2017 gaosou.COM
	This is NOT a freeware, use is subject to license.txt
*/
# http://help.gaosou.com/faq/config.php shows detail

$CFG['database'] = 'mysql';
$CFG['pconnect'] = '0';
//$CFG['db_host'] = '120.76.78.213';
$CFG['db_host'] = '39.108.163.163';
//$CFG['db_host'] = '192.168.0.200';
//$CFG['db_host'] = '127.0.0.1';
$CFG['db_pass'] = 'f20c7259c1';
//$CFG['db_pass'] = '123456';
//$CFG['db_name'] = 'gaosou';
$CFG['db_name'] = 'ywb2b';
$CFG['db_user'] = 'root';

$CFG['db_charset'] = 'utf8';
$CFG['db_expires'] = '0';
$CFG['tb_pre'] = 'yw_';
$CFG['charset'] = 'utf-8';
$CFG['url'] = 'http://39.108.163.163/gaosou/';
$CFG['com_domain'] = '';
$CFG['com_dir'] = '1';
$CFG['com_rewrite'] = '0';
$CFG['com_vip'] = 'VIP';
$CFG['file_mod'] = 0777;
$CFG['cache'] = 'file';
$CFG['cache_pre'] = 'cac_';
$CFG['cache_dir'] = '';
$CFG['tag_expires'] = '0';
$CFG['template_refresh'] = '1';
$CFG['cookie_domain'] = '';
$CFG['cookie_path'] = '/';
$CFG['cookie_pre'] = 'cbv_';
$CFG['session'] = 'file';
$CFG['editor'] = 'fckeditor';
$CFG['timezone'] = 'Etc/GMT-8';
$CFG['timediff'] = '0';
$CFG['skin'] = 'default';
$CFG['template'] = 'default';
$CFG['language'] = 'zh-cn';
$CFG['authadmin'] = 'session';
$CFG['authkey'] = 'VDPuyYW7aUIToGd0';
$CFG['static'] = '';
$CFG['cloud_uid'] = '';
$CFG['cloud_key'] = '';
$CFG['edittpl'] = '1';
$CFG['executesql'] = '1';
$CFG['founderid'] = '1';
error_reporting ( 0 );
define('ADMIN_UID', '1');
define('CHARSET', 'utf-8');
define('DBTYPE', 'mysqli');
define('TB_PRE', 'yw_');
define('ENCODE_KEY','keke');
define('GZIP', TRUE);
define('KEKE_DEBUG', 1);
define("TPL_CACHE", 0);
define('IS_CACHE', 0);
define('CACHE_TYPE', 'file');
define('ADMIN_DIRECTORY', 'admin');
define('COOKIE_DOMAIN', '');
define('COOKIE_PATH', '/kppw/');
define('COOKIE_PRE', 'kekeWitkey' );
define('COOKIE_TTL', 0);
define('SESSION_MODULE', 'files');
define('SYS_START_TIME', time());
$random = explode(' ', microtime());
define("RANDOM_PARA", $random[0]);
function_exists ('date_default_timezone_set') and date_default_timezone_set ('PRC');

?>
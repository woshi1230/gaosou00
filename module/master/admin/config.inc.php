<?php
defined('DT_ADMIN') or exit('Access Denied');
$MCFG['module'] = 'master';
$MCFG['name'] = '高手';
$MCFG['author'] = 'gaosou.COM';
$MCFG['homepage'] = 'www.gaosou.net';
$MCFG['copy'] = false;
$MCFG['uninstall'] = false;

$RT = array();
$RT['file']['index'] = '高手列表';
$RT['file']['vip'] = VIP.'管理';
$RT['file']['html'] = '更新网页';

$RT['action']['vip']['add'] = '添加'.VIP;
$RT['action']['vip']['edit'] = '修改'.VIP;
$RT['action']['vip']['delete'] = '撤销'.VIP;
$RT['action']['vip']['expire'] = '过期'.VIP;
$RT['action']['vip']['show'] = '查看申请';
$RT['action']['vip']['move'] = '删除申请';
$RT['action']['vip']['update'] = '更新指数';

$RT['action']['index']['fporder'] = '高手订单服务';//tmp 2010-12-13
$RT['action']['index']['fptech'] = '高手技术支持';//tmp

$CT = false;
?>
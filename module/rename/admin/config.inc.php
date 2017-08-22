<?php
defined('DT_ADMIN') or exit('Access Denied');
//此模块是复制的品牌模块，即brand
$MCFG['module'] = 'taskmanage';
$MCFG['name'] = '任务管理';
$MCFG['author'] = 'taskmanage.COM';
$MCFG['homepage'] = 'www.taskmanage.net';
$MCFG['copy'] = true;
$MCFG['uninstall'] = true;
$MCFG['moduleid'] = 88;

$RT = array();
$RT['file']['index'] = '任务管理';
$RT['file']['html'] = '更新网页';

$RT['action']['index']['add'] = '添加任务';
$RT['action']['index']['edit'] = '修改任务';
$RT['action']['index']['delete'] = '删除任务';
$RT['action']['index']['check'] = '审核任务';
$RT['action']['index']['expire'] = '过期任务';
$RT['action']['index']['reject'] = '未通过';
$RT['action']['index']['recycle'] = '回收站';
$RT['action']['index']['move'] = '移动任务';
$RT['action']['index']['level'] = '任务级别';

$CT = true;
?>
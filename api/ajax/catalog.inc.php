<?php
/*
 * 包含模板，碎片目录中的目录文件
 */
defined('IN_GAOSOU') or exit('Access Denied');
isset($MODULE[$mid]) or exit;
include template('catalog', 'chip');
?>
<?php
defined('IN_GAOSOU') or exit('Access Denied');
if($page < 1 || $page > $total) $page = 1;
$demo_url = str_replace(array('%7B', '%7D'), array('{', '}'), $demo_url);
$pages .= lang($L['curr_page'], array($items, $page, $total)).'&nbsp;&nbsp;';
$url = $home_url;
$pages .= '<a href="'.$url.'">&nbsp;'.$L['home_page'].'&nbsp;</a> ';
$_page = $page >= $total ? 1 : $page + 1;
$url = $_page == 1 ? $home_url : str_replace('{gaosou_page}', $_page, $demo_url);
$pages .= '<a href="'.$url.'">&nbsp;'.$L['next_page'].'&nbsp;</a><input type="hidden" id="gaosou_next" value="'.$url.'"/> ';
$_page = $page <= 1 ? $total : ($page - 1);
$url = $_page == 1 ? $home_url : str_replace('{gaosou_page}', $_page, $demo_url);
$pages .= '<input type="hidden" id="gaosou_previous" value="'.$url.'"/><a href="'.$url.'">&nbsp;'.$L['prev_page'].'&nbsp;</a> ';
$url = $total == 1 ? $home_url : str_replace('{gaosou_page}', $total, $demo_url);
$pages .= '<a href="'.$url.'">&nbsp;'.$L['last_page'].'&nbsp;</a> ';
$pages .= '<cite></cite><input type="text" class="pages_inp" id="gaosou_pageno" value="'.$page.'" onkeydown="if(event.keyCode==13 && this.value) {window.location.href=\''.$demo_url.'\'.replace(/\\{gaosou_page\\}/, this.value);return false;}"> <input type="button" class="pages_btn" value="GO" onclick="if(Dd(\'gaosou_pageno\').value>0)window.location.href=\''.$demo_url.'\'.replace(/\\{gaosou_page\\}/, Dd(\'gaosou_pageno\').value);"/>';
?>
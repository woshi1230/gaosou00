<?php
defined('IN_GAOSOU') or exit('Access Denied');
$_page = $page <= 1 ? $total : ($page - 1);
$demo_url = str_replace(array('%7B', '%7D'), array('{', '}'), $demo_url);
$url = $_page == 1 ? $home_url : str_replace('{gaosou_page}', $_page, $demo_url);
$pages .= '<input type="hidden" id="gaosou_previous" value="'.$url.'"/><a href="'.$url.'">&nbsp;&#171;'.$L['prev_page'].'&nbsp;</a> ';
if($total >= 1) {
	$_page = 1;
	$url = $home_url;
	$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
}
if($total >= 2) {
	$_page = 2;
	$url = str_replace('{gaosou_page}', $_page, $demo_url);
	$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
}
if($total >= 3) {
	$pages .= '&nbsp;&#8230;&nbsp;';
	if($total > 4) {
		if($page <= 2) {
			$min = 3; $max = 3 + $step*2;
		} else if($page >= $total - 1) {
			$min = $total - 2 - $step*2; $max = $total - 2;
		} else {
			$min = $page - $step; $max = $page + $step;
		}
		if($min < 3) $min = 3;
		if($max > $total - 2) $max = $total - 2;
		if($page == 3) while($max < $page + $step*2 && $max < $total - 2) { $max++; }
		if($page == 4) while($max < $page + $step*2 - 1 && $max < $total - 2) { $max++; }
		if($page == $total - 3) while($min > $page - $step*2 + 1 && $min - 1 > 2) { $min--;}
		if($page == $total - 2) while($min > $page - $step*2 && $min - 1 > 2) { $min--; }
		for($_page = $min; $_page <= $max; $_page++) {
			$url = $_page == 1 ? $home_url : str_replace('{gaosou_page}', $_page, $demo_url);
			$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
		}
		$pages .= '&nbsp;&#8230;&nbsp;';
	}
	if($total >= 4) {
		$_page = $total - 1;
		$url = $_page == 1 ? $home_url : str_replace('{gaosou_page}', $_page, $demo_url);
		$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
	}
	if($total >= 3) {
		$_page = $total;
		$url = $_page == 1 ? $home_url : str_replace('{gaosou_page}', $_page, $demo_url);
		$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
	}
}
$_page = $page >= $total ? 1 : $page + 1;
$url = $_page == 1 ? $home_url : str_replace('{gaosou_page}', $_page, $demo_url);
	$pages .= '<a     href="'.$url.'">&nbsp;'.$L['next_page'].'&#187;&nbsp;</a> <input type="hidden" id="gaosou_next" value="'.$url.'"/>&nbsp;'.lang($L['info_page'], array($items, $total)).'&nbsp;';
//$pages .= '<a href="javascript:makeRequest(\'action=task&template=homepage2&moduleid=6&userid=2&username=\'+username, \'task?type=2\', \'_getInfo\');">&nbsp;'.$L['next_page'].'&#187;&nbsp;</a> <input type="hidden" id="gaosou_next" value="'.$url.'"/>&nbsp;'.lang($L['info_page'], array($items, $total)).'&nbsp;';
$pages .= '<input type="text" class="pages_inp" id="gaosou_pageno" value="'.$page.'" onkeydown="if(event.keyCode==13 && this.value) {window.location.href=\''.$demo_url.'\'.replace(/\\{gaosou_page\\}/, this.value);return false;}"> <input type="button" class="pages_btn" value="GO" onclick="if(Dd(\'gaosou_pageno\').value>0)window.location.href=\''.$demo_url.'\'.replace(/\\{gaosou_page\\}/, Dd(\'gaosou_pageno\').value);"/>';
?>
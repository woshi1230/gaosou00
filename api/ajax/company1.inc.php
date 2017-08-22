<?php
defined('IN_GAOSOU') or exit('Access Denied');
$module == 'company' or exit;
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require MD_ROOT.'/company.class.php';
$do = new company;
if($job == 'bycid') {
	$condition = "catids like '%,".$catid.",%'";
	if($page == 1) {
		$items = $db->count($table, $condition, $CFG['db_expires']);
	} else {
		$items = $CAT['item'];
	}
	$pagesize = 25;
	$offset = 0;
//	$pages = listpages($CAT, $items, $page, $pagesize);
	$tags = $_tags = $ids = array();
	if($items) {
		$result = $db->query("SELECT company,business,username,total_sales FROM {$table} WHERE {$condition} ORDER BY ".$MOD['order']." LIMIT {$offset},{$pagesize}");
		$count = 0;
		while($r = $db->fetch_array($result)) {
			$count++;
//			echo "<a class=\"ws ws".$count."\"><span class=\"img\">";
//			echo "<img src=\"".DT_PATH."api/avatar/show.php?username=".$r['username']."&size=large\" /></span>";
//			echo "<span class=\"name\">".$r['username']."</span>";
//			echo "<span class=\"level\">新兵</span></a>";
			echo "<div class=\"group-list f_l\">";
			echo "    <a target=\"_blank\" data-toggle=\"popover\" data-placement=\"top\" data-html=\"true\" data-trigger=\"hover\" data-content=\"";
			echo "        <p><strong>名称：</strong>".$r['company']."</p><p><strong>经营范围：</strong>".$r['business']."</p>\"";
			echo "        href=\"".userurl($r['username'])."\" onmouseenter=\"membPop(this)\">";
			echo "        <img class=\"group-pic\" src=\"".useravatar($r['username'])."\">";
			echo "        <p class=\"group-name\">".dsubstr($r['company'], 10, '')."</p>";
			echo "        <p class=\"group-count\">获取总报酬：<span style=\"color: #ff8a00\">￥".$r['total_sales']."</span></p>";
			echo "    </a>";
			echo "</div>";
		}
	}
	exit;
} elseif($job == 'forrank') {
	$condition = "catids like '%,".$catid.",%'";
	if($page == 1) {
		$items = $db->count($table, $condition, $CFG['db_expires']);
	} else {
		$items = $CAT['item'];
	}
	$pagesize = 48;
	$offset = 0;
	$tags = $_tags = $ids = array();
	if($items) {
		echo "<div class=\"ibox_head\" style=\"text-decoration: blink;\">";
		echo "	<a href=\"".$MODULE[42][linkurl]."\" style=\"border-bottom: 1px solid #e0e0e0;\"><strong><span style=\"color: #ff8a00;padding-right: 10px;\">高手排行</span> ".$catname."</strong></a>";
		echo "</div>";
		echo "<div class=\"mthumb\" style=\"margin: 5px 0 0 0;\">";

		$tags = array();
		$result = $db->query("SELECT linkurl,company,business,username,total_sales FROM {$table} WHERE {$condition} ORDER BY total_sales desc LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			$tags[] = $r;
		}

		$iList = 12;
		$iListM = count($tags)%$iList;
		$iListWidth = $iListM==0 ? floor(count($tags)/$iList) : floor(count($tags)/$iList)+1;

		if ($iListWidth==2) $iListWidth = 440; //232*2;
		if ($iListWidth==3) $iListWidth = 309; //232*4/3
		if ($iListWidth==1 || $iListWidth==4) $iListWidth = 232;

		echo "<div style=\"width: ".$iListWidth."px;float: left;padding-left: 6px;\">";
		$length = count($tags);
		for($i = 0; $i < $length; $i++)	{
			if ($i && $i%$iList==0) {
				echo "<div style=\"width: ".$iListWidth."px;float: left;border-left: 1px solid rgb(221, 221, 221);padding-left: 5px;\">";
			}
			echo "<div class=\"ranking-list f_l\">";
			echo "    <a target=\"_blank\" href=\"".userurl($tags[$i][username])."\">";
			echo "        <span style=\"float: left;margin-top: 7px;padding: 1px;background-color: #ff8a00;border-radius: 3px;color: white;\">".($i+1)."</span>";
			echo "        <img class=\"group-pic\" src=\"".useravatar($tags[$i][username])."\">";
			echo "        <p class=\"group-name\">".dsubstr($tags[$i][company], 10, '')."</p>";
			echo "        <p class=\"group-count\">获取总报酬：<span style=\"color: #ff8a00\">￥".$tags[$i][total_sales]."</span></p>";
			echo "    </a>";
			echo "</div>";
			if ($i && ($i+1)%$iList==0) {
				echo "</div>";
			}
		}
		echo "</div>";
	}
	exit;
}elseif($job == 'bydata'){
//	$userid=16;
	$table_data = $table.'_data';
	$condition = "userid =".$userid;
	if($page == 1) {
//		$items = $db->count($table, $condition, $CFG['db_expires']);
		$items = 1;
	} else {
		$items = $CAT['item'];
	}
	$pagesize = 25;
	$offset = 0;
//	$pages = listpages($CAT, $items, $page, $pagesize);
	$tags = $_tags = $ids = array();
	if($items) {
//		$result = $db->query("SELECT company,business,username,total_sales FROM {$table} WHERE {$condition} ORDER BY ".$MOD['order']." LIMIT {$offset},{$pagesize}");
		$result = $db->query("SELECT a.username,b.content FROM {$table} as a left join {$table_data} as b on a.userid = b.userid  where a.$condition");
//		$result_name = $db->query("SELECT username FROM {$table} WHERE {$condition}");
//		$result_content = $db->query("SELECT content FROM {$table_data} WHERE {$condition}");
		$count = 0;
		while($r = $db->fetch_array($result)) {
			$count++;
			echo "<div class=\"group-list f_l\">";
			echo "<p>$r[username]</p>";
			echo "<hr>";
			echo "<p>$r[content]</p>";

			echo "</div>";
		}
//		while($r = $db->fetch_array($result_content)) {
//			$count++;
//			echo "<div class=\"group-list f_l\">";
//			echo "<p>$r[content]</p>";
//			echo "<hr>";
//			echo "</div>";
//		}
	}
	exit;
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: hongxin
 * Date: 2017/1/3
 * Time: 14:49
 */

require '../../mobile/common.inc.php';

$offset = isset($index) ? intval($index) : 0;
$pagesize = 20;
$offset = $offset * $pagesize;

$lists = array();
$result = $db->query("SELECT * FROM {$DT_PRE}mall WHERE status=3 ORDER BY editdate LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result)) {
    if($kw) $r['title'] = str_replace($kw, '<b class="f_red">'.$kw.'</b>', $r['title']);
//    $r['linkurl'] = mobileurl($moduleid, 0, $r['itemid']);
    $lists[] = $r;
}
$db->free_result($result);


header('Access-Control-Allow-Origin:*');
echo json_encode ( array ('data' => $lists), JSON_UNESCAPED_UNICODE);

?>
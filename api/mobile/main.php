<?php
/**
 * Created by PhpStorm.
 * User: hongxin
 * Date: 2017/1/3
 * Time: 14:49
 */

require '../../mobile/common.inc.php';

$ads = array();
//$pid = intval($EXT['mobile_pid']);
$pid = 14;
if($pid > 0) {
    $result = $db->query("SELECT * FROM {$DT_PRE}ad WHERE pid=$pid AND status=3 AND totime>$DT_TIME ORDER BY listorder ASC,addtime ASC LIMIT 10", 'CACHE');
    while($r = $db->fetch_array($result)) {
        $r['image_src'] = linkurl($r['image_src']);
        $r['url'] = $r['stat'] ? DT_PATH.'api/redirect.php?aid='.$r['aid'] : linkurl($r['url']);
        $ads[] = $r;
    }
    $db->free_result($result);
}

header('Access-Control-Allow-Origin:*');
echo json_encode ( array ('data' => $ads), JSON_UNESCAPED_UNICODE);

?>
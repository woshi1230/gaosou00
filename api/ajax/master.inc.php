<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/15
 * Time: 16:29
 */

//WHERE $condition ORDER BY seller_ctime DESC LIMIT $offset,$pagesize

//接收参数暂未过滤

//搜索名字，添加好友功能


//if($submit) {
//    check_post() or dalert($L['bad_data']);//safe
//    $BANWORD = cache_read('banword.php');
//    if($BANWORD && isset($post)) {
//        $keys = array('title', 'tag', 'introduce', 'content');
//        foreach($keys as $v) {
//            if(isset($post[$v])) $post[$v] = banword($BANWORD, $post[$v]);
//        }
//    }
//}
//safe

$username = $_POST['suibian'];
//
//
//
//
$result0 = $db->query("SELECT username FROM {$DT_PRE}chat where online=1");
//$result = $db->query("SELECT * FROM {$DT_PRE}company");
while($r0 = $db->fetch_array($result0)) {
    $lists0[] = $r0;
}
//
$result1 = $db->query("SELECT username FROM {$DT_PRE}online where online=1");
//$result = $db->query("SELECT * FROM {$DT_PRE}company");
while($r1 = $db->fetch_array($result1)) {
    $lists1[] = $r1;
}
//$lists1 = array_column($lists1,'username');
foreach($lists1 as $k=>$v){
    $lists2[] .=$v['username'];
}


$result = $db->query("SELECT c.username,c.address,c.buyer_level,c.avatarpic,m.truename FROM {$DT_PRE}company as c JOIN {$DT_PRE}member as m on c.userid = m.userid WHERE c.username LIKE '$username%' OR m.truename LIKE '$username%'");
//$result = $db->query("SELECT * FROM {$DT_PRE}company");
while($r = $db->fetch_array($result)) {
    if(in_array($r['username'],$lists2)){
//        $r['online']=1;
        $r['online']=1;
    }else{
        $r['online']=0;
    }
    if(!$r['avatarpic']){
        $r['avatarpic'] ='file/upload/default.jpg';
    }
    $r['avatarpic'] = DT_PATH.$r['avatarpic'];
    if ($r['buyer_level']) {
        $r['buyer_level'] =DT_PATH.substr(strstr($r['buyer_level'], '<'), 10, 35);
    }
    $r['href'] = DT_PATH.'com/'.$r['username'];

    $lists[] = $r;
}
if(empty($lists)){
    $lists['code'] = '500';
    echo json_encode($lists);
}else{
    echo json_encode($lists);
}
?>


<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24
 * Time: 11:48
 */
$username = $_POST['username'];

$username = isset($username) ? trim($username) : '';
$truename = $homepage = $company = $school = $career = $telephone = $msn = $qq = $ali = $skype = '';
if($username) {
    $r = userinfo($username);
    if($r) {

        $truename = $r['truename'];
        $homepage = userurl($username);
        $company = $r['company'];
        $telephone = $r['telephone'];
        $career = $r['career'];
        $school = $r['school'];
        $msn = $r['msn'];
        $qq = $r['qq'];
        $ali = $r['ali'];
        $skype = $r['skype'];
        $infoid = $r['userid'];
    }else{
        $msg['code'] = '600';
        echo json_encode($msg);
        return ;
    }
}
$rb = userinfo($_username);
$_truename = $rb['truename'];
$_company = $rb['company'];
$addtime = $DT_TIME;
$res1 = $db->query("insert into {$DT_PRE}friend (`userid`,`username`,`truename`,`company`,`addtime`,`agree`) VALUES ('$_userid','$username','$truename','$company','$addtime','0')");
$res2 = $db->query("insert into {$DT_PRE}friend (`userid`,`username`,`truename`,`company`,`addtime`,`agree`) VALUES ('$infoid','$_username','$_truename','$_company','$addtime','0')");
//$lastId = $db->get_one("SELECT max(itemid) FROM {$DT_PRE}friend");
$res3 = $db->query("INSERT INTO {$DT_PRE}message (`title`,`typeid`,`content`,`fromuser`,`touser`,`addtime`,`status`)  VALUES ('{$_username}请求您添加他（她）为好友','4','{$_username} 先生 想邀请您添加成为他（她）为好友，同意请按确认，忽略本次请求则无需做确认处理:','$_username','$username','$addtime','3')");
$res4 = $db->query("update {$DT_PRE}member set message=message+1 where username = '$username'");

if($res1 && $res2 && $res3 && $res4){
    $msg['code'] = '200';
    echo json_encode($msg);
}else{
    $msg['code'] = '500';
    echo json_encode($msg);
}

<?php
/**
 * Created by PhpStorm.
 * User: hongxin
 * Date: 2017/1/3
 * Time: 13:52
 */

require '../../common.inc.php';
$json = array ('DT' => $DT);
header('Access-Control-Allow-Origin:*');
echo json_encode ( array ('data' => $json), JSON_UNESCAPED_UNICODE);

?>
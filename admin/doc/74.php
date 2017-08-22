<?php
include 'header.html';
?>
<div class="tt">数据库操作</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><style>
                .f1 {color:#015D90;padding:0 5px 0 5px;}
                .f2 {color:#FF0000;}
                .code {font-family:Fixedsys,verdana;color:blue;font-size:12px;border:#CAD9EA 1px dotted;padding:5px 10px 5px 10px;background:#F9FCFF;}
            </style>

            初始化系统后系统会自动连接数据库，并将数据库操作对象保存在$db。数据库操作方法请参考include/db_mysql.class.php函数原型，以下仅对常用操作举例。<br>
            <br>
            <strong>1、执行SQL语句</strong><br>
            <br>
            <div class="code">
                $db-&gt;query("INSERT INTO `{$DT_PRE}table` (`xxx`) VALUES ('yyy')");
            </div>
            <br>
            <div class="code">
                $db-&gt;query("UPDATE `{$DT_PRE}table` SET `xxx`='yyy' WHERE `zzz`=1");
            </div>
            <br>
            <div class="code">
                $db-&gt;query("DELETE FROM `{$DT_PRE}table` WHERE `zzz`=1");
            </div>
            <br>
            <br>
            <strong>2、读取多条信息</strong><br>
            <br>
            <div class="code">
                $A = array();<br>
                $result = $db-&gt;query("SELECT * FROM `{$DT_PRE}table` WHERE `xxx`='yyy' ORDER BY `zzz` DESC LIMIT 0,10");<br>
                while($r = $db-&gt;fetch_array($result)) {<br>
                &nbsp;&nbsp;&nbsp;&nbsp;$A[] = $r;<br>
                }<br>
                print_r($A);
            </div>
            <br>
            <strong>3、读取单条信息</strong><br>
            <br>
            <div class="code">
                $A = $db-&gt;get_one("SELECT * FROM `{$DT_PRE}table` WHERE `xxx`='yyy'");<br>
                print_r($A);
            </div>
            <br>
            <strong>4、计算总数</strong><br>
            <br>
            <div class="code">
                $A = $db-&gt;get_one("SELECT COUNT(*) AS num FROM `{$DT_PRE}table` WHERE `xxx`='yyy'");<br>
                echo $A['num'];
            </div>
            <br>

            系统的表前缀可以使用变量$DT_PRE(一般在语句中使用)或者$db-&gt;pre(一般在函数中使用)。<br>
            如果在函数中使用数据库操作，需要先进行global $db;<br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-10-09 &nbsp;|&nbsp; 浏览次数:63444 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

<?php
include 'header.html';
?>
<div class="tt">忘记管理员密码如何找回</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;">1、如果系统开启了邮件发送，可以通过前台的找回密码功能邮件找回。<br>
            <br>
            2、使用数据库管理工具，例如PHPMyAdmin，找到destoon_member表，<br>
            <br>
            5.0及以下版本，修改管理员password字段值为：<span style="color: #0000ff">14e1b600b1fd579f47433b88e8d85291<br>
</span>6.0及以上版本，修改管理员password字段值为：<span style="color: rgb(0, 0, 255);">bb1aad6621657f367db7662ef7484b32</span>&nbsp; &nbsp;passsalt字段值为：<span style="color: rgb(0, 0, 255);">abcd1234</span><br>
            <br>
            或者，假如管理户名为admin，可以直接执行如下SQL语句：<br>
            <br>
            5.0及以下版本<br>
            <span style="color: #0000ff">update destoon_member set password='14e1b600b1fd579f47433b88e8d85291' where username='admin';</span><br>
            6.0及以上版本<br>
            <span style="color: #0000ff">update destoon_member set password='bb1aad6621657f367db7662ef7484b32',passsalt='abcd1234' where username='admin';</span><br>
            <br>
            通过以上操作，管理员密码将被设置为：<span style="color: #ff0000">123456<br>
</span><br>
            用密码123456登入后台，修改新的管理密码即可。</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2015-09-16 &nbsp;|&nbsp; 浏览次数:13570 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

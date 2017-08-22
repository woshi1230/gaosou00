<?php
include 'header.html';
?>
<div class="tt">电子邮件发送设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>进入网站设置 邮件发送</p>
            <p>1、使用126、163、QQ等第三方电子邮箱</p>
            <p>发送方式选择 通过SMTP SOCKET 连接 SMTP 服务器发送(支持ESMTP验证)，如下图<br>
                <br>
                <img height="485" width="646" alt="" src="http://static.destoon.com/home/201105/12/17-23-46-80-1.jpg"></p>
            <p>163的smtp服务器为 smtp.163.com<br>
                126的smtp服务器为 smtp.126.com<br>
                QQ的smtp服务器为 smtp.qq.com</p>
            <p>2、通过Linux的mail函数发送</p>
            <p>请先咨询服务器管理员，确定sendmail已经配置成功。<br>
                发送方式选择 通过PHP mail 函数发送(通常为Unix/Linux 主机)</p>
            <p>3、Winwebmail</p>
            <p>发送方式选择 通过SMTP SOCKET 连接 SMTP 服务器发送(支持ESMTP验证)<br>
                SMTP服务器是否验证 选择否(需要在Winwebmail的SMTP发信设置里添加服务器IP为信任IP)</p>
            <p>4、Gmail</p>
            <p>参考 <a href="http://help.destoon.com/use/14.html">http://help.destoon.com/use/14.html</a></p>
            <p>5、其他方式</p>
            <p>请咨询邮件服务器管理员</p>
            <p><br>
                <strong>设置失败常见问题：</strong></p>
            <p>- 发送方式选择错误<br>
                - SMTP服务器地址或端口填写错误<br>
                - 邮件帐号或密码填写错误<br>
                - 服务器上防火墙或杀毒软件阻止了邮件发送</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-05-12 &nbsp;|&nbsp; 浏览次数:14368 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

<?php
include 'header.html';
?>
<div class="tt">Gmail发送邮件的配置方法</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>目前大部分新申请的免费邮箱不支持smtp发信，对于没有独立服务或者没有企业邮局的用户，可以尝试使用Gmail发信。</p>
            <p>首先，PHP配置需要支持OpenSSL，可以在后台起始页 服务器信息-&gt;详细信息里查看</p>
            <p>如果可以看到 OpenSSL support&nbsp; enabled，说明支持ssl连接</p>
            <p>进入网站设置 邮件设置</p>
            <p>发送方式 选择 通过SMTP SOCKET 连接 SMTP 服务器发送(支持ESMTP验证)<br>
                邮件头的分隔符 选择 使用 CRLF 作为分隔符(通常为Windows主机)<br>
                SMTP服务器 填写 ssl://smtp.gmail.com<br>
                SMTP端口 填写 465<br>
                SMTP服务器是否验证 选择 是<br>
                邮箱帐号 填写 您的gmail地址（xxx@gmail.com）<br>
                邮箱密码 填写 您的gmail密码<br>
                发件人邮箱 填写 您的gmail地址</p>
            <p>测试是否发送成功。<br>
                &nbsp;</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2009-08-14 &nbsp;|&nbsp; 浏览次数:6972 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

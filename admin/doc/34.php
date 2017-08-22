<?php
include 'header.html';
?>
<div class="tt">如何修改后台管理地址</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>系统后台默认地址为 http://你的域名/admin.php</p>
            <p>为了网站安全，请远程登录服务器或者连接FTP修改网站根目录admin.php文件名。</p>
            <p>例如修改为 admin_xxx.php ，则新的管理地址为 http://你的域名/admin_xxx.php</p>
            <p>这样即使管理密码被盗，盗号者在不知道后台地址的情况下也无法登入后台。</p>
            <p><span style="color: rgb(255, 0, 0);">提示：自V6.0，后台文件名必须修改且网站根目录不存在admin.php文件之后才能登录后台。</span></p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2015-10-14 &nbsp;|&nbsp; 浏览次数:14490 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

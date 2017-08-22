<?php
include 'header.html';
?>
<div class="tt">累计x次错误尝试 您在x小时内不能登录系统</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;">当多次输入错误密码或帐号，系统会提示“累计x次错误尝试 您在x小时内不能登录系统”，出现此情况时，可以通过以下方法解决：<br>
            <br>
            1、如果是管理员被锁定，可以通过FTP连接服务器，打开cache/ban目录，删除 您的IP.php 文件即可解锁。<br>
            <br>
            自V4.0，cache目录已经移至file目录，所以在file/cache/ban里删除<br>
            <br>
            2、如果是普通会员被锁定，可以使用管理帐号登录后台，系统工具 -&gt; 禁止IP -&gt; 登录锁定 删除对会员IP的锁定。同样也可以用方法一来解除。<br>
            <br>
            登录锁定可以在后台会员管理 模块设置 登录失败次数限制 设置<br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-11-15 &nbsp;|&nbsp; 浏览次数:6096 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

<?php
include 'header.html';
?>
<div class="tt">网站安全设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p><strong>创始人密码安全</strong><br>
                系统创始人拥有最高管理权限，因此需要设置复杂的密码，例如数字、字母、特殊符号的组合，勿用123456等弱口令，以免被猜解。</p>
            <p><strong>后台登录地址</strong><br>
                后台登录地址默认为 你的域名/admin.php，可以通过FTP或在服务器上修改网站根目录/admin.php文件名，例如修改为 xxx.php ，然后通过 你的域名/xxx.php来管理网站。</p>
            <p><strong>后台安全</strong><br>
                网站设置，安全中心可以设置允许后台登录的IP和日期，同时安全中心可以选择是否开启后台管理日志。</p>
            <p><strong>模板安全</strong><br>
                如果自己制作了模板，为了防止被下载，可以设置一个秘密的目录名字，例如 template/aaabbb，在网站设置里面选择默认模板为 aaabbb。</p>
            <p><strong>数据库安全<br>
                </strong>如果是独立服务器，数据库服务器一般设置为localhost访问，禁止远程访问。密码勿用123456等弱口令，以免被猜解。<br>
                &nbsp;</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-01-12 &nbsp;|&nbsp; 浏览次数:19559 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

<?php
include 'header.html';
?>
<div class="tt">利用Rewrite规则设置网站安全</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;">规则一：<br>
            屏蔽非php扩展的动态文件，例如asp、aspx等，可以阻止asp、aspx等后缀的后门程序运行<br>
            <br>
            <span style="color: rgb(0, 0, 255);">RewriteRule ^(.*)\.(asp|aspx|asa|asax|dll|jsp|cgi|fcgi|pl)(.*)$ /404.php</span><br>
            <br>
            规则二：<br>
            屏蔽站点file目录php运行权限，站点的file目录默认具有写入权限，当网站出现未知漏洞时，可能会被写入后门程序，阻止php运行之后，即使有后门程序也将无法运行。<br>
            <br>
            <span style="color: rgb(0, 0, 255);">RewriteRule ^(.*)/file/(.*)\.php(.*)$ /404.php</span><br>
            <br>
            3.0及以下版本需要再加一条<br>
            <br>
            <span style="color: rgb(0, 0, 255);">RewriteRule ^(.*)/cache/(.*)\.php(.*)$ /404.php</span><br>
            <br>
            最新的伪静态规则已经更新，请参考：<a target="_blank" href="http://help.destoon.com/skill/10.html">http://help.destoon.com/skill/10.html</a><br>
            <br type="_moz"></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-10-09 &nbsp;|&nbsp; 浏览次数:16876 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

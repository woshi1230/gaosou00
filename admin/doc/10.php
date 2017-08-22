<?php
include 'header.html';
?>
<div class="tt">URL Rewrite(伪静态)设置方法</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>V6.0手机版伪静态规则不生效，提示Error Loading，请点击：<a href="http://bbs.destoon.com/thread-70821-1-1.html" target="_blank">http://bbs.destoon.com/thread-70821-1-1.html</a> 查看解决方法</p>
            <p>1、如果您的服务器支持.htaccess，则无需设置，网站根目录下的.htaccess已经设置好规则。<br>
                规则详情：<a href="http://download.destoon.com/rewrite/htaccess.txt" target="_blank">http://download.destoon.com/rewrite/htaccess.txt</a></p>
            <p>2、如果是Apache服务器</p>
            <p>Apache 1.x 的用户请检查 conf/httpd.conf 中是否存在如下两段代码： <br>
                LoadModule rewrite_module&nbsp;&nbsp;&nbsp;&nbsp; libexec/mod_rewrite.so<br>
                AddModule mod_rewrite.c</p>
            <p>Apache 2.x 的用户请检查 conf/httpd.conf 中是否存在如下一段代码： <br>
                LoadModule rewrite_module&nbsp;&nbsp;&nbsp;&nbsp; modules/mod_rewrite.so<br>
                <br>
                如果存在，且以#开头，请删除#。然后在配置文件（通常就是 conf/httpd.conf或者conf/extra/httpd-vhosts.conf）中加入如下代码。此时请务必注意，如果网站使用通过虚拟主机来定义，请务必加到虚拟主机配置，即 <virtualhost></virtualhost>中去，如果加在虚拟主机配置外部将可能无法使用。改好后然后将 Apache 重启。</p>
            <p>Apache conf文件配置规则<br>
                <a href="http://download.destoon.com/rewrite/apache.txt" target="_blank">http://download.destoon.com/rewrite/apache.txt</a></p>
            <p>3、Nginx规则<br>
                <a href="http://download.destoon.com/rewrite/nginx.txt" target="_blank">http://download.destoon.com/rewrite/nginx.txt</a></p>
            <p>4、Zeus规则<br>
                <a href="http://download.destoon.com/rewrite/zeus.txt" target="_blank">http://download.destoon.com/rewrite/zeus.txt</a><br>
                <br>
                5、IIS6服务器</p>
            <p>请下载 <a target="_blank" href="http://download.destoon.com/rewrite/IIS_Rewrite.zip">http://download.destoon.com/rewrite/IIS_Rewrite.zip</a><br>
                规则已经设置好，按readme.txt文件内容进行操作<br>
                如果网站支持httpd.ini文件，请下载<br>
                <a target="_blank" href="http://download.destoon.com/rewrite/httpd.ini">http://download.destoon.com/rewrite/httpd.ini</a></p>
            <p>7、IIS7服务器</p>
            <p>请参考&nbsp;<a href="http://download.destoon.com/rewrite/web.config.txt" target="_blank">http://download.destoon.com/rewrite/web.config.txt</a></p>
            <p><br>
                Rewrite生效后，请在网站后台 网站设置&nbsp;SEO优化&nbsp;URL Rewrite &nbsp;选择开启 提交</p>
            <p>然后进入各模块的模块设置 SEO设置 选择对应伪静态地址规则<br>
                <br>
                选择更新地址 提交<br>
                &nbsp;</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2015-09-22 &nbsp;|&nbsp; 浏览次数:85238 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

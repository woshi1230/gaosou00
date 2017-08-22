<?php
include 'header.html';
?>
<div class="tt">二级域名+会员名形式公司主页地址设置方法</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>开启会员二级域名容易影响主站的权重，按会员组设置不同的地址规则又会影响系统效率，基于此，DT4.0新增的目前门户网站较为常用的“二级域名/会员名”的地址格式。<br>
                例如百度的hi.baidu.com/username，新浪微博的weibo.com/username，QQ微博的t.qq.com/username，这样的地址既美观易记，又不会影响主站的权重。<br>
                假如你需要绑定的二级域名为i.xxx.com，首先解析这个域名到你的服务器ip，在服务器上建立站点绑定这个域名到主站的company目录，此站点需要单独设置伪静态规则，规则如下：</p>
            <p>Apache<br>
                <a href="http://download.destoon.com/rewrite/sub_apache.txt">http://download.destoon.com/rewrite/sub_apache.txt</a><br>
                <a href="http://download.destoon.com/rewrite/sub_htaccess.txt">http://download.destoon.com/rewrite/sub_htaccess.txt</a><br>
                IIS6<br>
                <a href="http://download.destoon.com/rewrite/DTURewrite.zip">http://download.destoon.com/rewrite/DTURewrite.zip</a><br>
                <a href="http://download.destoon.com/rewrite/sub_httpd.ini">http://download.destoon.com/rewrite/sub_httpd.ini</a><br>
                II7<br>
                <a href="http://download.destoon.com/rewrite/sub_web.config.txt">http://download.destoon.com/rewrite/sub_web.config.txt</a><br>
                Nginx<br>
                <a href="http://download.destoon.com/rewrite/sub_nginx.txt">http://download.destoon.com/rewrite/sub_nginx.txt</a><br>
                Zeus<br>
                <a href="http://download.destoon.com/rewrite/sub_zeus.txt">http://download.destoon.com/rewrite/sub_zeus.txt</a></p>
            <p><br>
                如果需要使用apache的.htaccess或者iis7的Web.config，为了不影响主站公司模块的运行，可以复制company为company1，然后把域名绑定到compnay1目录，.htaccess或者Web.config放在company1目录</p>
            <p>进入网站后台，网站设置，SEO优化，公司主页绑定二级域名填写i.xxx.com，保存<br>
                进入公司管理，更新数据，更新公司<br>
                进入公司管理，高手新闻，更新地址<br>
                进入公司管理，高手单页，更新地址</p>
            <p>以上操作完成之后，打开任意一个vip会员的公司主页，检查各个页面是否能正确打开。</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-10-09 &nbsp;|&nbsp; 浏览次数:31276 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

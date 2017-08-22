<?php
include 'header.html';
?>
<div class="tt">会员绑定二级域名和顶级域名的方法</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p><strong>会员绑定二级域名和顶级域名的方法</strong><br>
                <br>
                会员自动绑定二级域名的方法</p>
            <p>为了便于理解，下面以域名为abc.com讲解。</p>
            <p>首先在域名管理里添加一条A记录 *.abc.com 指向目标服务器IP</p>
            <p>然后在服务器上绑定*.abc.com 至 网站路径/company目录或网站根目录<br>
                <br>
                生效后进入网站后台 网站设置 SEO优化 公司主页绑定二级域名 填写 .abc.com</p>
            <p>进入网站后台 功能模块 公司管理 生成网页 更新公司</p>
            <p>系统会更新公司的主页地址。</p>
            <p>附：<br>
                Apache示例<br>
                <a target="_blank" href="http://download.destoon.com/vhost/apache.txt">http://download.destoon.com/vhost/apache.txt</a><br>
                Nginx示例<br>
                <a target="_blank" href="http://download.destoon.com/vhost/nginx.txt">http://download.destoon.com/vhost/nginx.txt</a><br>
                IIS示例<br>
                <a href="http://bbs.destoon.com/thread-72-1-1.html">http://bbs.destoon.com/thread-72-1-1.html</a></p>
            <virtualhost> </virtualhost> <br>
            <a href="http://bbs.destoon.com/thread-72-1-1.html"><br>
            </a>
            <p>&nbsp;</p>
            <p><strong>会员绑定顶级域名的方法</strong></p>
            <p>首先需要把服务器默认目录修改至 网站路径/company 目录，即输入服务器ip即可显示公司模块的页面</p>
            <p>要求会员将待绑定的域名A记录指向服务器IP</p>
            <p>修改会员资料，公司资料 绑定域名 里填写需要绑定的域名 例如 www.cde.com</p>
            <p>提交即可<br>
                &nbsp;</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-07-19 &nbsp;|&nbsp; 浏览次数:45391 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

<?php
include 'header.html';
?>
<div class="tt">FLV格式视频不能播放解决办法</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>如果上传的flv视频无法播放，可参考以下方法解决：<br>
                <br>
                1、如果是IIS服务器，打开网站属性，切换到HTTP头选项卡，点击右下角的MIME类型<br>
                <br>
                <img height="445" width="464" alt="" src="http://static.destoon.com/home/201101/25/18-05-24-81-1.jpg"><br>
                <br>
                <br>
                点新建，在“扩展名”框内输入“.flv”，“MIME类型”框中输入“video/x-flv”，然后确定<br>
                <br>
                2、Apache服务器，直接在httpd.conf文件里添加一行<br>
                <br>
<span style="color: #0000ff">AddType video/x-flv .flv<br>
</span></p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-01-25 &nbsp;|&nbsp; 浏览次数:9445 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

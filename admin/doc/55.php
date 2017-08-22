<?php
include 'header.html';
?>
<div class="tt">如何修改文件上传大小限制</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;">PHP默认限制的上传文件为2M，如果需要调整此限制，需要修改服务器端php.ini里面的upload_max_filesize参数。<br>
            <br>
            如果不清楚php.ini保存在什么位置，可以进入网站后台，在后台起始页面点击服务器详细信息：<br>
            <br>
            <img height="203" alt="" width="616" src="http://static.destoon.com/home/201101/26/14-17-12-68-1.jpg"><br>
            <br>
            <br>
            在打开的页面里查找php.ini即可看到php.ini的存放路径，如下图所示：<br>
            <br>
            <img height="87" alt="" width="600" src="http://static.destoon.com/home/201101/26/14-19-36-49-1.jpg"><br>
            <br>
            在服务器端编辑php.ini，查找 upload_max_filesize 然后修改对应的值，例如10M，保存后重启一下web服务器。<br>
            <br>
            进入网站后台，网站设置，安全中心，允许上传大小限制，填写限制大小，例如限制10M可以填写10240<br>
            <br>
            <br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-01-26 &nbsp;|&nbsp; 浏览次数:7560 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

<?php
include 'header.html';
?>
<div class="tt">大文件上传设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;">V4.0支持swfupload带进度提示上传大文件，对于视频和下载频道，需要上传的文件体积可能较大，所以要做以下设置才可以正常上传。<br>
            <br>
            1.修改php.ini&nbsp; post_max_size 参数，例如修改为100M<br>
            <br>
            2.修改php.ini&nbsp; upload_max_filesize 参数，例如修改为100M<br>
            <br>
            3.修改网站设置，安全中心，允许上传大小限制，例如修改为102400（代表100M）<br>
            <br type="_moz"></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-10-09 &nbsp;|&nbsp; 浏览次数:8108 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

<?php
include 'header.html';
?>
<div class="tt">如何开启下载镜像服务器</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;">镜像服务器可以在 api/mirror.inc.php 里配置名称和网址。<br>
            <br>
            如果你有多台文件存储服务器，可设置此项。<br>
            <br>
            设置请参考内容里的示例(#Example:)<br>
            <br>
            例如<br>
            <br>
            $MIRROR = array(<br>
            &nbsp;array('name'=&gt;'中国电信', 'url'=&gt;'http://down1.destoon.com/'),<br>
            &nbsp;array('name'=&gt;'联通网通', 'url'=&gt;'http://down2.destoon.com/'),<br>
            &nbsp;array('name'=&gt;'移动铁通', 'url'=&gt;'http://down3.destoon.com/'),<br>
            );<br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2010-08-10 &nbsp;|&nbsp; 浏览次数:3255 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

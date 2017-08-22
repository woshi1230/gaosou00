<?php
include 'header.html';
?>
<div class="tt">Table xxx is marked as crashed and should be repaired</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><br>
            服务器断电等原因可能导致数据表损坏，导致访问的时候提示：<br>
            <br>
            Table xxx is marked as crashed and should be repaired<br>
            <br>
            其中xxx为表的名称。<br>
            <br>
            可以在phpmyadmin执行以下修复语句来解决此问题：<br>
            <br>
            <span style="color: #0000ff">repair table xxx;</span><br>
            <br>
            例如 repair table destoon_session;<br>
            <br>
            <br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-10-09 &nbsp;|&nbsp; 浏览次数:2566 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

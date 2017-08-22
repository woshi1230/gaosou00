<?php
include 'header.html';
?>
<div class="tt">Can not connect to MySQL server</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;">系统无法连接到MySQL服务器，可以参考以下方法排除问题：<br>
            <br>
            检查服务器端MySQL服务是否已经启动。<br>
            <br>
            检查系统配置文件config.inc.php内提供的MySQL连接帐号是否正确。<br>
            <br>
            如果此问题频繁间断出现，尝试修改config.inc.php内pconnect参数为1，开启MySQL长连接。</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-10-09 &nbsp;|&nbsp; 浏览次数:78961 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

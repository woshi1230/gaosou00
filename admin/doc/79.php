<?php
include 'header.html';
?>
<div class="tt">QQ互联提示redirect uri is illegal(100010)</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;">&nbsp;QQ互联提示redirect uri is illegal(100010)，如下图：<br>
            <br>
            <img src="http://static.destoon.com/home/201506/17/16-00-28-40-1.jpg" width="666" height="238" alt=""><br>
            <br>
            此问题是由回调地址填写错误导致的，在QQ互联管理平台编辑应用，填写回调地址为：<br>
            <br>
            http://网站首页域名/api/oauth/qq/callback.php<br>
            <br>
            <img src="http://static.destoon.com/home/201506/17/16-00-52-22-1.jpg" alt=""><br>
            <br>
            （虽然QQ互联文档里提示填写网站域名就可以，但是实际测试会出错）</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2015-06-17 &nbsp;|&nbsp; 浏览次数:3517 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody>
</table>
<?php
include 'fooder.html';
?>
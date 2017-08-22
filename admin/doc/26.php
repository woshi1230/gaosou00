<?php
include 'header.html';
?>
<div class="tt">Cannot modify header information</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><br>
            UTF-8编码的文件用Windows记事本<span style="color: #ff0000">打开</span>或<span style="color: #ff0000">修改</span>时，会在文件头写入3字节的空白BOM字符，将可能导致如下问题：<br>
            <br>
            1、页面空白，在<a href="http://help.destoon.com/skill/23.html">开启错误报告</a>的情况下显示 Cannot modify header information...<br>
            <br>
            2、模板变形，字体变大，顶部出现一个换行<br>
            <br>
            3、验证码无法正常显示<br>
            <br>
            ......<br>
            <br>
            如果出现上述问题，可以用Editplus等编辑软件，打开文件另存为无BOM格式。<br>
            <br>
<span style="color: #ff0000">强烈建议不要用记事本 <strong>打开 </strong>或 <strong>修改 </strong>UTF-8编码的文件。<br>
<br>
<br>
</span><br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-10-09 &nbsp;|&nbsp; 浏览次数:2614 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

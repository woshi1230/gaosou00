<?php
include 'header.html';
?>
<div class="tt">500 Internal Server Error 解决方法</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p><strong>方法一</strong>、删除根目录下.htaccess文件，如果无效，请尝试方法二； <br>
                <br>
                <strong>方法二</strong>、对于Liunx/Unix服务器，如果不支持0777属性，可修改<br>
                <br>
                根目录config.inc.php<br>
                <br>
                <span style="color: #0000ff">$CFG['file_mod'] = 0777;</span><br>
                <br>
                为<br>
                <br>
                <span style="color: #0000ff">$CFG['file_mod'] = 0755 ;</span><br>
                <br>
                然后，FTP修改已经被系统自动修改为0777属性的目录和文件为0755属性。</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2010-03-08 &nbsp;|&nbsp; 浏览次数:6521 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

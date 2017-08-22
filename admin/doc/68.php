<?php
include 'header.html';
?>
<div class="tt">需要设置可写权限的目录和文件</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><strong>V4.0</strong><br>
            <br>
            about/<br>
            announce/<br>
            file/<br>
            config.inc.php<br>
            index.html<br>
            <br>
            <strong>V3.0及以下版本</strong><br>
            <br>
            announce/<br>
            cache/<br>
            extend/<br>
            file/<br>
            config.inc.php<br>
            index.html<br>
            <br>
            以上目录或文件必须正确设置可写权限，且设置目录可写时，必须包含所有子目录及子文件，否则可能引起系统功能无法正常使用。<br>
            <br>
            安装目录install在完成安装之后，系统会尝试销毁安装文件，但可能因为权限文件而无法销毁，建议ftp删除install目录。<br>
            <br>
            升级目录upgrade在完成升级之后，系统会尝试销毁升级文件，但可能因为权限问题而无法销毁，建议ftp删除upgrade目录。<br>
            <br>
            <br type="_moz"></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-10-09 &nbsp;|&nbsp; 浏览次数:14579 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

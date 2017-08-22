<?php
include 'header.html';
?>
<div class="tt">网站转移空间教程</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>1、首先登录Destoon后台，进入数据库维护</p>
            <p>&nbsp;&nbsp; 进入数据库恢复，如果有之前备份的文件，先全部删除</p>
            <p>&nbsp;&nbsp; 进入数据库备份，备份系统所有表<br>
                <br>
                &nbsp;&nbsp; 如果更换了域名，点击字符替换<br>
                <br>
                &nbsp;&nbsp; 选择一个备份系列<br>
                <br>
                &nbsp;&nbsp; 查找里填写旧的域名<br>
                <br>
                &nbsp;&nbsp; 替换里填写新的域名<br>
                <br>
                &nbsp;&nbsp; 执行<br>
                <br>
                <img height="309" alt="" width="636" src="http://static.destoon.com/home/200912/03/10-36-21-22-1.jpg"></p>
            <p>2、转移空间内所有文件至新空间(cache目录可不转移，系统会自动生成)</p>
            <p>3、修改新空间 config.inc.php 数据库连接参数，如果更换了网址，需要修改一下$CFG['url']配置的网址</p>
            <p>4、使用下面压缩包内的数据库管理工具恢复备份的数据库&nbsp;&nbsp;&nbsp;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://download.destoon.com/tool/db.zip">http://download.destoon.com/tool/db.zip</a><br>
                <br>
                <br>
                &nbsp;</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2010-08-19 &nbsp;|&nbsp; 浏览次数:28784 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

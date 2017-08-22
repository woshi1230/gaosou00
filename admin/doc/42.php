<?php
include 'header.html';
?>
<div class="tt">网站备份</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p><strong>1、备份数据库<br>
                </strong><br>
                进入网站后台》系统维护》系统工具》数据维护，如下图：<br>
                <br>
                <img height="323" alt="" width="597" src="http://static.destoon.com/home/201101/12/21-30-55-27-1.png"><br>
                &nbsp;<br>
                点击底部的“开始备份”按钮，系统将开始备份数据。<br>
                备份完成之后，备份文件保存在 网站目录/file/backup/ 目录里，1个目录就是一次备份所生成的文件，可以同FTP下载到本地电脑保存。<br>
                提示：如果是独立的服务器或者VPS可以直接在服务器上备份MySQL的data目录。<br>
                <br>
                <strong>2、备份附件</strong><br>
                系统上传的附件全部保存在 网站目录/file/upload/ 目录里，可以FTP下载到本地备份。<br>
                提示：系统每天生成一个按日期命名的目录，建议每日或定期备份一次新增的附件目录。<br>
                <br>
                <strong>3、其他文件</strong><br>
                如果修改过模板，可以FTP下载 网站目录/template目录<br>
                如果修改过风格，可以FTP下载 网站目录/skin目录<br>
                如果修改过公司主页风格，可以FTP下载 网站目录/company/skin目录<br>
                如果修改过语言文件，可以FTP下载 网站目录/lang目录</p>
            <p>以上文件全部正确备份之后，可以通过备份的文件随时恢复完整网站。<br>
                <br>
                <strong><span style="color: #ff0000">友情提示：</span></strong><span style="color: #ff0000"><br>
数据无价，良好的数据备份习惯是一位网站管理人员必备的职业素质。<br>
建议每周至少备份一次，切勿心存侥幸。</span></p>
            <p>&nbsp;</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-01-24 &nbsp;|&nbsp; 浏览次数:17030 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

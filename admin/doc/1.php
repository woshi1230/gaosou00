<?php
include 'header.html';
?>
<div class="tt">系统安装</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p><strong>一、系统运行环境</strong><br>
                <br>
                1、可用的httpd服务器（以下服务器软件任选其一）：<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IIS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Windows Server操作系统自带<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Apache&nbsp; <a href="http://www.apache.org" target="_blank">http://www.apache.org</a><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nginx&nbsp;&nbsp;&nbsp; <a href="http://www.nginx.org" target="_blank">http://www.nginx.org</a><br>
                2、PHP 4.3.0及以上<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://www.php.net" target="_blank">http://www.php.net</a><br>
                3、MySQL 4.0.0及以上<br>
                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<a href="http://www.mysql.com" target="_blank">http://www.mysql.com</a></p>
            <p>服务器端软件的安装和设置请参考网上教程或联系技术支持，站点目录文档顺序应该为index.html index.php。<br>
                <br>
                如果需要在本地电脑体验，可以下载DTServer一键安装包，一键完成Destoon B2B本地环境的运行的安装。<br>
                <br>
                下载地址：<a href="http://www.destoon.com/download.php?file=DTServer.rar">http://www.destoon.com/download.php?file=DTServer.rar</a><br>
                <br>
                <strong>二、系统安装</strong><br>
                <br>
                1、解压destoon软件压缩包，将压缩包内destoon目录内的所有文件及目录上传至网站根目录。<br>
                <br>
                &nbsp;<img width="601" height="259" src="http://static.destoon.com/home/201101/12/21-02-12-72-1.png" alt=""><br>
                <br>
                2、如果安装Destoon的服务器目录访问地址为http://www.abc.com/，则访问http://www.abc.com/install/进入程序安装向导。<br>
                &nbsp;<br>
                <img src="http://static.destoon.com/home/201101/12/21-02-56-56-1.png" alt=""><br>
                <br>
                <br>
                3、根据安装向导提示设置必要的数据库连接参数以及必要的文件属性完成系统安装。<br>
                <br>
                <strong>三、系统安装常见问题<br>
                </strong><br>
                1、500 internal server error。请删除根目录下.htaccess文件 或 对于Liunx/Unix服务器，如果不支持0777属性，可修改config.inc.php内 $CFG['file_mod'] = 0777; 为 $CFG['file_mod'] = 0755; 提示修改被系统自动修改为0777属性的目录或者文件属性为0755。<br>
                <br>
                2、license.txt文件不存在或被修改。请FTP二进制上传根目录license.txt。<br>
                <br>
                提示：为了确保所有功能都可以正常使用，不建议使用虚拟空间，推荐选择VPS或者独立服务器(<a target="_blank" href="http://idc.destoon.com/">http://idc.destoon.com/</a>)。<br>
                <br>
                <br>
                &nbsp;</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-12-01 &nbsp;|&nbsp; 浏览次数:40117 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

<?php
include 'header.html';
?>
<div class="tt">系统升级</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><strong>系统升级</strong>是指程序低版本向高版本的升级，例如V2.5升级为V3.0。版本的升级意味着程序结构和数据库结构发生了重大变化，因此会发布升级包，正确的升级步骤如下：<br>
            <br>
            1、进入网站后台，网站设置，关闭网站；<br>
            2、备份数据库，可以在后台备份或者直接在服务器上备份MySQL的data目录里面的数据库目录；<br>
            3、备份修改过的模板、风格、PHP文件，同时建议备份一下根目录config.inc.php；<br>
            4、上传升级程序，访问 你的域名/upgrade/ 进入升级向导，根据向导提示完成系统升级；</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2013-09-11 &nbsp;|&nbsp; 浏览次数:14938 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

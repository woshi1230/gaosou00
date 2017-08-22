<?php
include 'header.html';
?>
<div class="tt">会员整合Ucenter/Discuz!/PHPWind教程</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>首先进入 Destoon网站后台 -〉会员管理 -〉模块设置 -〉会员整合</p>
            <p>假如需要整合的主站地址为 http://www.abc.com 论坛为 http://bbs.abc.com</p>
            <p><strong>1、整合Ucenter</strong></p>
            <p>详见：<a href="http://help.destoon.com/skill/18.html">http://help.destoon.com/skill/18.html</a>&nbsp;</p>
            <p><strong>2、整合Discuz!(5.x/6.x)</strong></p>
            <p>- 启用会员整合 选择 Discuz!<br>
                - 整合程序字符编码 选择 论坛 http://bbs.abc.com 的编码<br>
                - 整合程序地址 填写 http://bbs.abc.com<br>
                - 整合密钥 自行设定 建议 字母和数字组合<br>
                - 提交</p>
            <p>进入 Discuz! -〉扩展设置 -〉通行证设置</p>
            <p>- 启用通行证 选择 是<br>
                - 通行证私有密钥 填写 整合密钥<br>
                - 应用程序 URL 地址 填写 http://www.abc.com/member/<br>
                - 应用程序注册地址 填写 register.php<br>
                - 应用程序登录地址 填写 login.php<br>
                - 应用程序退出地址 填写 logout.php<br>
                - 提交</p>
            <p><strong>3、整合PHPWind(6.x/7.x)</strong></p>
            <p>- 启用会员整合 选择 PHPWind<br>
                - 整合程序字符编码 选择 论坛 http://bbs.abc.com 的编码<br>
                - 整合程序地址 填写 http://bbs.abc.com<br>
                - 整合密钥 自行设定 建议 字母和数字组合<br>
                - 提交</p>
            <p>进入 PHPWind后台 -〉插件中心 -〉通行证</p>
            <p>- 是否开启通行证 选择 是<br>
                - 通行证私有密钥 填写 整合密钥<br>
                - 将该网站做为通行证的 选择 客户端<br>
                - 通行证服务器地址 填写 http://www.abc.com/member<br>
                - 通行证登录地址 填写 login.php<br>
                - 通行证登录地址 填写 logout.php?<br>
                - 通行证注册地址 填写 register.php<br>
                - 提交</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-03-01 &nbsp;|&nbsp; 浏览次数:35062 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

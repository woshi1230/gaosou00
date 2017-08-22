<?php
include 'header.html';
?>
<div class="tt">Cookie作用域的设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;">当网站任意一个模块绑定了二级域名或者会员公司主页开启了二级域名时，必须设置cookie作用域，否则会导致二级域名站点不能显示正确的登录状态，js权限错误等问题(例如评论框显示不完全的现象)。<br>
            <br>
            进入网站设置，安全中心可以设置Cookie作用域。<br>
            <br>
            例如你的主站域名为 <span style="color: #0000ff"><strong>www.abc.com</strong></span>，那么对应的cookie作用域应该为 <span style="color: #0000ff"><strong>.abc.com</strong></span>，注意前面有个点。<br>
            <br>
            第一次更改cookie作用域之后，需要同时修改一下cookie前缀，否则会出现当前帐号无法正常退出的情况(可以删除浏览器cookies强行退出)。<br>
            <br>
            设置完毕之后，需要点一下生成首页，以便立即更新配置文件config.js内容。<br>
            <br>
            <br>
            <br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-01-20 &nbsp;|&nbsp; 浏览次数:8697 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

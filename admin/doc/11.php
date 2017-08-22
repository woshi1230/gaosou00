<?php
include 'header.html';
?>
<div class="tt">模块绑定二级域名的方法</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>Destoon B2B网站管理系统所有模块均可绑定二级域名，方法如下</p>
            <p>1、网站设置 -&gt; 绝对地址 -&gt; 启用 (默认是启用的，如果没有更改过可跳过此步)</p>
            <p>2、模块管理 -&gt; 修改 -&gt; 绑定域名 填写二级域名</p>
            <p>例如：</p>
            <p>为供应模块绑定 sell.abc.com 则填写 http://sell.abc.com/ (注意 / 结尾)<br>
                然后将域名 sell.abc.com 绑定到 网站目录/sell<br>
                进入功能 供应管理 生成网页 更新信息<br>
                如果生成了html页面，需要重新生成一遍</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2009-08-01 &nbsp;|&nbsp; 浏览次数:25756 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

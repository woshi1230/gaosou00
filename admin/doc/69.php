<?php
include 'header.html';
?>
<div class="tt">地图接口</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;">公司主页地图接口可以在网站后台，公司管理，模块设置里选择。<br>
            <br>
            您可能需要先在对应的网站申请一个接口API KEY，申请地址如下：<br>
            <br>
            Google地图<br>
            APP KEY申请地址：<a href="http://code.google.com/intl/zh-CN/apis/maps/signup.html" target="_blank">http://code.google.com/intl/zh-CN/apis/maps/signup.html</a><br>
            <br>
            Baidu地图<br>
            APP KEY申请地址：无需申请<br>
            <br>
            Mapabc<br>
            APP KEY申请地址：<a href="http://code.mapabc.com" target="_blank">http://code.mapabc.com/</a><br>
            <br>
            51ditu<br>
            APP KEY申请地址：无需申请<br>
            <br>
            获取到KEY之后，打开对应的地图配置文件，以Google地图为例，配置文件保存在网站目录/api/map/google/config.inc.php，其中：<br>
            <br>
            $map_mid 代表地图默认中心点的经纬度<br>
            $map_key 代表接口的API KEY<br>
            <br type="_moz"></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2015-05-18 &nbsp;|&nbsp; 浏览次数:11346 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

<?php
include 'header.html';
?>
<div class="tt">IP地址库更新教程</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>由于电信会不时的更改IP段，可能导致根据IP显示的地区出现不准确的情况，因此需要定期更新IP数据库。</p>
            <p>系统支持纯真版IP数据库，下载地址：<a href="http://www.cz88.net/">http://www.cz88.net/</a></p>
            <p>下载后，将软件包内QQWry.Dat改名为wry.dat，上传至网站目录file/ipdata/即可。</p>
            <p>自V4.0，系统已经支持新浪的IP地址库接口，进入网站file/ipdata目录，删除wry.dat和tiny.dat，建立一个空的sina.dat文件上传至此目录即可启用，启用之后在后台查询IP测试一下，如果能正确显示说明你的服务器支持此接口。</p>
            <p>系统读取file/ipdata目录下的库文件的顺序依次是：</p>
            wry.dat纯真IP库，需要定期更新以保证数据准确<br>
            tiny.dat精简版数据库，体积小，但是数据可能不准确<br>
            sina.dat新浪数据库，在线查询，数据准确<br>
            <p>例如删除wry.dat，系统将优先读取tiny.dat，删除wry.dat和tiny.dat，系统将优先读取sina.dat</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-09-12 &nbsp;|&nbsp; 浏览次数:4798 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

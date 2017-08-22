<?php
include 'header.html';
?>
<div class="tt">如何开启系统的错误报告</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>当由于服务器环境、修改代码、修改模板等原因导致页面空白时，可以开启系统的错误报告，根据错误提示来查找原因。</p>
            <p>查找系统根目录 common.inc.php 第6行</p>
            <p><span style="color: #0000ff">define('DT_DEBUG', 0);</span></p>
            <p>修改为</p>
            <p><span style="color: #0000ff">define('DT_DEBUG', 1);</span></p>
            <p>这样就可以开启错误报告。保存后，刷新出错的页面一般就可以看到错误提示。</p>
            <p><strong>注意：</strong><br>
                1、错误原因找到之后，请及时关闭错误报告，修改1为0<br>
                2、如果是UTF-8编码的程序，请<span style="color: #ff0000">不要用记事本修改PHP文件</span>，否则可能导致程序出错。<br>
                &nbsp;</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-10-09 &nbsp;|&nbsp; 浏览次数:6871 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

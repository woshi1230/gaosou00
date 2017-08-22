<?php
include 'header.html';
?>
<div class="tt">在线支付配置说明</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>当前支持的第三方支付平台为 网银在线、支付宝、财付通。</p>
            <p>配置参数在 网站后台 -&gt; 会员管理 -&gt; 模块设置 -&gt; 支付接口 设置。</p>
            <p>相应的商户帐号，密钥等信息需要在对应的官方网站获取。具体请参考：</p>
            <p>网银在线: <a target="_blank" href="http://www.chinabank.com.cn">http://www.chinabank.com.cn</a></p>
            <p>支付宝: <a target="_blank" href="http://www.alipay.com">http://www.alipay.com</a><br>
                <br>
                财付通: <a target="_blank" href="http://www.tenpay.com">http://www.tenpay.com</a></p>
            <br>
            <p>为了防止充值过程中的掉单情况，需要设置正确的接受服务器通知地址。</p>
            <br>
            对于网银在线，请联系网银在线客服，提交商户号及接收地址<br>
            假如你的网站为 www.abc.com 则接收地址为 http://www.abc.com/api/chinabank.php<br>
            为了防止接收地址受到不必要的骚扰，建议修改 api/chinabank.php 文件名，例如 chinabank_123.php<br>
            然后提交接收地址为 http://www.abc.com/api/chinabank_123.php<br>
            <br>
            对于支付宝，默认接收通知文件为 api/alipay.php<br>
            为了防止接收地址受到不必要的骚扰，建议修改 alipay.php 文件名，例如 alipay_123.php<br>
            然后在网站后台 -&gt; 会员管理 -&gt; 模块设置 -&gt; 支付接口 -&gt; 支付宝 Alipay -&gt; 接收服务器通知文件名 填写新的文件名 alipay_123.php 即可<br>
            <br>
            <br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2009-12-31 &nbsp;|&nbsp; 浏览次数:18507 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

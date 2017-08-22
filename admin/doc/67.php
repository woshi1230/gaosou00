<?php
include 'header.html';
?>
<div class="tt">系统常量与变量</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><style>
                .var{background:#666666;margin:auto;}
                .var th{background:#888888;font-weight:bold;height:25px;line-height:24px;letter-spacing:1px;color:#FFFFFF;}
                .var td{line-height:20px;padding-left:10px;padding-right:10px;font-family:Arial;}
                .var tr{background:#FFFFFF;}
                .on td{background:#CCCCFF;}
            </style>
            <table cellpadding="5" cellspacing="1" class="var" width="760">
                <tbody><tr><th width="160">常量</th><th width="300">说明</th><th>备注</th></tr>
                <tr><td>DT_ROOT</td><td>站点物理路径</td><td></td></tr>
                <tr><td>DT_PATH</td><td>站点首页网址</td><td></td></tr>
                <tr><td>DT_SKIN</td><td>风格目录网址</td><td></td></tr>
                <tr><td>DT_STATIC</td><td>静态文件地址</td><td>&gt;=5.0</td></tr>
                <tr><td>DT_ADMIN</td><td>是否在管理后台</td><td></td></tr>
                <tr><td>DT_DOMAIN</td><td>Cookie作用域</td><td></td></tr>
                <tr><td>DT_LANG</td><td>站点语言</td><td></td></tr>
                <tr><td>DT_KEY</td><td>安全密钥</td><td></td></tr>
                <tr><td>DT_CHARSET</td><td>字符编码</td><td></td></tr>
                <tr><td>DT_CACHE</td><td>缓存目录物理路径</td><td></td></tr>
                <tr><td>DT_VERSION</td><td>系统版本</td><td></td></tr>
                <tr><td>DT_RELEASE</td><td>更新时间</td><td></td></tr>
                <tr><td>VIP</td><td>VIP名称</td><td></td></tr>
                <tr><th>变量</th><th>说明</th><th>备注</th></tr>
                <tr><td>$DT_TIME</td><td>当前时间</td><td>Unix时间戳</td></tr>
                <tr><td>$DT_IP</td><td>当前IP</td><td></td></tr>
                <tr><td>$DT_URL</td><td>当前网址URL</td><td></td></tr>
                <tr><td>$DT_PRE</td><td>数据表前缀</td><td></td></tr>
                <tr><td>$db</td><td>数据库操作对象</td><td></td></tr>
                <tr><td>$dc</td><td>缓存操作对象</td><td></td></tr>
                <tr><td>$DT</td><td>网站设置</td><td>数组</td></tr>
                <tr><td>$EXT</td><td>扩展功能模块设置</td><td>数组</td></tr>
                <tr><td>$MOD</td><td>当前模块设置</td><td>数组，仅模块内部存在</td></tr>
                <tr><td>$MODULE</td><td>系统模块信息</td><td>数组</td></tr>
                <tr><td>$forward</td><td>来源页面</td><td></td></tr>
                <tr><td>$page</td><td>当前页码</td><td></td></tr>
                <tr><td>$moduleid</td><td>模块ID</td><td></td></tr>
                <tr><td>$catid</td><td>分类ID</td><td></td></tr>
                <tr><td>$CAT</td><td>$catid所有属性</td><td>数组</td></tr>
                <tr><td>$areaid</td><td>地区ID</td><td></td></tr>
                <tr><td>$ARE</td><td>$areaid所有属性</td><td>数组</td></tr>
                <tr><td>$itemid</td><td>信息ID</td><td></td></tr>
                <tr><td>$cityid</td><td>分站ID</td><td></td></tr>
                <tr><td>$kw</td><td>搜索关键词</td><td></td></tr>
                <tr><td>$_userid</td><td>当前登录会员的会员ID</td><td>0为游客</td></tr>
                <tr><td>$_username</td><td>当前登录会员的会员名</td><td></td></tr>
                <tr><td>$_truename</td><td>当前登录会员的姓名</td><td></td></tr>
                <tr><td>$_company</td><td>当前登录会员的公司名</td><td></td></tr>
                <tr><td>$_money</td><td>当前登录会员的资金</td><td></td></tr>
                <tr><td>$_credit</td><td>当前登录会员的积分</td><td></td></tr>
                <tr><td>$_sms</td><td>当前登录会员的短信</td><td></td></tr>
                <tr><td>$_message</td><td>当前登录会员的站内信</td><td></td></tr>
                <tr><td>$_chat</td><td>当前登录会员的新对话</td><td></td></tr>
                <tr><td>$_groupid</td><td>当前登录会员的会员组</td><td></td></tr>
                <tr><td>$MG</td><td>当前登录会员的会员组权限</td><td></td></tr>
                </tbody></table></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-11-17 &nbsp;|&nbsp; 浏览次数:57235 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

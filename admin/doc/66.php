<?php
include 'header.html';
?>
<div class="tt">系统目录文件结构</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><style>
                .dir{background:#666666;margin:auto;}
                .dir th{background:#888888;font-weight:bold;height:25px;line-height:24px;letter-spacing:1px;color:#FFFFFF;}
                .dir td{line-height:20px;padding-left:10px;padding-right:10px;font-family:Arial;}
                .dir tr{background:#FFFFFF;}
                .on td{background:#CCCCFF;}
            </style>
            <table cellpadding="5" cellspacing="1" class="dir" width="760">
                <tbody><tr><th width="300">目录/文件</th><th>说明</th></tr>
                <tr><td>/admin</td><td>系统核心后台管理</td></tr>
                <tr><td>├ image</td><td>后台风格</td></tr>
                <tr><td>├ template</td><td>后台模板</td></tr>
                <tr><td>/api</td><td>系统及第三方接口</td></tr>
                <tr><td>├ kf</td><td>在线客服</td></tr>
                <tr><td>├ map</td><td>电子地图</td></tr>
                <tr><td>├ oauth</td><td>一键登录</td></tr>
                <tr><td>├ pay</td><td>支付接口</td></tr>
                <tr><td>├ stats</td><td>第三方统计</td></tr>
                <tr><td>├ trade</td><td>担保交易</td></tr>
                <tr><td>├ ucenter</td><td>UCenter</td></tr>
                <tr><td>/file</td><td></td></tr>
                <tr><td>├ backup</td><td>数据库备份</td></tr>
                <tr><td>├ cache</td><td>缓存</td></tr>
                <tr><td>├ captcha</td><td>验证码字体</td></tr>
                <tr><td>├ chat</td><td>聊天记录</td></tr>
                <tr><td>├ config</td><td>配置</td></tr>
                <tr><td>├ data</td><td>导数据导入</td></tr>
                <tr><td>├ email</td><td>邮件列表</td></tr>
                <tr><td>├ flash</td><td>Flash文件</td></tr>
                <tr><td>├ font</td><td>中文字体</td></tr>
                <tr><td>├ image</td><td>公用图片</td></tr>
                <tr><td>├ ipdata</td><td>IP数据库</td></tr>
                <tr><td>├ log</td><td>日志</td></tr>
                <tr><td>├ md5</td><td>MD5镜像</td></tr>
                <tr><td>├ mobile</td><td>手机列表</td></tr>
                <tr><td>├ script</td><td>javascript</td></tr>
                <tr><td>├ session</td><td>SESSION</td></tr>
                <tr><td>├ setting</td><td>配置数据</td></tr>
                <tr><td>├ temp</td><td>临时目录</td></tr>
                <tr><td>├ update</td><td>系统更新</td></tr>
                <tr><td>├ upload</td><td>上传文件</td></tr>
                <tr><td>/include</td><td>核心类库</td></tr>
                <tr><td>/install</td><td>安装程序</td></tr>
                <tr><td>/lang</td><td>语言包</td></tr>
                <tr><td>/module</td><td>功能模块</td></tr>
                <tr><td>├ article</td><td>文章模块</td></tr>
                <tr><td>├ article/admin</td><td>文章管理</td></tr>
                <tr><td>├ article/admin/template</td><td>文章管理模板</td></tr>
                <tr><td>├ article/common.inc.php</td><td>文章模块初始化</td></tr>
                <tr><td>├ article/global.func.php</td><td>文章核心函数</td></tr>
                <tr><td>├ article/article.class.php</td><td>文章核心类</td></tr>
                <tr><td>├ article/index.inc.php</td><td>文章首页</td></tr>
                <tr><td>├ article/index.htm.php</td><td>静态文章首页</td></tr>
                <tr><td>├ article/list.inc.php</td><td>文章列表页</td></tr>
                <tr><td>├ article/list.htm.php</td><td>静态文章列表页</td></tr>
                <tr><td>├ article/show.inc.php</td><td>文章内容页</td></tr>
                <tr><td>├ article/show.htm.php</td><td>静态文章内容页</td></tr>
                <tr><td>├ article/search.inc.php</td><td>文章搜索</td></tr>
                <tr><td>├ article/task.inc.php</td><td>文章计划任务</td></tr>
                <tr><td>/skin</td><td>风格皮肤</td></tr>
                <tr><td>├ default</td><td>默认风格</td></tr>
                <tr><td>├ default/image</td><td>图片文件</td></tr>
                <tr><td>├ default/style.css</td><td>CSS文件</td></tr>
                <tr><td>/template</td><td>模板文件</td></tr>
                <tr><td>├ default</td><td>默认模板</td></tr>
                <tr><td>├ default/index.htm</td><td>首页模板</td></tr>
                <tr><td>/upgrade</td><td>系统升级</td></tr>
                <tr><td>/admin.php</td><td>后台入口</td></tr>
                <tr><td>/common.inc.php</td><td>系统初始化</td></tr>
                <tr><td>/config.inc.php</td><td>系统配置</td></tr>
                <tr><td>/index.html</td><td>静态首页</td></tr>
                <tr><td>/index.php</td><td>动态首页</td></tr>
                <tr><td>/version.inc.php</td><td>版本控制</td></tr>
                </tbody></table></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-11-17 &nbsp;|&nbsp; 浏览次数:46600 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

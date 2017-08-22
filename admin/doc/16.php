<?php
include 'header.html';
?>
<div class="tt">配置文件config.inc.php参数说明</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><strong>$CFG['db_host']</strong><br>
            数据库服务器,可以包括端口号,一般为localhost<br>
            <br>
            <strong>$CFG['db_user']</strong><br>
            数据库用户名,一般为root<br>
            <br>
            <strong>$CFG['db_pass']</strong><br>
            数据库密码<br>
            <br>
            <strong>$CFG['db_name']</strong><br>
            数据库名称<br>
            <br>
            <strong>$CFG['db_charset']</strong><br>
            数据库连接字符集<br>
            <br>
            <strong>$CFG['database']</strong><br>
            数据库类型，默认为mysql<br>
            <br>
            <strong>$CFG['pconnect']</strong><br>
            是否使用持久连接<br>
            <br>
            <strong>$CFG['tb_pre']</strong><br>
            数据表前缀，默认为destoon_<br>
            <br>
            <strong>$CFG['charset']</strong><br>
            网站字符集<br>
            <br>
            <strong>$CFG['path']</strong><br>
            系统安装路径(相对于网站根路径的) 以 / 结尾<br>
            <br>
            <strong>$CFG['url']</strong><br>
            网站访问地址，以 / 结尾<br>
            <br>
            <strong>$CFG['absurl']</strong><br>
            是否启用绝对地址1=启用[如有任一模块绑定二级域名时必须启用] 0=不启用<br>
            <br>
            <strong>$CFG['com_domain']</strong><br>
            公司库绑定域名<br>
            <br>
            <strong>$CFG['com_dir']</strong><br>
            泛解析绑定目录 1=company目录 0=网站根目录<br>
            <br>
            <strong>$CFG['com_rewrite']</strong><br>
            会员顶级域名ReWrite 1=开启 0=关闭<br>
            <br>
            <strong>$CFG['com_vip']</strong><br>
            VIP会员名称<br>
            <br>
            <strong>$CFG['file_mod']</strong><br>
            文件或目录可写属性,Windows服务器可以填0<br>
            <br>
            <strong>$CFG['cache_dir']</strong><br>
            缓存目录 允许和网站不在同一目录或磁盘分区 <br>
            目录必须存在且PHP需具备访问和写入权限 例如设置 E:\cache 结尾不要 \<br>
            <br>
            <strong>$CFG['db_expires']</strong><br>
            数据库查询结果缓存过期时间(秒) <br>
            <br>
            <strong>$CFG['tag_expires']</strong><br>
            数据调用标签缓存过期时间(秒) <br>
            <br>
            <strong>$CFG['template_refresh']</strong><br>
            模板自动刷新(0=关闭,1=打开,如不再修改模板,请关闭)<br>
            <br>
            <strong>$CFG['template_trim']</strong><br>
            去除模板换行等多余标记,可以压缩一定网页体积(0=关闭,1=打开)<br>
            <br>
            <strong>$CFG['cookie_domain']</strong><br>
            cookie 作用域 例如 .destoon.com 如果绑定了二级域名 此项必须设置<br>
            <br>
            <strong>$CFG['cookie_path']</strong><br>
            cookie 作用路径<br>
            <br>
            <strong>$CFG['cookie_pre']</strong><br>
            cookie 前缀<br>
            <br>
            <strong>$CFG['timezone']</strong><br>
            时区设置(&gt;PHP 5.1),Etc/GMT-8 实际表示的是 GMT+8 GMT+8 <br>
            <br>
            <strong>$CFG['timediff']</strong><br>
            服务器时间校正 单位(秒) 可以为负数<br>
            <br>
            <strong>$CFG['template']</strong><br>
            默认模板<br>
            <br>
            <strong>$CFG['skin']</strong><br>
            默认风格<br>
            <br>
            <strong>$CFG['language']</strong><br>
            默认语言<br>
            <br>
            <strong>$CFG['authkey']</strong><br>
            网站安全密钥，建议定期在后台修改 推荐字母和数字组合<br>
            <br>
            <strong>$CFG['founderid']</strong><br>
            创始人ID<br>
            创始人相对于其他超级管理员独具以下系统权限<br>
            全站设置 管理员管理 模块管理/设置 数据库管理 模板管理 栏目管理 地区管理 在线升级等系统关键操作<br>
            <br>
            <strong>$CFG['edittpl']</strong><br>
            是否允许在后台编辑模板 (0=关闭,1=打开)<br>
            <br>
            <strong>$CFG['executesql']</strong><br>
            是否允许在后台运行SQL语句 (0=关闭,1=打开)<br>
            <br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2015-01-16 &nbsp;|&nbsp; 浏览次数:18845 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

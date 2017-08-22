<?php
include 'header.html';
?>
<div class="tt">二次开发入门</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><style>
                .code {font-family:Fixedsys,verdana;color:blue;font-size:12px;border:#CAD9EA 1px dotted;padding:5px 10px 5px 10px;background:#F9FCFF;}
            </style>
            <strong>一、初始化系统</strong><br>
            <br>
            包含系统根目录下的common.inc.php即可初始化系统。<br>
            <br>
            例如在站点根目录下创建一个hello.php。<br>
            <br>
            示例代码：<br>
            <div class="code">
                &lt;?php<br>
                require 'common.inc.php';<br>
                echo 'Hello World';<br>
                ?&gt;
            </div>
            <br>
            <strong>二、编写逻辑</strong><br>
            <br>
            系统初始化之后，就可以在php文件里编写逻辑代码，同时也可以调用系统内置的变量、函数和类了。<br>
            <br>
            示例代码：<br>
            <br>

            <div class="code">
                &lt;?php<br>
                require 'common.inc.php';<br>
                <br>
                echo DT_ROOT;//输出站点的物理路径<br>
                echo '&lt;br/&gt;';<br>
                <br>
                echo DT_PATH;//输出站点的首页地址<br>
                echo '&lt;br/&gt;';<br>
                <br>
                $r = $db-&gt;get_one("SELECT * FROM {$DT_PRE}category");//从分类表里查询一条数据<br>
                print_r($r);//打印读取的数据<br>
                <br>
                $A = cache_read('area.php');//读取系统的地区缓存<br>
                print_r($A);//打印读取的数据<br>
                <br>
                print_r($MODULE);//打印系统模块数据<br>
                <br>
                message('Hello World');//输出一段提示信息<br>
                ?&gt;
            </div>

            <br>
            <strong>三、应用模板</strong><br>
            <br>
            所有输出给浏览器的HTML均通过模板里的规则显示。<br>
            <br>
            使用方法：<br>
            <br>

            <div class="code">
                include template('a', 'b');
            </div>

            <br>
            参数a表示模版名称<br>
            参数b表示模板存放的目录，此参数可以不设置<br>
            <br>
            假如模板目录为default，那么：<br>
            template('a', 'b'); 代表 template/default/b/a.htm 模板文件<br>
            template('a'); 代表 template/default/a.htm 模板文件<br>
            <br>
            示例代码：<br>
            <br>

            <div class="code">
                &lt;?php<br>
                require 'common.inc.php';<br>
                template('hello');<br>
                ?&gt;
            </div>

            <br>
            template/default/hello.htm 模板文件需要提前创建<br>
            <br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-12-16 &nbsp;|&nbsp; 浏览次数:72171 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

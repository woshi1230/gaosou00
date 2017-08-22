<?php
include 'header.html';
?>
<div class="tt">Destoon B2B标签(tag)调用手册</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><style>
                .f1 {color:#015D90;padding:0 5px 0 5px;}
                .f2 {color:#FF0000;}
                .code {font-family:Fixedsys,verdana;color:blue;font-size:12px;border:#CAD9EA 1px dotted;padding:5px 10px 5px 10px;background:#F9FCFF;}
            </style>
            <strong>什么是标签调用？</strong><br>
            标签调用是根据<span class="f1">调用条件(condition)</span>从<span class="f1">数据表(table)</span>读取<span class="f1">调用数量(pagesize)</span>条数据，并按<span class="f1">排序方式(order)</span>排序，最终通过标签模板的布局输出数据。<br>
            可以看出，标签的工作分两个部分，一是读取数据，二是显示数据。<br>
            <br>
            <strong>标签函数原型</strong><br>
            标签函数保存于 include/tag.func.php<br>
            <div class="code">tag($parameter, $expires = 0)</div>
            $parameter 表示传递给tag函数的字符串，系统自动将其转换为多个变量。<br>
            例如传递 table=destoon&amp;pagesize=10&amp;hello=world<br>
            系统相当于得到：<br>
            $table = 'destoon';<br>
            $pagesize = 10;<br>
            $hello = 'world';<br>
            三个变量<br>
            $expires 表示标签缓存过期时间<br>
            <span style="color:blue;">&gt;0</span>  缓存$expires秒；<span style="color:blue;">0</span> - 系统默认标签缓存时间；<span style="color:blue;">-1</span> - 不缓存；<span style="color:blue;">-2</span> - 缓存SQL结果；<br>
            一般情况保持默认不需要传递。<br>
            <br>
            <strong>数据读取过程</strong><br>
            例如以下标签：
            <div class="code">&lt;!--{tag("moduleid=5&amp;condition=status=3&amp;order=addtime desc&amp;pagesize=10")}--&gt;</div>
            会被转换为如下的SQL语句：<br>
            <div class="code">
                SELECT *<br>
                FROM destoon_sell<br>
                WHERE status=3<br>
                ORDER BY addtime DESC<br>
                LIMIT 0,10<br>
            </div>
            读出的数据会保存在 <span class="f1">$tags</span> 数组里<br>
            <span style="color:red;">通常情况下不需要写table=xxx，应该写moduleid=模块ID，系统会自动对应模块的表</span><br>
            <br>
            <strong>数据显示过程</strong><br>
            1、通过标签模板显示<br>
            传递&amp;template=abc给标签函数，例如：
            <div class="code">&lt;!--{tag("moduleid=...&amp;template=abc")}--&gt;</div>
            默认的标签模板保存在<span class="f1">模板目录/tag/</span>目录里，例如<span class="f1">&amp;template=abc</span>将调用<span class="f1">模板目录/tag/abc.htm</span>模板来显示数据。<br>
            如果标签模板存放于其他目录，例如def，则传递<span class="f1">&amp;dir=def&amp;template=abc</span>，系统将调用<span class="f1">模板目录/def/abc.htm</span>模板。<br><br>

            2、直接在模板里循环数据
            <div class="code">&lt;!--{php $tags=tag("moduleid=...&amp;template=null");}--&gt;</div>
            此写法传递标签模板为null，并且直接返回数据给<span class="f1">$tags</span>数组，此时可以直接在模板里循环了。<br>

            以下为一个完整的示例：<br>
            <div class="code">
                &lt;!--{php $tags=tag("moduleid=...&amp;template=null");}--&gt;<br>
                {loop $tags $t}<br>
                ...<br>
                {/loop}<br>
            </div>
            <br>
            第一种写法一般用于多次调用的数据，第二种写法一般用于只调用一次的数据。<br>
            <br>
            <strong>常用参数及含义</strong><br>

            <span class="f2">moduleid</span><br>
            moduleid指模块ID，可在后台模块管理里查询。对于直接调用模块的数据，设置正确的模块ID后，将不需要传递table参数，系统会自动获取。<br>
            例如传递moduleid=5，系统将识别为调用供应信息，自动设置table参数为sell。<br>
            一般情况下，除了扩展模块里的功能都需要通过moduleid来调用。<br>

            <span class="f2">table</span><br>
            table指表名，可在后台数据库维护里查询。对于Destoon系统表，不需要加表的前缀；对于非Destoon系统表，需要填写完整的表名，且传递prefix参数。<br>
            例如对于Destoon系统表，传递table=announce，如果表前缀为destoon_，系统将识别表名为 destoon_announce。<br>
            对于非Destoon系统表，传递table=tb_abc&amp;prefix=或者table=abc&amp;prefix=tb_，系统将识别表名为 tb_abc。<br>

            <span class="f2">fields</span><br>
            fields指查询的字段，默认为*。可以传递例如 fields=title,addtime，但是一般情况下无需传递，Destoon独有的标签缓存机制会自动缓存查询结果，不必担心效率问题。<br>

            <span class="f2">condition</span><br>
            condition指查询的条件，如果不传递，则为1，代表任意条件的数据(此项需了解SQL语法)。Destoon所有模块遵循统一标准开发，所以很多条件是通用的。<br>
            例如 status=3表示正常通过的信息、status=3 and level=1表示级别为1的信息、status=3 and thumb&lt;&gt;''表示有标题图片的信息等。<br>

            <span class="f2">order</span><br>
            order指数据的排序方法(此项需了解SQL语法)。<br>
            例如order=addtime desc表示按添加时间降序排列、order=itemid desc表示按itemid降序排列、order=rand()表示随机数据等。<br>

            <span class="f2">pagesize</span><br>
            pagesize指调用数据的数量，如果不传递，默认为10。<br>

            <span class="f2">template</span><br>
            template指指定的标签模板，如果不传递，默认为list，位于模板目录/tag/list.htm，如果传递为null，表示不应用标签模板。参见上述数据显示过程。<br>

            <span class="f2">debug</span><br>
            debug参数用于调试标签，例如传递&amp;debug=1，系统将输出标签构造成的SQL语句，以便验证标签写法是否正确，不需要调试的标签不用加此参数。<br>

            <br>
            <strong>数据字典</strong><br>
            参考：<a href="http://help.destoon.com/dict.php" target="_blank">http://help.destoon.com/dict.php</a><br>
            <br>
            <strong>其他常见用法举例</strong><br><br>

            <span class="f2">&amp;和and的区别</span><br>
            &amp;用来分割参数，and是sql语句where后的读取条件，二者完全不同。<br>
            <br>

            <span class="f2">多表联合查询</span><br>
            例如查询会员名为destoon的会员和公司资料，可以使用：<br>
            {tag("table=destoon_member m,destoon_company c&amp;prefix=&amp;condition=m.userid=c.userid and m.username='destoon'&amp;template=list-com")}<br>
            destoon_member和destoon_company是表的实际名称(包含表前缀)，prefix=表示系统不再自动在表名前加前缀。<br>
            通常通过传递moduleid可以实现大部分的调用，除非您确认熟悉联合查询，否则不推荐使用。<br>
            截至目前，系统默认模板里还没有一个功能需要用到联合查询。<br>
            <br>

            <span class="f2">控制标题长度</span><br>
            在标签里传递length参数，例如&amp;length=20表示20个字符长度(一个汉字占2个字符)，一般情况建议用css隐藏多余字符(定义height和overflow:hidden)。<br>
            传递length参数，系统仅对title字段自动截取，如果需要截取其他字段，可用dsubstr函数。<br>
            例如 {dsubstr($t[company], 20, '...')} 表示截取company字段为20个字符，截取后，结尾追加...<br>
            <br>

            <span class="f2">设置日期显示格式</span><br>
            可以在标签里传递datetype参数：<br>
            1 表示 年； <br>
            2 表示 月-日；<br>
            3 表示 年-月-日；<br>
            4 表示 月-日 时:分；<br>
            5 表示 年-月-日 时:分；<br>
            6 表示 年-月-日 时:分:秒<br>
            也可以在模板里直接使用date函数，例如{date('Y-m-d', $t[addtime])} 表示将时间转换为 年-月-日 格式<br>
            date函数的使用请参阅PHP手册。<br>
            <br>


            <span class="f2">调用某一分类的信息</span><br>
            在标签里传递catid参数，例如&amp;catid=5表示调用分类ID为5的所有信息。<br>
            如果调用多个分类，用逗号分隔分类ID，例如 &amp;catid=5,6,7表示调用分类ID为5、6、7的所有信息。<br>
            分类调用<span class="f1">默认包含子分类的信息</span>，如果不需要包含子分类，可设置&amp;child=0参数。<br>
            例如&amp;catid=5&amp;child=0表示只调用分类ID为5的信息，不包括子分类的信息。<br>
            <br>

            <span class="f2">调用某一地区的信息</span><br>
            调用地区信息和上述调用分类信息的方法完全相同，将其中的catid换为areaid即可。<br>
            <br>

            <a name="catname"></a>
            <span class="f2">显示信息所在分类</span><br>
            <span class="px12">&lt;a href="{$MODULE[$moduleid][linkurl]}{$CATEGORY[$t[catid]][linkurl]}"&gt;{$CATEGORY[$t[catid]][catname]}&lt;/a&gt;</span><br>
<span class="px12">
<span style="color:red;">注意：</span>自V4.0，以上写法将不可用，需要在标签里传递&amp;showcat=1参数，然后在模板里写&lt;a href="{$t[caturl]}"&gt;{$t[catname]}&lt;/a&gt;</span><br>
            <br>

            <span class="f2">控制列数</span><br>
            此项常用于图片的布局，可使用cols参数。<br>
            例如调用12张图片，一行显示4个，共3行，则传递&amp;pagesize=12&amp;cols=4<br>
            支持cols参数的标签模板限thumb-table.htm和list-table.htm<br>
            其中，thumb-table.htm显示图片列表，list-table.htm显示文字列表<br>
            如果新建支持cols的标签模板或直接循环$tags，可参考以上两个模板的写法<br>
            上述效果可以也可以通过CSS实现，无需使用表格，请自行书写<br>
            <br>

            <span class="f2">显示文章的简介</span><br>
            使用{$t[introduce]}变量，如果要截取字数，例如80字符，可使用{dsubstr($t[introduce], 80, '...')}<br>
            <br>

            <br>

            <strong>小结</strong><br>
            标签看似复杂难懂，实际上在理解各个参数的含义和调用流程后，您会了解到标签实际简单自由、灵活易用、功能强大。<br>
            默认模板里已提供了大量的调用范例和标签模板，可以在学习中参阅和调试。<br>
            标签调用是制作模板必备的知识，希望您能早日掌握。<br><br>

            <br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2012-09-13 &nbsp;|&nbsp; 浏览次数:156661 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

<?php
include 'header.html';
?>
<div class="tt">模板存放规则及语法参考</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><style>
                .f1 {color:#015D90;padding:0 5px 0 5px;}
                .f2 {color:#FF0000;}
                .code {font-family:Fixedsys,verdana;color:blue;font-size:12px;border:#CAD9EA 1px dotted;padding:5px 10px 5px 10px;background:#F9FCFF;}
            </style>
            <p><strong>一、模板存放及调用规则</strong></p>
            模板存放于系统 template 目录，template 目录下的一个目录<br>
            例如 template/default/ 即为一套模板<br>
            <br>
            模板文件以 .htm 为扩展名，可直接存放于模板目录<br>
            例如 template/default/index.htm<br>
            也可以存放于模板目录的子目录里<br>
            例如 template/default/member/index.htm<br>
            <br>
            在PHP文件里，使用模板语法为<br>
            <span class="phpcode">&lt;?php include template('index');?&gt;</span><br>
            或者<br>
            <span class="phpcode">&lt;?php include template('index', 'member');?&gt;</span><br>
            <br>
            如果当前默认模板套系为default，则：<br>
            <span class="phpcode">&lt;?php include template('header');?&gt;</span> <br>
            表示使用 template/default/header.htm 模板文件<br>
            <span class="phpcode">&lt;?php include template('header', 'member');?&gt;</span> <br>
            表示使用 template/default/member/header.htm 模板文件<br>
            <br>
            模板目录下在 these.name.php 是模板别名的配置文件，模板别名可以在后台模板管理修改。<br>
            <br>
            模板解析后的缓存文件保存于cache/tpl/目录，扩展名为 .tpl.php<br>
            <br>
            <strong>二、模板语法</strong><br>
            <br>
            1、包含模板 <span class="dstcode">{template 'header'}</span> 或 <span class="dstcode">{template 'header', 'member'}</span><br>
            <br>
            <span class="dstcode">{template 'header'}</span> 被解析为 <br>
            <span class="phpcode">&lt;?php include template('header');?&gt;</span> <br>
            表示使用 template/default/header.htm 模板文件<br>
            <span class="dstcode">{template 'header', 'member'}</span> <br>
            被解析为 <span class="phpcode">&lt;?php include template('header', 'member');?&gt;</span> <br>
            表示使用 template/default/member/header.htm 模板文件<br>
            <br>
            2、变量或常量表示<br>
            <br>
            变量 <span class="dstcode">{$destoon}</span> 被解析为 <span class="phpcode">&lt;?php echo $destoon;?&gt;</span><br>
            常量 <span class="dstcode">{DESTOON}</span> 被解析为 <span class="phpcode">&lt;?php echo DESTOON;?&gt;</span><br>
            对于数组，标准写法应为 例如 <span class="dstcode">{$destoon['index']}</span>，可简写为 <span class="dstcode">{$destoon[index]}</span>，模板在解析时会自动追加引号。<br>
            <br>
            3、函数 <span class="dstcode">{func_name($par1, $par2)}</span><br>
            <br>
            <span class="dstcode">{func_name($par1, $par2)}</span> 被解析为<br>
            <span class="phpcode">&lt;?php func_name($par1, $par2);?&gt;</span><br>
            <br>
            4、PHP表达式 <span class="dstcode">{php expression}</span><br>
            <br>
            <span class="dstcode">{php expression}</span> 被解析为 <span class="phpcode">&lt;?php expression ?&gt;</span><br>
            <br>
            5、条件语句 <span class="dstcode">{if $a=='b'} do A {/if}</span> 或 <span class="dstcode">{if $a=='b'} do A {else} do B {/if}</span> 或 <span class="dstcode">{if $a=='b'} do A {elseif $b=='c'} do C {else} do B {/if}</span><br>
            <br>
            <span class="dstcode">{if $a=='b'} do A {/if}</span> 被解析为<br>
            <span class="phpcode">&lt;?php if($a=='b') { do A }?&gt;</span><br>
            <span class="dstcode">{if $a=='b'} do A {else} do B {/if}</span> 被解析为<br>
            <span class="phpcode">&lt;?php if($a=='b') { do A } else { do B } ?&gt;</span><br>
            <span class="dstcode">{if $a=='b'} do A {elseif $b=='c'} do C {else} do B {/if}</span> 被解析为<br>
            <span class="phpcode">&lt;?php if($a=='b') { do A } else if($b=='c') { do C } else { do B } ?&gt;</span><br>
            <br>
            6、LOOP循环 <span class="dstcode">{loop $var $v}...{loop}</span> 或<br>
            <span class="dstcode">{loop $var $k $v}...{loop}</span><br>
            <br>
            <span class="dstcode">{loop $var $v}...{loop}</span> 被解析为 <br>
            <span class="phpcode">&lt;?php if(is_array($var)) { foreach($var as $v) { ... } }?&gt;</span><br>
            <span class="dstcode">{loop $var $k $v}...{loop}</span> 被解析为 <br>
            <span class="phpcode">&lt;?php if(is_array($var)) { foreach($var as $k=&gt;$v) { ... } }?&gt;</span><br>
            <br>
            <strong>三、特殊用法</strong><br>
            <br>
            1、变量或表达式可以用HTML注释，例如 <span class="dstcode">&lt;!--{$destoon}--&gt;</span> 仍被解析为 <span class="phpcode">&lt;?php echo $destoon; ?&gt;</span> (可自动过滤此类注释)<br>
            2、模板可以用<span class="dstcode">&lt;!--[注释内容]--&gt;</span>，进行注释，模板编译时会自动去除，不会显示在页面中。(V&gt;=5.0)
            3、可直接在模板里书写PHP代码，直接书写PHP代码与 DESTOON 模板语法是兼容的。<br>
            <br></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2011-01-12 &nbsp;|&nbsp; 浏览次数:63367 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

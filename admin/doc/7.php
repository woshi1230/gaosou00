<?php
include 'header.html';
?>
<div class="tt">信息级别(level)的用法说明</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p><strong>信息级别可以理解为管理员对信息所做的一个标记，默认为0级，取值范围为0-9级。</strong></p>
            <p>此标记在信息调用的时候会变得非常有用。</p>
            <p>例如，如果网站管理员约定级别为1级的文章为推荐文章，那么在模板中调用推荐文章时，只要把条件限定为1级(level=1)即可。</p>
            <p>对于文章模型，默认的</p>
            <p><span style="color: #0000ff">1级为 推荐文章 <br>
2级为 幻灯图片 <br>
3级为 推荐图文 <br>
4级为 头条相关 <br>
5级为 头条文章 <br>
</span></p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2009-11-15 &nbsp;|&nbsp; 浏览次数:9884 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

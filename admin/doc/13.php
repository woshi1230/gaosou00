<?php
include 'header.html';
?>
<div class="tt">公司主页模板风格添加方法</div>
<table cellpadding="2" cellspacing="1" class="tb">
    <tbody><tr>
        <td style="line-height:150%;padding:10px 10px 10px 12px;"><p>公司主页模板存放于 模板目录/homepage/ (默认为template/default/homepage)<br>
                公司主页风格存放于 company/skin/</p>
            <p>一般情况下，建议不要直接修改默认模板或风格，以备制作参考。</p>
            <p>如果需要创建一套新模板，可以将 模板目录/ homepage目录复制一份 例如 模板目录/newhomepage<br>
                对应创建一套风格，可以将 company/skin/default 目录复制一份 例如 company/skin/newskin</p>
            <p>进入后台 会员管理 公司管理 公司模板 添加模板</p>
            <p>模板名称 填写新模板的命名<br>
                风格目录 填写 newskin<br>
                模板目录 填写 newhomepage<br>
                会员组&nbsp;&nbsp; 根据需要授权的用户组选择</p>
            <p>在网站前台，用测试会员帐号登陆，进入会员中心 主页设置 模板<br>
                启用新添加的模板</p>
            <p>然后边修改风格和模板边刷新会员主页相关页面，即可以看到新模板的效果。</p>
            <p>模板制作完成后，抓取界面图片，修改大小为150px X 110px，命名为thumb.gif 保存于 company/skin/newskin/ 供会员选择时预览。</p>
            <p>&nbsp;</p></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;更新时间:2010-11-03 &nbsp;|&nbsp; 浏览次数:49844 &nbsp;|&nbsp; <a href="?">返回列表</a></td>
    </tr>
    </tbody></table>
<?php
include 'fooder.html';
?>

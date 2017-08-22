<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
    <form action="?">
        <div class="tt"><?php echo $MOD['name'];?>搜索</div>
        <input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
        <input type="hidden" name="action" value="<?php echo $action;?>"/>
        <table cellpadding="2" cellspacing="1" class="tb">
            <tr>
                <td>
                    &nbsp;关键词
                    <input type="text" size="50" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
                    <input type="submit" value="搜 索" class="btn"/>&nbsp;
                    <input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
                </td>
            </tr>
        </table>
    </form>
    <div class="tt"><?php echo $title;?></div>
    <table cellpadding="2" cellspacing="1" class="tb">
        <tbody>
        <tr>
            <td style="line-height:150%;padding:10px 10px 10px 12px;">
                <style>
                    .code {font-family:Fixedsys,verdana;color:blue;font-size:12px;border:#CAD9EA 1px dotted;padding:5px 10px 5px 10px;background:#F9FCFF;}
                </style>
                <?php echo $content;?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;更新时间:<?php echo $editdate;?> &nbsp;|&nbsp; 浏览次数:<?php echo $hits;?> &nbsp;|&nbsp; <a href="<?php echo $menus[1][1];?>">返回列表</a></td>
        </tr>
        </tbody>
    </table>
<?php include tpl('footer');?>
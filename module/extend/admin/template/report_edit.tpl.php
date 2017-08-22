<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" id="dform">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<div class="tt">举报管理 </div>
<table cellpadding="2" cellspacing="1" class="tb">
    <?php if($obj=='work') { ?><!--稿件-->
    <tr>
    <td class="tl"><span class="f_hid"></span> 所属稿件</td>
    <td><a href="index.php?do=taskhandle&op=workinfo&taskId=<?php echo $origin_id;?>&workId=<?php echo $obj_id;?>" target="_blank">#<?php echo $obj_id;?></a></td>
    </tr>
    <?php } ?><!--稿件-->

    <tr>
    <td class="tl"><span class="f_hid"></span> 所属任务</td>
    <td><a href="index.php?do=task&id=<?php echo $origin_id;?>" target="_blank">#<?php echo $origin_id;?></a></td>
    </tr>

    <tr>
    <td class="tl"><span class="f_hid"></span> 举报发起人</td>
    <td><a href="javascript:_user('<?php echo $username;?>');"><?php echo $username;?></a>
        <font color="red">E-mail</font>:&nbsp;||&nbsp;<font color="red">电话</font>:&nbsp;||&nbsp;<font color="red">QQ</font>:&nbsp;||&nbsp;<font color="red">手机号</font>:
    </td>
    </tr>

    <tr>
    <td class="tl"><span class="f_hid"></span> 举报对象</td>
    <td><a href="javascript:_user('<?php echo $to_username;?>');"><?php echo $to_username;?></a>
        <font color="red">E-mail</font>:&nbsp;||&nbsp;<font color="red">电话</font>:&nbsp;||&nbsp;<font color="red">QQ</font>:&nbsp;||&nbsp;<font color="red">手机号</font>:
    </td>
    </tr>

    <tr>
    <td class="tl"><span class="f_hid"></span> 申请举报时间</td>
    <td>
        <?php echo date('Y-m-d H:i:s',$on_time);?>
    </td>
    </tr>

    <tr>
    <td class="tl"><span class="f_hid"></span> 申请状态</td>
    <td>
        <?php
        $trans_obj = array (
            "1" => '待处理',
            "2" => '处理中',
            "3" => '未成立',
            "4" => '已处理'
        );
        echo $trans_obj [$report_status];
        ?>
    </td>
    </tr>

    <tr>
        <td class="tl"><span class="f_hid"></span> 举报说明</td>
        <td>
            <?php echo $report_desc;?>
        </td>
    </tr>

    <tr>
        <td class="tl"><span class="f_hid"></span> 举报附件</td>
        <td>
            <?php if($report_file) { ?>
                <a href="<?php echo $report_file;?>"><?php echo $report_file;?></a>
            <?php } else { ?>
                未提交附件
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td class="tl"><span class="f_hid"></span> 举报处理方案</td>
        <td>
            <?php if($obj == 'task') { ?>
                <input type="radio" name="post[status]" value="1" <?php if($report_status == 1) echo 'checked';?>/>关闭此任务
                <input type="radio" name="post[status]" value="2" <?php if($report_status == 2) echo 'checked';?>/>系统选稿
            <?php } elseif($obj == 'work') { ?>
                <?php if(in_array($obj_status,array(1,2,3,4,6))) { ?>
                <input type="radio" name="post[status]" value="5" <?php if($report_status == 5) echo 'checked';?>/>取消中标,系统选稿
                <?php } else { ?>
                <input type="radio" name="post[status]" value="4" <?php if($report_status == 4) echo 'checked';?>/>屏蔽稿件
                <?php } ?>
            <?php } ?>
            <input type="radio" name="post[status]" value="3" <?php if($report_status == 3) echo 'checked';?>/> 举报无效
            <input type="radio" name="post[status]" value="6" <?php if($report_status == 6) echo 'checked';?>/> 账号禁用
        </td>
    </tr>

    <tr style="display:none;" id="nopass">
        <td class="tl">请说明原因</td>
        <td>
            <textarea cols="" rows="7" style="width:360px;" name="post[status]" id="reply"></textarea>
        </td>
    </tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn" onclick="return report()"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">Menuon(0);</script>
<script type="text/javascript">
    $(function(){
        $("input[name='post[status]']").click(function(){
            if($(this).val() == '3'){
                $("#nopass").show();
            }else{
                $("#nopass").hide();
            }
        });
    });
    function report(){
        $("#pass").show();
        $("#nopass").hide();
        var reportType='<?php echo $type;?>';//交易维权类型, 1:维权; 2:举报
        switch(reportType){
            case "1":
                var content='';
                var obj_cash=parseFloat($obj_info['cash'])+0.00;
                var wk_get  =parseFloat($("#wk_get").val())+0.00;
                var gz_get  =parseFloat($("#gz_get").val())+0.00;

                if(wk_get<0.00||gz_get<0.00){
                    art.dialog.alert("{$_lang['nopass_msg']}");return false;
                }else if(wk_get+gz_get!=obj_cash){
                    art.dialog.alert("{$_lang['nopass_title']}{$action_arr[$type]['1']}{$_lang['part_comission']}");return false;
                }
                content+="{$_lang['employer']}（{$gz_info['username']}）{$_lang['part']}{$_lang['zh_mh']}"+gz_get+"{$_lang['yuan']}，{$_lang['witkey']}（{$wk_info['username']}）{$_lang['part']}{$_lang['zh_mh']}"+wk_get+"{$_lang['yuan']}{$_lang['zh_jh']}";
                art.dialog({
                    title: "{$_lang['confirm_notice']}",
                    content: "{$_lang['now_case']}{$_lang['zh_mh']}<br>"+content,
                    icon: 'succeed',
                    yesFn: function(){$("#process_result").val(content);$("#action").val('pass');$("#frm").submit()},
                    noFn :function(){this.close();return false;}
                });
                return false;
                break;
            case "2":

                var content='';

                if($("#cancel_bid").is(":checked")){
                    content+="{$_lang['cancel_user']}{$report_info['to_username']}{$_lang['de']}#{$report_info['obj_id']}{$_lang['hao']}{$trans_object[$report_info['obj']]}{$_lang['bid_status']};<br>";
                }
                switch($('input:radio:checked').val()){
                    case '1':
                        content+="关闭此任务";
                        break;
                    case '2':
                        content+="系统选稿";
                        break;
                    case '3':
                        content+="举报无效";
                        break;
                    case '4':
                        content+="屏蔽稿件";
                        break;
                    case '5':
                        content+="取消中标，系统选稿";
                        break;
                    case '6':
                        content+="账号禁用";
                        break;
                    default:
                        alert('请选择处理方案');
                        return false;
                }
                return confirm('确定执行?');
                break;
        }
    }
    function nopass(){
        $("#pass").hide();
        $("#nopass").show();
        if($("#nopass").is(":visible")){
            var shtml=$("#reply").val();
            if(shtml.length<20){
                art.dialog.alert("{$_lang['warn_no_case_msg']}");return false;
            }else{
                art.dialog({
                    title: "{$_lang['confirm_notice']}",
                    content: "{$_lang['confirm_no_accept']}{$action_arr[$type]['1']}{$_lang['record_reason']}:<br>"+shtml,
                    icon: 'succeed',
                    yesFn: function(){$("#process_result").val(shtml);$("#action").val('nopass');$("#frm").submit()},
                    noFn :function(){this.close();return false;}
                });
                return false;
            }
        }
    }
</script>
<?php include tpl('footer');?>
<?php
  1 => 
  array (
    'model_id' => '1',
    'model_code' => 'sreward',
    'model_name' => '单人悬赏',
    'config' => 'a:17:{s:10:"audit_cash";s:3:"100";s:8:"max_cash";s:1:"0";s:8:"min_cash";s:4:"0.01";s:9:"task_rate";s:2:"10";s:14:"task_fail_rate";s:2:"10";s:11:"work_hidden";s:1:"0";s:13:"notice_period";s:1:"0";s:7:"min_day";s:1:"1";s:11:"vote_period";s:1:"1";s:14:"reg_vote_limit";s:1:"1";s:11:"choose_time";s:1:"1";s:19:"agree_complete_time";s:1:"2";s:14:"min_delay_cash";s:2:"10";s:9:"max_delay";s:1:"2";s:10:"end_action";s:5:"split";s:10:"witkey_num";s:1:"2";s:16:"auto_choose_rule";s:9:"work_time";}',
    'model_desc' => '计件悬赏任务的一般流程是：<br />
1、雇主发布任务将任务金额托管到网站平台<br />
2、众多高手参与并提交方案<br />
3、雇主选择满意方案，设置方案入围状态，商议最终价格<br />
4、雇主从入围方案中选择中标方案<br />
5、方案中标发放赏金。如果议价金额小于托管金额网站返还雇主多余赏金。',
  ),
  2 => 
  array (
    'model_id' => '2',
    'model_code' => 'mreward',
    'model_name' => '多人悬赏',
    'config' => 'a:13:{s:10:"audit_cash";s:3:"100";s:8:"max_cash";s:4:"1000";s:8:"min_cash";s:4:"0.01";s:9:"task_rate";s:2:"20";s:14:"task_fail_rate";s:1:"5";s:11:"work_hidden";s:1:"0";s:13:"notice_period";s:1:"0";s:7:"min_day";s:1:"1";s:11:"choose_time";s:1:"1";s:14:"min_delay_cash";s:1:"2";s:9:"max_delay";s:1:"3";s:10:"end_action";s:6:"refund";s:16:"auto_choose_rule";s:8:"take_num";}',
    'model_desc' => '多人悬赏任务是指您在发布任务时，先将任务赏金全额托管到平台，再从交稿中选出满意的稿件任务。该任务获奖任务为雇主发布任务时设置的奖项总数目（一等奖，二等奖，三等奖的总和）,获奖者将会根据自己的奖项排名获取相应的赏金。<br />
<br />
多人悬赏任务的一般流程是：<br />
1、雇主发布任务会将对应的任务金额托管到网站平台；<br />
2、众多高手参与任务并提交方案，等待雇主选择方案；<br />
3、雇主会根据方案的优劣，设置相应的稿件奖项排名（如：一等奖，二等奖等）；<br />
4、雇主分配奖项后，如果选稿期结束该任务会进入公示期，在该时期威客可以用相应操作权限，一旦公示期结束，平台会给获奖的高手支付赏金（平台提成一定的比例），如果该任务还有多余的金额，平台会将多余的金额返还给雇主（平台提成一定的比例）。<br />
',
  ),
  3 => 
  array (
    'model_id' => '3',
    'model_code' => 'preward',
    'model_name' => '计件悬赏',
    'config' => 'a:13:{s:10:"audit_cash";s:3:"100";s:8:"max_cash";s:1:"0";s:8:"min_cash";s:4:"0.02";s:9:"task_rate";s:2:"10";s:14:"task_fail_rate";s:1:"5";s:11:"work_hidden";s:1:"0";s:7:"min_day";s:1:"2";s:11:"choose_time";s:1:"1";s:8:"mark_day";s:1:"1";s:14:"min_delay_cash";s:1:"1";s:9:"max_delay";s:1:"2";s:12:"work_percent";s:3:"200";s:15:"is_auto_adjourn";s:1:"1";}',
    'model_desc' => '计件悬赏任务的一般流程是：<br />
1、雇主发布任务将任务金额托管到网站平台<br />
2、众多高手参与并提交方案<br />
3、雇主选择满意方案，设置方案中标状态<br />
4、方案中标发放赏金',
  ),
  4 => 
  array (
    'model_id' => '4',
    'model_code' => 'tender',
    'model_name' => '普通招标',
    'config' => 'a:6:{s:8:"zb_audit";s:1:"1";s:11:"work_hidden";s:1:"0";s:7:"zb_fees";s:1:"1";s:11:"zb_max_time";s:3:"400";s:11:"zb_min_time";s:1:"2";s:11:"choose_time";s:1:"2";}',
    'model_desc' => '普通招标，雇主选择中标者后，交付将在线下完成，雇主确认后，任务完成，普能招标，网站只收取固定的服务费用,普通招标将不能增涨双方的信誉值，与能力值',
  ),
  5 => 
  array (
    'model_id' => '5',
    'model_code' => 'dtender',
    'model_name' => '订金招标',
    'config' => 'a:11:{s:10:"open_audit";s:4:"open";s:11:"work_hidden";s:1:"0";s:11:"pay_methods";s:5:"fixed";s:7:"deposit";s:2:"30";s:13:"deposit_scale";s:2:"30";s:9:"task_rate";s:2:"10";s:14:"task_fail_rate";s:2:"10";s:12:"bid_max_time";s:3:"100";s:12:"bid_min_time";s:1:"1";s:14:"pay_limit_time";s:1:"2";s:18:"confirm_limit_time";s:3:"100";}',
    'model_desc' => '订金招标是指托管任务订金，选择应标高手完成任务的任务类型。任务采用选择高手完成任务的方式，避免了全款悬赏任务高手作品浪费的现象。<br />
<br />
订金招标流程较复杂，用时较长，但效果较好且能有效防止诈骗，特别适合大中型任务的发布这些任务可以考虑使用订金招标：VI/SI等大型设计项目，长期的画册设计外包，多页面的网页设计，电子杂志设计，网站程序开发，软件开发，音视频拍摄/调整，视频短片，大型翻译…… <br />
<br />
任务流程：雇主发布订金招标任务并托管任务款后，等待高手来参加任务。高手可以通过搜索等方式查看到该订金招标任务，并依据任务雇主的需求，提出解决方案。雇主查看到最合适最优秀的方案后，即可邀请提交此方案的高手写任务合同。双方对任务合同协调无异议后，即可确定该合同生效，并进入任务实施阶段。分期发放任务赏金。订金招标任务成功结束。<br />
',
  ),
  6 => 
  array (
    'model_id' => '6',
    'model_code' => 'match',
    'model_name' => '速配任务',
    'config' => 'a:8:{s:9:"task_rate";s:2:"10";s:7:"deposit";s:2:"99";s:12:"deposit_rate";s:2:"10";s:8:"defeated";s:1:"1";s:14:"task_fail_rate";s:1:"5";s:7:"min_day";s:1:"1";s:7:"max_day";s:2:"50";s:7:"cutdown";s:1:"0";}',
    'model_desc' => '速配任务',
  ),
);
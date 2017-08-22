服务器跟本地php版本不一致 使用5.6+的函数请谨慎

.\file\script\config.js 文件的域名需要修改...生成首页时会更新此文件..

ALTER TABLE `ywb2b`.`yw_company`
ADD COLUMN `total_sales` DECIMAL(10,2) NULL DEFAULT '0.00' AFTER `buy`,             -- (威客)销售总额
ADD COLUMN `max_qprice` DECIMAL(10,2) NULL DEFAULT '0.00' AFTER `total_sales`;      -- (雇主)最大报价
ADD COLUMN `seller_credit` INT(11) NULL DEFAULT '0' AFTER `max_qprice`;             -- (我作为威客)卖家的信誉
ADD COLUMN `seller_good_num` INT(11) NULL DEFAULT '0' AFTER `seller_credit`;        -- (我作为威客)卖家的好评数
ADD COLUMN `seller_total_num` INT(11) NULL DEFAULT '0' AFTER `seller_good_num`;     -- (我作为威客)卖家的出售总数
ADD COLUMN `seller_level` VARCHAR(1000) NULL DEFAULT '' AFTER `seller_total_num`;   -- (我作为威客)卖家的等级
ADD COLUMN `buyer_credit` INT(11) NULL DEFAULT '0' AFTER `seller_level`;            -- (我作为雇主)买家的信誉
ADD COLUMN `buyer_good_num` INT(11) NULL DEFAULT '0' AFTER `buyer_credit`;          -- (我作为雇主)买家的好评数
ADD COLUMN `buyer_total_num` INT(11) NULL DEFAULT '0' AFTER `buyer_good_num`;       -- (我作为雇主)买家的购买总数
ADD COLUMN `buyer_level` VARCHAR(1000) NULL DEFAULT '' AFTER `buyer_total_num`;     -- (我作为雇主)买家的等级
ADD COLUMN `pub_num` INT(11) NULL DEFAULT '0' AFTER `buyer_level`;                  -- 发布数（雇主发布任务数）
ADD COLUMN `take_num` INT(11) NULL DEFAULT '0' AFTER `pub_num`;                     -- 承接数
ADD COLUMN `accepted_num` INT(11) NULL DEFAULT '0' AFTER `take_num`;                -- 接受数目（威客中标稿件数）

ALTER TABLE `ywb2b`.`yw_comment`
ADD COLUMN `obj_type` char(20) DEFAULT NULL AFTER `item_username`;                  -- '''评论类型''(task=>任务交流,Work=>稿件评论,Kf=>客服留言 ,Shop=>网店评论,Case=>案例留言 ,Service=>服务留言)'
ADD COLUMN `uid` int(11) DEFAULT '0' AFTER `quotation`;                             -- 用户编号

ALTER TABLE `ywb2b`.`yw_favorite`
ADD COLUMN `keep_type` char(20) DEFAULT NULL AFTER `itemid`;                        -- 收藏对象
ADD COLUMN `obj_id` int(11) DEFAULT NULL AFTER `keep_type`;                         -- 对象编号
x
ALTER TABLE `ywb2b`.`yw_message`
ADD COLUMN `fromuid` int(11) DEFAULT NULL AFTER `content`;                          -- 发件人ID
ADD COLUMN `touid` int(11) DEFAULT NULL AFTER `fromuser`;                           -- 收件人ID

ALTER TABLE `ywb2b`.`yw_mall`
ADD COLUMN `deliver_type` tinyint(1) DEFAULT NULL AFTER `cod`;                      -- 交付类型(1=>实物, 2=>软件)

ALTER TABLE `ywb2b`.`yw_mall_order`
ADD COLUMN `deliver_type` tinyint(1) DEFAULT NULL AFTER `buyer_mobile`;             -- 交付类型(1=>实物, 2=>软件)

ALTER TABLE `ywb2b`.`yw_upload_0`
ALTER TABLE `ywb2b`.`yw_upload_1`
ALTER TABLE `ywb2b`.`yw_upload_2`
ALTER TABLE `ywb2b`.`yw_upload_3`
ALTER TABLE `ywb2b`.`yw_upload_4`
ALTER TABLE `ywb2b`.`yw_upload_5`
ALTER TABLE `ywb2b`.`yw_upload_6`
ALTER TABLE `ywb2b`.`yw_upload_7`
ALTER TABLE `ywb2b`.`yw_upload_8`
ALTER TABLE `ywb2b`.`yw_upload_9`
ADD COLUMN `filename` VARCHAR(255) DEFAULT NULL AFTER `fileurl`;                    -- 文件名称

ALTER TABLE `ywb2b`.`yw_finance_record`
ADD COLUMN `order_id` int(11) DEFAULT '0' AFTER `itemid`;                           -- 订单编号
ADD COLUMN `uid` int(11) DEFAULT '0' AFTER `order_id`;                              -- 用户编号
ADD COLUMN `obj_type` char(20) DEFAULT NULL AFTER `username`;                       -- 对象类型
ADD COLUMN `obj_id` int(10) DEFAULT NULL AFTER `obj_type`;                          -- 对象编号
ADD COLUMN `site_profit` decimal(15,3) DEFAULT '0.000' AFTER `addtime`;             -- 站长利润

ALTER TABLE `ywb2b`.`yw_witkey_task`
ADD COLUMN `indus_fid` INT(11) NULL DEFAULT '0' AFTER `task_pic`;                   -- 行业总类（第一分类）
ADD COLUMN `indus_sid` INT(11) NULL DEFAULT '0' AFTER `indus_id`;                   -- 行业分类（第四分类）

ALTER TABLE `ywb2b`.`yw_category`
ADD COLUMN `thumb` VARCHAR(255) NOT NULL AFTER `group_add`;               --上传图片

新建表yw_image_cat
CREATE TABLE `yw_image_cat` (。。。。。。。。
为了存储个人头像，
ALTER TABLE `yw_company`
ADD COLUMN `avatarpic`  varchar(255) NULL AFTER `good_rate`;


任务大厅功能新增如下文件
/k_common.inc.php
/config.inc.php 增加内容
/buy/多个目录
/control/
/lib/
/file/script/多个目录
/skin/fonts
/skin/task.css,/skin/store.css
/template/default/多个文件
/template/default/task/
这些表的数据存在文件中：Keke_witkey_basic_config_class, Keke_witkey_model_class, Yw_witkey_mark_aid_class, Yw_witkey_mark_config_class

<td class="tl">网站banner</td>  上下几行代码会在，yw_setting增加一行三列：1，ad1，图片路径。

新注册账号：
guzu2和gaosou2的密码都为111111qq

ywb2b  支付密码  为：111111qq

发布任务第二步，选择行业分类，少一级分类

member表增加avatarpic字段，存放头像路径






手机数据更新地址
//更新http://120.76.78.213/gaosou/file/cache/master.json
http://120.76.78.213/gaosou/master/list.php?mobile=phone
http://localhost/ywb2b_v02/master/list.php?mobile=phone
//更新masterGood.json
http://120.76.78.213/gaosou/master/list.php?mobile=phone&desc=seller_good_rate
//更新masterTotal.json
http://120.76.78.213/gaosou/master/list.php?mobile=phone&desc=total_sales

http://localhost/ywb2b_v02/file/cache/masterTotal.json


刷新地区、任务列表
do=buy默认排序 tasklist.json
http://120.76.78.213/gaosou/index.php?do=buy

tasklistState.json工作中的任务，即可以交稿

刷新手机状态排序
http://120.76.78.213/gaosou/index.php?do=tasklist&intPage=1&s=1&o=7

http://120.76.78.213/gaosou/file/cache/master.json

http://120.76.78.213/gaosou/file/cache/tasklistDescMoney.json 金额降序
http://120.76.78.213/gaosou/file/cache/tasklistDescManuscript.json 稿件数
http://120.76.78.213/gaosou/file/cache/tasklistDescTime.json 时间
http://120.76.78.213/gaosou/file/cache/tasklistState.json 结果为工作中的任务，即可以交稿




header("Access-Control-Allow-Origin:*");
*修改？


老大交接：
120上面   git pull不行找邓工 花生壳有设置
https://my.oschina.net/u/173975/blog/145305

在alidata/vhosts  下改www.gaosou.net

服务都安装在alidata/server

123132
0未付款
1待审核
2投稿中
p2投标中
d2竞标中
3选稿中
4投票中
p4工作中
d4待托管
5公示中
6交付中
7冻结中
8结束
9失败
10审核失败
11仲裁中
13交付冻结


看代码是如何判断是否付款的
目测，witkey_task中cash_cost为-1时是已经付款



company.说明
userid id
username 名字
company 公司
qq       qq
telephone 电话
seller_total_num 售出总量
buyer_total_num  购买总量
ranking 排名
seller_level_pic 卖家等级图
total_sales     总收入(暂不是为三月收入，待完善)
手机等级图片须完善
accepted_num    多少笔

//buyer_level_pic  买家等级

工作评分




companyPicture.json



companyScore.json
username  名字
aid_star:评分
分别为：工作速度  工作质量 工作态度


http://120.76.78.213/gaosou/api/avatar/show.php?username=ywb2b


http://120.76.78.213/gaosou/api/avatar/show.php?username=ywb2b&size=large


http://120.76.78.213/gaosou/api/avatar/show.php?size=large&username=ywb2b
http://localhost/ywb2b_v02/api/avatar/show.php?size=large&username=ywb2b
http://localhost/ywb2b_v02/api/avatar/show.php?size=large&username=ywb2b&action=mobile

../../file/avatar/b3/c3/_ywb2b.jpg

用户头像json
companyAvatar.json

请求的必须是直接的路径，用一个文件存头像数据


ywb2b个人中心图片
http://localhost/ywb2b_v02/file/avatar/b3/c3/_ywb2bx48.jpg
全局搜索//头像&
D:\xampp\htdocs\ywb2b_v02\api\avatar\show.php
D:\xampp\htdocs\ywb2b_v02\include\global.func.php





绝招
http://120.76.78.213/gaosou/file/cache/companySkill.json
userid:id
item_key,item_value

出售商品。
http://120.76.78.213/gaosou/file/cache/companyMall.json

username 名字
price 单价
brand 品牌
thumb 图一
thumb1
thumb2
sales 销量
address  地区





takeTaskTask我承接的任务
http://120.76.78.213/gaosou/file/cache/takeTask.json
标题 task_title
地区  area
赏金  task_cash
模式  model_id
稿件数 work_num
状态 task_status
任务描述 task_desc





ReleaseTask我发布的任务
http://120.76.78.213/gaosou/file/cache/tasklist.json





-----用以前任务tasklist.json
take承接任务,未继续
http://120.76.78.213/gaosou/file/cache/takeTask.json
-- SELECT * FROM yw_witkey_task AS b LEFT JOIN  yw_witkey_task_work AS a on   a.task_id = b.task_id WHERE a.username='ywb2b'
SELECT task_id FROM yw_witkey_task_work WHERE username='ywb2b' ORDER BY task_id DESC

SELECT COUNT(DISTINCT b.task_id) AS num FROM yw_witkey_task AS b LEFT JOIN  yw_witkey_task_work AS a on   a.task_id = b.task_id WHERE a.1=1
SELECT * FROM yw_witkey_task AS b LEFT JOIN  yw_witkey_task_work AS a on   a.task_id = b.task_id
SELECT a.task_id,a.end_time,a.task_status,a.task_cash,a.task_title,a.start_time,a.username FROM yw_witkey_task AS a LEFT JOIN  yw_witkey_task_work as b  ON a.task_id = b.task_id   WHERE 1=1   GROUP BY  a.task_id ORDER BY a.task_id DESC LIMIT 0,20


图片案例评论
http://120.76.78.213/gaosou/file/cache/companyPicture.json (以前使用过，增加字段)
content评论
addtime 添加时间
star     星星
itemid
item_id

//图片案例分类下单个图片
http://120.76.78.213/gaosou/file/cache/companyPictureItem.json
item
introduce简介
username,
edittime,
hits   点击数
thumb   图片



SELECT itemid,thumb,introduce FROM yw_photo_item_12 WHERE item=10 ORDER BY listorder ASC,itemid ASC

SELECT content FROM yw_photo_data_12 WHERE itemid=10

react是否能使用此链接？？
http://localhost/ywb2b_v02/api/comment.php


高手排名分类
SELECT * FROM yw_company WHERE total_sales>=135 and catid like '%,5728,%'
yishan
5725   管理软件
5728   嵌入式系统软件
5730   电商系统


排名
SELECT COUNT(*) as amount FROM yw_company WHERE total_sales>=0 and catid like '%,5573,%'

分类、排名  高手个人的任务在分类中的排名
进个人页刷新
http://120.76.78.213/gaosou/com/lichentang/
/file/cache/companyCat.json


荣誉资质
companyHonor.json
authority 发证机构
fromtime  发证日期


header("Access-Control-Allow-Origin:*");
header('Content-type:text/html;charset=utf-8');



...删除任务abcdefg


25条
http://120.76.78.213/gaosou/master/list.php?catid=5570

每个人的$arrSellerMark 工作速度  质量 态度--


1.数组第1项  用户名

2.数组第123分别为工作速度，工作质量，工作态度

3.数组第4项与进度条相关---雇主=》信誉值

array[4][score_id]----
grade_rate   进度条
[pic2]       等级图片
[level_up]   升级还需要。。。
title   雇主等级中文
level   雇主等级数字

4. 数组第5项  好评率


5. 数组第6项  能力值
--seller_credit能力值

    [5] => 好评率
    [6] => 能力值
	[7] => 中标稿件数
	[8] => 售出稿件数
	[9] => 服务款
[10]

11 好评率
12 发布任务数
13 信誉值
14 购买稿件数
15 支付任务款
16 支付服务款
17 为空  不需要
18 付款及时性
19 合作愉快度


信誉是雇主
能力是威客

http://120.76.78.213/gaosou/file/cache/usernameSellerMark.json
进个人页可刷新





yw_witkey_mark

  `mark_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录编号',
  `model_code` char(20) DEFAULT '0' COMMENT '模型编号',
  `origin_id` int(11) DEFAULT NULL COMMENT '源对象编号',
  `obj_id` int(11) DEFAULT '0' COMMENT '对象编号',
  `obj_cash` decimal(10,0) DEFAULT '0' COMMENT '对象金额',
  `mark_status` int(11) DEFAULT '0' COMMENT '''评价状态'' (0为尚未评 1好 2中 3差) ',
  `mark_content` text COMMENT '评价内容',
  `mark_time` int(11) DEFAULT '0' COMMENT '评价时间',
  `uid` int(11) DEFAULT '0' COMMENT '被评者编号',
  `username` varchar(20) DEFAULT NULL COMMENT '被评者姓名',
  `mark_max_time` int(11) DEFAULT '0' COMMENT '自动评论过期时间',
  `by_uid` int(11) DEFAULT '0' COMMENT '评论人编号',
  `by_username` varchar(20) DEFAULT NULL COMMENT '评论人用户名',
  `aid` varchar(50) DEFAULT NULL COMMENT '''评价项'' (12,3=>对威客的评价项,4,5=>对雇主的评价项) ',
  `aid_star` varchar(50) DEFAULT NULL COMMENT '对应的评价项的星数',
  `mark_value` decimal(10,2) DEFAULT '0.00' COMMENT '评分所得能力值或信誉值',
  `mark_type` int(1) DEFAULT NULL COMMENT '''评论者角色'' (1任务发布者或买家 2为任务威客或卖家) ',
  `mark_count` int(10) DEFAULT '0' COMMENT '评价次数',
  PRIMARY KEY (`mark_id`),

  `avatarpic` `头像`
  `task_title` `标题`

  `mark_id`'记录编号',

  `origin_id`  '源对象编号',


  `mark_status` '''评价状态'' (0为尚未评 1好 2中 3差) ',
  `mark_content` '评价内容',
  `mark_time`   '评价时间',
  `uid`  '被评者编号',
  `username`  '被评者姓名',

  `by_username`  '评论人用户名',
  `aid`  '''评价项'' (12,3=>对威客的评价项,4,5=>对雇主的评价项) ',
  `aid_star`  '对应的评价项的星数',

  `mark_type`  '''评论者角色'' (1任务发布者或买家 2为任务威客或卖家) ',

评论刷新
进个人页-》点击  交易评论
http://120.76.78.213/gaosou/com/lichentang/



  /file/cache/commentTypeOne.json      //信誉等级 评论更加复杂 为中标者对雇主的评价  mark_type = 1  高手评价雇主
  /file/cache/commentTypeTwo.json


http://120.76.78.213/gaosou/file/cache/contact.json 说明
  telephone 电话
  online  1:在线    0：离线
  company 公司名称
  areaid  公司地址
  linkurl 公司网址
 truename 名字
 gender   1 男  2女
   qq      qq
   address  公司地址


   服务保障增加字段
   size 规模
   regyear



如果不用付款便可以发布任务，会出现不依托平台的情况？？比如雇主与高手在线下交易


match 双方支付诚意金后高手开始工作，工作完成后雇主确认验收，任务完成 这是匹配模式描述




tp5 api
/news/read/id
/news/readAll
//荣誉资质
/honor/readAll

//线上
//荣誉资质
/honor/readAll          √
/v10/news/readAll       √

/v10/company/readAll    √
/v10/company/score      √

这一段可以定为常量，以后服务器更改还会变
http://120.76.78.213/tp5/public/index.php/

const URL = 'http://120.76.78.213/tp5/public/index.php/v10/company/';

http://120.76.78.213/tp5/public/index.php/v10/company/honor √
masterGood.json改为/v10/company/mastergood    √
masterTotal.json改为/v10/company/mastertotal  √
companyScore.json改为/v10/company/score   √
companyPictureItem.json改为/v10/company/pictureitem   √
companyPicture.json改为/v10/company/picture   √
companyContact.json改为/v10/company/contact   √
commentTypeOne.json改为/v10/company/typeone   √
commentTypeTwo.json改为/v10/company/typetwo   √
tasklistDescTime.json改为/v10/company/tasklistDescTime    √
tasklistDescMoney.json改为/v10/company/tasklistDescMoney  √
companyScore.json-/v10/company/score    √
skill   √
mall    √
malldetail      √
mallorder       √
taketask        √
tasklistDescManuscript  √
tasklistState   √
tasklist    √
news    √
honor   √

companyMallxiangqing.json改为/v10/company/xiangqing √




修改标题 传 task_title task_id
修改描述    task_desc task_id
关闭交易    task_id


modifyTitle

modifyDesc

endTask
111




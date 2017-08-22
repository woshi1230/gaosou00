# gaosou V6.0 R20151222 http://www.gaosou.net
# 2016-02-14 09:51:55
# --------------------------------------------------------


DROP TABLE IF EXISTS `yw_sell_5`;
CREATE TABLE `yw_sell_5` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `mycatid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `elite` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `n1` varchar(100) NOT NULL,
  `n2` varchar(100) NOT NULL,
  `n3` varchar(100) NOT NULL,
  `v1` varchar(100) NOT NULL,
  `v2` varchar(100) NOT NULL,
  `v3` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL DEFAULT '',
  `unit` varchar(10) NOT NULL DEFAULT '',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `minamount` float unsigned NOT NULL DEFAULT '0',
  `amount` float unsigned NOT NULL DEFAULT '0',
  `days` smallint(3) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `mycatid` (`mycatid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='供应';

INSERT INTO `yw_sell_5` VALUES('1','1','0','0','1','1','0','供应-机械设备-信息标题1','','0','详细说明。。。。。','','','','','','','','','0.00','0','0','0','','供应-机械设备-信息标题1,供应,机械设备','','5','http://192.168.0.200/ywb2b/file/upload/201601/18/172125601.gif.thumb.gif','','','gaosou','1','YWZDH B2B网站管理系统','0','0','嘉客','','','','','','','','','0','gaosou','1453167486','2016-01-19','1453108850','2016-01-18','192.168.0.5','','3','show.php?itemid=1','','');
INSERT INTO `yw_sell_5` VALUES('2','1','0','0','1','1','0','信息标题2','','0','详细说明2.。。。。。。。。。。。。。。。','','','','','','','产品品牌2','','0.00','0','0','0','','信息标题2,供应,机械设备','','0','http://192.168.0.200/ywb2b/file/upload/201601/19/111732592.gif.thumb.gif','','','ywzdh','7','深圳市远望工业自动化有限公司','2','1','ywzdh','1234567890','','深圳市','','','','','','0','gaosou','1453173791','2016-01-19','1453173397','2016-01-19','192.168.0.5','','3','show.php?itemid=2','','');
INSERT INTO `yw_sell_5` VALUES('3','1','0','0','1','1','0','信息标题3','','0','详细说明3。。。。。。。。。。。。。。。。。','','','','','','','产品品牌3','','0.00','0','0','0','','信息标题3,供应,机械设备','','0','http://192.168.0.200/ywb2b/file/upload/201601/19/111851672.gif.thumb.gif','','','ywzdh','7','深圳市远望工业自动化有限公司','2','1','ywzdh','1234567890','','深圳市','','','','','','0','gaosou','1453173783','2016-01-19','1453173497','2016-01-19','192.168.0.5','','3','show.php?itemid=3','','');
INSERT INTO `yw_sell_5` VALUES('4','1','0','0','1','1','0','信息标题4','','0','详细说明4.。。。。。。。。。。。。','','','','','','','产品品牌4','','0.00','0','0','0','','信息标题4,供应,机械设备','','0','http://192.168.0.200/ywb2b/file/upload/201601/19/111939612.gif.thumb.gif','','','ywzdh','7','深圳市远望工业自动化有限公司','2','1','ywzdh','1234567890','','深圳市','','','','','','0','gaosou','1453173773','2016-01-19','1453173540','2016-01-19','192.168.0.5','','3','show.php?itemid=4','','');
INSERT INTO `yw_sell_5` VALUES('5','1','0','0','1','1','0','信息标题5','','0','详细说明5.。。。。。。。。。。。。。。。。。','','','','','','','产品品牌5','','0.00','0','0','0','','信息标题5,供应,机械设备','','1','http://192.168.0.200/ywb2b/file/upload/201601/19/112020242.gif.thumb.gif','','','ywzdh','7','深圳市远望工业自动化有限公司','2','1','ywzdh','1234567890','','深圳市','','','','','','0','gaosou','1453173764','2016-01-19','1453173589','2016-01-19','192.168.0.5','','3','show.php?itemid=5','','');
INSERT INTO `yw_sell_5` VALUES('6','1','0','0','1','1','0','信息标题6','','0','详细说明6.。。。。。。。。。。。。。。。。。','','','','','','','产品品牌6','','0.00','0','0','0','','信息标题6,供应,机械设备','','2','http://192.168.0.200/ywb2b/file/upload/201601/19/112103462.gif.thumb.gif','','','ywzdh','7','深圳市远望工业自动化有限公司','2','1','ywzdh','1234567890','','深圳市','','','','','','0','gaosou','1453173757','2016-01-19','1453173629','2016-01-19','192.168.0.5','','3','show.php?itemid=6','','');
INSERT INTO `yw_sell_5` VALUES('7','1','0','0','1','1','0','信息标题7','','0','详细说明7.。。。。。。。。。。。。。。。。','','','','','','','','','0.00','0','0','0','','信息标题7,供应,机械设备','','1','http://localhost/ywb2b/file/upload/201601/19/160042551.jpg.thumb.jpg','','','ywzdh','7','深圳市远望工业自动化有限公司','2','1','ywzdh','1234567890','','深圳市','','','','','','0','gaosou','1453190451','2016-01-19','1453188334','2016-01-19','192.168.0.5','','3','show.php?itemid=7','','');
INSERT INTO `yw_sell_5` VALUES('8','1','0','0','1','1','0','信息标题8','','0','详细说明8.........................','','','','','','','','','0.00','0','0','0','','信息标题8,供应,机械设备','','3','http://localhost/ywb2b/file/upload/201601/19/160134931.jpg.thumb.jpg','','','ywzdh','7','深圳市远望工业自动化有限公司','2','1','ywzdh','1234567890','','深圳市','','','','','','0','gaosou','1453190505','2016-01-19','1453190461','2016-01-19','unknown','','3','show.php?itemid=8','','');
INSERT INTO `yw_sell_5` VALUES('9','1','0','0','1','0','0','信息标题11','','0','详细说明12121212121','','','','','','','','','0.00','0','0','3','','信息标题11,供应,机械设备','','1','','','','gaosou','1','YWZDH B2B网站管理系统','0','0','嘉客','','','','','','','','','0','gaosou','1453281221','2016-01-20','1453281221','2016-01-20','192.168.0.5','','3','show.php?itemid=9','','');
INSERT INTO `yw_sell_5` VALUES('10','1','0','0','1','0','0','sdfasdfa','','0','tested','','','','','','','','','0.00','0','0','0','','sdfasdfa,供应,机械设备','','3','','','','gaosou','1','YWZDH B2B网站管理系统','0','0','嘉客','','','','','','','','','0','gaosou','1453425907','2016-01-22','1453425837','2016-01-22','192.168.0.5','','3','show.php?itemid=10','','');


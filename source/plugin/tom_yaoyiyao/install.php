<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS `pre_tom_yaoyiyao`;
CREATE TABLE `pre_tom_yaoyiyao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `type_id` int(11) DEFAULT '1',
  `must_gz` int(11) DEFAULT '1',
  `cj_times` int(11) DEFAULT '0',
  `start_time` int(11) DEFAULT '0',
  `end_time` int(11) DEFAULT '0',
  `pic_url` varchar(255) DEFAULT NULL,
  `cj_about` varchar(255) DEFAULT NULL,
  `content` text,
  `share_logo` varchar(255) DEFAULT NULL,
  `share_title` varchar(255) DEFAULT NULL,
  `share_desc` varchar(255) DEFAULT NULL,
  `guanzu_desc` varchar(255) DEFAULT NULL,
  `guanzu_url` varchar(255) DEFAULT NULL,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS `pre_tom_yaoyiyao_log`;
CREATE TABLE `pre_tom_yaoyiyao_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yao_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `time_id` int(11) DEFAULT '0',
  `log_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_yaoyiyao_prize`;
CREATE TABLE `pre_tom_yaoyiyao_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yao_id` int(11) DEFAULT NULL,
  `prize_status` int(11) DEFAULT '1',
  `prize_title` varchar(255) DEFAULT NULL,
  `prize_desc` varchar(255) DEFAULT NULL,
  `prize_num` varchar(255) DEFAULT NULL,
  `prize_chance` int(11) DEFAULT NULL,
  `prize_pwd` varchar(255) DEFAULT NULL,
  `prize_pic_url` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT '0',
  `every_nums` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `paixu` int(11) DEFAULT '100',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_yaoyiyao_share`;
CREATE TABLE `pre_tom_yaoyiyao_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yao_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `time_id` int(11) DEFAULT '0',
  `share_time` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_yaoyiyao_user`;
CREATE TABLE `pre_tom_yaoyiyao_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yao_id` int(11) DEFAULT '0',
  `openid` varchar(255) DEFAULT NULL,
  `xm` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `add_tel` int(11) DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `add_time` int(11) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_yaoyiyao_zj`;
CREATE TABLE `pre_tom_yaoyiyao_zj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yao_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `prize_id` int(11) DEFAULT '0',
  `time_id` int(11) DEFAULT '0',
  `zj_time` int(11) DEFAULT '0',
  `zj_ip` int(10) unsigned DEFAULT '0',
  `dh_status` int(11) DEFAULT '0',
  `dh_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

EOF;

runquery($sql);

$finish = TRUE;
?>
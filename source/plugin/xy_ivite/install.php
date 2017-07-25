<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_xyivite_apply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid` int(10) NOT NULL,
  `totalscore` varchar(255) NOT NULL
) ENGINE=MyISAM;
EOF;
runquery($sql);

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_xyivite_ivite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid` int(10) NOT NULL,
  `ivitephone` varchar(255) NOT NULL,
  `area`  varchar(255) NOT NULL,
  `score` varchar(255) NOT NULL,
  `addtime` int(15) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM;
EOF;
runquery($sql);

$finish = TRUE;	
?>
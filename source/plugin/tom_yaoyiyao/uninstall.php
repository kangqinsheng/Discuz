<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS pre_tom_yaoyiyao;
DROP TABLE IF EXISTS pre_tom_yaoyiyao_log;
DROP TABLE IF EXISTS pre_tom_yaoyiyao_prize;
DROP TABLE IF EXISTS pre_tom_yaoyiyao_share;
DROP TABLE IF EXISTS pre_tom_yaoyiyao_user;
DROP TABLE IF EXISTS pre_tom_yaoyiyao_zj;

EOF;

runquery($sql);

$finish = TRUE;

?>
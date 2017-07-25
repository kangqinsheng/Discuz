<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$Lang = $scriptlang['tom_yaoyiyao'];
$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_yaoyiyao&pmod=admin'; 
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_yaoyiyao&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_yaoyiyao&pmod=admin';

$tomSysOffset = getglobal('setting/timeoffset');

include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/tom.func.php';
if($_GET['tmod'] == 'index'){
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/admin/index.php';
}else if($_GET['tmod'] == 'prize'){
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/admin/prize.php';
}else if($_GET['tmod'] == 'user'){
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/admin/user.php';
}else if($_GET['tmod'] == 'zj'){
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/admin/zj.php';
}else if($_GET['tmod'] == 'addon'){
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/admin/addon.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/admin/index.php';
}

?>

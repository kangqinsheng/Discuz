<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
define('TPL_DEFAULT', true);
$formhash = FORMHASH;
$yaoConfig = $_G['cache']['plugin']['tom_yaoyiyao'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowDayTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;
require_once libfile('function/discuzcode');

$appid = trim($yaoConfig['yao_appid']);  
$appsecret = trim($yaoConfig['yao_appsecret']);

include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/weixin.class.php';
$weixinClass = new weixinClass($appid,$appsecret);
$wxJssdkConfig = $weixinClass->get_jssdk_config();

if($_GET['mod'] == 'index'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/module/index.php';
    
}else if($_GET['mod'] == 'info'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/module/info.php';
    
}else if($_GET['mod'] == 'ajax'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/module/ajax.php';
    
}else{
    
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/module/add.php';
}

?>

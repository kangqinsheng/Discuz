<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$yao_id      = isset($_GET['yao_id'])? intval($_GET['yao_id']):0;

$yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($yao_id);

$user_id = 0;
$bmStatus = 0;
$userInfo = array();
$cookieUserid = getcookie('tomwx_yaoyiyao_user_yaoid'.$yao_id);
if(!$cookieUserid){
    if($_SESSION['tomwx_yaoyiyao_user_yaoid'.$yao_id]){
        $cookieUserid = $_SESSION['tomwx_yaoyiyao_user_yaoid'.$yao_id];
    }
}
if($cookieUserid && $cookieUserid > 0){
    $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_id($cookieUserid);
    if($userInfo){
        $user_id = $userInfo['id'];
        $bmStatus = 1;
    }
}

if(!preg_match('/^http:/', $yaoyiyaoInfo['share_logo']) ){
    $share_logo_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$yaoyiyaoInfo['share_logo'];
}else{
    $share_logo_url = $yaoyiyaoInfo['share_logo'];
}

$showBtnBox = 1;

if(TIMESTAMP < $yaoyiyaoInfo['start_time']){
    $showBtnBox = 2;
}

if(TIMESTAMP > $yaoyiyaoInfo['end_time']){
    $showBtnBox = 3;
}

$allTimes = $yaoyiyaoInfo['cj_times'];
$useTimes = 0;
$zjStatus = 0;
$syTimes = 0;
if($yaoyiyaoInfo['type_id'] == 1 && $user_id){
    $useTimes = C::t('#tom_yaoyiyao#tom_yaoyiyao_log')->fetch_all_count(" AND yao_id = {$yao_id} AND user_id = {$user_id} AND time_id = {$nowDayTime} ");
    $zjPrizeListTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_all_list(" AND yao_id = {$yao_id} AND user_id = {$user_id} AND time_id = {$nowDayTime} ","ORDER BY id ASC",0,50);
    if($zjPrizeListTmp){
        $zjStatus = 1;
    }
}else if ($yaoyiyaoInfo['type_id'] == 2 && $user_id){
    $useTimes = C::t('#tom_yaoyiyao#tom_yaoyiyao_log')->fetch_all_count(" AND yao_id = {$yao_id} AND user_id = {$user_id} ");
    $zjPrizeListTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_all_list(" AND yao_id = {$yao_id} AND user_id = {$user_id} ","ORDER BY id ASC",0,50);
    if($zjPrizeListTmp){
        $zjStatus = 1;
    }
}
$syTimes = $allTimes - $useTimes;
if($zjStatus > 0){
    $syTimes = 0;
}
$cjTimesMsg = str_replace("{ALLTIMES}", $allTimes, $yaoyiyaoInfo['cj_about']);
$cjTimesMsg = str_replace("{SYTIMES}", $syTimes, $cjTimesMsg);

$showGuanzuBox = 0;
if(isset($_GET['from']) && !empty($_GET['from']) && $yaoyiyaoInfo['must_gz']==1 ){
    $showGuanzuBox = 1;
}

$shareTitle = $yaoyiyaoInfo['share_title'];
$shareDesc = $yaoyiyaoInfo['share_desc'];
$shareLogo = $share_logo_url;
$shareUrl = $_G['siteurl']."plugin.php?id=tom_yaoyiyao&mod=index&yao_id={$yao_id}";

$ajaxUrl = "plugin.php?id=tom_yaoyiyao&mod=ajax";

$tomkey = md5($yaoConfig['md5_key']."+++".$user_id);
$ajaxCjUrl = "plugin.php?id=tom_yaoyiyao&mod=ajax&act=cj&yao_id={$yao_id}&user_id={$user_id}&tomkey={$tomkey}&formhash=".FORMHASH;

$infoUrl = "plugin.php?id=tom_yaoyiyao&mod=info&yao_id={$yao_id}";

$bmUrl = "plugin.php?id=tom_yaoyiyao&mod=add&yao_id={$yao_id}";

$ajaxShareUrl = $_G['siteurl']."plugin.php?id=tom_yaoyiyao&mod=ajax&act=share&yao_id={$yao_id}&user_id={$user_id}&formhash=".FORMHASH;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && $yaoConfig['open_in_wx'] == 1) {
    include template("tom_yaoyiyao:weixin"); 
}else{
    include template("tom_yaoyiyao:index");  
}

?>

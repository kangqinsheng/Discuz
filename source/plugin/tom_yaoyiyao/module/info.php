<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$yao_id      = isset($_GET['yao_id'])? intval($_GET['yao_id']):0;
$page        = isset($_GET['page'])? intval($_GET['page']):1;

$yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($yao_id);

$user_id = 0;
$bmStatus = 0;
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

if(!preg_match('/^http:/', $yaoyiyaoInfo['pic_url']) ){
    $pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$yaoyiyaoInfo['pic_url'];
}else{
    $pic_url = $yaoyiyaoInfo['pic_url'];
}

if(!preg_match('/^http:/', $yaoyiyaoInfo['share_logo']) ){
    $share_logo_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$yaoyiyaoInfo['share_logo'];
}else{
    $share_logo_url = $yaoyiyaoInfo['share_logo'];
}

$yao_content = stripslashes($yaoyiyaoInfo['content']);

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

$prizeList = array();
$prizeListTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_all_list(" AND yao_id = {$yao_id} ","ORDER BY paixu ASC",0,50);
if(is_array($prizeListTmp) && !empty($prizeListTmp)){
    foreach ($prizeListTmp as $key => $value) {
        $prizeList[$key] = $value;
        if(!preg_match('/^http:/', $value['prize_pic_url']) ){
            $prize_pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['prize_pic_url'];
        }else{
            $prize_pic_url = $value['prize_pic_url'];
        }
        $prizeList[$key]['prize_pic_url'] = $prize_pic_url;
    }
}

$myZjList = array();
if($user_id){
    $myZjListTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_all_list(" AND yao_id = {$yao_id} AND user_id={$user_id} "," ORDER BY id DESC ",0,50);
    if(is_array($myZjListTmp) && !empty($myZjListTmp)){
        foreach ($myZjListTmp as $key => $value){
            $prizeInfoTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_by_id($value['prize_id']);
            if($prizeInfoTmp['prize_status'] == 1){
                $myZjList[$key] = $value;
                $myZjList[$key]['time'] = dgmdate($value['zj_time'],"Y-m-d H:i",$tomSysOffset);
                $myZjList[$key]['prize_title'] = $prizeInfoTmp['prize_title'];
                $myZjList[$key]['prize_desc'] = $prizeInfoTmp['prize_desc'];
                $myZjList[$key]['prize_id'] = $prizeInfoTmp['id'];
            }
        }
    }
}

$pagesize = 15;
$start = ($page-1)*$pagesize;
$zjListTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_all_list(" AND yao_id = {$yao_id} "," ORDER BY id DESC ",$start,$pagesize);
$zjListCount = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_all_count(" AND yao_id = {$yao_id} ");
$zjList = array();
if(is_array($zjListTmp) && !empty($zjListTmp)){
    foreach ($zjListTmp as $key => $value){
        $userInfoTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_id($value['user_id']);
        $prizeInfoTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_by_id($value['prize_id']);
        $zjList[$key] = $value;
        $zjList[$key]['time'] = dgmdate($value['zj_time'],"Y-m-d H:i",$tomSysOffset);
        $zjList[$key]['tel'] = substr($userInfoTmp['tel'], 0, 3)."****".substr($userInfoTmp['tel'], -4);
        $zjList[$key]['prize_title'] = $prizeInfoTmp['prize_title'];
    }
}
$showNextPage = 1;
if(($start + $pagesize) >= $zjListCount){
    $showNextPage = 0;
}
$allPageNum = ceil($zjListCount/$pagesize);
$prePage = $page - 1;
$nextPage = $page + 1;
$prePageUrl = "plugin.php?id=tom_yaoyiyao&mod=info&yao_id={$yao_id}&page={$prePage}";
$nextPageUrl = "plugin.php?id=tom_yaoyiyao&mod=info&yao_id={$yao_id}&page={$nextPage}";

$shareTitle = $yaoyiyaoInfo['share_title'];
$shareDesc = $yaoyiyaoInfo['share_desc'];
$shareLogo = $share_logo_url;
$shareUrl = $_G['siteurl']."plugin.php?id=tom_yaoyiyao&mod=index&yao_id={$yao_id}";

$ajaxUrl = "plugin.php?id=tom_yaoyiyao&mod=ajax";

$infoUrl = "plugin.php?id=tom_yaoyiyao&mod=info&yao_id={$yao_id}";

$ajaxShareUrl = $_G['siteurl']."plugin.php?id=tom_yaoyiyao&mod=ajax&act=share&yao_id={$yao_id}&user_id={$user_id}&formhash=".FORMHASH;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && $yaoConfig['open_in_wx'] == 1) {
    include template("tom_yaoyiyao:weixin"); 
}else{
    include template("tom_yaoyiyao:info");  
}

?>

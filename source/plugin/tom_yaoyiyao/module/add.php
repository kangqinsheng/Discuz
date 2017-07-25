<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/****厢遇获取手机号*********/
require (DISCUZ_ROOT."/source/plugin/xy_ivite/class/aes.class.php");		
require (DISCUZ_ROOT."/source/plugin/xy_ivite/class/XyiviteClass.class.php");	
@$userinfo = $_REQUEST['userinfo'];
if($userinfo){
	$aes = new aes;
	$c=$aes->aes128cbcHexDecrypt($userinfo);
	$users=json_decode($c,true);
	$uid = $users['uid'];
	$data=array("uid"=>$uid,"field"=>"username");
	$xy = new XyiviteClass("");
	$url="http://app.dsrb.cq.cn/index.php/api/Wzapi/getuser?t=".time();//userinfo
	$output=json_decode($xy->getHttpContent($url,"POST",$data),true);
	$phone=$output['data'];
}




$yao_id      = isset($_GET['yao_id'])? intval($_GET['yao_id']):0;

$yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($yao_id);

if(!$yaoyiyaoInfo){
    $yaoyiyaoList = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_all_list("","ORDER BY id DESC",0,1);
    $yaoyiyaoInfo = $yaoyiyaoList['0'];
    $yao_id = $yaoyiyaoInfo['id'];
}

$cookieUserid = getcookie('tomwx_yaoyiyao_user_yaoid'.$yao_id);
if(!$cookieUserid){
    if($_SESSION['tomwx_yaoyiyao_user_yaoid'.$yao_id]){
        $cookieUserid = $_SESSION['tomwx_yaoyiyao_user_yaoid'.$yao_id];
    }
}
if($cookieUserid && $cookieUserid > 0){
    $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_id($cookieUserid);
    if($userInfo){
        dheader('location:'.$_G['siteurl']."plugin.php?id=tom_yaoyiyao&mod=index&yao_id={$yao_id}");
        exit;
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

# IP
$yaoConfig['xz_area_id'] = trim($yaoConfig['xz_area_id']);
$xzArea = 1;
if($yaoConfig['open_area_ip'] == 1){
    $ipdata = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$_G['clientip']);
    $ipInfo = json_decode($ipdata, true);
    if(is_array($ipInfo) && $ipInfo['code'] == 0){
        if($yaoConfig['xz_area_type'] == 1){
            if($ipInfo['data']['region_id'] != $yaoConfig['xz_area_id']){
                $xzArea = 0;
                $showBtnBox = 4;
            }
        }else if($yaoConfig['xz_area_type'] == 2){
            if($ipInfo['data']['city_id'] != $yaoConfig['xz_area_id']){
                $xzArea = 0;
                $showBtnBox = 4;
            }
        }
    }else{
        $xzArea = 0;
        $showBtnBox = 4;
    }
}
# IP

if($showBtnBox == 1 && $yaoConfig['after_add_tel'] == 1){
    $openid = '';
    include DISCUZ_ROOT.'./source/plugin/tom_yaoyiyao/oauth2.php';
    $userInfoTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_yao_id_openid($yao_id,$openid);
    if($userInfoTmp){
        $lifeTime = 86400*30;
        $_SESSION['tomwx_yaoyiyao_user_yaoid'.$yao_id] = $userInfoTmp['id'];
        dsetcookie('tomwx_yaoyiyao_user_yaoid'.$yao_id,$userInfoTmp['id'],$lifeTime);
        dheader('location:'.$_G['siteurl']."plugin.php?id=tom_yaoyiyao&mod=index&yao_id={$yao_id}");
        exit;
    }else{
        $insertData = array();
        $insertData['yao_id']           = $yao_id;
        $insertData['openid']           = $openid;
        $insertData['xm']               = "";
        $insertData['tel']              = "";
        $insertData['add_tel']          = 0;
        $insertData['add_time']         = TIMESTAMP;
        C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->insert($insertData);
        $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_yao_id_openid($yao_id,$openid);
        if($userInfo){
            $lifeTime = 86400*30;
            $_SESSION['tomwx_yaoyiyao_user_yaoid'.$yao_id] = $userInfo['id'];
            dsetcookie('tomwx_yaoyiyao_user_yaoid'.$yao_id,$userInfo['id'],$lifeTime);
            dheader('location:'.$_G['siteurl']."plugin.php?id=tom_yaoyiyao&mod=index&yao_id={$yao_id}");
            exit;
        }
    }
    
}

$showGuanzuBox = 0;
if(isset($_GET['from']) && !empty($_GET['from']) && $yaoyiyaoInfo['must_gz']==1 ){
    $showGuanzuBox = 1;
    $showBtnBox = 10;
}

$shareTitle = $yaoyiyaoInfo['share_title'];
$shareDesc = $yaoyiyaoInfo['share_desc'];
$shareLogo = $share_logo_url;
$shareUrl = $_G['siteurl']."plugin.php?id=tom_yaoyiyao&mod=index&yao_id={$yao_id}";

$ajaxUrl = "plugin.php?id=tom_yaoyiyao&mod=ajax";

$infoUrl = "plugin.php?id=tom_yaoyiyao&mod=info&yao_id={$yao_id}";

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && $yaoConfig['open_in_wx'] == 1) {
    include template("tom_yaoyiyao:weixin"); 
}else{
    include template("tom_yaoyiyao:add");
}
?>

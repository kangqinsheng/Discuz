<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$yaoyiyaoInfo = $_G['cache']['plugin']['tom_yaoyiyao'];
$yao_id = isset($_GET['yao_id'])? intval($_GET['yao_id']):0;
$page   = isset($_GET['page'])? intval($_GET['page']):1;

$pagesize = 10000;
$start = ($page-1)*$pagesize;

$tomSysOffset = getglobal('setting/timeoffset');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    $zjListTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_all_list(" AND yao_id = {$yao_id} "," ORDER BY id DESC ",$start,$pagesize);
    $zjList = array();
    foreach ($zjListTmp as $key => $value) {
        $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_id($value['user_id']);
        $prizeInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_by_id($value['prize_id']);
        $zjList[$key]['xm'] = $userInfo['xm'];
        $zjList[$key]['tel'] = $userInfo['tel'];
        $zjList[$key]['prize_title'] = $prizeInfo['prize_title'];
        $zjList[$key]['prize_desc'] = $prizeInfo['prize_desc'];
        $zjList[$key]['zj_time'] = dgmdate($value['zj_time'],"Y-m-d H:i",$tomSysOffset);
        
        if($value['dh_status'] == 0){
            $zjList[$key]['dh_status'] = lang('plugin/tom_yaoyiyao','dh_status_no');
        }else if($value['dh_status'] == 1){
            $zjList[$key]['dh_status'] = lang('plugin/tom_yaoyiyao','dh_status_ok');
        }
        
    }

    $user_xm = lang('plugin/tom_yaoyiyao','user_xm');
    $user_tel = lang('plugin/tom_yaoyiyao','user_tel');
    $prize_title = lang('plugin/tom_yaoyiyao','prize_title');
    $prize_desc = lang('plugin/tom_yaoyiyao','prize_desc');
    $zj_time = lang('plugin/tom_yaoyiyao','zj_time');
    $dh_status = lang('plugin/tom_yaoyiyao','dh_status');

    $listData[] = array($user_xm,$user_tel,$prize_title,$prize_desc,$zj_time,$dh_status); 
    foreach ($zjList as $v){
        $lineData = array();
        $lineData[] = $v['xm'];
        $lineData[] = $v['tel'];
        $lineData[] = $v['prize_title'];
        $lineData[] = $v['prize_desc'];
        $lineData[] = $v['zj_time'];
        $lineData[] = $v['dh_status'];
        $listData[] = $lineData;
    }
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition:filename=exportYao.xls");

    foreach ($listData as $fields){
        foreach ($fields as $k=> $v){
            $str = @diconv("$v",CHARSET,"GB2312");
            echo $str ."\t";
        }
        echo "\n";
    }
    exit;
}else{
    exit('Access Denied');
}

?>

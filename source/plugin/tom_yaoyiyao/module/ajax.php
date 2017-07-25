<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$formhash = isset($_GET['formhash'])? daddslashes($_GET['formhash']):'';

if($_GET['act'] == 'add' && $formhash == FORMHASH){
    
    $xm = isset($_GET['xm'])? daddslashes(diconv(urldecode($_GET['xm']),'utf-8')):'';
    $tel = isset($_GET['tel'])? daddslashes($_GET['tel']):'';
    $yao_id = isset($_GET['yao_id'])? intval($_GET['yao_id']):'';
    
    if(empty($xm) || empty($tel)){
        echo 404;exit;
    }
    
    $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_yao_id_tel($yao_id,$tel);
    if($userInfo){
        $lifeTime = 86400*30;
        $_SESSION['tomwx_yaoyiyao_user_yaoid'.$yao_id] = $userInfo['id'];
        dsetcookie('tomwx_yaoyiyao_user_yaoid'.$yao_id,$userInfo['id'],$lifeTime);
        echo 100;exit;
    }else{
        $insertData = array();
        $insertData['yao_id']           = $yao_id;
        $insertData['xm']               = $xm;
        $insertData['tel']              = $tel;
        $insertData['add_tel']          = 1;
        $insertData['add_time']         = TIMESTAMP;
        C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->insert($insertData);
        $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_yao_id_tel($yao_id,$tel);
        if($userInfo){
            $lifeTime = 86400*30;
            $_SESSION['tomwx_yaoyiyao_user_yaoid'.$yao_id] = $userInfo['id'];
            dsetcookie('tomwx_yaoyiyao_user_yaoid'.$yao_id,$userInfo['id'],$lifeTime);
            echo 200;exit;
        }
    }
    echo 404;exit;
}else if($_GET['act'] == 'edit' && $formhash == FORMHASH){
    
    $xm = isset($_GET['xm'])? daddslashes(diconv(urldecode($_GET['xm']),'utf-8')):'';
    $tel = isset($_GET['tel'])? daddslashes($_GET['tel']):'';
    $user_id = isset($_GET['user_id'])? intval($_GET['user_id']):'';
    $yao_id = isset($_GET['yao_id'])? intval($_GET['yao_id']):'';
    
    if(empty($xm) || empty($tel)){
        echo 404;exit;
    }
    
    $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_id($user_id);
    if($userInfo){
        $updateData = array();
        $updateData['xm']               = $xm;
        $updateData['tel']              = $tel;
        $updateData['add_tel']          = 1;
        if(C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->update($user_id,$updateData)){
            echo 200;exit;
        }
    }
    echo 404;exit;
}else if($_GET['act'] == 'share'  && $formhash == FORMHASH){
    
    $yao_id = isset($_GET['yao_id'])? intval($_GET['yao_id']):'';
    $user_id = isset($_GET['user_id'])? intval($_GET['user_id']):0;
    
    $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_id($user_id);
    $yaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($yao_id);
    
    if($userInfo && $yaoInfo && $yaoInfo['id'] == $userInfo['yao_id']){
        
        if($yaoConfig['open_share_times'] == 1){
            if($yaoInfo['type_id'] == 1){
                $shareTimes = C::t('#tom_yaoyiyao#tom_yaoyiyao_share')->fetch_all_count(" AND yao_id = {$yao_id} AND user_id = {$user_id} AND time_id = {$nowDayTime} ");
                if($shareTimes < $yaoConfig['share_times_num']){
                    C::t('#tom_yaoyiyao#tom_yaoyiyao_log')->delete_by_condition(" AND yao_id = {$yao_id} AND user_id = {$user_id} AND time_id = {$nowDayTime} ");
                    $insertData = array();
                    $insertData['yao_id']          = $yao_id;
                    $insertData['user_id']         = $user_id;
                    $insertData['share_time']      = TIMESTAMP;
                    $insertData['time_id']         = $nowDayTime;
                    C::t('#tom_yaoyiyao#tom_yaoyiyao_share')->insert($insertData);
                }
            }else if($yaoInfo['type_id'] == 2){
                $shareTimes = C::t('#tom_yaoyiyao#tom_yaoyiyao_share')->fetch_all_count(" AND yao_id = {$yao_id} AND user_id = {$user_id} ");
                if($shareTimes < $yaoConfig['share_times_num']){
                    C::t('#tom_yaoyiyao#tom_yaoyiyao_log')->delete_by_condition(" AND yao_id = {$yao_id} AND user_id = {$user_id} ");
                    $insertData = array();
                    $insertData['yao_id']          = $yao_id;
                    $insertData['user_id']         = $user_id;
                    $insertData['share_time']      = TIMESTAMP;
                    $insertData['time_id']         = $nowDayTime;
                    C::t('#tom_yaoyiyao#tom_yaoyiyao_share')->insert($insertData);
                }
            }
        }
    }
    echo 1;exit;
}else if($_GET['act'] == 'pwd' && $formhash == FORMHASH){
    $outArr = array(
        'status'=> 1,
    );
    
    $yao_id     = isset($_GET['yao_id'])? intval($_GET['yao_id']):0;
    $zj_id      = isset($_GET['zj_id'])? intval($_GET['zj_id']):0;
    $prizepwd   = isset($_GET['prizepwd'])? daddslashes($_GET['prizepwd']):'';
    
    $zjInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_by_id($zj_id);
    $yaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($zjInfo['yao_id']);
    $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_id($zjInfo['user_id']);
    $prizeInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_by_id($zjInfo['prize_id']);
    
    if($zjInfo && $yaoInfo && $userInfo && $prizeInfo){
        if($zjInfo['dh_status'] == 0){
            if(isset($prizeInfo['prize_pwd']) && !empty($prizeInfo['prize_pwd'])){
                if($prizeInfo['prize_pwd'] == $prizepwd){
                    $updateData = array();
                    $updateData['dh_status'] = 1;
                    $updateData['dh_time'] = TIMESTAMP;
                    C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->update($zj_id,$updateData);

                    $outArr['status'] = 200;
                    echo json_encode($outArr); exit;
                }else{
                    $outArr['status'] = 100;
                    echo json_encode($outArr); exit;
                }
            }
        }
    }
    
    $outArr['status'] = 1;
    echo json_encode($outArr); exit;
    
}else if($_GET['act'] == 'cj' && $formhash == FORMHASH){
    
    $outArr = array(
        'status'    => 1,
        'title'     => '',
        'desc'      => '',
        'pic_url'   => '',
    );
    
    $yao_id = isset($_GET['yao_id'])? intval($_GET['yao_id']):0;
    $user_id = isset($_GET['user_id'])? intval($_GET['user_id']):0;
    $tomkey   = isset($_GET['tomkey'])? daddslashes($_GET['tomkey']):'';
    
    $yaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($yao_id);
    $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_id($user_id);
    
    if(!$yaoInfo){
        echo json_encode($outArr); exit;
    }
    
    if(!$userInfo){
        echo json_encode($outArr); exit;
    }
    
    $tomkeyCheck = md5($yaoConfig['md5_key']."+++".$user_id);
    if($tomkeyCheck != $tomkey){
        $outArr['status'] = 501;
        echo json_encode($outArr); exit;
    }
    
    
    if(TIMESTAMP > $yaoInfo['end_time']){
        $outArr['status'] = 301;
        echo json_encode($outArr); exit;
    }
    
    if(TIMESTAMP < $yaoInfo['start_time']){
        $outArr['status'] = 302;
        echo json_encode($outArr); exit;
    }
    
    $allTimes = $yaoInfo['cj_times'];
    $useTimes = 0;
    $zjStatus = 0;
    if($yaoInfo['type_id'] == 1){
        $useTimes = C::t('#tom_yaoyiyao#tom_yaoyiyao_log')->fetch_all_count(" AND yao_id = {$yao_id} AND user_id = {$user_id} AND time_id = {$nowDayTime} ");
        $zjPrizeListTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_all_list(" AND yao_id = {$yao_id} AND user_id = {$user_id} AND time_id = {$nowDayTime} ","ORDER BY id ASC",0,50);
        if($zjPrizeListTmp){
            $zjStatus = 1;
        }
    }else if ($yaoInfo['type_id'] == 2){
        $useTimes = C::t('#tom_yaoyiyao#tom_yaoyiyao_log')->fetch_all_count(" AND yao_id = {$yao_id} AND user_id = {$user_id} ");
        $zjPrizeListTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_all_list(" AND yao_id = {$yao_id} AND user_id = {$user_id} ","ORDER BY id ASC",0,50);
        if($zjPrizeListTmp){
            $zjStatus = 1;
        }
    }
    
    if($zjStatus){
        $outArr['status'] = 400;
        echo json_encode($outArr); exit;
    }
    
    if($useTimes >= $allTimes){
        $outArr['status'] = 303;
        echo json_encode($outArr); exit;
    }
    
    $prizeList = array();
    $prizeListTmp = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_all_list(" AND yao_id = {$yao_id} AND prize_status = 1 ","ORDER BY status ASC",0,50);
    if(is_array($prizeListTmp) && !empty($prizeListTmp)){
        foreach ($prizeListTmp as $key => $value) {
            $prizeList[$value['id']] = $value;
        }
    }
    $prizeArr = array();
    foreach ($prizeList as $key => $value){
        if($value['prize_chance'] !== 0 && $value['prize_num']>0 ){
            $prizeArr[$key] = $value['prize_chance'];
        }
    }
    $prizeArr[999999] = 10000 - array_sum($prizeArr);
    if($prizeArr[999999] < 0){
        $prizeArr[999999] = 0;
    }
    
    $randPrize = get_rand($prizeArr);
    
    if($randPrize>=1){
        
        if(isset($prizeList[$randPrize]['id']) && $prizeList[$randPrize]['prize_num'] >= 1  && $prizeList[$randPrize]['prize_chance'] != 0){
            $insertData = array();
            $insertData['yao_id']          = $yao_id;
            $insertData['user_id']         = $user_id;
            $insertData['prize_id']        = $prizeList[$randPrize]['id'];
            $insertData['time_id']         = $nowDayTime;
            $insertData['zj_time']         = TIMESTAMP;
            C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->insert($insertData);
            
            $updateData = array();
            $updateData['prize_num']       = $prizeList[$randPrize]['prize_num']-1;
            C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->update($prizeList[$randPrize]['id'],$updateData);
            
            $insertData = array();
            $insertData['yao_id']          = $yao_id;
            $insertData['user_id']         = $user_id;
            $insertData['time_id']         = $nowDayTime;
            $insertData['log_time']        = TIMESTAMP;
            C::t('#tom_yaoyiyao#tom_yaoyiyao_log')->insert($insertData);
            
            $prize_title = diconv($prizeList[$randPrize]['prize_title'],CHARSET,'utf-8');
            $prize_desc = diconv($prizeList[$randPrize]['prize_desc'],CHARSET,'utf-8');
            
            if(!preg_match('/^http:/', $prizeList[$randPrize]['prize_pic_url']) ){
                $prize_pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$prizeList[$randPrize]['prize_pic_url'];
            }else{
                $prize_pic_url = $prizeList[$randPrize]['prize_pic_url'];
            }
            
            $outArr = array(
                'status'    => 200,
                'title'     => $prize_title,
                'desc'      => $prize_desc,
                'pic_url'   => $prize_pic_url,
            );
            echo json_encode($outArr); exit;
        }else{
            
            $insertData = array();
            $insertData['yao_id']          = $yao_id;
            $insertData['user_id']         = $user_id;
            $insertData['time_id']         = $nowDayTime;
            $insertData['log_time']        = TIMESTAMP;
            C::t('#tom_yaoyiyao#tom_yaoyiyao_log')->insert($insertData);
            
            $outArr['status'] = 100;
            echo json_encode($outArr); exit;
            
        }
        
    }
    
    echo json_encode($outArr); exit;
}else{
    exit('Access Denied 101');
}

function get_rand($dataArr){ 
    $result = ''; 
    $dataSum = array_sum($dataArr); 
    $randNum = mt_rand(1, 10000); 
    foreach ($dataArr as $key => $dataCur) { 
        $nextSum = $dataSum-$dataCur;
        if($nextSum < $randNum && $randNum <= $dataSum) { 
            $result = $key; 
            break; 
        }
        $dataSum -= $dataCur;                     
    } 
    unset ($dataArr); 
    return $result; 
}

?>

<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')){
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=zj&yao_id='.$_GET['yao_id'];
$modListUrl = $adminListUrl.'&tmod=zj&yao_id='.$_GET['yao_id'];
$modFromUrl = $adminFromUrl.'&tmod=zj&yao_id='.$_GET['yao_id'];

$doDaoUrl = $_G['siteurl'].'plugin.php?id=tom_yaoyiyao:doDao&yao_id='.$_GET['yao_id'];

if($_GET['act'] == 'add'){
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'duihuan'){
    $updateData = array();
    $updateData['dh_status'] = 1;
    $updateData['dh_time'] = TIMESTAMP;
    C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{
    $yao_id = $_GET['yao_id'];
    $yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($_GET['yao_id']);
    $pagesize = 15;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_all_count(" AND yao_id={$yao_id} ");
    $zjList = C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->fetch_all_list(" AND yao_id={$yao_id}  ","ORDER BY zj_time DESC",$start,$pagesize);
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['user_xm'] . '</th>';
    echo '<th>' . $Lang['user_tel'] . '</th>';
    echo '<th>' . $Lang['prize_title'] . '</th>';
    echo '<th>' . $Lang['prize_desc'] . '</th>';
    echo '<th>' . $Lang['zj_time'] . '</th>';
    echo '<th>' . $Lang['dh_time'] . '</th>';
    echo '<th>' . $Lang['dh_status'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($zjList as $key => $value) {
        
        $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_id($value['user_id']);
        $prizeInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_by_id($value['prize_id']);
        
        echo '<tr>';
        echo '<td>' . $userInfo['xm'] . '</td>';
        echo '<td>' . $userInfo['tel'] . '</td>';
        echo '<td>' . $prizeInfo['prize_title'] . '</td>';
        echo '<td>' . $prizeInfo['prize_desc'] . '</td>';
        echo '<td>' . dgmdate($value['zj_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        echo '<td>' . dgmdate($value['dh_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        if($value['dh_status'] == 1){
            echo '<td>' . $Lang['dh_status_ok'] . '</td>';
        }else{
            echo '<td>' . $Lang['dh_status_no'] . '</td>';
        }
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=duihuan&id='.$value['id'].'&yao_id='.$yao_id.'&formhash='.FORMHASH.'">' . $Lang['duihuan'] . '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl,$doDaoUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
    }else{
        tomshownavli($Lang['zj_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['zj_list_dao'],$doDaoUrl,false);
    }
    tomshownavfooter();
}

?>

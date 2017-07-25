<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=user&yao_id='.$_GET['yao_id']; 
$modListUrl = $adminListUrl.'&tmod=user&yao_id='.$_GET['yao_id'];
$modFromUrl = $adminFromUrl.'&tmod=user&yao_id='.$_GET['yao_id'];

if($_GET['act'] == 'addzj'){
    $yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($_GET['yao_id']);
    $userInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_by_id($_GET['id']);
    
    if(submitcheck('submit')){
        
        $insertData = array();
        
        $insertData = __get_post_data();
        $insertData['yao_id'] = $_GET['yao_id'];
        $insertData['user_id'] = $_GET['id'];
        C::t('#tom_yaoyiyao#tom_yaoyiyao_zj')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=addzj&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html();
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'delete'){
    C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'fenhao'){
    $updateData = array();
    $updateData['status'] = 1;
    C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'recover'){
    $updateData = array();
    $updateData['status'] = 0;
    C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{

    $yao_id = $_GET['yao_id'];
    $yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($_GET['yao_id']);
    $pagesize = 15;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_all_count(" AND yao_id={$yao_id} ");
    $userList = C::t('#tom_yaoyiyao#tom_yaoyiyao_user')->fetch_all_list(" AND yao_id={$yao_id} ","ORDER BY add_time DESC",$start,$pagesize);
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th width="10%">uid</th>';
    echo '<th>' . $Lang['user_xm'] . '</th>';
    echo '<th>' . $Lang['user_tel'] . '</th>';
    //echo '<th>' . $Lang['status'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($userList as $key => $value) {
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['xm'] . '</td>';
        echo '<td>' . $value['tel'] . '</td>';
        if($value['status'] == 0){
            //echo '<td>' . $Lang['status_normal'] . '</td>';
        }else{
            //echo '<td>' . $Lang['status_fenhao'] . '</td>';
        }
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=addzj&id='.$value['id'].'&yao_id='.$yao_id.'&formhash='.FORMHASH.'">' . $Lang['zj_add'] . '</a>&nbsp;|&nbsp;';
        if($value['status'] == 0){
            //echo '<a href="'.$modBaseUrl.'&act=fenhao&id='.$value['id'].'&yao_id='.$yao_id.'&formhash='.FORMHASH.'">--' . $Lang['fenhao'] . '--</a>&nbsp;|&nbsp;';
        }else{
            //echo '<a href="'.$modBaseUrl.'&act=recover&id='.$value['id'].'&yao_id='.$yao_id.'&formhash='.FORMHASH.'">--' . $Lang['recover'] . '--</a>&nbsp;|&nbsp;';
        }
        echo '<a href="'.$modBaseUrl.'&act=delete&id='.$value['id'].'&yao_id='.$yao_id.'&formhash='.FORMHASH.'">' . $Lang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}

function __get_post_data($infoArr = array()){
    $data = array();
    
    $prize_id        = isset($_GET['prize_id'])? intval($_GET['prize_id']):1;
    $zj_time       = isset($_GET['zj_time'])? addslashes($_GET['zj_time']):'';
    $zj_time       = strtotime($zj_time);
    
    $nowDayTime = gmmktime(0,0,0,dgmdate($zj_time, 'n',$tomSysOffset),dgmdate($zj_time, 'j',$tomSysOffset),dgmdate($zj_time, 'Y',$tomSysOffset)) - $tomSysOffset*3600;
    
    $data['yao_id']          = $_GET['yao_id'];
    $data['prize_id']      = $prize_id;
    $data['time_id']      = $nowDayTime;
    $data['zj_time']      = $zj_time;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'prize_id'     => "",
        'zl_time'     => "",
    );
    $options = array_merge($options, $infoArr);
    
    $prizeList = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_all_list(" AND yao_id={$_GET['yao_id']} ","ORDER BY paixu ASC",0,100);
    
    echo '<tr class="header"><th>'.$Lang['zj_prize'].'</th><th></th></tr>';
    echo '<tr><td width="300"><select name="prize_id">';
    foreach ($prizeList as $pk => $pv){
        echo '<option value="'.$pv['id'].'">'.$pv['prize_title'].'</option>';
    }
    tomshowsetting(array('title'=>$Lang['zj_time'],'name'=>'zj_time','value'=>$options['zj_time'],'msg'=>$Lang['zj_time_msg']),"calendar");
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl,$doDaoUrl;
    tomshownavheader();
    if($_GET['act'] == 'addzj'){
        tomshownavli($Lang['user_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['user_add'],"",true);
    }else{
        tomshownavli($Lang['user_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['user_add'],$modBaseUrl."&act=addzj",false);
    }
    tomshownavfooter();
}

?>

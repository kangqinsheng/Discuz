<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=prize&yao_id='.$_GET['yao_id']; 
$modListUrl = $adminListUrl.'&tmod=prize&yao_id='.$_GET['yao_id'];
$modFromUrl = $adminFromUrl.'&tmod=prize&yao_id='.$_GET['yao_id'];

if($_GET['act'] == 'add'){
    $yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($_GET['yao_id']);
    if(submitcheck('submit')){
        
        $insertData = array();
        $insertData = __get_post_data();
        $insertData['add_time']     = TIMESTAMP;
        C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=add','enctype');
        showtableheader();
        __create_info_html();
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['act'] == 'edit'){
    $yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($_GET['yao_id']);
    $prizeInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($prizeInfo);
        C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->update($prizeInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($prizeInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{

    $yao_id = $_GET['yao_id'];
    $yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($_GET['yao_id']);
    $pagesize = 15;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_all_count(" AND yao_id={$yao_id} ");
    $prizeList = C::t('#tom_yaoyiyao#tom_yaoyiyao_prize')->fetch_all_list(" AND yao_id={$yao_id} ","ORDER BY paixu ASC",$start,$pagesize);
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th width="10%">ID</th>';
    echo '<th>' . $Lang['prize_title'] . '</th>';
    echo '<th>' . $Lang['prize_pic_url'] . '</th>';
    echo '<th>' . $Lang['prize_desc'] . '</th>';
    echo '<th>' . $Lang['prize_num'] . '</th>';
    echo '<th>' . $Lang['prize_chance'] . '</th>';
    echo '<th>' . $Lang['prize_status'] . '</th>';
    echo '<th>' . $Lang['paixu'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($prizeList as $key => $value) {
        
        if(!preg_match('/^http:/', $value['prize_pic_url']) ){
            $prize_pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['prize_pic_url'];
        }else{
            $prize_pic_url = $value['prize_pic_url'];
        }
        
        $prize_status = '';
        if($value['prize_status'] == 1){
            $prize_status = $Lang['prize_status_1'];
        }else if($value['prize_status'] == 2){
            $prize_status = $Lang['prize_status_2'];
        }
        
        $prize_chance = 0;
        if($value['prize_chance'] != 0){
            $prize_chance = $value['prize_chance']/100;
        }
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['prize_title'] . '</td>';
        echo '<td><img src="'.$prize_pic_url.'" width="40" /></td>';
        echo '<td>' . $value['prize_desc'] . '</td>';
        echo '<td>' . $value['prize_num'] . '</td>';
        echo '<td>' .$prize_chance . '</td>';
        echo '<td>' . $prize_status . '</td>';
        echo '<td>' . $value['paixu'] . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&yao_id='.$yao_id.'&formhash='.FORMHASH.'">' . $Lang['prize_edit']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=del&id='.$value['id'].'&yao_id='.$yao_id.'&formhash='.FORMHASH.'">' . $Lang['delete'] . '</a>';
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
    
    $prize_status    = isset($_GET['prize_status'])? intval($_GET['prize_status']):1;
    $prize_title     = isset($_GET['prize_title'])? addslashes($_GET['prize_title']):'';
    $prize_desc      = isset($_GET['prize_desc'])? addslashes($_GET['prize_desc']):'';
    $prize_num       = isset($_GET['prize_num'])? intval($_GET['prize_num']):0;
    $prize_chance    = isset($_GET['prize_chance'])? intval($_GET['prize_chance']*100):0;
    $prize_pwd       = isset($_GET['prize_pwd'])? addslashes($_GET['prize_pwd']):'';
    $paixu           = isset($_GET['paixu'])? intval($_GET['paixu']):100;
    
    $prize_pic_url = "";
    if($_GET['act'] == 'add'){
        $prize_pic_url        = tomuploadFile("prize_pic_url");
    }else if($_GET['act'] == 'edit'){
        $prize_pic_url        = tomuploadFile("prize_pic_url",$infoArr['prize_pic_url']);
    }
    
    $data['yao_id']           = $_GET['yao_id'];
    $data['prize_status']     = $prize_status;
    $data['prize_title']      = $prize_title;
    $data['prize_desc']       = $prize_desc;
    $data['prize_num']        = $prize_num;
    $data['prize_chance']     = $prize_chance;
    $data['prize_pwd']        = $prize_pwd;
    $data['prize_pic_url']    = $prize_pic_url;
    $data['paixu']            = $paixu;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'prize_status'        => 1,
        'prize_title'         => '',
        'prize_desc'          => "",
        'prize_num'           => "",
        'prize_chance'        => "0",
        'prize_pwd'           => "",
        'prize_pic_url'       => "",
    );
    $options = array_merge($options, $infoArr);
    
    if($options['prize_chance'] != 0){
        $options['prize_chance'] = $options['prize_chance']/100;
    }
    
    $prize_status_item = array(1=>$Lang['prize_status_1'],2=>$Lang['prize_status_2']);
    tomshowsetting(array('title'=>$Lang['prize_status'],'name'=>'prize_status','value'=>$options['prize_status'],'msg'=>$Lang['prize_status_msg'],'item'=>$prize_status_item),"radio");
    tomshowsetting(array('title'=>$Lang['prize_title'],'name'=>'prize_title','value'=>$options['prize_title'],'msg'=>$Lang['prize_title_msg']),"input");
    tomshowsetting(array('title'=>$Lang['prize_pic_url'],'name'=>'prize_pic_url','value'=>$options['prize_pic_url'],'msg'=>$Lang['prize_pic_url_msg']),"file");
    tomshowsetting(array('title'=>$Lang['prize_desc'],'name'=>'prize_desc','value'=>$options['prize_desc'],'msg'=>$Lang['prize_desc_msg']),"input");
    tomshowsetting(array('title'=>$Lang['prize_num'],'name'=>'prize_num','value'=>$options['prize_num'],'msg'=>$Lang['prize_num_msg']),"input");
    tomshowsetting(array('title'=>$Lang['prize_chance'],'name'=>'prize_chance','value'=>$options['prize_chance'],'msg'=>$Lang['prize_chance_msg']),"input");
    tomshowsetting(array('title'=>$Lang['prize_pwd'],'name'=>'prize_pwd','value'=>$options['prize_pwd'],'msg'=>$Lang['prize_pwd_msg']),"input");
    tomshowsetting(array('title'=>$Lang['paixu'],'name'=>'paixu','value'=>$options['paixu'],'msg'=>""),"input");
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['prize_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['prize_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['prize_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['prize_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['prize_edit'],"",true);
    }else{
        tomshownavli($Lang['prize_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['prize_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}

?>

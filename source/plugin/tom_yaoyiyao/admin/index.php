<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=index'; 
$modListUrl = $adminListUrl.'&tmod=index';
$modFromUrl = $adminFromUrl.'&tmod=index';

if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        $insertData['add_time']     = TIMESTAMP;
        C::t('#tom_yaoyiyao#tom_yaoyiyao')->insert($insertData);
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
    $yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($yaoyiyaoInfo);
        C::t('#tom_yaoyiyao#tom_yaoyiyao')->update($yaoyiyaoInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($yaoyiyaoInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    C::t('#tom_yaoyiyao#tom_yaoyiyao')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'url'){
    
    $yaoyiyaoInfo = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_by_id($_GET['id']);
    
    $url = "{SITEURL}plugin.php?id=tom_yaoyiyao&yao_id=".$_GET['id'];
    $url  = str_replace("{SITEURL}", $_G['siteurl'], $url);
    
    __create_nav_html();
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' .$yaoyiyaoInfo['title'].'>>'. $Lang['url_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['url_title'] . '<input name="" readonly="readonly" type="text" value="'.$url.'" size="100" />' . $Lang['url_title_msg'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
}else{
    $pagesize = 15;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_all_count("");
    $yaoyiyaoList = C::t('#tom_yaoyiyao#tom_yaoyiyao')->fetch_all_list("","ORDER BY add_time DESC",$start,$pagesize);
    showtableheader();
    $Lang['yao_help_1']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['yao_help_1']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['yao_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['yao_help_1'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th width="10%">' . $Lang['yao_id'] . '</th>';
    echo '<th>' . $Lang['yao_title'] . '</th>';
    echo '<th>' . $Lang['yao_start_time'] . '</th>';
    echo '<th>' . $Lang['yao_end_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($yaoyiyaoList as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['title'] . '</td>';
        echo '<td>' . dgmdate($value['start_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        echo '<td>' . dgmdate($value['end_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=url&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['url_title']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['yao_edit']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$adminBaseUrl.'&tmod=prize&yao_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['prize_list_title']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$adminBaseUrl.'&tmod=user&yao_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['user_list_title']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$adminBaseUrl.'&tmod=zj&yao_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['zj_list_title']. '</a>&nbsp;|&nbsp;';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
    
    $jsstr = <<<EOF
<script type="text/javascript">
function del_confirm(url){
  var r = confirm("{$Lang['makesure_del_msg']}")
  if (r == true){
    window.location = url;
  }else{
    return false;
  }
}
</script>
EOF;
    echo $jsstr;
    
}

function __get_post_data($infoArr = array()){
    $data = array();
    
    $title          = isset($_GET['title'])? addslashes($_GET['title']):'';
    $type_id        = isset($_GET['type_id'])? intval($_GET['type_id']):1;
    $must_gz        = isset($_GET['must_gz'])? intval($_GET['must_gz']):1;
    $cj_times       = isset($_GET['cj_times'])? intval($_GET['cj_times']):0;
    $start_time     = isset($_GET['start_time'])? addslashes($_GET['start_time']):'';
    $start_time     = strtotime($start_time);
    $end_time       = isset($_GET['end_time'])? addslashes($_GET['end_time']):'';
    $end_time       = strtotime($end_time);
    $cj_about       = isset($_GET['cj_about'])? addslashes($_GET['cj_about']):'';
    $content        = isset($_GET['content'])? addslashes($_GET['content']):'';
    $share_title    = isset($_GET['share_title'])? addslashes($_GET['share_title']):'';
    $share_desc     = isset($_GET['share_desc'])? addslashes($_GET['share_desc']):'';
    $guanzu_desc    = isset($_GET['guanzu_desc'])? addslashes($_GET['guanzu_desc']):'';
    $guanzu_url     = isset($_GET['guanzu_url'])? addslashes($_GET['guanzu_url']):'';
    
    $pic_url = "";
    if($_GET['act'] == 'add'){
        $pic_url        = tomuploadFile("pic_url");
    }else if($_GET['act'] == 'edit'){
        $pic_url        = tomuploadFile("pic_url",$infoArr['pic_url']);
    }
    
    $share_logo = "";
    if($_GET['act'] == 'add'){
        $share_logo        = tomuploadFile("share_logo");
    }else if($_GET['act'] == 'edit'){
        $share_logo        = tomuploadFile("share_logo",$infoArr['share_logo']);
    }

    $data['title']        = $title;
    $data['type_id']      = $type_id;
    $data['must_gz']      = $must_gz;
    $data['cj_times']     = $cj_times;
    $data['start_time']   = $start_time;
    $data['end_time']     = $end_time;
    $data['pic_url']      = $pic_url;
    $data['cj_about']     = $cj_about;
    $data['content']      = $content;
    $data['share_logo']   = $share_logo;
    $data['share_title']  = $share_title;
    $data['share_desc']   = $share_desc;
    $data['guanzu_desc']  = $guanzu_desc;
    $data['guanzu_url']   = $guanzu_url;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'title'         => '',
        'type_id'       => 1,
        'must_gz'       => 1,
        'cj_times'      => 0,
        'start_time'    => time(),
        'end_time'      => time(),
        'pic_url'       => "",
        'cj_about'      => $Lang['yao_cj_about_value'],
        'content'       => "",
        'share_logo'    => "",
        'share_title'   => "",
        'share_desc'    => "",
        'guanzu_desc'    => $Lang['yao_guanzu_desc_value'],
        'guanzu_url'    => "",
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(array('title'=>$Lang['yao_title'],'name'=>'title','value'=>$options['title'],'msg'=>$Lang['yao_title_msg']),"input");
    $type_id_item = array(1=>$Lang['yao_type_id_1'],2=>$Lang['yao_type_id_2']);
    tomshowsetting(array('title'=>$Lang['yao_type_id'],'name'=>'type_id','value'=>$options['type_id'],'msg'=>$Lang['yao_type_id_msg'],'item'=>$type_id_item),"radio");
    $must_gz_item = array(1=>$Lang['yao_must_gz_1'],2=>$Lang['yao_must_gz_2']);
    tomshowsetting(array('title'=>$Lang['yao_must_gz'],'name'=>'must_gz','value'=>$options['must_gz'],'msg'=>$Lang['yao_must_gz_msg'],'item'=>$must_gz_item),"radio");
    tomshowsetting(array('title'=>$Lang['yao_cj_times'],'name'=>'cj_times','value'=>$options['cj_times'],'msg'=>$Lang['yao_cj_times_msg']),"input");
    tomshowsetting(array('title'=>$Lang['yao_start_time'],'name'=>'start_time','value'=>$options['start_time'],'msg'=>$Lang['yao_start_time_msg']),"calendar");
    tomshowsetting(array('title'=>$Lang['yao_end_time'],'name'=>'end_time','value'=>$options['end_time'],'msg'=>$Lang['yao_end_time_msg']),"calendar");
    tomshowsetting(array('title'=>$Lang['yao_pic_url'],'name'=>'pic_url','value'=>$options['pic_url'],'msg'=>$Lang['yao_pic_url_msg']),"file");
    tomshowsetting(array('title'=>$Lang['yao_cj_about'],'name'=>'cj_about','value'=>$options['cj_about'],'msg'=>$Lang['yao_cj_about_msg']),"textarea");
    tomshowsetting(array('title'=>$Lang['yao_content'],'name'=>'content','value'=>$options['content'],'msg'=>$Lang['yao_content_msg']),"text");
    tomshowsetting(array('title'=>$Lang['yao_share_logo'],'name'=>'share_logo','value'=>$options['share_logo'],'msg'=>$Lang['yao_share_logo_msg']),"file");
    tomshowsetting(array('title'=>$Lang['yao_share_title'],'name'=>'share_title','value'=>$options['share_title'],'msg'=>$Lang['yao_share_title_msg']),"input");
    tomshowsetting(array('title'=>$Lang['yao_share_desc'],'name'=>'share_desc','value'=>$options['share_desc'],'msg'=>$Lang['yao_share_desc_msg']),"input");
    tomshowsetting(array('title'=>$Lang['yao_guanzu_desc'],'name'=>'guanzu_desc','value'=>$options['guanzu_desc'],'msg'=>$Lang['yao_guanzu_desc_msg']),"textarea");
    tomshowsetting(array('title'=>$Lang['yao_guanzu_url'],'name'=>'guanzu_url','value'=>$options['guanzu_url'],'msg'=>$Lang['yao_guanzu_url_msg']),"input");
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['yao_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['yao_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['yao_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['yao_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['yao_edit'],"",true);
    }else if($_GET['act'] == 'url'){
        tomshownavli($Lang['yao_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['url_title'],"",true);
    }else{
        tomshownavli($Lang['yao_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['yao_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}

?>

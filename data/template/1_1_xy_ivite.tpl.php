<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
<meta charset="gb2312">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
<title>厢遇有礼</title>

<!-- Bootstrap -->
<link href="source/plugin/xy_ivite/template/touch/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="source/plugin/xy_ivite/template/touch/css/xyyl.css" />

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js" type="text/javascript"></script>
    <![endif]-->
</head>

<body>
<img src="source/plugin/xy_ivite/template/touch/img/banner.jpg" style="width: 100%;" />
<div class="container" style="margin-bottom: 58px;">
<div class="xy_table">
<ul id="myTab" class="nav nav-tabs">
<li class="active">
<a href="#home" data-toggle="tab">
积分英雄榜
</a>
</li>
<li>
<a href="#ios" data-toggle="tab" onClick="updatemylist()">
我的积分
</a>
</li>
<button class="glyphicon glyphicon-question-sign tc_one_button" aria-hidden="true" data-toggle="modal" data-target="#myModal">
</button>
</ul>
<div id="myTabContent" class="tab-content">
<div class="tab-pane fade in active" id="home">
<div class="jfb">
<table class="table table-bordered">
<thead>
<tr>
<th>排名</th>
<th>用户名</th>

<th>积分</th>
</tr>
</thead>
<tbody><?php if(is_array($list)) foreach($list as $key => $data) { ?><tr class="table_t<?php if($key%2==0) { ?>2<?php } else { ?>1<?php } ?>">
<td><?php echo $key+$start+1?></td>
<td><?php echo $data['nickname'];?></td>

<td><?php echo $data['totalscore'];?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<div style="margin-top:20px; text-align:center;"><?php echo $multipage;?></div>
</div>
<div class="tab-pane fade" id="ios">
<div class="tab-pane fade in active" id="home">
<div class="jfb">
<table class="table table-bordered">
<p>当前排名：<span id="rank">第<?php echo $rank;?>名</span>，共计获得积分：<span id="score"><?php echo $score;?>分</span></p>
<thead>
<tr>
<th>排序</th>
<th>电话号码</th>
<th>进度</th>
<th>归属地</th>
<th>积分</th>
</tr>
</thead>
<tbody id="mylist">

</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<!-- 模态框（myModal） 帮助资料的弹出框-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content tc_one">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
&times;
</button>
<h4 class="modal-title" id="myModalLabel">
活动规则
</h4>
</div>
<div class="modal-body">
<p>
<span style="display: block;font-weight: bold; font-size: 16px;">活动时间：</span> 2017年7月19日至2017年7月31日下午3:00

<span style="display: block;font-weight: bold; margin-top: 10px; font-size: 16px;">积分规则:</span> 只要好友下载并注册，你可以得1分；好友完善资料，可以加2分；如果好友是重庆本地号码，又可以加2分。根据积分多少获得不同奖品。

</p>
<table class="table table-bordered">
<caption>积分规则如下：</caption>
<thead>
<tr>
<th>下载注册</th>
<th>完善资料</th>
<th>重庆本地号码</th>
</tr>
</thead>
<tbody>
<tr>
<td>1分</td>
<td>2分</td>
<td>2分</td>
</tr>
</tbody>
</table>
<p>
<span style="display: block;font-weight: bold; font-size: 16px;">奖品设置：</span>
<span style="color: #f00; margin-top: 10px; display: block;">特等奖10名（第1名至10名）</span> 奖品： <br /> 第一名（1名）：一套香芋系列卡（4张，包括香芋卡、twins卡、music卡）+万家乐热水器 1台。<br /> 第二名至第四名（3名）：一套香芋系列卡（4张，包括香芋卡、twins卡、music卡）+格力大松电陶炉1台
<br /> 第五名至第十名（6名）：一套香芋系列卡（4张，包括香芋卡、twins卡、music卡）+格力小太阳取暖机1台
<br />

<span style="color: #f00; margin-top: 10px; display: block;">一等奖20名（第11名至30名）</span> 奖品： <br />一套香芋系列卡（4张，包括香芋卡、twins卡、music卡）<br />
<span style="color: #f00; margin-top: 10px; display: block;">二等奖100名（第31名至130名）</span> 奖品： <br />香芋系列——twins卡（2张[男女卡各1张]）<br />
<span style="color: #f00; margin-top: 10px; display: block;">三等奖200名（第131名至330名）</span> 奖品： <br />香芋系列——music卡（1张）<br /><br />
<span>请大家遵守活动规则，不要违规操作。</span><br />
<span>咨询电话：63315106</span>
</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default mt_botton_close" data-dismiss="modal">关闭
</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.moda1 -->
</div>
<!-- 模态框（myModa2） 填写手机号码的弹出框-->
<div class="modal fade" id="myModa2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content tc_one">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
&times;
</button>
<h4 class="modal-title" id="myModalLabel">
我要邀请
</h4>
</div>
<div class="modal-body">
<p>请提交您需要邀请人的手机号:</p>
<div class="form-horizontal" role="form" style="text-align: center;">

<div class="form-group">
<div class="col-sm-10">
<input type="text" class="form-control" placeholder="请输入电话号码" name="ivitephone" id="ivitephone">
</div>
</div>
<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
<div class="checkbox">
<label>
<input type="checkbox" name="issendmsg" id="sdmsg" value="true"  checked="checked"> 发送通知短信
</label>
</div>
</div>
</div>

</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default mt_botton_close" onClick="checksubmit(event)">提交 </button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.moda2 -->

</div>

<!-- 模态框（myModa3）邀请之后的提示信息 -->
<div class="modal fade" id="myModa3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content tc_one" style="width: 50%; background: #f00; color: #fff;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff; opacity: 0.8;">&times;</button> <span id="message">发送邀请信息成功！</span>
</div>

</div>
<!-- /.modal-content -->
</div>
<!-- /.moda2 -->
</div>

<!-- loading gif -->
<div class="loading" style="top:50%;left:50%;margin-left:-20px;margin-top:-20px;position: fixed;z-index:111111;display:none;">
<img src="source/plugin/xy_ivite/template/touch/img/loading.gif" style="width: 40px;" />
</div>

</div>

<!--底部邀请按钮-->

<div class="bottom_yq">
<?php if(time()>strtotime("2017-07-19") && time()<strtotime("2017-07-31 15:00:00")) { ?>	<button data-toggle="modal" data-target="#myModa2" class="mt_botton_close yq_button">我要邀请</button>
<?php } else { ?>
<button class="mt_botton_close yq_button">敬请期待</button>
<?php } ?>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js" type="text/javascript"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="source/plugin/xy_ivite/template/touch/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery.noConflict();
jQuery.ajaxSettings.async = false;

function checksubmit(event) {
jQuery(".loading").show();
var mobile = jQuery("#ivitephone").val();
var issendmsg = jQuery("input[type='checkbox']").is(':checked');
setTimeout(function() {
if(checkphone(mobile)) {
//jQuery("form").submit();
jQuery.post('plugin.php?id=xy_ivite&act=apply', {
"ivitephone": mobile,
"issendmsg": issendmsg
}, function(data) {
if(data == 1) {
jQuery("#message").html("邀请成功");
jQuery("#myModa3").addClass("in");
jQuery("#myModa3").show();
jQuery("#ivitephone").val("");
jQuery(".loading").hide();
} else {
jQuery("#message").html("邀请失败");
jQuery("#myModa3").removeClass("in");
jQuery("#myModa3").hide();
}
});
}
}, 1000);
event.preventDefault();
}

function checkphone(mobile) {
var myreg = /^(((13[0-9]{1})|(15[0-9]{1})||(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
var code = false;
if(!myreg.test(mobile)) {
// alert('请输入有效的手机号码！'); 
jQuery("#message").html("请输入有效手机号码");
jQuery("#myModa3").addClass("in");
jQuery("#myModa3").show();
jQuery(".loading").hide();
} else {
jQuery.ajaxSettings.async = false;
jQuery.getJSON('plugin.php?id=xy_ivite&act=checkmobile', {
"ivitephone": mobile
}, function(data) {
if(data) {
jQuery(".loading").hide();
}
if(data.status == 1) {
jQuery("#message").html("该号码已注册");
jQuery("#myModa3").addClass("in");
jQuery("#myModa3").show();
} else if(data.status == 2) {
jQuery("#message").html("该号码已邀请");
jQuery("#myModa3").addClass("in");
jQuery("#myModa3").show();
} else {
code = true;
jQuery("#myModa3").removeClass("in");
jQuery("#myModa3").hide();
}
});
}
return code;
}
jQuery(".close").click(function() {
jQuery(this).parents(".modal").hide();
});
var ajax = 0;
function updatemylist() { //更新个人积分
if(ajax==0){
jQuery(".loading").show();
}
jQuery.ajaxSettings.async = true;
jQuery.getJSON('plugin.php?id=xy_ivite&act=updatemylist', {}, function(data) {
jQuery(".loading").hide();
ajax=1;
jQuery("#rank").html("第" + data.rank + "名");
jQuery("#score").html(data.score + "分");
jQuery("#mylist").html("");
jQuery.each(data, function(k, v) {
if(k != "score" && k != "rank") {
var k = parseInt(k) + 1;
if(k % 2 == 0) {
var t = 1;
} else {
var t = 2;
}
if(v.status ==0){
v.status="未注册";
}
if(v.status ==1){
v.status="已注册";
}
if(v.status ==2){
v.status="已完成";
}
var html = '<tr class="table_t' + t + '"><td>' + k + '</td><td>' + v.ivitephone + '</td><td>' + v.status + '</td><td>' + v.area + '</td><td>' + v.score + '</td></tr>';
jQuery(html).appendTo("#mylist");
}

});
});
}
</script>

</body>

</html>
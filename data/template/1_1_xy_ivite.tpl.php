<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
<meta charset="gb2312">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- ����3��meta��ǩ*����*������ǰ�棬�κ��������ݶ�*����*������� -->
<title>��������</title>

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
����Ӣ�۰�
</a>
</li>
<li>
<a href="#ios" data-toggle="tab" onClick="updatemylist()">
�ҵĻ���
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
<th>����</th>
<th>�û���</th>

<th>����</th>
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
<p>��ǰ������<span id="rank">��<?php echo $rank;?>��</span>�����ƻ�û��֣�<span id="score"><?php echo $score;?>��</span></p>
<thead>
<tr>
<th>����</th>
<th>�绰����</th>
<th>����</th>
<th>������</th>
<th>����</th>
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
<!-- ģ̬��myModal�� �������ϵĵ�����-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content tc_one">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
&times;
</button>
<h4 class="modal-title" id="myModalLabel">
�����
</h4>
</div>
<div class="modal-body">
<p>
<span style="display: block;font-weight: bold; font-size: 16px;">�ʱ�䣺</span> 2017��7��19����2017��7��31������3:00

<span style="display: block;font-weight: bold; margin-top: 10px; font-size: 16px;">���ֹ���:</span> ֻҪ�������ز�ע�ᣬ����Ե�1�֣������������ϣ����Լ�2�֣�������������챾�غ��룬�ֿ��Լ�2�֡����ݻ��ֶ��ٻ�ò�ͬ��Ʒ��

</p>
<table class="table table-bordered">
<caption>���ֹ������£�</caption>
<thead>
<tr>
<th>����ע��</th>
<th>��������</th>
<th>���챾�غ���</th>
</tr>
</thead>
<tbody>
<tr>
<td>1��</td>
<td>2��</td>
<td>2��</td>
</tr>
</tbody>
</table>
<p>
<span style="display: block;font-weight: bold; font-size: 16px;">��Ʒ���ã�</span>
<span style="color: #f00; margin-top: 10px; display: block;">�صȽ�10������1����10����</span> ��Ʒ�� <br /> ��һ����1������һ������ϵ�п���4�ţ��������󿨡�twins����music����+�������ˮ�� 1̨��<br /> �ڶ�������������3������һ������ϵ�п���4�ţ��������󿨡�twins����music����+�������ɵ���¯1̨
<br /> ����������ʮ����6������һ������ϵ�п���4�ţ��������󿨡�twins����music����+����С̫��ȡů��1̨
<br />

<span style="color: #f00; margin-top: 10px; display: block;">һ�Ƚ�20������11����30����</span> ��Ʒ�� <br />һ������ϵ�п���4�ţ��������󿨡�twins����music����<br />
<span style="color: #f00; margin-top: 10px; display: block;">���Ƚ�100������31����130����</span> ��Ʒ�� <br />����ϵ�С���twins����2��[��Ů����1��]��<br />
<span style="color: #f00; margin-top: 10px; display: block;">���Ƚ�200������131����330����</span> ��Ʒ�� <br />����ϵ�С���music����1�ţ�<br /><br />
<span>�������ػ���򣬲�ҪΥ�������</span><br />
<span>��ѯ�绰��63315106</span>
</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default mt_botton_close" data-dismiss="modal">�ر�
</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.moda1 -->
</div>
<!-- ģ̬��myModa2�� ��д�ֻ�����ĵ�����-->
<div class="modal fade" id="myModa2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content tc_one">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
&times;
</button>
<h4 class="modal-title" id="myModalLabel">
��Ҫ����
</h4>
</div>
<div class="modal-body">
<p>���ύ����Ҫ�����˵��ֻ���:</p>
<div class="form-horizontal" role="form" style="text-align: center;">

<div class="form-group">
<div class="col-sm-10">
<input type="text" class="form-control" placeholder="������绰����" name="ivitephone" id="ivitephone">
</div>
</div>
<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
<div class="checkbox">
<label>
<input type="checkbox" name="issendmsg" id="sdmsg" value="true"  checked="checked"> ����֪ͨ����
</label>
</div>
</div>
</div>

</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default mt_botton_close" onClick="checksubmit(event)">�ύ </button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.moda2 -->

</div>

<!-- ģ̬��myModa3������֮�����ʾ��Ϣ -->
<div class="modal fade" id="myModa3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content tc_one" style="width: 50%; background: #f00; color: #fff;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff; opacity: 0.8;">&times;</button> <span id="message">����������Ϣ�ɹ���</span>
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

<!--�ײ����밴ť-->

<div class="bottom_yq">
<?php if(time()>strtotime("2017-07-19") && time()<strtotime("2017-07-31 15:00:00")) { ?>	<button data-toggle="modal" data-target="#myModa2" class="mt_botton_close yq_button">��Ҫ����</button>
<?php } else { ?>
<button class="mt_botton_close yq_button">�����ڴ�</button>
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
jQuery("#message").html("����ɹ�");
jQuery("#myModa3").addClass("in");
jQuery("#myModa3").show();
jQuery("#ivitephone").val("");
jQuery(".loading").hide();
} else {
jQuery("#message").html("����ʧ��");
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
// alert('��������Ч���ֻ����룡'); 
jQuery("#message").html("��������Ч�ֻ�����");
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
jQuery("#message").html("�ú�����ע��");
jQuery("#myModa3").addClass("in");
jQuery("#myModa3").show();
} else if(data.status == 2) {
jQuery("#message").html("�ú���������");
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
function updatemylist() { //���¸��˻���
if(ajax==0){
jQuery(".loading").show();
}
jQuery.ajaxSettings.async = true;
jQuery.getJSON('plugin.php?id=xy_ivite&act=updatemylist', {}, function(data) {
jQuery(".loading").hide();
ajax=1;
jQuery("#rank").html("��" + data.rank + "��");
jQuery("#score").html(data.score + "��");
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
v.status="δע��";
}
if(v.status ==1){
v.status="��ע��";
}
if(v.status ==2){
v.status="�����";
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
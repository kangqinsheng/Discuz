<?php
 //header("Content-type: text/html; charset=utf-8");     
	// error_reporting(E_ALL);
	if (!defined('IN_DISCUZ')) {
	 exit('Access Denied');
	}
	require ("class/XyiviteClass.class.php");
	require ("class/aes.class.php");
	@$act = $_REQUEST['act'] ? $_REQUEST['act'] : "index";
	session_start();
	//$uid = $_SESSION['uid'];
	//$uid=$_GET['uid'];
	@$userinfo = $_REQUEST['userinfo'];
	if($userinfo){
		$aes = new aes;
		$c=$aes->aes128cbcHexDecrypt($userinfo);
		$users=json_decode($c,true);
		$uid = $users['uid'];
		$_SESSION['uid']=$uid;
	}
	if($_SESSION['uid']){
		$uid=$_SESSION['uid'];
	}else{
		header("Location:http://www.cqdsrb.com.cn/app");
		exit;
	}
	
	$xy = new XyiviteClass($uid);
	//$xy->updateIviteAll();//更新
	if($act == "index"){
		$limit=30;
		$pageurl  = get_url('page');
		$count = C::t('#xy_ivite#xyivite_apply')->count_by_search();
		$allpage = ceil($count / $limit);
		$page = $_G['page'];
		$page = $limit && $page > $allpage ? 1 : $page;
		$start = ($page - 1) * $limit;
		$multipage = multi($count, $limit, $page, "" . $_G['siteurl'] . $pageurl);
		$list = $xy->getApplylist($start,$limit);
		echo "<pre />";
		print_r($list);
		echo "<pre />";
		exit;
		$url="http://app.dsrb.cq.cn/index.php/api/Wzapi/getuser?t=".time();//userinfo
		foreach($list as $key=>$val){
			$data=array("uid"=>$val['uid'],"field"=>"nickname");
			$output=json_decode($xy->getHttpContent($url,"POST",$data),true);
			$list[$key]['nickname']=iconv("UTF-8","GB2312",$output['data']);
		}
		
		$score=C::t('#xy_ivite#xyivite_ivite')->fetch_score($uid);
		$rank = C::t('#xy_ivite#xyivite_apply')->fetch_rank($score);
		$mylist = $xy->getMylist(0,1000);
	}
	/*if($act == "mylist"){
		$limit=20;
		$pageurl  = get_url('page');
		$count = C::t('#xy_ivite#xyivite_ivite')->count_by_search($uid);
		$allpage = ceil($count / $limit);
		$page = $_G['page'];
		$page = $limit && $page > $allpage ? 1 : $page;
		$start = ($page - 1) * $limit;
		$multipage = multi($count, $limit, $page, "" . $_G['siteurl'] . $pageurl);
		$xy = new XyiviteClass($uid);
		$list = $xy->getMylist($start,$limit);
	}*/
	if($act == "checkmobile"){
		$ivitephone = trim($_GET['ivitephone']);
		$xy = new XyiviteClass($uid);
		$res=$xy->checkMobile($ivitephone);
		echo $res;
		exit;
	}
	if($act == "apply"){
		$ivitephone = $_POST['ivitephone'];
		$sendmsg = $_POST['issendmsg'];
		/***************************/
		if($sendmsg == "true"){//发送短信
			include_once DISCUZ_ROOT.'./source/plugin/xy_ivite/alidayu/TopSdk.php';		
			define("TOP_AUTOLOADER_PATH", DISCUZ_ROOT.'source/plugin/xy_ivite/alidayu');
			$url="http://app.dsrb.cq.cn/index.php/api/Wzapi/getuser?t=".time();//userinfo
			$data=array("uid"=>$uid,"field"=>"nickname");
			$output=json_decode($xy->getHttpContent($url,"POST",$data),true);
			$nickname=iconv("GB2312","UTF-8",$output['data']);
			$appkey="24521509";
			$secret="f2235a331f443d99d02ece32a6a01dae";
			$c = new TopClient;
			$c->appkey = $appkey;
			$c->secretKey = $secret;
			$req = new AlibabaAliqinFcSmsNumSendRequest;
			$req->setExtend("");
			$req->setSmsType("normal");
			$req->setSmsFreeSignName("厢遇");
			//$req ->setSmsParam("{nickname:'".$nickname."'}");
			$req ->setSmsParam("");
			$req->setRecNum($ivitephone);
			$req->setSmsTemplateCode("SMS_77465058");
			$resp = $c->execute($req);
		}
		/***************************/
		if($ivitephone){
			$xy = new XyiviteClass($uid);
			$res=$xy->iviteApply($ivitephone);
			echo $res;
			exit;
		}
	}
	if($act == "updatemylist"){
		$xy->updateIvite();
		$score=C::t('#xy_ivite#xyivite_ivite')->fetch_score($uid);
		$rank = C::t('#xy_ivite#xyivite_apply')->fetch_rank($score);
		$mylist = $xy->getMylist(0,1000);
		foreach($mylist as $key=>$val){
			if($val['status'] ==0){
				$mylist[$key]['status']="未注册";
			}
			if($val['status'] ==1){
				$mylist[$key]['status']="已注册";
			}
			if($val['status'] ==2){
				$mylist[$key]['status']="已完成";
			}
			$mylist[$key]['area']=iconv("gb2312","utf-8",$val['area']);
		}
		if(empty($score)){
			$score=0;
		}
		$mylist['score']=$score;
		$mylist['rank']=$rank;
		echo json_encode($mylist);
		exit;
	}
	include template("xy_ivite", NULL, './source/plugin/xy_ivite/template/');
	function get_url($field){
		$get = $_GET;
		unset($get[$field]);
		return "plugin.php?".http_build_query($get);
	}
?>
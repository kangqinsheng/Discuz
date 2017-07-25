<?php
		require ("class/XyiviteClass.class.php");
		require ("class/aes.class.php");
		session_start();
		$phone = $_REQUEST['phone'];
		$xypassword=trim($_POST['xypassword']);
		if($xypassword == "xydsrb@#$%2017"){
			$_SESSION['xypassword']="xydsrb@#$%2017";
		}
		if($_GET['uid']){
			$uid=$_GET['uid'];
			$xy = new XyiviteClass($_GET['uid']);
			$xy->updateIvite();
			$score=C::t('#xy_ivite#xyivite_ivite')->fetch_score($uid);
			$rank = C::t('#xy_ivite#xyivite_apply')->fetch_rank($score);
			$mylist = $xy->getMylist(0,20);
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
				//$mylist[$key]['area']=iconv("gb2312","utf-8",$val['area']);
			}
			if(empty($score)){
				$score=0;
			}
		}
	if($_SESSION['xypassword'] == "xydsrb@#$%2017"){
		$limit=20;
		$pageurl  = get_url('page');
		$count = C::t('#xy_ivite#xyivite_apply')->count_by_search();
		$allpage = ceil($count / $limit);
		$page = $_G['page'];
		$page = $limit && $page > $allpage ? 1 : $page;
		$start = ($page - 1) * $limit;
		$multipage = multi($count, $limit, $page, "" . $_G['siteurl'] . $pageurl);
		$xy = new XyiviteClass("");
		$list = $xy->getApplylist($start,$limit);
		$url="http://app.dsrb.cq.cn/index.php/api/Wzapi/getuser?t=".time();//userinfo
		foreach($list as $key=>$val){
			$data=array("uid"=>$val['uid'],"field"=>"nickname");
			$output=json_decode($xy->getHttpContent($url,"POST",$data),true);
			$list[$key]['nickname']=iconv("UTF-8","GB2312",$output['data']);
		}
		foreach($list as $key=>$val){
			$data=array("uid"=>$val['uid'],"field"=>"username");
			$output=json_decode($xy->getHttpContent($url,"POST",$data),true);
			$list[$key]['username']=iconv("UTF-8","GB2312",$output['data']);
		}
	}
		include template("xy_rank", NULL, './source/plugin/xy_ivite/template/');
		function get_url($field){
		$get = $_GET;
		unset($get[$field]);
		return "plugin.php?".http_build_query($get);
		}
?>
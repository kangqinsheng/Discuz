<?php
class XyiviteClass{
	public $ivitephone;
	private $uid;
    public function __CONSTRUCT($uid){
		$this->ivitephone = "";
		$this->uid = $uid;
	}
	public function checkMobile($ivitephone){//检查手机
			$sql = "SELECT COUNT(*) as c FROM ".DB::table("xyivite_ivite")." WHERE ivitephone=".$ivitephone;
			$check = DB::fetch_first($sql);
			if(empty($check['c'])){
				$data=$this->getUserinfo_api($ivitephone);
				if($data){
					$result=array("status"=>1);
				}else{
					$result=array("status"=>0);
				}
			}else{
				$result=array("status"=>2);
			}
			
			return json_encode($result);
	}
	
	public function iviteApply($ivitephone){
		$info=C::t('#xy_ivite#xyivite_apply')->fetch_by_uid($this->uid);
		if(!$info){
			C::t('#xy_ivite#xyivite_apply')->insert(array('uid'=>$this->uid,'totalscore'=>'0'));
		}
		$id=C::t('#xy_ivite#xyivite_ivite')->insert(array('uid'=>$this->uid,'ivitephone'=>$ivitephone,'score'=>'0','addtime'=>time(),'status'=>'0'));
		return $id;
	}
	public function updateIvite(){
		$infos=C::t('#xy_ivite#xyivite_ivite')->fetch_all_by_uid($this->uid);//遍历当前用户状态status！=2
		$phones = [];
		foreach ($infos as $key => $value) {
			$phones[]=array($value['id']=>$value['ivitephone']);
		};
		$info=$this->getUserinfo_api($phones);//获取对应电话详细信息数组
		if(count($info)>0){
			//已注册
			$scorePhone = [];//注册加分情况
			foreach ($info as $key => $value) {
				if(is_array($value) && !empty($value['nickname'])){
					$scorePhone[] = 1;
				}else{
					$scorePhone[] = 0;
				}
			};
			$scoreAdress=[];//归属地加分
			$adress =[];//保存归属地
			foreach ($info as $key => $value) {
				$area=$this->get_mobile_area($value['username']);//判断手机归属地
				$adress[$key]=$area['province'];
				if($area['province'] == "重庆"){
					$scoreAdress[]=2;
				}else{
					$scoreAdress[]=0;
				}
			};
			//是否完善资料
			$isFinish = [];
			foreach ($info as $key => $value) {
				$do=strstr($value['headimg'],"user/headimg");
				if(!empty($value['nickname']) && empty($do) && !empty($value['hobby'])){//判断是否完善资料
					$isFinish[]=2;
					C::t('#xy_ivite#xyivite_ivite')->update($key,array('status'=>"2",'score'=>0));
				}else{
					//注册
					C::t('#xy_ivite#xyivite_ivite')->update($key, array('status'=>"1",'area'=>$adress[$key],'score'=>0));
					$isFinish[]=0;
				}	
			};
			//统计全部
			$i = 0;
			foreach ($info as $key => $value) {
				$scoreAll = $scoreAdress[$i]+$scorePhone[$i]+$isFinish[$i];
				if(is_array($value) && !empty($value['nickname'])){
					C::t('#xy_ivite#xyivite_ivite')->update($key, array('score'=>$scoreAll));
				}else{
					C::t('#xy_ivite#xyivite_ivite')->update($key, array('status'=>"0",'area'=>$adress[$key],'score'=>0));
				}
				$i++;
			};
		}
		$totalscore = DB::fetch_first("SELECT SUM(score) as total FROM ".DB::table("xyivite_ivite")." WHERE uid=".$this->uid);
		if($totalscore['total']){
			 DB::query("UPDATE ".DB::table("xyivite_apply")." SET totalscore=".$totalscore['total']." WHERE uid=".$this->uid);
		}
	}
	public function updateIviteAll(){
		$infos=C::t('#xy_ivite#xyivite_ivite')->fetch_all_uid();//遍历所有用户状态status！=2
		
		foreach($infos as $key =>$val){
			$score = 0;
			$info=$this->getUserinfo_api($val['ivitephone']);
			if(is_array($info) && !empty($info['nickname'])){
				$score+=1;
				$area=$this->get_mobile_area($val['ivitephone']);//判断手机归属地
				if($area['province'] == "重庆"){
					$score +=2 ;
				}
				$do=strstr($info['headimg'],"user/headimg");
				if(!empty($info['nickname']) && empty($do) && !empty($info['hobby'])){//判断是否完善资料
					$score +=1 ; 
					C::t('#xy_ivite#xyivite_ivite')->update($val['id'], array('status'=>"2",'score'=>$score));//status 1//已注册 2//已完善资料
				}else{
					C::t('#xy_ivite#xyivite_ivite')->update($val['id'], array('status'=>"1",'area'=>$area['province'],'score'=>$score));//status 1//已注册 2//已完善资料 

				}				
			}
			$totalscore = DB::fetch_first("SELECT SUM(score) as total FROM ".DB::table("xyivite_ivite")." WHERE uid=".$val['uid']);
			if($totalscore['total']){
				 DB::query("UPDATE ".DB::table("xyivite_apply")." SET totalscore=".$totalscore['total']." WHERE uid=".$val['uid']);
			}
		}
		
	}

	public function getMylist($start,$limit){
		$list=C::t('#xy_ivite#xyivite_ivite')->fetch_all_list("uid=".$this->uid,"order by id desc",$start,$limit);
		return $list;
	}

	public function getApplylist($start,$limit){
		$list=C::t('#xy_ivite#xyivite_apply')->fetch_all_list("id!= 0","order by totalscore desc",$start,$limit);
		return $list;
	}

	public function getHttpContent($url, $method = 'GET', $postData = array())  
	{  
		$data = '';  
	  
		if (!empty($url)) {  
			try {  
				$ch = curl_init();  
				curl_setopt($ch, CURLOPT_URL, $url);  
				curl_setopt($ch, CURLOPT_HEADER, false);  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
				curl_setopt($ch, CURLOPT_TIMEOUT, 300); //30秒超时  
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
				//curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);  
				if (strtoupper($method) == 'POST') {  
					$curlPost = is_array($postData) ? http_build_query($postData) : $postData;  
					curl_setopt($ch, CURLOPT_POST, 1);  
					curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);  
				}  
				$data = curl_exec($ch);  
				curl_close($ch);  
			} catch (Exception $e) {  
				$data = null;  
			}  
		}  
		return $data;  
	}  
	
	private function getUserinfo_api($ivitephone){
		$getUrl="http://app.dsrb.cq.cn/index.php/api/Wzapi/getuserinfoAll?t=".time();//userinfo 
		$post_data=array("username"=>$ivitephone);
		$res=$this->getHttpContent($getUrl,"POST",$post_data);
		$datas = json_decode($res,true);  
		$data=$datas['data'];
		return $data;
	}
	
	private function get_mobile_area($mobile){
		$sms = array('province'=>'', 'supplier'=>'');    //初始化变量
		//根据淘宝的数据库调用返回值
		$url = "http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=".$mobile."&t=".time();

		$content = file_get_contents($url);
		$sms['province'] = substr($content, "56", "4");  //截取字符串
		$sms['supplier'] = substr($content, "81", "4");
		return $sms;
	}

}
?>
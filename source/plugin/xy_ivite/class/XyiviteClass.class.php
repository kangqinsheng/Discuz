<?php
class XyiviteClass{
	public $ivitephone;
	private $uid;
    public function __CONSTRUCT($uid){
		$this->ivitephone = "";
		$this->uid = $uid;
	}
	public function checkMobile($ivitephone){//����ֻ�
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
		$infos=C::t('#xy_ivite#xyivite_ivite')->fetch_all_by_uid($this->uid);//������ǰ�û�״̬status��=2
		$phones = [];
		foreach ($infos as $key => $value) {
			$phones[]=array($value['id']=>$value['ivitephone']);
		};
		$info=$this->getUserinfo_api($phones);//��ȡ��Ӧ�绰��ϸ��Ϣ����
		if(count($info)>0){
			//��ע��
			$scorePhone = [];//ע��ӷ����
			foreach ($info as $key => $value) {
				if(is_array($value) && !empty($value['nickname'])){
					$scorePhone[] = 1;
				}else{
					$scorePhone[] = 0;
				}
			};
			$scoreAdress=[];//�����ؼӷ�
			$adress =[];//���������
			foreach ($info as $key => $value) {
				$area=$this->get_mobile_area($value['username']);//�ж��ֻ�������
				$adress[$key]=$area['province'];
				if($area['province'] == "����"){
					$scoreAdress[]=2;
				}else{
					$scoreAdress[]=0;
				}
			};
			//�Ƿ���������
			$isFinish = [];
			foreach ($info as $key => $value) {
				$do=strstr($value['headimg'],"user/headimg");
				if(!empty($value['nickname']) && empty($do) && !empty($value['hobby'])){//�ж��Ƿ���������
					$isFinish[]=2;
					C::t('#xy_ivite#xyivite_ivite')->update($key,array('status'=>"2",'score'=>0));
				}else{
					//ע��
					C::t('#xy_ivite#xyivite_ivite')->update($key, array('status'=>"1",'area'=>$adress[$key],'score'=>0));
					$isFinish[]=0;
				}	
			};
			//ͳ��ȫ��
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
		$infos=C::t('#xy_ivite#xyivite_ivite')->fetch_all_uid();//���������û�״̬status��=2
		
		foreach($infos as $key =>$val){
			$score = 0;
			$info=$this->getUserinfo_api($val['ivitephone']);
			if(is_array($info) && !empty($info['nickname'])){
				$score+=1;
				$area=$this->get_mobile_area($val['ivitephone']);//�ж��ֻ�������
				if($area['province'] == "����"){
					$score +=2 ;
				}
				$do=strstr($info['headimg'],"user/headimg");
				if(!empty($info['nickname']) && empty($do) && !empty($info['hobby'])){//�ж��Ƿ���������
					$score +=1 ; 
					C::t('#xy_ivite#xyivite_ivite')->update($val['id'], array('status'=>"2",'score'=>$score));//status 1//��ע�� 2//����������
				}else{
					C::t('#xy_ivite#xyivite_ivite')->update($val['id'], array('status'=>"1",'area'=>$area['province'],'score'=>$score));//status 1//��ע�� 2//���������� 

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
				curl_setopt($ch, CURLOPT_TIMEOUT, 300); //30�볬ʱ  
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
		$sms = array('province'=>'', 'supplier'=>'');    //��ʼ������
		//�����Ա������ݿ���÷���ֵ
		$url = "http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=".$mobile."&t=".time();

		$content = file_get_contents($url);
		$sms['province'] = substr($content, "56", "4");  //��ȡ�ַ���
		$sms['supplier'] = substr($content, "81", "4");
		return $sms;
	}

}
?>
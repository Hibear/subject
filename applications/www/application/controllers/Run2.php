<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Run2 extends MY_Controller{
	
	public $session_name = "yanji_user_openid";
	public $session_nick_name = "yanji_wetcaht_name";
	public $app;
	public $user_openid;
	public $wetcaht_name;
	public $user_id;
	public $pid = 2;
	
    public function __construct(){
        parent::__construct();
         $this->load->model([
             'Model_run_users' => 'Mrun_users',
             'Model_run_usersupport' => 'Mrun_usersupport',
             'Model_lottery' => 'Mlottery',
        ]);
		$this->load->library('openid');
		$this->app = C("appid_secret.akx");
		
    }
    
	/*
    * 
    *初始化参数
    * shunyu
    */
	public function _init($url=""){
		
		 if(!$this->session->has_userdata($this->session_name)){
			$userinfo = $this->openid->getopenid($this->app['app_id'],$this->app['app_secret'],1,$url);
			$this->session->set_userdata($this->session_name, $userinfo['openid']);
			$this->session->set_userdata($this->session_nick_name, $userinfo['nickname']);

		}

		$this->user_openid = $this->session->userdata($this->session_name);		
	}
	
    
    /*
    * 
    *助力
    * shunyu
    */
    public function index(){
        $data = $this->data;
		$data['token'] = $this->set_token();
        $this->_init();
		
	       //获取用户当前助力成功
		$nums = $this->Mrun_usersupport->count(array("pid"=>$this->pid,"user_openid"=>$this->user_openid));

		$pos = 0;
		//计算当前小人的位置
		
        $data['nums'] = $nums;
		if($nums<20){
			$data['pos'] = $nums;
		}else{
			$data['pos'] = 20;
		}
		
		//自定义分享
		$data['title'] = "畅游燕隼·自由呼吸"; 
		$data['link'] = C("domain.www.url")."/run2/showpage?id=".$this->user_openid; 
		$data['imgUrl'] = C("domain.www.url")."/static/run2/img/share.jpg"; 
		$data['desc'] = "畅游燕隼·自由呼吸"; 
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
		
		$this->load->view("run2/index", $data);
    }
	
   /*
    * 
    *分享页面
    * shunyu
    */
	public function showpage(){
		
		 $data = $this->data;
		 $this->_init(C("domain.www.url").$_SERVER['REQUEST_URI']);
		 $data['user_id'] = $this->input->get("id");

		//获取用户当前助力成功
		$nums = $this->Mrun_usersupport->count(array("pid"=>$this->pid,"user_openid"=>$data['user_id']));
        $data['nums'] = $nums;
		if($nums<20){
			$data['pos'] = $nums;
		}else{
			$data['pos'] = 20;
		}
		
		
		//自定义分享
		$data['title'] = "畅游燕隼·自由呼吸"; 
		$data['link'] = C("domain.www.url")."/run2/showpage?id=".$this->input->get("id"); 
		$data['imgUrl'] = C("domain.www.url")."/static/run2/img/share.jpg"; 
		$data['desc'] = "畅游燕隼·自由呼吸"; 
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
		
		$this->load->view("run2/share",$data);
	}
	
	/*
    * 
    * 获取当前的位置
    * shunyu
    */
	public function posion($nums){
		$pos = 0;
		if($nums){
			switch ($nums)
				{
				case 1:
				case 2:
				  $pos = 50;
				  break;
				case 3:
				case 4:
				  $pos = 100;
				  break;
				case 5:
				case 6:
				  $pos = 150;
				  break;  
				case 7:
				case 8:
				  $pos = 200;
				  break;    
				case 9:
				case 10:
				  $pos = 250;
				  break; 
				case 11:
				case 12:
				  $pos = 300;
				  break; 
				case 13:
				case 14:
				  $pos = 350;
				  break; 
				case 15:
				case 16:
				  $pos = 400;
				  break;   
				case 17:
				case 18:
				  $pos = 450;
				  break;
				default:
				   $pos = 500;			  
				}
		}
		return $pos;
	}
	
    /*
    * 
    *点击支持用户
    * shunyu
    */
	public function  run_zct(){
		if(IS_POST){
			
		    $user_id = $this->input->post("user_id");
			$openid = $this->session->userdata($this->session_name);
			if($user_id == $openid){
				$this->return_json(array("info"=>"不能自己给自己助力！","code"=>1));
			}
			//查询该用户是否已经支持过
			$result = $this->Mrun_usersupport->count(array("pid"=>$this->pid,"user_openid"=>$user_id,"openid"=>$openid));
			if(!$result){
				 $post_data = array(
				 'pid'=>$this->pid,
				 'user_openid'=>$user_id,
				 'openid'=>$openid,
				 'create_time'=>date("Y-m-d H:i:S")
			   );
			   $id = $this->Mrun_usersupport->create($post_data);
			   if($id){
				   
				   $nums = $this->Mrun_usersupport->count(array("pid"=>$this->pid,"user_openid"=>$user_id));
					$pos = 0;
					//计算当前小人的位置
					if($nums<20){
						 $pos = $nums;
					}else{
						$pos = 20;
					}
				   $this->return_json(array("info"=>"支持成功<br />点击我也要畅游燕隼！","pos"=>$nums,"code"=>2));
			   }
			   else{
				   	$this->return_json(array("info"=>"助力失败！","code"=>1));
				}
			}else{
				$this->return_json(array("info"=>"你已经助力过了","code"=>1));
			}
		}
	}
	
	
	/*
    * 
    *用户报名
    * shunyu
    */
	public function add_user(){
		if(IS_POST){
			$openid = $this->session->userdata($this->session_name);
            $count = $this->Mrun_users->count(array("openid"=>$openid,'pid'=>$this->pid));
			if(!$count){
				$wetcaht_name = $this->session->userdata($this->session_nick_name);
				$res = $this->Mrun_users->replace_into(array("openid"=>$openid,'wetcaht_name'=>$wetcaht_name,'pid'=>$this->pid,'create_time'=>date("Y-m-d H:i:s")));
			    if($res){
					$this->return_json(array("info"=>"提交成功"));
				}else{
					$this->return_json(array("info"=>"提交失败"));
				}
			}else{
				$this->return_json(array("info"=>"你已经提交过了"));
			}
		}
	}
	
	/*
    * 
    *提交信息
    * shunyu
    */
	public function success(){
		$data = $this->data;
		$data['token'] = $this->set_token();

		
	//自定义分享
		$data['title'] = "畅游燕隼·自由呼吸"; 
		$data['link'] = C("domain.www.url")."/run2"; 
		$data['imgUrl'] = C("domain.www.url")."/static/run2/img/share.jpg"; 
		$data['desc'] = "畅游燕隼·自由呼吸"; 
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
		
		$this->load->view("run2/success",$data);
	}
	
	
	
	

   //更新用户的数据
   public function update_users(){
	   if(IS_POST){
		   $openid = $this->session->userdata($this->session_name);
		   if(!$openid){
			   $this->return_json(array("info"=>"非法用户")); 
			}
		   
		   $data = array(
		     'name'=>$this->input->post("name"),
		     'tel'=>$this->input->post("tel")
		   );
		 $result = $this->Mrun_users->update_info($data,array("openid"=>$openid,'pid'=>$this->pid));
		 if($result){
			$this->return_json(array("info"=>"提交成功！")); 
		 }else{
			$this->return_json(array("info"=>"提交失败！"));  
		 }
	   }
   }

}
?>

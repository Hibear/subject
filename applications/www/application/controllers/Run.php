<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Run extends MY_Controller{
	
	public $session_name = "run_user_openid";
	public $session_nick_name = "wetcaht_name";
	public $app;
	public $user_openid;
	public $wetcaht_name;
	public $user_id;
	public $pid = 1;
	
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
		if($nums<10){
			$data['percent'] =intval(($nums/10)*100);
			$data['peoples'] = 10-$nums;
		}else{
			$data['percent'] = 100;
			$data['peoples'] = -1;
		}
        $data['nums'] = $nums;
	  
	  
		//自定义分享
		$data['title'] = "逃离寒冬，相约未来"; 
		$data['link'] = "http://h5.wesogou.com/run/showpage?id=".$this->user_openid; 
		$data['imgUrl'] = C("domain.www.url")."/static/run/share.png"; 
		$data['desc'] = "逃离寒冬，相约未来"; 
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
		
		$this->load->view("run/index", $data);
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
		if($nums<10){
			$data['percent'] =intval(($nums/10)*100);
			$data['peoples'] = 10-$nums;
		}else{
			$data['percent'] = 100;
			$data['peoples'] = -1;
		}
        $data['nums'] = $nums;
		
		
		//自定义分享
		$data['title'] = "逃离寒冬，相约未来"; 
		$data['link'] = C("domain.www.url")."/run/showpage?id=".$this->input->get("id"); 
		$data['imgUrl'] = C("domain.www.url")."/static/run/share.png"; 
		$data['desc'] = "逃离寒冬，相约未来"; 
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
		
		$this->load->view("run/share",$data);
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
				$this->return_json(array("info"=>"不能自己给自己助力！"));
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
				   $this->return_json(array("info"=>"支持成功<br />点击我也要逃离寒冬！"));
			   }
			   else{
				   	$this->return_json(array("info"=>"助力失败！"));
				}
			}else{
				$this->return_json(array("info"=>"你已经助力过了"));
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
				$this->Mrun_users->replace_into(array("openid"=>$openid,'wetcaht_name'=>$wetcaht_name,'pid'=>$this->pid,'create_time'=>date("Y-m-d H:i:s")));
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
		
		
		//自定义分享
		$data['title'] = "逃离寒冬，相约未来"; 
		$data['link'] = C("domain.www.url")."/run/showpage?id=".$this->user_openid; 
		$data['imgUrl'] = C("domain.www.url")."/static/run/share.png"; 
		$data['desc'] = "逃离寒冬，相约未来"; 
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
		
		$this->load->view("run/success",$data);
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

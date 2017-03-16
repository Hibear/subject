<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Naonao extends MY_Controller{
	
	public $session_name = "naonao_user_openid";
	public $session_nick_name = "naonao_wetcaht_name";
	public $app;
	public $user_openid;
	public $wetcaht_name;
	public $user_id;
	public $pid = 3;
	
    public function __construct(){
        parent::__construct();
         $this->load->model([
             'Model_lottery_users' => 'Musers',
             'Model_lottery' => 'Mlottery',
        ]);
		$this->load->library('openid');
		$this->app = C("appid_secret.dashi");
		
    }
    
	/*
    * 
    *初始化参数
    * 1034487709@qq.com
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
    *挠一挠送红包
    * 1034487709@qq.com
    */
    public function index(){
		

		$data = $this->data;
		$data['token'] = $this->set_token();
		$url = C("domain.www.url").'/naonao';
        $this->_init($url);
	  
		
		//自定义分享
		$data['title'] = "挠小金人·送红包"; 
		$data['link'] = C("domain.www.url")."/naonao"; 
		$data['imgUrl'] = C("domain.www.url")."/static/naonao/img/1.png"; 
		$data['desc'] = "挠小金人·送红包"; 
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
		
		$this->load->view("naonao/index", $data);
    }
	
   /*
    * 
    *验证码
    * 1034487709@qq.com
    */
	public function code(){
		$this->load->library('yancode');
        Yancode::generate(6,20,'captcha',150,40);
	}
	
	/*
    * 
    *用户报名
    * 1034487709@qq.com
    */
	public function add_user(){
		if(IS_POST){
			$token = $this->input->post("token");
			$name = $this->input->post("name");
			$tel = $this->input->post("tel");
			$code = strtolower($this->input->post("code"));
			if(!$this->check_token($token)){
				$this->return_json(array("info"=>"非法用户","code"=>-1));
			}
			
			//判断验证码
			$captcha = strtolower($this->session->userdata("captcha"));
			if($code != $captcha){
				$this->return_json(array("info"=>"验证码不正确","code"=>-4));
			}
			
			//判断是否是开始
			$start_time = 20161117;
			$end_time = 20161125;
			$now = intval(date("Ymd"));
			$start_h = 14;
			$end_h = 19;
			$h = intval(date("H"));
			
			if(($now < $start_time) || ($h < $start_h)){
				$this->return_json(array("info"=>"活动还没有开始","code"=>102));
			}
			if($now>$end_time){
				$this->return_json(array("info"=>"活动已经结束","code"=>101));
			}
			if($h > $end_h){
				
				$this->return_json(array("info"=>"今天活动结束，明天14点再来","code"=>100));
			}
			//每天领取500元
			
			$date_file = "logs/".$now.".txt";
			$count = 0;
			if(file_exists($date_file)){
				$count = intval(file_get_contents($date_file));
			}
			if($count>=300){
				 $this->return_json(array("info"=>"今天红包已经结束,明天14点再来!","code"=>100));
			 }	   
			
			$openid = $this->session->userdata($this->session_name);
			if(!$openid){
				$this->return_json(array("info"=>"非法用户","code"=>-2));
			}
            $count_user = $this->Musers->count(array("openid"=>$openid,'pid'=>$this->pid));
			 
			if(!$count_user){
					$wetcaht_name = $this->session->userdata($this->session_nick_name);

					  //只能在微信中打开
				     $agent = $_SERVER['HTTP_USER_AGENT'];
				     if(!strpos($agent,"icroMessenger")) {
					   $this->return_json(array("info"=>"只能在微信中打开!","code"=>103));
				     }
				     
					 //判断openid
				     $openid_arr = json_decode(file_get_contents("logs/openid.txt"),true);
				     if(in_array($openid, $openid_arr)){
					   $this->return_json(array("code"=>2,"info"=>"你已经领取过"));
				     }
					 
					  //判断ip
					 $ip_arr = json_decode(file_get_contents("logs/ip.txt"),true);
						if(in_array($_SERVER["REMOTE_ADDR"], $ip_arr)){
						$this->return_json(array("code"=>3,"info"=>"你已经领取过"));
					 }
					 
				    $res = $this->send_red(100);
					echo $res;
					$res_arr = json_decode($res,true);
					if(intval($res_arr['code']) == 1){
						
						 array_push($openid_arr,$openid);
						 file_put_contents("logs/openid.txt",json_encode($openid_arr));
						 
						 array_push($ip_arr,$_SERVER["REMOTE_ADDR"]);
						 file_put_contents("logs/ip.txt",json_encode($ip_arr));
						 
						 file_put_contents($date_file,$count+1);
						 $result = $this->Musers->create(array("openid"=>$openid,'name'=>$name,'tel'=>$tel,'pid'=>$this->pid,'create_time'=>date("Y-m-d H:i:s")));

					}
					
				
			
			}else{
				
				$this->return_json(array("info"=>"你已经领取过了","code"=>-3));
			}
		}
	}
	
	/*
    * 
    * 发送红包
    * 1034487709@qq.com
    */
	private  function send_red($total_amount){
		   $this->load->library('authcode');
			 $url = "http://123.57.238.232:8090/Red/new_one_red";
			$post_data = array(
				"app_mchid"=>$this->app['app_mchid'],
				"app_id"=>$this->app['app_id'],
				"openid"=>$this->session->userdata($this->session_name),
				"filename"=>"akx",
				"send_name"=>"中央国际",
				"wishing"=>"恭喜发财",
				"act_name"=>"中央国际",
				"remark"=>"中央国际",
				"total_amount"=>$total_amount,
				"en_string"=>Authcode::Crypto("token","ENCODE","194912")
			);
			
			file_put_contents("logs/b.txt",json_encode($post_data));
			$result = Http::Request($url,$post_data,"POST");
			file_put_contents("logs/liu.txt",$result);
			return $result ;
			
	}
	
	
}
?>

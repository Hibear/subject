<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Fireworks extends MY_Controller{
	
	public $session_name = "fzyanhua";
	
    public function __construct(){
        parent::__construct();
         $this->load->model([
             'Model_lottery_users' => 'Mlottery_users',
             'Model_register_uers' => 'Mregister_uers',
             'Model_lottery' => 'Mlottery',
        ]);
    }
    
    
    /*
    * 
    *蓄力烟花
    * nengfu@gz-zc.cn
    */
    public function index(){
        $data = $this->data;
		$data['token'] = $this->set_token();
        $this->load->library('openid');
		$app = C("appid_secret.akx");
	
		//$this->session->unset_userdata($this->session_name);
		if(empty($this->session->userdata($this->session_name))){
			
			$userinfo = $this->openid->getopenid($app['app_id'],$app['app_secret']);
				
			if(!isset($userinfo['openid']) || empty($userinfo)){
				$userinfo['openid'] = "Cms_" . $this->get_rand_char(20);
			}
			$openid = $userinfo['openid']; 
			$this->session->set_userdata($this->session_name, $openid);
		}else{
			$openid = $this->session->userdata($this->session_name);
		}
	
		//自定义分享
		$data['title'] = "庆祝大国诞生 点燃绚烂烟花 赢取节日贺礼"; 
		$data['link'] = C("domain.www.url")."/fireworks/index"; 
		$data['imgUrl'] = "http://h5.wesogou.com/static/fireworks/img/next.png"; 
		$data['desc'] = "庆祝大国诞生 点燃绚烂烟花 赢取节日贺礼"; 
        $data['signPackage'] = $this->share($app['app_id'],$app['app_secret']);
		
		//判断活动是否开始
		$data['lottery'] = $this->Mlottery->get_one("name,switch,info",array("pid"=>1));
		
		
		
		//判断用户当天是否
		$user = $this->Mlottery_users->get_one("operate_time",array("openid"=>$openid,'pid'=>1));
		$data['recoder'] = 0;
		if($user){
			if($user['operate_time'] == date("Ymd")){
				$data['recoder'] = 1;
			}
			
		}else{
			$user_data = array(
			'openid'=>$openid,
			'pid'=>1,
			'create_time'=>date("Y-m-d H:i:s")
			);
		   $this->Mlottery_users->replace_into($user_data);
		}
		
		$data['openid'] = $openid;
	//	$this->output->cache(30);
		$this->load->view("fireworks/index", $data);
    }
	public function baoming(){
		$data = $this->data;
		if(IS_POST){
			$user = array(
			'pid'=>1,
			'name'=>$this->input->post("name",true),
			'tel'=>intval($this->input->post("tel")),
			'create_time'=>date("Y-m-d H:i:s")
			);
			
		   echo $this->Mregister_uers->replace_into($user);
		   exit;
		}
		
		
		//自定义分享
		$app = C("appid_secret.akx");
		$data['title'] = "澜亭集序  趣味背诗词 赢方舟大礼"; 
		$data['link'] = "http://wx.wesogou.com/develop/zhongqiu/index.php"; 
		$data['imgUrl'] = "http://wx.wesogou.com/develop/zhongqiu/img/logo.jpg"; 
		$data['desc'] = "澜亭集序  趣味背诗词 赢方舟大礼"; 
        $data['signPackage'] = $this->share($app['app_id'],$app['app_secret']);
		$this->load->view("fireworks/baoming",$data);
	}
	
	
	/***
	 *抽奖
	***/
	public function get_ajax(){
		if(IS_GET){
			$openid =  $this->session->userdata($this->session_name);
			$prize_arr = array(
				'0' => array('id' => 1, 'prize' => '中奖了', 'v' => 200),
				'1' => array('id' => 2, 'prize' => '谢谢参与', 'v' => 25),
				'2' => array('id' => 3, 'prize' => '再接再厉', 'v' => 25),
				'3' => array('id' => 4, 'prize' => '明日再战', 'v' => 30),
				'4' => array('id' => 5, 'prize' => '谢谢参与', 'v' => 0),
				'5' => array('id' => 6, 'prize' => '谢谢参与', 'v' => 0),
			);
			
			foreach ($prize_arr as $key => $val) {
				$arr[$val['id']] = $val['v'];
			}
			
			$rid = $this->get_rand($arr); //根据概率获取奖项id 
			if(in_array($rid,array(1))){
				$res['code'] = 0;
			}else{
				$res['code'] = -1;
			}	
			
			$res['yes'] = $prize_arr[$rid - 1]['prize']; //中奖项 
			unset($prize_arr[$rid - 1]); //将中奖项从数组中剔除，剩下未中奖项 
			shuffle($prize_arr); //打乱数组顺序 
			
			for ($i = 0; $i < count($prize_arr); $i++) {
				$pr[] = $prize_arr[$i]['prize'];
			}
			$res['no'] = $pr;
			
			//把中奖概率写入表中
			$data = array(
				'level'=>$rid
			);
			$this->Mlottery_users->update_info($data,array("openid"=>$openid,'pid'=>1));
			
			$this->return_json($res);
			
			
		}
	}

   //更新用户的数据
   public function update_users(){
	   if(IS_POST){
		   $openid = $this->session->userdata($this->session_name);
		   $data = array(
		     'name'=>$this->input->post("name"),
		     'tel'=>$this->input->post("tel"),
		     'operate_time'=>date("Ymd")
		   );
		  echo $this->Mlottery_users->update_info($data,array("openid"=>$openid,'pid'=>1));
	   }
   }



 

  

 

}
?>

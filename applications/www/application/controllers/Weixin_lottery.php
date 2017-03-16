<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Weixin_lottery extends MY_Controller{
	
public $session_name = "yanji_user_openid";
	public $session_nick_name = "lottery_wetcaht_name";
	public $app;
	public $user_openid;
	public $wetcaht_name;
	public $user_id;
	public $pid = 4;

    public function __construct(){
        parent::__construct();
         $this->load->model([
             'Model_lottery_users' => 'Mlottery_users'
        ]);
		
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
	
    
    public function index(){
		error_reporting(0);
		$this->load->library('openid');
		$this->app = C("appid_secret.dashi");
	    $url = C("domain.www.url").'/lottery';
	    $this->_init($url);
		
		//查询用户中奖信息
		$openid = $this->session->userdata($this->session_name);
		$data['prize'] = $this->Mlottery_users->get_one("*", array('openid' => $openid, 'pid' => $this->pid));
		// echo "<pre>";print_r($data['prize']);exit;
		
		//自定义分享
		$data['title'] = "幸运大转盘"; 
		$data['link'] = C("domain.www.url")."/lottery"; 
		$data['imgUrl'] = C("domain.www.url")."/static/lottery/images/share.jpg"; 
		$data['desc'] = "幸运大转盘"; 
		
		
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
		
        $this->load->view("lottery/index", $data);

    }

	public function rand_lottery(){
		//查询用户是否已经中过奖
		$openid = $this->session->userdata($this->session_name);
		if(!$openid){
			echo -2;
			exit;
		}
	
		$count = $this->Mlottery_users->count(
			array(
			'openid'=>$openid,
			'pid'=>$this->pid
			)
		);
		//echo $this->db->last_query();
		if($count){
			echo -1;
			exit;
		}
		
		
		//查询今天发放出去的奖品数量
		$list = $this->Mlottery_users->count_group(
			array('level','count(id) as num'),
			array(
			"pid"=>$this->pid,
			"operate_time"=>date("Ymd")
			),
			'level'
		);
		
		$leve_arry = array(
			'1' => 150,        //利是封
			'2' => 5,		   //保温杯
			'3' => 5,		   //充电宝
			'4' => 5,		   //折叠伞
			'5' => 5,          //长柄伞
			'6' => 5,          //8.8元红包
			'7' => 150,        //纸巾盒
			'8' => 300,        //笔
		);
	
		for($i = 1; $i <= 8; $i++) {
			if($list) {
				foreach($list as $key => $val) {
					if($val['level'] == $i) {
						if($val['num'] <= $leve_arry[$i]) {
							$leve_arry[$i] = $leve_arry[$i]-$val['num'];
						} else {
							$leve_arry[$i] = 0;
						}
						break;
					}
				}
		    }
		}
		
		// print_r($leve_arry);exit;
		//判断今天奖品是否已经抽取完成
		if(!array_sum($leve_arry)){
			echo -3;
			exit;
		}
	
		//echo $this->db->last_query();
		$prize_arr = array(
			'0' => array('id' => 1, 'prize' => '利是封', 'v' => $leve_arry[1]),
			'1' => array('id' => 2, 'prize' => '保温杯', 'v' => $leve_arry[2]),
			'2' => array('id' => 3, 'prize' => '充电宝', 'v' => $leve_arry[3]),
			'3' => array('id' => 4, 'prize' => '折叠伞', 'v' => $leve_arry[4]),
			'4' => array('id' => 5, 'prize' => '长柄伞', 'v' => $leve_arry[5]),
			'5' => array('id' => 6, 'prize' => '8.8元红包', 'v' => $leve_arry[6]),
			'6' => array('id' => 7, 'prize' => '纸巾盒', 'v' => $leve_arry[7]),
			'7' => array('id' => 8, 'prize' => '笔', 'v' => $leve_arry[8]),
		);
		
		foreach ($prize_arr as $key => $val) {
			$arr[$val['id']] = $val['v'];
		}
		
		
		
		$number = $this->Mlottery_users->get_one("max(number) AS number", array("pid"=>$this->pid));
		if ($number && $number['number']) {
			$number = $number['number'] + 1;
		} else {
			$number = "10000";
		}
		
		echo $rid = $this->get_rand($arr); //根据概率获取奖项id 
		$this->Mlottery_users->create(
			array(
			"openid"=>$openid,
			"name"=>$this->session->userdata($this->session_nick_name),
			'pid'=>$this->pid,
			'level'=>$rid,
			'level_name'=>$prize_arr[$rid-1]['prize'],
			'number'=>$number,
			'create_time'=>time(),
			'operate_time'=>date("Ymd")
			)
		);
		
	}	
	//计算中奖概率
	public function get_rand($proArr) {
    $result = '';

    //概率数组的总概率精度 
    $proSum = array_sum($proArr);

    //概率数组循环 
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
            $result = $key;
            break;
        } else {
            $proSum -= $proCur;
        }
    }
    unset($proArr);

    return $result;
}
}
?>

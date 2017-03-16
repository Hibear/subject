<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Lotterys extends MY_Controller{
	
    public $session_name = "xitai_user";
	private $open_id;
	public $app;
    public function __construct(){
        parent::__construct();
         $this->load->model([
             'Model_weixin_lottery_user' => 'Mweixin_lottery_user',
             'Model_lottery_log' => 'Mlottery_log',
             'Model_vote_log' => 'Mvote_log'
        ]);
        if($this->session->has_userdata($this->session_name)){
            $this->open_id = $this->session->userdata($this->session_name);
        }
        $this->app = C("appid_secret.dashi");
    }
	
    
    public function index(){
		error_reporting(0);
		//获取openid
		$open_id =$this->open_id;
		if(!$open_id){
		    $this->load->view('lotterys/no_login');
		}else{
		    $data['prize'] = $this->Mlottery_log->get_lists("*", array('open_id' => $open_id,'is_del' => 0), array('create_time' => 'desc'));
		    //查询用户是否完善领奖信息
		    $res = $this->Mweixin_lottery_user->get_one('id,fullname,tel',['openid' => $this->open_id,'is_del' => 0]);
		    if($res){
		        //返回不用添加领奖信息标记
		        $data['user'] = $res;
		        $data['status'] = 0;
		    }else{
		        $data['status'] = 1;
		    }
		    //分享
		    $data['title'] = "幸运大转盘";
		    $data['link'] = C("domain.www.url")."/weixin/detail?id=".$info['id'];
		    $data['imgUrl'] = C("domain.www.url")."uploads/images/".$info['cover_img'];
		    $data['desc'] = "贵阳方舟戏台幸运大转盘抽奖活动";
		    
		    $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
		    
		    
		    $this->load->view("lotterys/index", $data);
		}
    }
    
    public function update_user_info(){
        $add = $this->input->post();
        $add['fullname'] = trim($add['fullname']);
        if(!$this->open_id){
            $this->return_json(['status' => 0, 'msg' => '非法请求！']);
        }
        if(empty($add['fullname'])){
            $this->return_json(['status' => 0, 'msg' => '姓名不能为空！']);
        }
        if(empty($add['tel'])){
            $this->return_json(['status' => 0, 'msg' => '电话不能为空！']);
        }
        if(!preg_match('/^1[3|4|5|8|7][0-9]\d{8}$/', $add['tel'])){
            $this->return_json(['status' => 0, 'msg' => '手机号格式不正确！']);
        }
        $add['openid'] = $this->open_id;
        $add['create_time'] = $add['update_time'] = date('Y-m-d H:i:s');
        $res = $this->Mweixin_lottery_user->create($add);
        if(!$res){
            $this->return_json(['status' => 0, 'msg' => '请重试！']);
        }
        $this->return_json(['status' => 1, 'msg' => '完成']);
    }

	public function rand_lottery(){
		//判断是否已经关注公众号
		$open_id = $this->open_id;
		if(!$open_id){
			echo -2;
			exit;
		}
	    //查询今天是否已经抽过奖
		$count = $this->Mlottery_log->count(
			array(
			'open_id'=>$open_id,
			'year(create_time)' => date('Y'),
			'month(create_time)' => date('m'),
			'day(create_time)' => date('d'),
			'is_del' => 0
			)
		);
		if($count){
			echo -1;
			exit;
		}
		
		if(!$this->check_lottery()){
		    echo -4;exit;//不满足抽奖条件
		}
		
		$list = $this->Mlottery_log->count_group(
			array('level','count(id) as num'),
			array(
			    'year(create_time)' => date("Y"),
			    'month(create_time)' => date("m"),
			    'day(create_time)' => date("d"),
			),
			'level'
		);
		
		$leve_arry = array(
			'1' => 75,        //戏台门票
			'2' => 1000,		   //谢谢参与
			'3' => 1000,		   //谢谢参与
			'4' => 1000,		   //谢谢参与
			'5' => 75          //戏台门票
		);
	
		for($i = 1; $i <= 5; $i++) {
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
		if(!array_sum($leve_arry)){
			echo -3;
			exit;
		}
	
		//echo $this->db->last_query();
		$prize_arr = array(
			'0' => array('id' => 1, 'prize' => '戏台门票', 'v' => $leve_arry[1]),
			'1' => array('id' => 2, 'prize' => '谢谢参与', 'v' => $leve_arry[2]),
			'2' => array('id' => 3, 'prize' => '谢谢参与', 'v' => $leve_arry[3]),
			'3' => array('id' => 4, 'prize' => '谢谢参与', 'v' => $leve_arry[4]),
			'4' => array('id' => 5, 'prize' => '戏台门票', 'v' => $leve_arry[5])
		);
		
		foreach ($prize_arr as $key => $val) {
			$arr[$val['id']] = $val['v'];
		}
		
		echo $rid = $this->get_rand($arr); 
		$this->Mlottery_log->create(
			array(
			"open_id"=>$open_id,
			'level'=>$rid,
			'lottery_info'=>$prize_arr[$rid-1]['prize'],
			'create_time'=>date('Y-m-d H:i:s')
			)
		);
		
	}	

	public function get_rand($proArr) {
    $result = '';


    $proSum = array_sum($proArr);


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
    
    private function check_lottery(){
        //检查是否具备抽奖的条件
        $open_id = $this->open_id;
        if(!$open_id){
            return false;
        }
        $where = ['open_id' => $open_id, "year(create_time)" => date('Y'), "month(create_time)" => date('m'), "day(create_time)" => date('d'), 'is_del' => 0];
        $info = $this->Mvote_log->count($where);
        if($info == 3){
            return true;
        }else{
            return false;
        }
    }
}
?>

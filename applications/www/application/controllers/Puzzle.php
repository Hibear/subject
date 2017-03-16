<?php 
/**
 * 九宫格拼图游戏
 * @author jianming
 */
defined('BASEPATH') or exit('No direct script access allowed');    
class Puzzle extends MY_Controller{
	public $session_name = "run_user_openid";
	public $session_nick_name = "wetcaht_name";
	public $app;
	public $user_openid;
	public $wetcaht_name;
	public $user_id;
	public $pid = 1;
	
    public function __construct() {
        parent::__construct();
        $this->load->model([
                'Model_puzzle_users' => 'Mpuzzle_users',
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
    
    /**
     * 首页
     */
    public function index() {
        $data = $this->data;
		$this->_init();
		
		$open_id = $this->session->userdata($this->session_name);
		$user = $this->Mpuzzle_users->get_one('*', array('open_id' => $open_id));
		$data['is_win'] = $user['is_win'];
		
        $this->load->view("puzzle/index", $data);
    }
	
	public function validate_user() {
		$open_id = $this->session->userdata($this->session_name);
		if (!$open_id) {
			$this->return_json(array('flag' => false, 'msg' => '获取不到openid'));
		}
		
		$user = $this->Mpuzzle_users->get_one('*', array('open_id' => $open_id));
		if ($user) {
			if($user['is_win'] == 1) {
				$this->return_json(array('flag' => false, 'msg' => '您已经成功闯关！不能再次进入游戏！'));
			}
			
			if($user['already_play_count'] >= 3) {
				$this->return_json(array('flag' => false, 'msg' => '每天只有三次机会，请明天再来！'));
			} else {
				$this->Mpuzzle_users->update_info(array('incr' => array('already_play_count' => 1)), array('open_id' => $open_id));
				$this->return_json(array('flag' => true));
			}
		} else {
			$this->Mpuzzle_users->create(array('open_id' => $open_id, 'already_play_count' => 1, 'create_time' => date('Y-m-d H:i:s')));
			$this->return_json(array('flag' => true));
		}
	}
	
	public function game() {
		$open_id = $this->session->userdata($this->session_name);
		$action =  $this->uri->segment(2) ? strtolower($this->uri->segment(2)) : ''; //方法
		if($action != 'index' && !$open_id) {
			header('location:' . C('domain.www.url') .'/puzzle');
            exit;
		}
		
		$data = $this->data;
		$img_arr = array('1', '2', '3', '4', '5','6','7','8','9','10');
		shuffle($img_arr);
		$data['img_arr'] = $img_arr;
		
		$user = $this->Mpuzzle_users->get_one('*', array('open_id' => $open_id));
		if($user['already_play_count'] >= 3) {
			header('location:' . C('domain.www.url') .'/puzzle');
            exit;
		}
		$data['already_play_count'] = $user['already_play_count'];
        $this->load->view("puzzle/game", $data);
	}
	
	public function get_ticket() {
		$open_id = $this->session->userdata($this->session_name);
		$action =  $this->uri->segment(2) ? strtolower($this->uri->segment(2)) : ''; //方法
		if($action != 'index' && !$open_id) {
			header('location:' . C('domain.www.url') .'/puzzle');
            exit;
		}
		
		$user = $this->Mpuzzle_users->get_one('*', array('open_id' => $open_id));
		if($user['is_win'] == 1) {
			header('location:' . C('domain.www.url') .'/puzzle');
            exit;
		}
		
		$data = $this->data;
		$this->load->view("puzzle/getticket", $data);
	}
	
	public function save_userinfo() {
		$data = $this->data;
		$open_id = $this->session->userdata($this->session_name);
		$update_data['user_name'] = $this->input->post('user_name');
		$update_data['phone_number'] = $this->input->post('phone_number');
		$update_data['is_win'] = 1;
		$result = $this->Mpuzzle_users->update_info($update_data, array('open_id' => $open_id));
		if($result) {
			$this->return_json(array('flag' => true, 'msg' => '提交成功！'));
		} else {
			$this->return_json(array('flag' => false, 'msg' => '提交失败！请重试！'));
		}
	}
	
	public function update_already_count() {
		$open_id = $this->session->userdata($this->session_name);
		if (!$open_id) {
			$this->return_json(array('flag' => false, 'msg' => '获取不到openid'));
		}
		$result = $this->Mpuzzle_users->update_info(array('incr' => array('already_play_count' => 1)), array('open_id' => $open_id, 'is_win' => 0));
		if($result) {
			$this->return_json(array('flag' => true));
		}
	}

}
?>

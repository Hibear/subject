<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Target extends MY_Controller{
	
public $session_name = "target_user_openid";
	public $session_nick_name = "target_wetcaht_name";
	public $app;
	public $user_openid;
	public $wetcaht_name;
	public $user_id;
	public $pid = 6;

    public function __construct(){
        parent::__construct();
         $this->load->model([
            'Model_target_users' => 'Mtarget_users'
        ]);
		
    }
    
    /*
    * 
    *初始化参数
    * shunyu
    */
	public function _init($url=""){
		
			$userinfo = $this->openid->getopenid($this->app['app_id'],$this->app['app_secret'],1,$url);
			$this->session->set_userdata($this->session_name, $userinfo['openid']);
			$this->user_openid = $userinfo['openid'];
			$this->data['user']= $userinfo;	
	}
	
    
    public function index(){
		error_reporting(0);
		$this->load->library('openid');
		$this->app = C("appid_secret.dashi");
	    $url = C("domain.www.url").'/target';
	    $this->_init($url);
	/*  $this->data['user'] = array(
		'nickname'=>"123",
		'headimgurl'=>"http://wx.qlogo.cn/mmopen/hxq3zibPfj0Llx85ygFOHCQRibNawDIgiaVOnjCesePLeSratW09a22icrAo9iaPAkBb0Koia1NroBn2IIh3wwHqMNtiaMeRtImUHIy/0",
		'openid'=>"oMUIWs1SZUn9KCHsbUyhm62pTo-A"
	   );*/
	    $this->data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);

        $this->load->view("target/index", $this->data);

    }
	
	//获取有多少人参加
	public function allcount(){
		
		echo $res = $this->Mtarget_users->count();
	}

	
	public function publish_target(){
		$data = str_replace("[removed]","data:image/png;base64,",$_POST['data']);
		$userinfo = array(
			'openid'=>$_POST['openid'],
			'name'=>$_POST['name'],
			'headimage'=>$_POST['headimage'],
			'target_img'=>$data
		);	
		echo $this->Mtarget_users->create($userinfo);
		
	}
	
	//获取点赞数
	public function clickLike(){
		$id = $_GET['id'];
		$data['incr'] = array(
			'like_count'=>1
		);
		$where['id'] = $id; 
		$this->Mtarget_users->update_info($data,$where);
	}
	
	//获取列表
	public function targetList(){
		$index = $_GET['offset']?$_GET['offset']:1;
		$listRows = 20;
		$offset = $listRows * ($index - 1);
		
		$where = array();
		$type = $_GET['type'];
		if($type == "new"){
			$order = array("id"=>"desc");
		}
		else
		if($type == "hot"){
			$order = array("like_count"=>"desc");
		}
		else
		if($type == "my"){
			$order = array("id"=>"desc");
			$where['openid'] = $openid = $this->session->userdata($this->session_name);
		}		
		
		
		$list = $this->Mtarget_users->get_lists("*",$where,$order,$listRows,$offset);
		$this->return_json($list);
		
	}

}
?>

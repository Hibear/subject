<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Goldegg extends MY_Controller{
    private $app;
    private $AppID; //应用ID
    private $AppSecret; //应用密匙
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
                'Model_active' => 'Mactive',
                'Model_active_prize' => 'Mactive_prize'
        ));
        //分享用的
        $this->app = C("appid_secret.dashi");
        //艾客逊公众号，用户网页授权
        $this->AppID = C('appid_secret.akx.app_id');
        $this->AppSecret = C('appid_secret.akx.app_secret');
        $this->load->driver('cache');
    }
    
    public function index(){
        $data = $this->data;
        $id = (int) $this->input->get('active_id');
        //根据id获取本次砸金蛋的数据
        $info = $this->Mactive->get_one('*', ['id' => $id, 'is_del' => 0]);
        if($info){
            $data['info'] = $info;
            //查询本次砸金蛋的奖项
            $prize = $this->Mactive_prize->get_lists('*', ['active_id' => $id]);
        }
        $this->load->view('goldegg/index', $data);
    }
    
}
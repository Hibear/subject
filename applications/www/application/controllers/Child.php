<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Child extends MY_Controller{
    private $app;
    public function __construct(){
        parent::__construct();
        //分享用的
        $this->app = C("appid_secret.dashi");
    }
    
    public function index(){
        $data = $this->data;
        //分享
        $data['title'] = "试试能拿多少分！--您学到的有多少已还给老师？";
        $data['link'] = C("domain.www.url")."/child";
        $data['imgUrl'] = C("domain.statics.url").'/h5/images/child/child_share.jpg';
        $data['desc'] = "六一节小测试";
        
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
        $this->load->view('child/index', $data);
    }
    
    
    private function check_login(){
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            $this->session->set_userdata('login_back_url', '/child/index');
            redirect(C('domain.h5.url').'/weixin_active_login/login');
            exit;
        }
    }
    
}
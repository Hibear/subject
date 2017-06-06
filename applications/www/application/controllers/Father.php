<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Father extends MY_Controller{
    
    private $app;
    public function __construct(){
        parent::__construct();
        //分享用的
        $this->app = C("appid_secret.dashi");
    }
    
    public function index(){
        $data = $this->data;
        //分享
        $data['title'] = "父亲节-为爸爸的超能力致敬！";
        $data['link'] = C("domain.www.url")."/father/index";
        $data['imgUrl'] = C("domain.statics.url").'/h5/images/father/share_img.png';
        $data['desc'] = "";
        
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
        $this->load->view('father/index', $data);
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
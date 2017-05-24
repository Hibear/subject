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
        $this->check_login();
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
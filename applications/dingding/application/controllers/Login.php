<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * desc:后台登陆
 * yonghua
 */

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model([
            'Model_admins' => 'Madmins',
            'Model_admins_group' => 'Madmins_group',
            'Model_admins_purview' => 'Madmins_purview',
            'Model_login_log' => 'Mlogin_log',
            'Model_configes' => 'Mconfiges'
         ]);

        $this->load->library('auth_ding', C('ding'));
        $this->load->library('session');
      }

    public function index() {
        $data['domain'] = C('domain');
        //判断是否是手机端访问
        if(ismobile()){
            exit('<h1 style="text-align:center;">请使用钉钉pc端访问！</h1>');
        }
        if(isset($_SESSION['USER'])&& $_SESSION['USER']){
            header('location:' . C('domain.ding.url'));exit;
        }
        $data['config'] = (array) json_decode($this->auth_ding->get_config());
        $this->load->view("login", $data);
    }
    


    /*
     * 登录验证
     * yonghua
     */
    public function login(){
        $code =  $this->input->post('code');
        $name = $this->input->post('name');
        $headimg = $this->input->post('headimg');
        $access_token = $this->auth_ding->get_access_token();
        //获取用户信息
        $user_info = (array) json_decode($this->auth_ding->get_user_info($access_token, $code));
        if($user_info && $user_info['errcode'] == 0){
            if($user_info['is_sys']){
                $user['userid'] = $user_info['userid'];
                $user['name'] = $name;
                $user['headimg'] =$headimg;
                $user['id'] = 1;
                $this->session->set_userdata(array("USER"=>$user));
                $this->return_json(['code' => 1, 'msg' => '登陆成功']);
            }else{
                $this->return_json(['code' => 0, 'msg' => '未允许的用户']);
            }
        }else{
            $this->return_json(['code' => 0, 'msg' => '获取信息失败']);
        }
    }
    
    

    /**
     * 转化为json字符串
     * @author 1034487709@qq.com
     * @param unknown $arr
     * @ruturn return_type
     */
    public function return_json($arr) {
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: X-Requested-With');
        header('Content-Type: application/json');
        header('Cache-Control: no-cache');
        echo json_encode($arr);exit;
    }

    /*
     * 退出
     * 1034487709@qq.com
     */
    public function out(){
        session_start();
        session_destroy();
        tp_redirect('/login');
    }

}














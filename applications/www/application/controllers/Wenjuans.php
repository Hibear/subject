<?php
/**
 * 问卷调查
 * @author 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Wenjuans extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
             'Model_wenjuan' => 'Mwenjuan'
        ));
    }
    
    public function index(){
        $data = $this->data;
        $this->check_login();
        $this->load->view('wenjuans/index', $data);
    }
    
    public function add(){
        $post = $this->input->post();
        $this->check_login();
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            $this->return_json(['code' => 0, 'msg' => '请先登陆']);
        }
        
        if(!$post['zutuan']){
            $this->return_json(['code' => 0, 'msg' => '请填写组团名称']);
        }
        $add['zutuan'] = $post['zutuan'];
        unset($post['zutuan']);
        
        if(!$post['age']){
            $this->return_json(['code' => 0, 'msg' => '选择年龄']);
        }
        $add['age'] = $post['age'];
        unset($post['age']);
        
        if(!$post['hobby']['class']){
            $this->return_json(['code' => 0, 'msg' => '选择兴趣类型']);
        }
        $add['class'] = json_encode($post['hobby']['class']);
        unset($post['hobby']['class']);
        
        if(!isset($post['sex'])){
            $this->return_json(['code' => 0, 'msg' => '选择性别']);
        }
        $add['sex'] = (int) $post['sex'];
        unset($post['sex']);
        
        if(!$post['yj']){
            $this->return_json(['code' => 0, 'msg' => '填写意见']);
        }
        $add['yj'] = $post['yj'];
        unset($post['yj']);
        
        $add['openid'] = $user_info['openid'];//$user_info['openid'];
        $add['create_time'] = date('Y-m-d');
        $add['info'] = json_encode($post);
        
        unset($post);
        $ret = $this->Mwenjuan->count(['openid' => $user_info['openid']]);
        if($ret){
            $this->return_json(['code' => 0, 'msg' => '您已经提交过了，只能提交一次哦！']);
        }
        $res = $this->Mwenjuan->create($add);
        if(!$res){
            $this->return_json(['code' => 0, 'msg' => '提交失败']);
        }else{
            $this->return_json(['code' => 0, 'msg' => '提交成功']);
        }
        
    }
    

    private function check_login($id = 0){
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            $this->session->set_userdata('login_back_url', '/wenjuans/index');
            redirect(C('domain.h5.url').'/weixin_login/login');
            exit;
        }
    }
}
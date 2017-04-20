<?php
/**
 * 问卷调查
 * @author 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Wenjuan extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
             'Model_wenjuan' => 'Mwenjuan'
        ));
    }
    
    public function index(){
        $data = $this->data;
        $this->load->view('wenjuan/index', $data);
    }
    
    public function add(){
        $post = $this->input->post();
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            exit;
        }
        $add['openid'] = 1;//$user_info['openid'];
        $add['create_time'] = date('Y-m-d');
        $add['info'] = json_encode($post);
        
        if(!$post['zt']){
            $this->return_json(['code' => 0, 'msg' => '请填写组团名称']);
        }
        unset($post);
        $res = $this->Mwenjuan->create($add);
        if(!$res){
            $this->return_json(['code' => 0, 'msg' => '提交失败']);
        }else{
            $this->return_json(['code' => 0, 'msg' => '提交成功']);
        }
        
    }
}
<?php
/**
 * renzheng
 * @author 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Renzheng extends MY_Controller{

    private $openid = '';
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
             'Model_game_user' => 'Mgame_user'
        ));
        $user_info = $this->session->userdata('user_info');
        if($user_info){
            $this->openid = $user_info['openid'];
        }
    }
    
    
    /**
     * 认证用户
     * 认证完成后，可以获得+10积分
     */
    public function index(){
    
        if(IS_POST){
            $openid = $this->openid;
            $realname = trim($this->input->post('realname'));
            if(!$realname){
                $this->return_json(['code' => 0, 'msg' => '姓名不能为空！']);
            }
            $tel = trim($this->input->post('tel'));
            if(!$tel){
                $this->return_json(['code' => 0, 'msg' => '手机号不能为空！']);
            }
            if(!preg_match(C('regular_expression.mobile'), $tel)){
                $this->return_json(['code' => 0, 'msg' => '手机号格式不正确！']);
            }
            //判断手机号是否已经被使用
            $info = $this->Mgame_user->count(['tel' => $tel]);
            if($info == 1){
                $this->return_json(['code' => 0, 'msg' => '手机号已经被注册过了！']);
            }
            $up = [
                'realname' => $realname,
                'tel' => $tel,
                'addr' => '',
                'status' => 1,
                'incr' => [
                    '`score`' => 10
                ]
            ];
            $res = $this->Mgame_user->update_info($up, ['openid' => $openid, 'status' => 0]);
            if(!$res){
                $this->return_json(['code' => 0, 'msg' => '请重试！']);
            }
            $this->return_json(['code' => 1, 'msg' => '认证成功']);
        }else{
            $data = $this->data;
            if(!$this->openid){
                show_404();exit;
            }
            $res = $this->Mgame_user->get_one('status', ['openid' => $this->openid]);
            if($res['status'] == 1){
                show_404();exit;
            }
            //获取回调地址
            $data['back_url'] = $this->session->userdata('renzheng_back_url');
            $this->load->view('common/renzheng', $data);
        }
    }
}
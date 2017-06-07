<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Father extends MY_Controller{
    
    private $app;
    public function __construct(){
        parent::__construct();
        //分享用的
        $this->app = C("appid_secret.dashi");
        $this->load->model([
            'Model_say_to_father' => 'Msay_to_father',
            'Model_game_user' => 'Mgame_user',
            'Model_say_log' => 'Msay_log'
        ]);
    }
    
    public function index(){
        $data = $this->data;
        //微信登陆 
        $this->check_login();
        
        $user_info = $this->session->userdata('user_info');
        $data['r_status'] = 0;
        if($user_info){
            //判断当前用户是否已经验证
            $data['r_status'] = (int) $this->Mgame_user->get_one('status', ['openid' => $user_info['openid']])['status'];
        }
        //生成token
        $token = $this->createNonceStr();
        $data['f_csrf'] = $token;
        $this->session->set_userdata('_f_csrf', $token);
        //查询点赞数前十的数据
        $list = $this->Msay_to_father->get_lists('id, openid, msg, zan_num', ['is_del' => 0], ['zan_num' => 'desc', 'create_time' => 'desc'], $limit = 4);
        $data['list'] = $list;
        if($list){
            //提取所有openid
            $openids = array_column($list, 'openid');
            //查询微信用户信息
            $weixin = $this->Mgame_user->get_lists('openid, nickname, head_img', ['in' => ['openid' => $openids]]);
            if($weixin){
                foreach ($list as $k => $v){
                    $data['list'][$k]['nickname'] = '';
                    $data['list'][$k]['head_img'] = '';
                    foreach ($weixin as $key => $val){
                        if($v['openid'] == $val['openid']){
                            $data['list'][$k]['nickname'] = $val['nickname'];
                            $data['list'][$k]['head_img'] = $val['head_img'];
                            break;
                        }
                    }
                }
            }
        }
        
        
        //分享
        $data['title'] = "父亲节-为爸爸的超能力致敬！";
        $data['link'] = C("domain.www.url")."/father/index";
        $data['imgUrl'] = C("domain.statics.url").'/h5/images/father/share_img.png';
        $data['desc'] = "";
        
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
        $this->load->view('father/index', $data);
    }
    
    /**
     * 留言
     */
    public function say(){
        $url = C('domain.h5.url');
        header( "Access-Control-Allow-Origin: {$url}");
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            $this->return_json(['code' => 0, 'msg' => '请先登陆！']);
        }
        if(IS_POST){
            
            $f_yzm = trim($this->input->post('f_yzm'));
            if(!f_yzm){
                $this->return_json(['code' => 0, 'msg' => '验证码不能为空']);
            }
            //判断验证码是否正确
            if($f_yzm != $_SESSION['f_yzm']){
                $this->return_json(['code' => 0, 'msg' => '验证码错误']);
            }
            
            $r_status = $this->Mgame_user->get_one('status', ['openid' => $user_info['openid']])['status'];
            if(!$r_status){
                //添加用户信息
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
                $res = $this->Mgame_user->update_info($up, ['openid' => $user_info['openid'], 'status' => 0]);
                if(!$res){
                    $this->return_json(['code' => 0, 'msg' => '请重试！']);
                }
            }
            
            $msg = trim($this->input->post('msg'));
            if(!$msg){
                $this->return_json(['code' => 0, 'msg' => '留言不能为空']);
            }
            $csrf = trim($this->input->post('_f_csrf'));
            if($csrf){
                $_csrf = $this->session->userdata('_f_csrf');
                if($csrf == $_csrf){
                    $ip = get_client_ip();
                    //判断留言是否重复
                    $count = $this->Msay_to_father->count(['msg' => $msg]);
                    if($count){
                        $this->return_json(['code' => 0, 'msg' => "您的留言内容已经被人抢先发表啦！"]);
                    }
                    $time = date('Y-m-d H:i:s');
                    $add = [
                        'openid' => $user_info['openid'],
                        'msg' => $msg,
                        'ip' => $ip,
                        'create_time' => $time
                    ];
                    $res = $this->Msay_to_father->create($add);
                    if(!$res){
                        $this->return_json(['code' => 0, 'msg' => '留言失败，请重试']);
                    }
                    $this->return_json(['code' => 1, 'msg' => '留言成功', 'time' => $time]);
                }else{
                    $this->return_json(['code' => 0, 'msg' => '请重新刷新当前页面']);
                }
            }
        }
        $this->return_json(['code' => 0, 'msg' => '未知错误']);
    }
    
    public function zan(){
        $url = C('domain.h5.url');
        header( "Access-Control-Allow-Origin: {$url}");
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            $this->return_json(['code' => 0, 'msg' => '请先登陆！']);
        }
        //获取将要点赞的id
        $id = (int) $this->input->get('p_id');
        if(!$id){
            $this->return_json(['code' => 0, 'msg' => '无效的参数']);
        }
        //判断是否已经点赞过了
        $count = $this->Msay_log->count(['p_id' => $id, 'openid' => $user_info['openid']]);
        if($count){
            $this->return_json(['code' => 0, 'msg' => '您已经点赞过了！']);
        }
        
        $res = $this->Msay_to_father->update_info(['incr' => ['zan_num' => 1]], ['id' => $id]);
        if(!$res){
            $this->return_json(['code' => 0, 'msg' => '请重试！']);
        }
        //添加点赞记录
        $log = [
            'p_id' => $id,
            'openid' => $user_info['openid'],
            'create_time' => date('Y-m-d H:i:s')
        ];
        $this->Msay_log->create($log);
        $this->return_json(['code' => 1, 'msg' => '点赞成功']);
    }
    
    
    private function check_login(){
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            $this->session->set_userdata('login_back_url', '/father/index');
            redirect(C('domain.h5.url').'/weixin_active_login/login');
            exit;
        }
    }
    
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    
    public function code(){
        $this->load->library('valicode');
        $this->valicode->outImg('f_yzm');
    }
    
}
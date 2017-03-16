<?php 
/**
 * 自媒用户登录、注册、密码找回控制器
 * 
 * @author jialin@gz-zc.cn
 */
defined('BASEPATH') or exit('No direct script access allowed');    
class Passport extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model([
                'Model_user' => 'Muser',
                'Model_user_extend' => 'Muser_extend',
	            'Model_tel_verify' => 'Mverify'
        ]);
        
        $this->data['action']= '';
        
    }
    
    /**
     * 首页
     * 
     * @author jialin@gz-zc.cn
     */
    public function index(){
         show_404();
    }
    
    /**
     * 登录
     * 
     * @author jialin@gz-zc.cn
     */
    public function login(){
        $this->set_token();
        $data = $this->data;
        $data['back_url'] = '';
        $data['back_url'] = $this->input->get('back_url', TRUE);
        if (isset($_SERVER['HTTP_REFERER'])){
            $data['back_url'] =  $_SERVER['HTTP_REFERER'];
        }
        
        
        $this->load->view("passport/login", $data);
    }
    
    /**
     * 注册
     * 
     * @author jialin@gz-zc.cn
     */
    public function register(){
        $this->set_token();
        
        $data = $this->data;
        
        $this->load->view("passport/reg", $data);
    }
    
    
    /**
     * 找回密码
     * 
     * @author jialin@gz-zc.cn
     */
    public function findpass(){
        $this->set_token();
        $data = $this->data;
        
        
        $this->load->view("passport/pwrecovery", $data);
    }
    
    
    /**
     * 退出
     * 
     * @author jialin@gz-zc.cn
     */
    public function logout(){
        $this->session->unset_userdata('font_user');
        $this->input->set_cookie('font_user', null,  time()+C('site_config.cookie_expire'), C('site_config.root_domain'), '/',  '', FALSE, TRUE);
        $url = '/';
        if($_SERVER['HTTP_REFERER'])
        {
            $url = $_SERVER['HTTP_REFERER'];
        }
        redirect($url);
    }
    
    
    /**
     * 登录处理
     *
     * @return multitype:string
     */
    public function check_login(){
        $return_arr = array('msg' => '登录成功', 'status' =>0);
        $mobile = (int)$this->input->post('mobile');
        $auto_login = (int)$this->input->post('auto_login');
        $password = trim(strip_tags($this->input->post('password', TRUE)));
        
        if(! $this->check_token($this->input->get_post('token', TRUE)))
        {
            $return_arr['msg'] = '参数错误！';
            $return_arr['status'] =-1;
            $this->return_json($return_arr);
        }
        
        if(! preg_match(C('regular_expression.mobile'), $mobile))
        {
            $return_arr['msg'] = '手机号格式不对！';
            $return_arr['status'] =-1;
            $this->return_json($return_arr);
        }
         
        if(empty($password))
        {
            $return_arr['msg'] = '密码不能为空！';
            $return_arr['status'] =-1;
            $this->return_json($return_arr);
        }
         
        $login_info = $this->http_request('user/login', array('mobile' => $mobile, 'password' => $password));
        if(isset($login_info['status']))
        {
            $login_info = $login_info['data'];
        }
        else
        {
            $return_arr['msg'] = '网络错误！';
            $return_arr['status'] =-1;
            $this->return_json($return_arr);
        }
         
        if($login_info['code'] != 1)
        {
            if ($login_info['code'] == 5)
            {
                $return_arr['msg'] = '该用户已经被禁止登录！';
                $return_arr['status'] =-1;
                $this->return_json($return_arr);
            }
            else
            {
                $return_arr['msg'] = '手机号或密码错误！';
                $return_arr['status'] =-1;
                $this->return_json($return_arr);
            }
    
        }
        else
        {
           
            $back_url = $this->input->post('back_url', TRUE);
            
            $user_info = $login_info['user_data'];
            unset($user_info['password']);
            $encode_user_info = $this->encrypt->encode(encrypt($user_info));
            $this->session->set_userdata(array('font_user'  => $encode_user_info));

            //自动登录
            if($auto_login)
            {    
                $this->input->set_cookie('font_user', $encode_user_info,  time()+C('site_config.cookie_expire'), C('site_config.root_domain'), '/',  '', FALSE, TRUE);
            }
            
            if (strpos($back_url, C('site_config.root_domain')) !== false)
            {
                //个人中心的跳转到中心首页
                $pos = strpos($back_url, 'usercenter');
                if ($pos !== false )
                {
                    $back_url =  substr($back_url, 0, $pos+10);
                }
                $return_arr['back_url'] = urldecode($back_url);
            }
            else
            {
               $return_arr['back_url'] = $this->data['domain']['base']['url'];
            }
            
            $this->return_json($return_arr);
        }
    }
       
    
    /**
     * 注册处理
     *
     * @return multitype:string
     */
    public  function check_reg(){
        $time = date('Y-m-d H:i:s' ,time());
        $return_arr = array('msg' => '注册成功', 'status' =>0);
        $data = array();
        $data['mobile'] = (int)$this->input->post('mobile', TRUE);
        $data['tel_verify'] = addslashes(strip_tags($this->input->post('verify', TRUE)));
        $data['password'] = addslashes(strip_tags($this->input->post('password', TRUE)));
        $data['repassword'] = addslashes(strip_tags($this->input->post('repassword', TRUE)));
        
        if(! $this->check_token($this->input->get_post('token')))
        {
            $return_arr['msg'] = '参数错误！';
            $return_arr['status'] =-1;
            $this->return_json($return_arr);
        }
        
        $check_info = $this->http_request('user/reg', ['data' => $data]);
        if(isset($check_info['status']))
        {
            $check_info = $check_info['data'];
        }
        else
        {
            $return_arr['msg'] = '信息验证失败，请重试！';
            $return_arr['status'] = -1;
            $this->return_json($return_arr);
        }
         
        if($check_info['code'] != 1)
        {
            $return_arr['msg'] = $check_info['msg'];
            $return_arr['status'] = -1;
            $this->return_json($return_arr);
        }
        else
        {
            $login_password =   $data['password'];
            
            $data['phone_number']	= $data['mobile'];
            $data['password']	= get_encode_pwd($data['password']);
            $data['create_time']	= $time;
            $data['update_time']	= $time;
            
            unset($data['tel_verify'], $data['mobile'], $data['repassword']);
            $user_id = $this->http_request('user/add', ['data' => $data]);
            if(isset($user_id['status']) && $user_id['status'] == C('status.success.value'))
            {
                $user_id = $user_id['data'];
            }
            else
            {
                $return_arr['msg'] = '注册失败，请重试！';
                $return_arr['status'] = -1;
                $this->return_json($return_arr);
            }
            if (!$user_id)
            {
                $return_arr['msg'] = '注册失败，请重试！';
                $return_arr['status'] = -1;
                $this->return_json($return_arr);
            }
             
            //添加用户扩展表中信息
            $user_extend_info = $this->http_request('userextend/info', ['phone_number' => $data['phone_number']]);
            if(isset($user_extend_info['status']))
            {
                $extend_info = $user_extend_info['data'];
            }
             
            if(! $extend_info)
            {
                $user_extend = array(
                                'user_id'  =>  $user_id,
                                'phone_number' => $data['phone_number'],
                                'create_time' =>$time,
                                'update_time' =>$time
                );
                $info = $this->http_request('userextend/add_user_extend', ['data' => $user_extend], TRUE);
                 
            }

            //写入站内消息表
            $this->http_request('message/add', ['data' => array('title' => C('message.reg.title'), 'content' => C('message.reg.content'), 'receiver' => $user_id)]);
            
            $return_arr['url'] = $this->data['domain']['base']['url'] . C('user_center.url.login');
            $this->return_json($return_arr);

            //自动登录
            $login_info = $this->http_request('user/login', ['mobile' => $data['phone_number'], 'password' => $login_password]);
            if(isset($login_info['status']))
            {  
                $user_info = $login_info['data'];
                unset($user_info['user_data']['password']);
                $this->session->set_userdata(array('font_user'  => encrypt($user_info['user_data'])));
                
            }
            else
            {
                $return_arr['msg'] = '网络错误，自动登录失败！';
                $return_arr['status'] = -1;
                $this->return_json($return_arr);
            }
     
            if($user_info['code'] == 1)
            {
                $return_arr['url'] = $this->data['domain']['base']['url'] . C('user_center.url.user_center');
                $this->return_json($return_arr);
            }
            else
            {
                $return_arr['url'] = $this->data['domain']['base']['url'] . C('user_center.url.login');
                $this->return_json($return_arr);
            }
            
        }
    }
    
    /**
     * 密码重置处理
     */
    public function check_find(){
        $mobile = $this->input->post('mobile');
        $token = $this->input->post('token');
        $code = $this->input->post('verify');
        $passwd = addslashes(strip_tags($this->input->post('password', TRUE)));
        $repasswd = addslashes(strip_tags($this->input->post('repassword', TRUE)));
        if(!$this->check_token($token))
        {
            $this->return_failed('非法请求');
        }
    
        if(empty($mobile))
        {
            $this->return_failed('手机号不能为空');
        }
        if(empty($code))
        {
            $this->return_failed('手机验证码不能为空');
        }
        if(empty($passwd) || empty($repasswd))
        {
            $this->return_failed('密码或确认密码不能为空');
        }
        if($passwd != $repasswd)
        {
            $this->return_failed('两次密码输入不一致');
        }
        $verify_code = $this->Mverify->get_one(array('code,add_time'), array('phone_number' => $mobile));
        $sms_config = C('sms.sms_config_huaxing');
        if(isset($verify_code['code']))
        {
            if ((time() - $verify_code['add_time']) > $sms_config['nvalidation_time'])
            {
                $this->return_failed('手机验证码过期！');
            }
            if ($verify_code['code'] != $code)
            {
                $this->return_failed('手机验证码错误！');
            }
             
        }
        else
        {
            $this->return_failed('手机验证码错误！');
        }
        
    
        $data['password'] = get_encode_pwd($passwd);
        $result = $this->Muser->update_info($data, array('phone_number' => $mobile));
    
        if($result)
        {
            $this->return_success();
        }
        else
        {
            $this->return_failed();
        }
    
    }
    
}
?>

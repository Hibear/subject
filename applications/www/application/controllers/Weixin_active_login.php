<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Weixin_active_login extends MY_Controller
{
    private $AppID; //应用ID
    private $AppSecret; //应用密匙

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Model_game_user' => 'Mgame_user'
        ));
        //艾客逊公众号，用户网页授权
        $this->AppID = C('appid_secret.sdzh.app_id');
        $this->AppSecret = C('appid_secret.sdzh.app_secret');
        $this->load->driver('cache');
        $param = array(
            'app_id' => $this->AppID,
            'app_secret' => $this->AppSecret,
            'per' => 'sdzh_'    //缓存前缀
        );
        $this->load->library('jssdk', $param);
    }

    public function login()
    {
        if ($this->check_login()) {
            //已经登录后不再拉取网页授权
            $function = $this->session->userdata('login_back_url');
            if($function){
                $back_url = C('domain.h5.url') .$function;
                redirect($back_url);
                exit;
            }else{
                show_404();
            }
            
        }
        $data = $this->data;
        $redirect_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->AppID;
        $redirect_url .= '&redirect_uri=' . urlencode($this->data['domain']['www']['url'] . '/weixin_login/get_access_token');
        $redirect_url .= "&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header('location:' . $redirect_url);
        exit;
    }


    /**
     * 2 setup 非静默授权
     * 通过code换取网页授权获取access_token、openid
     */
    public function get_access_token()
    {
        if ($this->check_login()) {
            //已经登录后不再拉取网页授权
            $function = $this->session->userdata('login_back_url');
            if($function){
                $back_url = C('domain.h5.url') .$function;
                redirect($back_url);
                exit;
            }else{
                show_404();
            }
        }
        $code = $this->input->get('code');
        if (empty($code)) {
            $this->return_failed('获取code失败！');
        }
        $openid_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->AppID}&secret={$this->AppSecret}&code={$code}&grant_type=authorization_code";
        $openid_ch = curl_init();
        curl_setopt($openid_ch, CURLOPT_URL, $openid_url);
        curl_setopt($openid_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($openid_ch, CURLOPT_SSL_VERIFYPEER, 0);
        $openid_data = curl_exec($openid_ch);
        curl_close($openid_ch);
        $openid_arr = json_decode($openid_data, true);
        //如果拉取不到用户openid信息
        if (!isset($openid_arr['openid'])) {
            $this->return_failed('获取openid信息失败！');
        }
        $openid = $openid_arr['openid'];
        $access_token = $openid_arr['access_token'];
        $refresh_token = $openid_arr['refresh_token'];
        //判断access_token是否过期
        $check_access_token_url = "https://api.weixin.qq.com/sns/auth?access_token={$access_token}&openid={$openid} ";
        $check_data = json_decode($this->httpGet($check_access_token_url), true);
        if (isset($check_data['errcode']) && $check_data['errcode'] == 0) {
            //没有过期
            $res = array(
                'openid' => $openid,
                'access_token' => $access_token
            );
        } else {
            $refresh = $this->refresh_token($refresh_token);
            $res = array(
                'openid' => $refresh['openid'],
                'access_token' => $refresh['access_token']
            );
        }
        $user_info = $this->get_weixin_user_info($res);
        
        $ret = $this->session->has_userdata('login_back_url');
        if($ret){
            $this->add_user($user_info);
            $function = $this->session->userdata('login_back_url');
            $back_url = C('domain.h5.url') .$function;
            redirect($back_url);
            exit;
        }else{
            show_404();
        }
    }

    /**
     * 3 setup 非静默授权
     * 获取用户信息
     * @param [openid access_token] $res
     * @return mixed
     */
    private function get_weixin_user_info($res)
    {
        if (!$res) {
            $this->return_failed('获取授权信息失败！');
        }
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $res['access_token'] . '&openid=' . $res['openid'] . '&lang=zh_CN';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }

    /**
     * 刷新access_token
     * @param unknown $refresh_token
     */
    private function refresh_token($refresh_token)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$this->AppID}&grant_type=refresh_token&refresh_token={$refresh_token}";
        $refresh_data = json_decode($this->httpGet($url), true);
        return $refresh_data;
    }

    
    private function getAccessToken() {
        $this->load->driver('cache');
        if(!$this->cache->file->get('access_token')){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".C('appid_secret.sdzh.app_id')."&secret=".C('appid_secret.sdzh.app_secret');
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $this->cache->file->save('sdzh_access_token', $access_token, 7000);
                return $access_token;
            }
        }else{
            return $this->cache->file->get('sdzh_access_token');
        }  
    }

    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
    
    //检查登录
    private function check_login()
    {
    
        $user_info = $this->session->userdata('user_info');
        if ($user_info) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * 添加用户到数据库
     * @param unknown $user_info
     */
    private function add_user($user_info){
        if(!empty($user_info)){
            //查找open_id 是否绑定本平台账户，若绑定则使用平台账户登录
            $user = $this->Mgame_user->get_one('*', array('openid' => $user_info['openid']));
            if($user){
                //将用户信息保存到会话
                $this->session->set_userdata('user_info', $user);
            }else{
                $add['openid'] = $user_info['openid'];
                $add['nickname'] = $user_info['nickname'];
                $add['head_img'] = $user_info['headimgurl'];
                $add['create_time'] = date('Y-m-d H:i:s');
                $this->Mgame_user->create($add);
                //将用户信息保存到会话
                $this->session->set_userdata('user_info', $add);
            }
        }else{
            $this->return_failed('获取信息失败，请重试！');
        }
    }
}


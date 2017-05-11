<?php 

/**
 * 钉钉先关接口
 * 
 * @author yonghua 
 *
 */
class Auth_ding{
    
    private $config = array();
    private $_token = array();
    /**
     * 
     * @param array $config
     * 
     */
    public function __construct($config){
        $CI =& get_instance();
        $this->config = $config;
        $CI->load->model([
            'Model_ding_token' => 'Mding_token'
        ]);
        $this->get_ding_token();
    }
    
    //获取数据库的token
    private function get_ding_token(){
        $CI =& get_instance();
        $this->_token = $CI->Mding_token->get_one('*', ['id' => 1]);
    }
    
    /**
     * 获取配置信息json对象
     * 
     * @return string
     */
    public  function get_config(){
        $nonce = $this->createNonceStr();
        $time_stamp = time();
        $url = $this->cur_page_url();
        $corp_access_token = $this->get_access_token();
        if (!$corp_access_token)
        {
            die("[getConfig] ERR: no corp access token");
        }
        $ticket = $this->get_ticket($corp_access_token);
        $signature = $this->sign($ticket, $nonce, $time_stamp, $url);
        $config = array(
                        'url' => $url,
                        'nonce' => $nonce,
                        'agentid' => $this->config['agentid'],
                        'timestamp' => $time_stamp,
                        'corpid' => $this->config['corpid'],
                        'signature' => $signature
        );
        return json_encode($config, JSON_UNESCAPED_SLASHES);
    }
    
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    
    /**
     * 获取 access_token
     * 
     * @return unknown
     */
    public  function  get_access_token(){
    
        $_token = $this->_token;
        if($_token){
            if(isset($_token['access_token']) && $_token['access_token'] && $_token['a_expire']){
                if(time() < $_token['a_expire']){
                    return $_token['access_token'];
                }
            }
        }
        $CI =& get_instance();
        //accessToken有效期为两小时，建议缓存accessToken。需要在失效前请求新的accessToken
        $url = $this->oapi_url('/gettoken');
        $access_token = '';
        $response = Http::Request($url, array('corpid' => $this->config['corpid'], 'corpsecret' => $this->config['corpsecret']));
        $response = json_decode($response);
        
        if($this->check($response)){
            $access_token = $response->access_token;
            //如果数据库的access_token过期则更新
            if($access_token != $_token['access_token']){
                $CI->Mding_token->update_info(['access_token' => $access_token, 'a_expire' => time()+7000], ['id' => 1]);
            }
        }
        
        return $access_token;
    }
    
    /**
     * 获取jsticket
     * 
     * @param string $access_token
     * @return string $jsticket
     */
    public  function get_ticket($access_token){
        $_token = $this->_token;
        if($_token){
            if(isset($_token['ticket']) && $_token['ticket'] && $_token['t_expire']){
                if(time() < $_token['t_expire']){
                    return $_token['ticket'];
                }
            }
        }
        $CI =& get_instance();
        $jsticket = '';
        $url = $this->oapi_url('/get_jsapi_ticket');
        $response =  Http::Request($url, array('type' => 'jsapi', 'access_token' => $access_token));
        $response = json_decode($response);
        if($this->check($response)){
            $jsticket = $response->ticket;
            //如果数据库的ticket过期则更新
            if($jsticket != $_token['ticket']){
                $CI->Mding_token->update_info(['ticket' => $jsticket, 't_expire' => time()+7000], ['id' => 1]);
            }
        }
        return $jsticket;
    }
    
    /**
     * 获取用户信息
     * 
     * @param string $access_token
     * @param string $code
     * @return string
     */
    public   function get_user_info($access_token, $code){
        $url = $this->oapi_url('/user/getuserinfo');
        $user_info = '';
        $response = Http::Request($url, array("access_token" => $access_token, "code" => $code));
        if($this->check(json_decode($response))){
           $user_info = json_decode($response, TRUE);
           $user_info['url'] = $url;
           $user_info = json_encode($user_info, JSON_UNESCAPED_SLASHES);
        }
        return $user_info;
    }
    
    //获取特殊的accesstoken,便于获取管理员信息
    public function get_SsoToken(){
        $url = $this->oapi_url('/sso/gettoken');
        $access_token = '';
        $response = Http::Request($url, array('corpid' => $this->config['corpid'], 'corpsecret' => $this->config['ssosecret']));
        $response = (array) json_decode($response);
        if(isset($response['errcode']) && $response['errcode'] == 0){
            $access_token = $response['access_token'];
        }
        
        return $access_token;
    }
    
    //获取当前管理员的信息
    public function getManagerInfo($access_token, $code){
        $url = $this->oapi_url('/sso/getuserinfo');
        $manager = '';
        $response = Http::Request($url, array('access_token' => $access_token, 'code' => $code));
        $response = (array) json_decode($response);
        return $response;
        if(isset($response['errcode']) && $response['errcode'] == 0){
            $manager = $response;
        }
        
        return $manager;
    }
    
    /**
     * 获取用户企业内更详细信息
     * 
     * @param string $access_token
     * @param string $code
     * @return string
     */
    public   function get_user_details($access_token, $userid){
        $url = $this->oapi_url('/user/get');
        $user_details = '';
        $response = Http::Request($url, array("access_token" => $access_token, "userid" => $userid));
        if($this->check(json_decode($response))){
           $user_details = json_decode($response, TRUE);
           $user_details['url'] = $url;
           $user_details = json_encode($user_details, JSON_UNESCAPED_SLASHES);
        }
        return $user_details;
    }
    
    /**
     * 获取sns token
     * 
     * @param unknown $access_token
     * @return Ambigous <string, unknown>
     */
    public function get_sns_token($access_token){
        $url = $this->oapi_url('/sns/get_sns_token');
        $response = Http::Request($url, array("access_token" => $access_token));
        $sns_token = '';
        $response = Http::Request($url, array("access_token" => $access_token, "code" => $code));
        if($this->check(json_decode($response))){
            $sns_token = $response;
            
        }
        return $sns_token;
    }
    
    
    /**
     * 获取当前页面链接
     * 
     * @return string
     */
    public   function cur_page_url(){
        $page_url = 'http';
        if (array_key_exists('HTTPS',$_SERVER)&&$_SERVER["HTTPS"] == "on")
        {
            $page_url .= "s";
        }
        $page_url .= "://";
        if ($_SERVER["SERVER_PORT"] != "80")
        {
            $page_url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        }
        else
        {
            $page_url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $page_url;
    }
    
    /**
     * 获取签名数据
     * 
     * @param string $ticket
     * @param string $nonceStr
     * @param string $timeStamp
     * @param string $url
     * @return string
     */
    public  function sign($ticket, $nonceStr, $timeStamp, $url){
        $plain = 'jsapi_ticket=' . $ticket .
        '&noncestr=' . $nonceStr .
        '&timestamp=' . $timeStamp .
        '&url=' . $url;
        
        return sha1($plain);
    }
    
    /**
     * 验证返回结果
     * 
     * @param mixed $res
     */
    public  function check($res){
        if ($res->errcode != 0)
        {
             return  FASLE;
        }
        else
        {
            return TRUE;
        }
    }
    
    /**
     * 组装钉钉open api 地址
     * 
     * @param string $uri
     * @return string
     */
    private function oapi_url($uri = ''){
        
        return  $this->config['oapihost'].$uri;
    }
    
    
} 

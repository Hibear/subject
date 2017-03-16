<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $data = array();
    public function __construct() {
        parent::__construct();
      

       $_GET = xss_clean($_GET);
       $_POST = xss_clean($_POST);

        $this->data['domain'] = C('domain');
        $this->data['c_modle'] = $this->uri->segment(1);

       
        $this->load->library('session');
        $this->load->library('encrypt');
  
    }
	
	
	/**
	  *自定义分享
	**/
	public function share($appid,$appsecret,$url=""){
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$data = array(
			"appid"=>$appid,
			"appsecret"=>$appsecret,
			"url"=>$url
		);
		$request_url= "http://123.57.238.232:8090/index.php?m=Share&a=index";
	    return json_decode(Http::Request($request_url,$data,"POST"),true);

	}
	

    /**
     * 转化为json字符串
     * @author yuanxiaolin@global28.com
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

     /**
      * 请求成功返回
      * @author yuanxiaolin@global28.com
      * @param unknown $data
      * @param string $msg
      * @ruturn return_type
      */
    public function return_success($data = array(),$msg = 'request is ok') {

        $this->return_json(
                array(
                    'status'=> C('status.success.value'),
                    'data'    => $data,
                    'msg'   => $msg,
                )
        );

    }

    /**
     * 请求失败返回
     * @author yuanxiaolin@global28.com
     * @param string $result
     * @param string $success_msg
     * @param string $failure_msg
     * @ruturn return_type
     */
    public function return_failed ( $msg = 'request failed',$data = '',$status = -1) {

        $this->return_json(
            array(
                'status'    => isset($status) ? $status : C('status.failed.value'),
                'msg'       => $msg,
                'data'        => $data
            )
        );
    }

    /**
     * 通用的HTTP请求工具
     * @author yuanxiaolin@global28.com
     * @param string $path 接口请求path
     * @param unknown $data get|post请求数据
     * @param string $debug 接口的debug模式， 为true将会把数据原包返回
     * @param string $method 请求方式，默认POST
     * @param unknown $cookie 接口请求的cookie信息，用于需要登陆验证的接口
     * @param unknown $multi 文件信息
     * @param unknown $headers 附加的头文件信息
     * @ruturn return_type 返回string 或者 array
     */
    public function http_request($path = '',$data = array(),$debug=false, $method ='POST',$cookie = array(),$multi = array(),$headers = array()){
        $this->benchmark->mark('start');//start clock....
        
        $api_url = $this->create_url($path);

        $response = $this->get_response($api_url,$data,$method,$cookie,$multi,$headers);
        
        if ($debug === true) {
            return $response;
        }else{
            $response = json_decode($response,true);
        }
        
        $this->benchmark->mark('end');//end clock....
        
        $this->log_message($api_url,$response);
        
        return $response;
   }

    /**
     * 创建接口请求URL
     * @author yuanxiaolin@global28.com
     * @param string $path
     * @return string
     */
    public function create_url($path = ''){
        return sprintf('%s/%s',$this->data['domain']['service']['url'],$path);
    }




    protected function get_user_info($user_base_info){
        
        if(empty($user_base_info))
        {
            return FALSE;
        }
        
        $user_info['user_id'] = $user_base_info['id'];
        $user_info['phone_number'] = $user_base_info['phone_number'];
        $this->data['user_info'] = $user_info;
        
        $user_detail= $this->http_request('/user/info',['user_id'=>$user_base_info['id']]);
        if ($user_detail['status'] == C('status.success.value')) {
            if(!empty($user_detail['data']['userInfo'])){
                $this->data['user_info'] = $user_detail['data']['user_info'];
            }
        }
        
        //用户名显示处理
        if ($this->data['user_info']){
            if (isset($this->data['user_info']['nickname']) && !empty($this->data['user_info']['nickname'])){
                $this->data['user_info']['user_name'] = $this->data['user_info']['nickname'];
            }else{
                $this->data['user_info']['user_name'] = $this->data['user_info']['phone_number'];
            }
        }
    }

    /**
     * 创建并设置访问token
     * @ruturn return_type
     */
    public  function set_token(){
        if(!isset($_SESSION))
        {
            session_start();
        }
        $this->data['token'] = md5(time());
        $this->session->set_userdata(array('user_token'  => $this->data['token']));
		return $this->data['token'];
    }

    /**
     * 检查是否是有效token
     * @param string $token
     * @throws Exception
     * @ruturn return_type
     */
    public function check_token($token = ''){
        if(!isset($_SESSION))
        {
            session_start();
        }
        if($token != $this->session->userdata('user_token')){
            return false;
        }
        return true;
    }

    /**
     * 销毁访问token
     * @ruturn return_type
     */
    public function unset_token(){
        if(!isset($_SESSION))
        {
            session_start();
        }
        if($this->session->has_userdata('user_token')){
            $this->session->unset_userdata('user_token');
        }
    }

    /**
     * 限制用户在一定时间不能重复点赞
     * @params id 评论ID
     */
    public  function set_token_dz($id = 0){
        $this->session->set_userdata(array('token_dz_'.$id  => md5($id)));
    }

    /**
     * 检查是否是有效token
     * @param ID $token
     * @ruturn boolean
     */
    public function check_dz_token($id){
        $token_name = "token_dz_".$id;
        if($this->session->userdata($token_name)){
            return true;
        }
        return false;
    }

    /**
     * 从底层服务请求数据
     *
     * @param string $url
     * @param string $data
     * @param string $debug
     * @return boolean|Ambigous <>
     */
    public function get_from_api($url = '', $data = '', $debug = false){
        if(empty($url) && empty($data)){
            return false;
        }
        $result = $this->http_request($url, $data, $debug );
        if($debug)
        {
            echo $result;exit;
        }
        if($result['status'] == C('status.success.value')){
            return $result;
        }
        else{
            return false;
        }
    
    }
    
    /**
     * 接口日志记录（此方法只限于接口监控使用）
     * @author yuanxiaolin@global28.com
     * @param unknown $data
     * @ruturn return_type
     */
    private function log_message($url = '', $data = array()){

        //日志初始化参数
        $params = array(
            'path'=>C('log.api.path'),
            'level'=>C('log.api.level')
        );

        //日志开关
        if(C('log.api.enable') === false){
            return ;
        }

        //加载日志工具
        $this->load->library('Logfile',$params);

        //接口时差，单位为毫秒
        $cost_time = $this->benchmark->elapsed_time('start','end') * 1000;

        if(isset($data['status']))
        {
            if($data['status'] == C('status.success.value'))
            {
                //返回成功，记录info日志
                $return_data = 'success';
                $message = sprintf('%s | %s | %s | %s',$data['status'],$cost_time,$url,$return_data);
                $this->logfile->info($message);
            }
            else
            {
                //返回错误，记录error日志
                $return_data = json_encode($data);
                $message = sprintf('%s | %s | %s | %s',$data['status'],$cost_time,$url,$return_data);
                $this->logfile->error($message);
            }
        }
        else
        {
            //格式错误，或者http请求未到达，记录error日志
            $return_data = 'http request error';
            $message = sprintf('%s | %s | %s | %s',$data['status'],$cost_time,$url,$return_data);
            $this->logfile->error($message);
        }
    }
    
    /**
     * 从接口获取数据，根据情况判断从数据库获取还是从memcache获取
     * @param string $path 接口请求path
     * @param unknown $data get|post请求数据
     * @param string $debug 接口的debug模式， 为true将会把数据原包返回
     * @param string $method 请求方式，默认POST
     * @param unknown $cookie 接口请求的cookie信息，用于需要登陆验证的接口
     * @param unknown $multi 文件信息
     * @param unknown $headers 附加的头文件信息
     * @author mochaokai@global28.com
     */
    private function get_response($api_url,$data,$method,$cookie,$multi,$headers){
        $url = $this->get_url($api_url).json_encode($data);
        //判断客户端是否支持memcached和memcached开关是否打开，memcached开关在memcached配置文件中
        if(class_exists('memcached') && C('mymemcached.switch')){
            $this->load->library('Mymemcache');
            $response = Mymemcache::get($url);
            if(!$response){
                $response = Http::Request($api_url,$data,$method,$cookie,$multi,$headers);
                Mymemcache::set($url, $response, C('mymemcached.time'));
                $all_key_arr = Mymemcache::get(C('mymemcached.all_keys'));
                if(!$all_key_arr){
                    $all_key_arr = [];
                }
                if(!in_array($url, $all_key_arr)){
                    $all_key_arr[] = $url;
                    Mymemcache::set(C('mymemcached.all_keys'), $all_key_arr, C('mymemcached.time'));
                }
                return $response;
            }else{
                return $response;
            }
        }else{
            return Http::Request($api_url,$data,$method,$cookie,$multi,$headers);
        }
    }
    
    /**
     * 对memcache的键进行规范化处理
     * @author mochaokai@global28.com
     * @param string $url
     * @return string $str
     */
    private function get_url($url){
        $str = 'http://';
        foreach (explode('/', $url) as $k => $v){
            if(!empty($v) && $k > 0){
                $str .= $v.'/';
            }
        }
        return $str;
    }
	
	
	/**
	 *计算概率
	 *@author lsy
	**/
	public function get_rand($proArr) {
		$result = '';

		//概率数组的总概率精度 
		$proSum = array_sum($proArr);

		//概率数组循环 
		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);
			if ($randNum <= $proCur) {
				$result = $key;
				break;
			} else {
				$proSum -= $proCur;
			}
		}
		unset($proArr);

		return $result;
	}
	
	/**
	 *获取随机字符串
	 *@author 1034487709@qq.cpm 
	**/
	public function get_rand_char($length){
	   $str = null;
	   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	   $max = strlen($strPol)-1;

	   for($i=0;$i<$length;$i++){
		$str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
	   }

	   return $str;
	  }
    
}














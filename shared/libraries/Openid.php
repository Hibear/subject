<?php
/**
 * 微信获取用户信息
 * 
 * @author lsy
 *
 */
class Openid {
	
	public $scope = "snsapi_base";
	
	public function getopenid($appid,$appsecret,$scope = "snsapi_base",$url=""){
		if($scope == 1){
			$this->scope = "snsapi_userinfo";
		}
	    $get = @$_GET['param'];
		$code = @$_GET['code'];
		if(empty($url)){
			 $url = C("domain.www.url").$_SERVER['REQUEST_URI']."?param=access_token";
		}else{
			  $url =$url.'?param=access_token' ;
		}
	   if($get=='access_token' && !empty($code)){
			$json = $this->get_access_token($appid,$appsecret,$code);
			if($scope != 1){
				return $json;  
			}
			 
			if(!empty($json)){
				$userinfo = $this->get_user_info($json['access_token'],$json['openid']);
				return $userinfo;
			}
		}else{
			$this->get_authorize_url($appid,$url,'STATE');
		}
	}
	
	//获取用户详细信息
	public function get_user_info($access_token = '', $open_id = '')
    {
        if($access_token && $open_id)
        {
			$access_url = "https://api.weixin.qq.com/sns/auth?access_token={$access_token}&openid={$open_id}";
			$access_data = $this->http($access_url);
			$access_info = json_decode($access_data[0], TRUE);
			if($access_info['errmsg']!='ok'){
				exit('页面过期');
			}
            $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
            $info_data = $this->http($info_url);  		
            if(!empty($info_data[0]))
            {
                return json_decode($info_data[0], TRUE);
            }
        }
        
        return FALSE;
    }   	
	
	/**
     * 获取授权token
     * 
     * @param string $code 通过get_authorize_url获取到的code
     */
    public function get_access_token($appid,$app_secret,$code = '')
    {
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$app_secret}&code={$code}&grant_type=authorization_code";
        $token_data = $this->http($token_url);
        if(!empty($token_data[0]))
        {
            return json_decode($token_data[0], TRUE);
        }
        
        return FALSE;
    }   
	
	/**
     * 获取微信授权链接
     * 
     * @param string $redirect_uri 跳转地址
     * @param mixed $state 参数
     */
    public function get_authorize_url($appid,$redirect_uri = '', $state = '')
    {
	//snsapi_userinfo
	
        $redirect_uri = urlencode($redirect_uri);
       $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=".$this->scope."&state={$state}#wechat_redirect"; 

        echo "<script language='javascript' type='text/javascript'>";  
        echo "window.location.href='$url'";  
        echo "</script>";   
			
    }       
	
	
	public function http($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $output = curl_exec($ch);//输出内容
        curl_close($ch);
        return array($output);
    }   
		
		
		
}



?>
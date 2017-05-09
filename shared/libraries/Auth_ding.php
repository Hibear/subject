<?php 
class Auth_ding
{
    public function getAccessToken(){
        //缓存accessToken。accessToken有效期为两小时，需要在失效前请求新的accessToken。
        
    }

    
     
    
    public function getTicket($accessToken){
        //缓存jsTicket。jsTicket有效期为两小时，需要在失效前请求新的jsTicket
        
    }
    
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
          $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public static function getConfig(){
        $corpId = CORPID;
        $agentId = AGENTID;
        $nonceStr = 'abcdefg';
        $timeStamp = time();
        $url = '';
        $ticket = '';
        $signature = '';

        $config = array(
            'url' => $url,
            'nonceStr' => $nonceStr,
            'agentId' => $agentId,
            'timeStamp' => $timeStamp,
            'corpId' => $corpId,
            'signature' => $signature);
        return json_encode($config, JSON_UNESCAPED_SLASHES);
    }


    public static function sign($ticket, $nonceStr, $timeStamp, $url)
    {
        $plain = 'jsapi_ticket=' . $ticket .
        '&noncestr=' . $nonceStr .
        '&timestamp=' . $timeStamp .
        '&url=' . $url;
        return sha1($plain);
    }
    
    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
    
        $res = curl_exec($curl);
        curl_close($curl);
    
        return $res;
    }
}
?>
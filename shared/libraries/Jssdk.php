<?php
class JSSDK {
  private $appId;
  private $appSecret;
  private $per;

  public function __construct($param) {
    $this->appId = $param['app_id'];
    $this->appSecret = $param['app_secret'];
    $this->per = $param['per'];
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
    $CI =& get_instance();
    $CI->load->driver('cache');
    $ticket = $CI->cache->file->get($this->per.'ticket');
    if (!$ticket) {
      $accessToken = $this->getAccessToken();
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
          $CI->cache->file->save($this->per.'ticket', $ticket, 7200);
          return $ticket;
      }
    } else {
      return $ticket;
    }
  }

  public function getAccessToken() {
    $CI =& get_instance();
    $CI->load->driver('cache');
    $access_token = $CI->cache->file->get($this->per.'access_token');
    if (!$access_token) {
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->httpGet($url));
      $access_token = $res->access_token;
      if ($access_token) {
          $CI->cache->file->save($this->per.'access_token', $access_token, 7200);
          return $access_token;
      }
    } else {
      return $access_token;
    }
    
  }

    private function httpGet($url) {
        $curl = curl_init();
        @curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        @curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        @curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        @curl_setopt($curl, CURLOPT_URL, $url);
    
        $res = curl_exec($curl);
        curl_close($curl);
    
        return $res;
    }
}


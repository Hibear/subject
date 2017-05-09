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

    // ע�� URL һ��Ҫ��̬��ȡ������ hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // ���������˳��Ҫ���� key ֵ ASCII ����������
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


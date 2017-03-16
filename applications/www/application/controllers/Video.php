<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Video extends MY_Controller{
	

	
    public function __construct(){
        parent::__construct();
		$this->app = C("appid_secret.akx");
		
		
    }
    
	
    public function index(){
       
		//自定义分享
		$data['title'] = "信仰会一直在空中飘扬"; 
		$data['link'] = C("domain.www.url")."/video/index"; 
		$data['imgUrl'] = C("domain.www.url")."/static/video/logo.jpg"; 
		$data['desc'] = "信仰会一直在空中飘扬"; 
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
	
		$this->load->view("video/index", $data);
    }
	
	
	
   /*
    * 
    *分享页面
    * shunyu
    */
	public function android(){
		
		//自定义分享
		$data['title'] = "信仰会一直在空中飘扬"; 
		$data['link'] = C("domain.www.url")."/video/index"; 
		$data['imgUrl'] = C("domain.www.url")."/static/video/logo.jpg"; 
		$data['desc'] = "信仰会一直在空中飘扬"; 
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
		
		$this->load->view("video/android",$data);
	}
	
	
   


}
?>

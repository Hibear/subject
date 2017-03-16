<?php 
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends MY_Controller{
    public function __construct(){
        parent::__construct();
      
    }
    
    /**
     * 首页
     */
    public function index(){
       $this->load->view("home/home");
    }
    
    
}
?>

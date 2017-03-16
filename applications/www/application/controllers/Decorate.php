<?php 
defined('BASEPATH') or exit('No direct script access allowed');
class Decorate extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->data['action']  = 'decorate';
        $this->data['cur_sel'] = '2';
    }
    
    /**
     * 首页
     */
    public function index(){
        $data = $this->data;
        $this->load->view("decorate/index", $data);
    }
    
    
    public function detail(){
        $data = $this->data;
        $this->load->view("decorate/detail", $data);
    }
    
}
?>

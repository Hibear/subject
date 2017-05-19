<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Message extends MY_Controller{
    public function __construct(){
        parent::__construct();
        //切换到媒介系统数据库
        
        $this->load->Model([
            'Model_points' => 'Mpoints'
        ]);
        $this->load->driver('cache');
    }
    
    public function save(){
        
    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Child extends MY_Controller{
    private $app;
    public function __construct(){
        parent::__construct();
        $this->load->model(array(

        ));
        //分享用的
        $this->app = C("appid_secret.dashi");
        $this->load->driver('cache');
    }
    
    public function index(){
        $data = $this->data;
        $this->load->view('child/index', $data);
    }
    
}
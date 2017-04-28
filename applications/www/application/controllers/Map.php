<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Map extends MY_Controller{
    public function __construct(){
        parent::__construct();
        //切换到媒介系统数据库
        $this->db->db_select('adv_manage');
    }
    
    public function index(){
        $data = $this->data;
        $data['lists'] =[
            ['id' => 1, 'name' => 'marker_1', 'is_use' => 1 , 'x' => 26.644755, 'y' => 106.649823],
            ['id' => 2, 'name' => 'marker_2', 'is_use' => 0 , 'x' => 26.641226, 'y' => 106.649630],
            ['id' => 3, 'name' => 'marker_3', 'is_use' => 1 , 'x' => 26.642395, 'y' => 106.649716],
            ['id' => 4, 'name' => 'marker_4', 'is_use' => 1 , 'x' => 26.639197, 'y' => 106.651062]
            
        ];
        $this->load->view('map/index', $data);
    }
    
}
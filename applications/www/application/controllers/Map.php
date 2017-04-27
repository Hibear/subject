<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Map extends MY_Controller{
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $data = $this->data;
        $data['lists'] =[
            ['id' => 1, 'name' => 'marker_1', 'is_use' => 1 , 'x' => 40, 'y' => 117.10],
            ['id' => 2, 'name' => 'marker_2', 'is_use' => 0 , 'x' => 40.1, 'y' => 117.11],
            ['id' => 3, 'name' => 'marker_3', 'is_use' => 1 , 'x' => 39.99, 'y' => 117.12],
            ['id' => 4, 'name' => 'marker_4', 'is_use' => 0 , 'x' => 40.12, 'y' => 117.1309],
            ['id' => 5, 'name' => 'marker_5', 'is_use' => 1 , 'x' => 40.12, 'y' => 117.13],
            ['id' => 6, 'name' => 'marker_6', 'is_use' => 0 , 'x' => 40.121, 'y' => 117.132],
            ['id' => 7, 'name' => 'marker_7', 'is_use' => 1 , 'x' => 40.122, 'y' => 117.13],
            ['id' => 8, 'name' => 'marker_8', 'is_use' => 0 , 'x' => 40.1206, 'y' => 117.131] 
        ];
        $this->load->view('map/index', $data);
    }
}
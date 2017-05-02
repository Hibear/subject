<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Map extends MY_Controller{
    public function __construct(){
        parent::__construct();
        //切换到媒介系统数据库
        $this->db->db_select('adv_manage');
        
        $this->load->Model([
            'Model_points' => 'Mpoints',
            'Model_medias' => 'Mmedias'
        ]);
    }
    
    public function index(){
        $data = $this->data;
        //查询媒体资源表获取高杆广告ids,高杆类型type = 2
        $info = $this->Mmedias->get_lists('id', ['type' => 2, 'is_del' => 0]);
        if($info){
            $ids = array_column($info, 'id');
            if($ids){
                $fields = 'id,price,address,tx_coordinate,tx_jiejingid,images,is_lock';
                $lists = $this->Mpoints->get_lists($fields, ['in' => ['id' => $ids], 'is_del' => 0]);
            }
        }
        if($lists){
            $data['lists'] = $lists;
            foreach ($lists as $k => $v){
                if($v['images']){
                    $data['lists'][$k]['images'] = explode(';', $v['images']);
                }
            }
            
        }
        $this->load->view('map/index', $data);
    }
    
}
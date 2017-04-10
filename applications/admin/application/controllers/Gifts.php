<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Gifts extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
             'Model_gifts' => 'Mgifts'   
        ));
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'gifts_list';
    }

    public function index(){
        $data = $this->data;
        $this->load->view('gifts/index', $data);
    }
    
    public function add(){
        $data = $this->data;
        if(IS_POST){
            $add = $this->input->post();
            if(empty($add['title'])){
                $this->error('请填写礼品名称！');
            }
            if(empty($add['num'])){
                $this->error('请填写库存量！');
            }
            if(empty($add['score'])){
                $this->error('请填写兑换积分！');
            }
            $add['create_time'] = date('Y-m-d H:i:s');
            if(empty($add['img_url'])){
                $this->error('请上传封面图！');
            }
            $add['cover_img'] = $add['img_url'];
            unset($add['img_url']);
            $res = $this->Mgifts->create($add);
            if(!$res) {
                $this->error('添加失败，请重试！');
            }
            $this->success('添加成功！','/gifts');
        }
        $this->load->view('gifts/add', $data);
    }
}
<?php
/**
 * 公共投票管理
 * @author 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Public_vote extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
            'Model_vote_obj' => 'Mvote_obj',
            'Model_active' => 'Mactive'
        ));
        $this->load->library('pagination');
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'vote_list';
    }
    
    public function index(){
        $data = $this->data;
        //查询所有投票类型的活动
        $pageconfig = C('page.page_lists');
        $page = $this->input->get_post('per_page') ? : '1';
        $where = [
            'type' => C('active_type.tp.id')
        ];
        $title = trim($this->input->get('title'));
        if($title){
            $where['like'] = ['title' => $title];
            $data['title'] = $title;
        }
        $start_time = trim($this->input->get('start_time'));
        if($start_time){
            $start_time = explode('-', $start_time);
            $where['year(start_time)'] = $start_time[0];
            $where['month(start_time)'] = $start_time[1];
            $where['day(start_time)'] = $start_time[2];
            $start_time = implode('-', $start_time);
            $data['start_time'] = $start_time;
        }
        $data['list'] = $this->Mactive->get_lists('*', $where, ['start_time' => 'desc'], $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        $data_count = $this->Mactive->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;
        
        //获取分页
        $pageconfig['base_url'] = "/public_vote";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息

        $this->load->view('public_vote/index', $data);
    }
    
    public function obj_lists(){
        $data = $this->data;
        //查询所有投票类型的活动
        $pageconfig = C('page.page_lists');
        $page = $this->input->get_post('per_page') ? : '1';
        $id = (int) $this->input->get('active_id');
        $data['id'] = $id;
        $where = [
            'active_id' => $id
        ];
        $vote_obj = trim($this->input->get('vote_obj'));
        if($vote_obj){
            $where['like'] = ['vote_obj' => $vote_obj];
            $data['vote_obj'] = $vote_obj;
        }
        
        $data['list'] = $this->Mvote_obj->get_lists('*', $where, ['create_time' => 'desc'], $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        $data_count = $this->Mvote_obj->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;
        
        //获取分页
        $pageconfig['base_url'] = "/public_vote/obj_lists?id=$id";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息

        $this->load->view('public_vote/obj_lists', $data);
    }
    
}
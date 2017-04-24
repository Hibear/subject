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
        $pageconfig['base_url'] = "/public_vote/obj_lists?active_id=$id";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息

        $this->load->view('public_vote/obj_lists', $data);
    }
    
    /**
     * 添加公共参选对象
     */
    public function add_obj(){
        $data = $this->data;
        $data['active_id'] = (int) $this->input->get('active_id');
        if(IS_POST){
            $add = $this->input->post();
            if(empty($add['vote_obj'])){
                $this->error('请填写参选对象！');
            }
            if(empty($add['title'])){
                $this->error('请填写参选标题！');
            }
            $add['create_time'] = date('Y-m-d');
            if(empty($add['img_url'])){
                $this->error('请上传封面图！');
            }
            $add['cover_img'] = $add['img_url'];
            unset($add['img_url']);
            if(isset($add['images'])){
                $add['images'] = implode(';', $add['images']);
            }
            $res = $this->Mvote_obj->create($add);
            if(!$res) {
                $this->error('添加失败，请重试！');
            }
            $this->success('添加成功！','/public_vote//obj_lists?active_id='.$add['active_id']);
        }
        $this->load->view('public_vote/add_obj', $data);
    }
    
    /**
     * 编辑公共参选对象
     */
    public function edit_obj(){
        $data = $this->data;
        $data['active_id'] = (int) $this->input->get('active_id');
        $id = (int) $this->input->get('obj_id');
        if(IS_POST){
            $add = $this->input->post();
            $active_id = $add['active_id'];
            unset($add['active_id']);
            $id = $add['id'];
            unset($add['id']);
            if(empty($add['vote_obj'])){
                $this->error('请填写参选对象！');
            }
            if(empty($add['title'])){
                $this->error('请填写参选标题！');
            }
            $add['create_time'] = date('Y-m-d');
            if(empty($add['img_url'])){
                $this->error('请上传封面图！');
            }
            $add['cover_img'] = $add['img_url'];
            unset($add['img_url']);
            if(isset($add['images'])){
                $add['images'] = implode(';', $add['images']);
            }

            $res = $this->Mvote_obj->update_info($add, ['id' => $id, 'active_id' => $active_id]);
            if(!$res) {
                $this->error('操作失败，请重试！');
            }
            $this->success('编辑成功！','/public_vote/obj_lists?active_id='.$active_id);
        }
        
        $data['info'] = $this->Mvote_obj->get_one('*', ['id' => $id]);
        $this->load->view('public_vote/edit_obj', $data);
    }  
}
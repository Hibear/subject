<?php 
/**
* 活动管理控制器
* @author 254274509@qq.com
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Active extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_active' => 'Mactive'
        ]);
        $this->load->library('pagination');
        $this->data['code'] = 'weixin_manage';
        $this->data['active'] = 'active_list';
    }
    /**
     * 活动列表
     * @author 254274509@qq.com
     */
    public function index(){
        $data = $this->data;
        $pageconfig = C('page.page_lists');
        $page = $this->input->get_post('per_page') ? : '1';
        $where = [];
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
        $pageconfig['base_url'] = "/active";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        $this->load->view('active/index', $data);
    }
    /**
     * 活动添加
     * @author 254274509@qq.com
     */
    public function add(){
        $data = $this->data;
        if(IS_POST){
            $add = $this->input->post();
            $res = $this->Mactive->create($add);
            if(!$res){
                $this->error('操作失败！');
            }
            $this->success('操作成功！', '/active');
        }
        $this->load->view('active/add', $data);
    }
    
    /**
     * 活动编辑
     * @author 254274509@qq.com
     */
    public function edit(){
        $data = $this->data;
        if(IS_POST){
            $up = $this->input->post();
            $id = (int) $up['id'];
            unset($up['id']);
            $res = $this->Mactive->update_info($up, ['id' => $id]);
            if(!$res) {
                $this->error('修改失败，请重试！');
            }
            $this->success('修改成功！', '/active');
        }
        $id = (int) $this->input->get('id');
        $info = $this->Mactive->get_one('*', ['id' => $id]);
        $data['info'] = $info?$info:array();
        
        $this->load->view('active/edit', $data);
    }
}
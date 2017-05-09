<?php 
/**
* 规格管理控制器
* @author jianming@gz-zc.cn
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Moteusers extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
             'Model_mote_users' => 'Mmote_users',
        ]);
        $this->data['code'] = 'sign_manage';
        $this->data['active'] = 'mote_list';
    }
    

    /**
     * 模特报名人员列表
     */
    public function index() {
        $data = $this->data;
        $pageconfig = C('page.page_lists');
        $this->load->library('pagination');
        $page = $this->input->get_post('per_page') ? : '1';

        $where =  array();
        if ($this->input->get('phone_number')) $where['phone_number'] = $this->input->get('phone_number');
        if ($this->input->get('user_name')) $where['like']['user_name'] = $this->input->get('user_name');
        if ($this->input->get('is_auth') != '') $where['is_auth'] = $this->input->get('is_auth');

        $data['phone_number'] = $this->input->get('phone_number');
        $data['user_name'] = $this->input->get('user_name');
        $data['is_auth'] = $this->input->get('is_auth');

        $data['list'] = $this->Mmote_users->get_lists("*", $where, array("create_time" => "DESC"), $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        $data_count = $this->Mmote_users->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;

        //获取分页
        $pageconfig['base_url'] = "/moteusers";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息

        $this->load->view("mote/index", $data);
    }


    /**
     * 模特报名人员详情
     */
    public function detail($id) {
        $data = $this->data;

        $data['info'] = $this->Mmote_users->get_one("*", array('id' => $id));
        $data['info']['cover_img'] = $data['info']['cover_img'] ? explode(',', $data['info']['cover_img']) : array();
        $this->load->view("mote/detail", $data);
    }


    /**
     * 更新审核状态
     */
    public function set_auth($id, $auth_state) {
        $result = $this->Mmote_users->update_info(array('is_auth' => $auth_state), array('id' => $id));
        if ($result) {
            $this->success('操作成功！', '/moteusers/detail/'.$id);
        } else {
            $this->error('操作失败', '/moteusers/detail/'.$id);
        }
    }


}


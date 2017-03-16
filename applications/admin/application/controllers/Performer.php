<?php
/**
 * 方舟戏台演员报名
 * @author yonghua 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Performer extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_performer' => 'Mperformer'
        ]);
        $this->data['code'] = 'sign_manage';
        $this->data['active'] = 'performer';
    }

    public function index() {
        $data = $this -> data;
        $pageconfig = C('page.page_lists');
        $this->load->library('pagination');
        $page = $this->input->get_post('per_page') ? : '1';
        $where =  array();
        if ($this->input->get('tel')) $where['tel'] = trim($this->input->get('tel'));
        if ($this->input->get('fullname')) $where['like']['fullname'] = trim($this->input->get('fullname'));
        $data['tel'] = $this->input->get('tel');
        $data['fullname'] = $this->input->get('fullname');
        $fields = 'id,fullname,tel,vote_num,create_time, is_del';
        $data['list'] = $this->Mperformer->get_lists($fields, $where, array("vote_num" => "DESC","create_time" => "DESC"), $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        $data_count = $this->Mperformer->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;

        //获取分页
        $pageconfig['base_url'] = "/performer";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        $this->load->view('performer/index', $data);
    }

    public function add(){
        $data = $this -> data;
        if(IS_POST){
            $add = $this->input->post();
            if(empty($add['fullname'])){
                $this->error('请填写演员姓名！');
            }
            if(empty($add['tel'])){
                $this->error('请填写手机号！');
            }
            if(!isset($_FILES)){
                $this->error('请选择封面图！');
            }
            if(!preg_match('/^1[3|4|5|8|7][0-9]\d{8}$/', $add['tel'])) {
                $this->error('手机号格式不正确！');
            }
            $add['create_time'] = $add['update_time'] = date('Y-m-d H:i:s');

            $config = array(
                'upload_path'   => '../www/uploads/images',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'max_size'     => 1024*5,
                'max_width'    => 2000,
                'max_height'   => 2000,
                'encrypt_name' => TRUE,
                'remove_spaces'=> TRUE,
                'use_time_dir'  => TRUE,      //是否按上传时间分目录存放
                'time_method_by_day'=> TRUE, //分目录存放的方式：按天
            );

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('cover_img')){
                $this->error('上传的图片不符合要求');
            } else {
                $data = $this->upload->data();
                $add['cover_img'] = $data['file_name'];
                $this->thumb_img($data['file_name']);
            }

            $res = $this->Mperformer->create($add);
            if(!$res) {
                $this->error('添加失败，请重试！');
            }
            $this->success('添加成功！','/performer');
        }
        //显示表单页面
        $this->load->view('performer/add',$data);

    }

    public function modify(){
        $data = $this -> data;
        if(IS_POST){
            $up = $this->input->post();
            $id = (int) $up['id'];
            unset($up['id']);
            $up['update_time'] = date('Y-m-d H:i:s');
            if(isset($_FILES['cover_img']) && !empty($_FILES['cover_img']['size'])){
                $config = array(
                    'upload_path'   => '../www/uploads/images',
                    'allowed_types' => 'gif|jpg|png|jpeg',
                    'max_size'     => 1024*5,
                    'max_width'    => 2000,
                    'max_height'   => 2000,
                    'encrypt_name' => TRUE,
                    'remove_spaces'=> TRUE,
                    'use_time_dir'  => TRUE,      //是否按上传时间分目录存放
                    'time_method_by_day'=> TRUE, //分目录存放的方式：按天
                );

                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('cover_img')){
                    $this->error('上传的图片不符合要求');
                } else {
                    $data = $this->upload->data();
                    $up['cover_img'] = $data['file_name'];
                    $this->thumb_img($data['file_name']);
                }
            }
            $res = $this->Mperformer->update_info($up, ['id' => $id]);
            if(!$res) {
                $this->error('修改失败，请重试！');
            }
            $this->success('修改成功！', '/performer');
        }
        $id = (int) $this->input->get('id');
        $info = $this->Mperformer->get_one('*', ['id' => $id]);
        $data['info'] = $info?$info:array();
        //显示表单页面
        $this->load->view('performer/edit',$data);
    }
    
    private function thumb_img($path){
        $config['image_library'] = 'gd2';
        $config['source_image'] = '../www/uploads/images/'.$path;
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = TRUE;
        $config['width']     = 640;
        
        $this->load->library('image_lib', $config);
        
        $this->image_lib->resize();
    }

}
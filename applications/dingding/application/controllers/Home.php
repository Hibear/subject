<?php 
/**
* 首页控制器
* @author yonghua
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_warehouse' => 'Mwarehouse',
            'Model_warehouse_cate' => 'Mwarehouse_cate',
            'Model_borrow_log' => 'Mborrow_log'
        ]);
        $this->pageconfig = C('page.page_lists');
        $this->load->library('pagination');
        $this->load->library('auth_ding', C('ding'));
    }

    #主页面
    public function index(){
        $data = $this->data;
        $page =  intval($this->input->get("per_page",true)) ?  : 1;
        $name = trim($this->input->get('name'));
        $cate_id = (int) $this->input->get('cate_id');
        $data['cate_id'] = $cate_id;
        $where = [
            'is_del' => 0
        ];
        if($name){
            $data['name'] = $name;
            $where['like'] =[
                'name' => $name
            ];
        }
        if($cate_id){
            $where['cate_id'] = $cate_id;
        }
        $size = $this->pageconfig['per_page'];
        $lists = $this->Mwarehouse->get_lists('*', $where, [], $size, $size*($page-1));
        if($lists){
            //分页
            $data['lists'] = $lists;
            $data_count = $this->Mwarehouse->count($where);
            $this->pageconfig['base_url'] = "/home/index";
            $this->pageconfig['total_rows'] = $data_count;
            $this->pagination->initialize($this->pageconfig);
            $data['pagestr'] = $this->pagination->create_links(); // 分页信息
            
            $data['page'] = $page;
            $data['data_count'] = $data_count;
        }
        $data['cate'] = $this->get_cate();
        $data['config'] = (array) json_decode($this->auth_ding->get_config());
        $this->load->view("home/home",$data);
    }
    
    public function add(){
        $data = $this->data;
        $data['cate'] = $this->get_cate();
        if(IS_POST){
            $add = $this->input->post();
            if(!$add['name']){
                $this->error('名称不能为空');
            }
            if(!$add['num'] || $add['num'] == 0){
                $this->error('数量不能为空');
            }
            $add['num'] = (int) $add['num'];
            $res = $this->Mwarehouse->create($add);
            if(!$res){
                $this->error('操作失败！');
            }
            
            $this->success('操作成功！', '/home');
        }
        $this->load->view('home/add', $data);
    }
    
    public function edit(){
        $data = $this->data;
        $data['cate'] = $this->get_cate();
        $id = (int) $this->input->get('id');
        if(IS_POST){
            $add = $this->input->post();
            $id = (int) $add['id'];
            unset($add['id']);
            if(!$add['name']){
                $this->error('名称不能为空');
            }
            if(!$add['num'] || $add['num'] == 0){
                $this->error('数量不能为空');
            }
            $add['num'] = (int) $add['num'];
            $res = $this->Mwarehouse->update_info($add, ['id' => $id]);
            if(!$res){
                $this->error('操作失败！');
            }
    
            $this->success('操作成功！', '/home');
        }
        $info = $this->Mwarehouse->get_one('*', ['id' => $id, 'is_del' => 0]);
        if(!$info){
            show_404();
        }
        $data['info'] = $info;
        $this->load->view('home/edit', $data);
    }
    
    public function del(){
        $id = (int) $this->input->get('id');
        //查询次物件是否还有未归还的记录
        $num = $this->Mborrow_log->count(['borrow_id' => $id, 'status' => 0]);
        if($num){
            $this->error('该物件还有未归还的记录，请先归还！');
        }
        $res = $this->Mwarehouse->update_info(['is_del' => 1], ['id' => $id]);
        if(!$res){
            $this->error('操作失败！');
        }
        $this->success('删除成功！', '/home');
    }
    
    public function cate(){
        $data = $this->data;
        $page =  intval($this->input->get("per_page",true)) ?  : 1;
        $name = trim($this->input->get('name'));
        $where = [];
        if($name){
            $data['name'] = $name;
            $where['like'] =[
                'name' => $name
            ];
        }
        $size = $this->pageconfig['per_page'];
        $lists = $this->Mwarehouse_cate->get_lists('*', $where, [], $size, $size*($page-1));
        if($lists){
            //分页
            $data['lists'] = $lists;
            $data_count = $this->Mwarehouse_cate->count($where);
            $this->pageconfig['base_url'] = "/home/cate";
            $this->pageconfig['total_rows'] = $data_count;
            $this->pagination->initialize($this->pageconfig);
            $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        
            $data['page'] = $page;
            $data['data_count'] = $data_count;
        }
        $this->load->view("home/index_cate",$data);
    }
    
    public function add_cate(){
        $data = $this->data;
        if(IS_POST){
            $add = $this->input->post();
            if(!$add['name']){
                $this->error('名称不能为空');
            }
            $res = $this->Mwarehouse_cate->count(['name' => $add['name'], 'is_del' => 0]);
            if($res){
                $this->error('分类已经存在！');
            }
            $res = $this->Mwarehouse_cate->create($add);
            if(!$res){
                $this->error('操作失败！');
            }
        
            $this->success('操作成功！', '/home');
        }
        $this->load->view('home/add_cate', $data);
    }
    
    public function edit_cate(){
        $data = $this->data;
        if(IS_POST){
            $name = trim($this->input->post('name'));
            $id = $this->input->post('id');
            $is_del = (int) $this->input->post('is_del');
            if(!$name){
                $this->error('名称不能为空');
            }
            $res = $this->Mwarehouse_cate->update_info(['name' => $name, 'is_del' => $is_del], ['id' => $id]);
            if(!$res){
                $this->error('操作失败！');
            }
    
            $this->success('操作成功！', '/home/cate');
        }
        $id = (int) $this->input->get('id');
        $info = $this->Mwarehouse_cate->get_one('*', ['id' => $id, 'is_del' => 0]);
        if(!$info){
            show_404();
        }
        $data['info'] = $info;
        $this->load->view('home/edit_cate', $data);
    }

    private function get_cate(){
        $where = [
            'is_del' => 0
        ];
        $lists = $this->Mwarehouse_cate->get_lists('*', $where);
        if($lists){
            return $lists;
        }
        return null;
    }

}
?>

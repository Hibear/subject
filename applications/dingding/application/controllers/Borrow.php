<?php 
/**
* 首页控制器
* @author yonghua
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Borrow extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_warehouse' => 'Mwarehouse',
            'Model_borrow_log' => 'Mborrow_log'
        ]);
        $this->pageconfig = C('page.page_lists');
        $this->load->library('pagination');
    }
    
    public function index(){
        $data = $this->data;
        $id = (int) $this->input->get('id');
        $name = trim($this->input->get('name'));
        if(!$id){
            show_404();
        }
        $data['id'] = $id;
        //根据物件id获取物件名称
        $data['obj_name'] = $this->Mwarehouse->get_one('name', ['id' => $id])['name'];
        $page =  intval($this->input->get("per_page",true)) ?  : 1;
        $size = $this->pageconfig['per_page'];
        $where = [
            'borrow_id' => $id
        ];
        if($name){
            $data['name'] = $name;
            $where['like'] =[
                'name' => $name
            ];
        }
        $list = $this->Mborrow_log->get_lists('*', $where, ['start_time' => 'desc'], $size, $size*($page-1));
        if($list){
            //分页
            $data['lists'] = $list;
            $data_count = $this->Mborrow_log->count($where);
            $this->pageconfig['base_url'] = "/borrow/index";
            $this->pageconfig['total_rows'] = $data_count;
            $this->pagination->initialize($this->pageconfig);
            $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        
            $data['page'] = $page;
            $data['data_count'] = $data_count;
        }
        $this->load->view('borrow/index', $data);
    }
    
    public function back(){
        $data = $this->data;
        $id = (int) $this->input->get('id');
        $borrow_id = (int) $this->input->get('borrow_id');
        $up = [
            'end_time' => date('Y-m-d'),
            'in_admin_id' => $data['userInfo']['userid'],
            'in_admin_name' => $data['userInfo']['name'],
            'status' => 1
        ];
        $res = $this->Mborrow_log->update_info($up, ['id' => $id]);
        if($res){
            $this->Mwarehouse->update_info(['decr' => ['`out_num`' => 1] ], ['id' => $borrow_id]);
            $this->success('归还成功');
        }else{
            $this->error('操作失败');
        }
        
    }
    
    public function out(){
        $data = $this->data;
        $borrow_id = (int) $this->input->post('borrow_id');
        //判断是否能够借出
        $res = $this->Mwarehouse->get_one('num, out_num', ['id' => $borrow_id]);
        if($res['num'] == $res['out_num']){
            $this->return_json(['code' => 0, 'msg' => '已借完，请先等待其他同事归还']);
        }
        $userid = trim($this->input->post('userid'));
        $name = trim($this->input->post('name'));
        $add = [
            'borrow_id' => $borrow_id,
            'userid' => $userid,
            'name' => $name,
            'admin_id' => $data['userInfo']['userid'],
            'admin_name' => $data['userInfo']['name'],
            'status' => 0,
            'start_time' => date('Y-m-d')
        ];
        $res = $this->Mborrow_log->create($add);
        if($res){
            $this->Mwarehouse->update_info(['incr' => ['`out_num`' => 1] ], ['id' => $borrow_id]);
            $this->return_json(['code' => 1, 'msg' => '操作成功']);
        }else{
            $this->return_json(['code' => 0, 'msg' => '操作失败']);
        }
    }
    
}
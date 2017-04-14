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
            'Model_active' => 'Mactive',
            'Model_active_prize' => 'Mactive_prize'
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
            if(!$add['title']){
                $this->error('活动名称不能为空');
            }
            $prize = $add['prize'];
            unset($add['prize']);
            $res = $this->Mactive->create($add);
            if(!$res){
                $this->error('操作失败！');
            }
            //如果有设置了奖项
            if($prize){
                $this->do_prize($res, $prize);
            }
            $this->success('操作成功！', '/active');
        }
        $this->load->view('active/add', $data);
    }
    
    /**
     * 处理奖项, 批量插入
     */
    private function do_prize($id, $list){
        $res = [];
        //将奖项转换成多维数组，即多条的形式
        foreach ($list as $k => $v){
            foreach ($v as $key => $val){
                $res[$key][$k] = $val;
            }
        }
        //循环处理数组，如果当前数组奖项名称为空，则删除当前的数组
        $j = count($res);
        for($i=0; $i <= $j-1; $i++){
            if(!$res[$i]['prize_name']){
                unset($res[$i]);
            }else{
                $res[$i]['active_id'] = $id;
            }
        }
        if($res){
            //批量插入数据库
            $ret = $this->Mactive_prize->create_batch($res);
            if(!$ret){
                $this->Mactive->delete(['id' => $id]);
                $this->error('操作失败！');
            }else{
                $this->success('操作成功！', '/active');
            }
        }
    }
    
    /**
     * 删除奖项
     * @author 254274509@qq.com
     */
    public function del_prize(){
        $id = (int) $this->input->post('id');
        $res = $this->Mactive_prize->update_info(['is_del' => 1], ['id' => $id]);
        if(!$res){
            $this->return_json(['code' => 0, 'msg' => '操作失败']);
        }
        $this->return_json(['code' => 1, 'msg' => '删除成功']);
    }
    
    /**
     * 更新奖项
     * @author 254274509@qq.com
     */
    public function update_prize(){
        $up = $this->input->post();
        $id = $up['id'];
        unset($up['id']);
        $res = $this->Mactive_prize->update_info($up, ['id' => $id]);
        if(!$res){
            $this->return_json(['code' => 0, 'msg' => '操作失败']);
        }
        $this->return_json(['code' => 1, 'msg' => '更新成功']);
    }
    
    /**
     * 活动编辑
     * @author 254274509@qq.com
     */
    public function edit(){
        $data = $this->data;
        if(IS_POST){
            $up = $this->input->post();
            if(!$up['title']){
                $this->error('活动名称不能为空');
            }
            if(isset($up['prize'])){
                $prize = $up['prize'];
                unset($up['prize']);
            }
            $id = (int) $up['id'];
            unset($up['id']);
            
            $res = $this->Mactive->update_info($up, ['id' => $id]);
            if(!$res) {
                $this->error('修改失败，请重试！');
            }
            //如果有新增设置了奖项
            if(isset($prize)){
                $this->do_prize($id, $prize);
            }
            $this->success('修改成功！', '/active');
        }
        $id = (int) $this->input->get('id');
        $info = $this->Mactive->get_one('*', ['id' => $id]);
        if($info){
            $data['info'] = $info;
            $data['prize_lists'] = $this->Mactive_prize->get_lists('*', ['active_id' => $info['id'], 'is_del' => 0]);
        }
        $this->load->view('active/edit', $data);
    }
}
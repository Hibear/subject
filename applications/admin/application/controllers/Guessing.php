<?php
/**
 * 竞猜管理
 * @author 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Guessing extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
            'Model_vote_obj' => 'Mvote_obj',
            'Model_active' => 'Mactive',
            'Model_active_vote_log' => 'Mactive_vote_log',
            'Model_game_user' => 'Mgame_user'
        ));
        $this->load->library('pagination');
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'guessing_list';
    }
    
    public function index(){
        $data = $this->data;
        //查询所有竞猜类型的活动
        $pageconfig = C('page.page_lists');
        $page = $this->input->get_post('per_page') ? : '1';
        $where = [
            'type' => C('active_type.jc.id')
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
        $pageconfig['base_url'] = "/guessing";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息

        $this->load->view('guessing/index', $data);
    }
    
    public function obj_lists(){
        $data = $this->data;
        //查当前id竞猜类型的活动
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
        
        $data['list'] = $this->Mvote_obj->get_lists('*', $where, ['score' => 'desc', 'create_time' => 'desc'], $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        $data_count = $this->Mvote_obj->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;
        
        //获取分页
        $pageconfig['base_url'] = "/guessing/obj_lists?active_id=$id";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息

        $this->load->view('guessing/obj_lists', $data);
    }
    
    public function dowmload(){
        $active_id = (int) $this->input->get('active_id');
        //获取本次活动的所有参与者openid
        $user_list = $this->Mactive_vote_log->get_lists('openid, obj_id, create_time', ['active_id' => $active_id], ['create_time' => 'asc']);
        if(!$user_list){
            echo '<h1>暂无数据</h1>';
            exit;
        }
        //根据openid获取用户的姓名
        $openids = array_column($user_list, 'openid');
        $user_list_info = $this->Mgame_user->get_lists('openid, realname, nickname, tel', ['in' => ['openid' => $openids]]);
        //获取支持的总队伍
        $obj_ids = array_column($user_list, 'obj_id');
        $obj_list = $this->Mvote_obj->get_lists('id,vote_obj', ['in' => ['active_id' => $active_id]]);
        
        //拼接数据
        $lists = $user_list;
        foreach ($user_list as $k => $v){
            
            foreach ($user_list_info as $key => $val){
                if($v['openid'] == $val['openid']){
                    $lists[$k]['realname'] = $val['realname'];
                    $lists[$k]['nickname'] = $val['nickname'];
                    $lists[$k]['tel'] = $val['tel'];
                    break;
                }
            }
            foreach ($obj_list as $key => $val){
                if($v['obj_id'] == $val['id']){
                    $lists[$k]['obj_name'] = $val['vote_obj'];
                    break;
                }
            }
        }
        
        //导出加载phpexcel
        $this->load->library("PHPExcel");
    
        //设置表头
        $table_header =  array(
            '姓名'=>"realname",
            '微信昵称'=>"nickname",
            '电话' => 'tel',
            '支持队伍'=>"obj_name",
            '生成时间' => 'create_time'
        );
    
        $i = 0;
        foreach($table_header as  $kk=>$v){
            $cell = PHPExcel_Cell::stringFromColumnIndex($i).'1';
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue($cell, $kk);
            $i++;
        }
    
        $where =  array();
        $where['in']['level'] = [1,5];
    
    
        $h = 2;
        foreach($lists as $key=>$val){
            $j = 0;
            foreach($table_header as $k => $v){
                $cell = PHPExcel_Cell::stringFromColumnIndex($j++).$h;
                $this->phpexcel->getActiveSheet(0)->setCellValue($cell, $val[$v].' ');
            }
            $h++;
        }
    
        $this->phpexcel->setActiveSheetIndex(0);
        // 输出
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=竞猜数据_'.date("YmdHis").'.xls');
        header('Cache-Control: max-age=0');
    
        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save('php://output');

    }
    
    /**
     * 添加竞猜对象
     */
    public function add_obj(){
        $data = $this->data;
        $data['active_id'] = (int) $this->input->get('active_id');
        if(IS_POST){
            $add = $this->input->post();
            if(empty($add['vote_obj'])){
                $this->error('请填写竞猜对象！');
            }
            if(empty($add['title'])){
                $this->error('请填写标题！');
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
            $this->success('添加成功！','/guessing/obj_lists?active_id='.$add['active_id']);
        }
        $this->load->view('guessing/add_obj', $data);
    }
    
    /**
     * 编辑竞猜对象
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
                $this->error('请填写竞猜对象！');
            }
            if(empty($add['title'])){
                $this->error('请填写标题！');
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
            $this->success('编辑成功！','/guessing/obj_lists?active_id='.$active_id);
        }
        
        $data['info'] = $this->Mvote_obj->get_one('*', ['id' => $id]);
        $this->load->view('guessing/edit_obj', $data);
    }  
}
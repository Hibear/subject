<?php
/**
 * 后台礼品管理
 * @author 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Gifts extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
             'Model_gifts' => 'Mgifts',
             'Model_exchange_log' => 'Mexchange_log',
             'Model_game_user' => 'Mgame_user'
        ));
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'gifts_list';
    }

    public function index(){
        $data = $this->data;
        $pageconfig = C('page.page_lists');
        $this->load->library('pagination');
        $page = $this->input->get_post('per_page') ? : '1';
        $where =  array();
        $title = trim($this->input->get('title'));
        if($title){
            $where['like'] = ['title' => $title];
            $data['title'] = $title;
        }
        $data['list'] = $this->Mgifts->get_lists('*', $where, ['create_time' => 'desc'], $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        //获取分页
        if($data['list']){
            $data_count = $this->Mgifts->count($where);
            $data['data_count'] = $data_count;
            $pageconfig['base_url'] = "/gifts";
            $pageconfig['total_rows'] = $data_count;
            $this->pagination->initialize($pageconfig);
            $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        }
        
        $this->load->view('gifts/index', $data);
    }
    
    /**
     * 礼品添加
     */
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
    
    /**
     * 修改礼品
     */
    public function modify(){
        $data = $this->data;
        if(IS_POST){
            $up = $this->input->post();
            $id = $up['id'];
            unset($up['id']);
            if(empty($up['title'])){
                $this->error('礼品名称不能为空！');
            }
            if(empty($up['score'])){
                $this->error('请填写兑换积分！');
            }
            if(empty($up['img_url'])){
                $this->error('请上传封面图！');
            }
            $up['cover_img'] = $up['img_url'];
            unset($up['img_url']);
            $res = $this->Mgifts->update_info($up, ['id' => $id]);
            if(!$res) {
                $this->error('操作失败，请重试！');
            }
            $this->success('修改成功！','/gifts');
        }
        $id = (int) $this->input->get('id');
        $info = $this->Mgifts->get_one('*', ['id' => $id]);
        $data['info'] = $info?$info:array();
        $this->load->view('gifts/modify', $data);
    }
    
    
    /**
     * 礼品记录查询
     */
    public function exchange(){
        $data = $this->data;
        $pageconfig = C('page.page_lists');
        $this->load->library('pagination');
        $page = $this->input->get_post('per_page') ? : '1';
        $where =  [
            'is_del' => 0
        ];
        $realname = trim($this->input->get('realname'));
        $status = 1;
        if($realname){
            $data['realname'] = $realname;
            $info = $this->Mgame_user->get_lists('openid, realname, tel, addr', ['like' => ['realname' => $realname], 'is_del' => 0 ]);
            if($info && count($info) > 0){
                $where['in'] = [
                    'openid' => array_column($info, 'openid')
                ];
            }else{
                $status = 0;
            }
        }
        
        if($status){
            $list = $this->Mexchange_log->get_lists('*', $where, ['create_time' => 'desc'], $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
            if($list){
                $data['list'] = $list;
                //如果是根据姓名查询过的， 可以直接使用$info
                if(isset($info)){
                    foreach ($list as $k => $v){
                        foreach ($info as $key => $val){
                            if($v['openid'] == $val['openid']){
                                $data['list'][$k]['user_info'] = $val;
                            }
                        }
                    }
                }else{
                    //根据兑换记录表的openid, 查询用户的信息
                    $openids = array_column($list, 'openid');
                    if($openids){
                        $user_lists = $this->Mgame_user->get_lists('openid, realname, tel, addr', ['in' => ['openid' => $openids], 'is_del' => 0]);
                        if($user_lists){
                            foreach ($list as $k => $v){
                                foreach ($user_lists as $key => $val){
                                    if($v['openid'] == $val['openid']){
                                        $data['list'][$k]['user_info'] = $val;
                                    }
                                }
                            }
                        }
                    }
            
                }
            
                //分页
                $data_count = $this->Mexchange_log->count($where);
                $data['data_count'] = $data_count;
                $pageconfig['base_url'] = "/gifts/exchange";
                $pageconfig['total_rows'] = $data_count;
                $this->pagination->initialize($pageconfig);
                $data['pagestr'] = $this->pagination->create_links(); // 分页信息
            }
        }
        
        $this->load->view('gifts/exchange', $data);
    }
    
    /**
     * 礼品发放
     */
    public function get(){
        $id = $this->input->get('id');
        $res = $this->Mexchange_log->update_info(['status' => 1, 'post_time' => date('Y-m-d H:i:s')], ['id' => $id]);
        if(!$res) {
            $this->error('操作失败，请重试！');
        }
        $this->success('发放成功！','/gifts/exchange');
    }
    
    /**
     * 强制领取
     */
    public function power(){
        $id = $this->input->get('id');
        $res = $this->Mexchange_log->update_info(['status' => 2, 'get_time' => date('Y-m-d H:i:s')], ['id' => $id]);
        if(!$res) {
            $this->error('操作失败，请重试！');
        }
        $this->success('操作成功！','/gifts/exchange');
    }
    
    /**
     * 礼品上下架
     */
    public function up_down(){
        $id = $this->input->get('id');
        $status = $this->input->get('status');
        $res = $this->Mgifts->update_info(['status' => $status], ['id' => $id]);
        if(!$res) {
            $this->error('操作失败，请重试！');
        }
        $this->success('操作成功！','/gifts');
    }
}
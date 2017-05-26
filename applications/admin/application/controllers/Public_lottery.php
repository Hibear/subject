<?php
/**
 * 公共中奖管理
 * @author 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Public_lottery extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
            'Model_prize_log' => 'Mprize_log',
            'Model_active' => 'Mactive',
            'Model_game_user' => 'Mgame_user'
        ));
        $this->load->library('pagination');
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'lottery_list';
    }
    
    public function index(){
        $data = $this->data;
        //查询所有投票类型的活动
        $pageconfig = C('page.page_lists');
        $page = $this->input->get_post('per_page') ? : '1';
        $where = [
            'in' => [
                'type' => [C('active_type.zjd.id'), C('active_type.ggk.id')]
            ]
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

        $this->load->view('public_lottery/index', $data);
    }
    
    public function lists(){
        $data = $this->data;
        //查询所有当前类型的中奖人员
        $pageconfig = C('page.page_lists');
        $page = $this->input->get_post('per_page') ? : '1';
        $id = (int) $this->input->get('active_id');
        $nickname = trim($this->input->get('nickname'));
        $data['id'] = $id;
        $where = [
            'active_id' => $id,
            'is_lottery' => 1
        ];
        if($nickname){
            //根据nickname查找openid
            $data['nickname'] = $nickname;
            $weixin = $this->Mgame_user->get_lists('openid', ['like' => ['nickname' => $nickname]]);
            if($weixin){
                //获取所有openid
                $openids = array_column($weixin, 'openid');
                if($openids){
                    $where['in'] = [
                        'openid' => $openids
                    ];
                }
            }
        }
        
        $data['list'] = $this->Mprize_log->get_lists('*', $where, ['create_time' => 'desc'], $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        if($data['list']){
            //根据openid获取微信昵称
            $openids = array_column($data['list'], 'openid');
            if($openids){
                $weixin_user = $this->Mgame_user->get_lists('openid,nickname', ['in' => ['openid' => $openids]]);
                if($weixin_user){
                    foreach ($data['list'] as $k => $v){
                        $data['list'][$k]['nickname'] = '';
                        foreach ($weixin_user as $key => $val){
                            if($v['openid'] == $val['openid']){
                                $data['list'][$k]['nickname'] = $val['nickname'];
                            }
                        }
                    }
                }
            }
            
            $data_count = $this->Mprize_log->count($where);
            $data['data_count'] = $data_count;
            $data['page'] = $page;
            
            //获取分页
            $pageconfig['base_url'] = "/public_lottery/lists?active_id=$id";
            $pageconfig['total_rows'] = $data_count;
            $this->pagination->initialize($pageconfig);
            $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        }
        
        $this->load->view('public_lottery/lists', $data);
    }
    
    
    /**
     * 领奖
     */
    public function lingqu(){
        $data = $this->data;
        $active_id = (int) $this->input->get('active_id');
        $id = (int) $this->input->get('id');
        $res = $this->Mprize_log->update_info(['status' => 1, 'update_time' => date('Y-m-d H:i:s')], ['active_id' => $active_id, 'id' => $id]);
        if(!$res){
            $this->error('领取失败，请重试！');
        }
        $this->error('领取成功！');
    }  
}
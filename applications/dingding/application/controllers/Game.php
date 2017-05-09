<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Game extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
                'Model_lottery_users' => 'Mlottery_users'
        ));
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'game_list';
    }
    
    public function index(){
        $data = $this->data;
        $sql = 'SELECT * FROM(select * from (select id,openid,game_time from t_game_log where is_del = 0 order by game_time limit 10) a group by a.openid) b ORDER BY b.game_time asc;';
        $query = $this->db->query($sql);
        $this->db->last_query();
        $lists = [];
        foreach ($query->result_array() as $row){
            $lists[] = $row;
        }
        if($lists){
            //获取用户信息
            $openids = array_column($lists, 'openid');
            $user_list = $this->Mlottery_users->get_lists('openid,tel,name', ['in' => ['openid' => $openids]]);
            if($user_list){
                foreach ($lists as $k => $v) {
                    $lists[$k]['name'] = '匿名用户';
                    foreach ($user_list as $key => $val) {
                        if($v['openid'] == $val['openid']){
                            $lists[$k]['tel'] = $val['tel'];
                            $lists[$k]['name'] = $val['name'];
                        }
                    }
                }
            }
        }
        $data['list'] = $lists;
        
        $this->load->view('game/index', $data);
    } 
}


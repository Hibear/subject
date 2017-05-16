<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Public_vote extends MY_Controller{
    private $app;
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
                'Model_weixin_active' => 'Mweixin_active',
                'Model_vote_obj' => 'Mvote_obj',
                'Model_active_vote_log' => 'Mactive_vote_log'
        ));
        //分享用的
        $this->app = C("appid_secret.dashi");
        $this->load->driver('cache');
    }
    
    public function index(){
        
        $data = $this->data;
        $active_id = (int) $this->input->get('active_id');
        if(!$active_id){
            show_404();
        }
        $this->check_login($active_id);
        
        $info = $this->cache->file->get('vote_'.$active_id);
        $vote_obj = trim($this->input->get('vote_obj'));
        if(!$info){
            $info = $this->Mweixin_active->get_one('*', ['id' => $active_id, 'is_del' => 0, 'type' => C('active_type.tp.id')]);
            if(!$info){
                show_404();
            }else{
                $this->cache->file->save('vote_'.$active_id, $info, 5*60); //缓存5分钟
            }
        }
        //增加访问量
        $this->Mweixin_active->update_info(['incr' => ['visits' => 1]], ['id' => $info['id']]);
        
        $data['info'] = $info;
        $data['total'] = $this->Mvote_obj->get_lists('sum(score) as total', ['active_id' => $active_id, 'is_del' => 0])[0]['total'];
        $where = ['active_id' => $active_id, 'is_del' => 0 ];
        if($vote_obj){
            $where['like'] =[
                'vote_obj' => $vote_obj
            ];
        }
        $data['lists'] = $this->Mvote_obj->get_lists('id,title,cover_img,vote_obj,score,video', $where, ['create_time' => 'desc']);
        $this->load->view('public_vote/index', $data);
    }
    
    public function detail(){
        $data = $this->data;
        $active_id = (int) $this->input->get('active_id');
        $obj_id = (int) $this->input->get('obj_id');
        
        $info = $this->cache->file->get('vote_'.$active_id);
        $vote_obj = trim($this->input->get('vote_obj'));
        
        //获取活动信息
        if(!$info){
            $info = $this->Mweixin_active->get_one('*', ['id' => $active_id, 'is_del' => 0, 'type' => C('active_type.tp.id')]);
            if(!$info){
                show_404();
            }else{
                $this->cache->file->save('vote_'.$active_id, $info, 5*60); //缓存5分钟
            }
        }
        //登陆
        $this->check_login($active_id);
        
        $data['active_id'] =$active_id;
        //查询被投对象的数据
        $data['obj'] = $this->Mvote_obj->get_one('*', ['active_id' => $active_id, 'id' => $obj_id, 'is_del' => 0]);
        if(!$data['obj']){
            show_404();
        }
        //获取用户的排行
        $obj_score = $data['obj']['score'];
        $data['range'] = $this->get_obj_ranges($obj_id, $obj_score, $active_id);
        $this->load->view('public_vote/detail', $data);
        
    }
    
    /**
     * 改良版计算排名
     * @param 用户id $id
     * @param 用户积分 $score
     * @param 投票活动id $active_id
     * @return 排名数 string|number
     */
    private function get_obj_ranges($id, $score, $active_id){
        $range = '暂无';
        $lists = $this->Mvote_obj->get_lists('id,score', ['active_id' => $active_id, 'score>=' => $score, 'is_del' => 0], ['score' => 'desc']);
        if(!$lists){
            return $range;
        }
        foreach ($lists as $k => $v){
                if($v['id'] == $id){
                    return $k+1;
                }
            }
        }
    
    
    private function get_obj_range($id, $score, $active_id){
        $range = '暂无';
        $lists = $this->cache->file->get('range_list_'.$active_id);
        if(!$lists){
            $lists = $this->Mvote_obj->get_lists('id, score', ['active_id' => $active_id, 'is_del' => 0], ['score' => 'desc']);
            if(!$lists){
                return $range;
            }
            $this->cache->file->save('range_list_'.$active_id, $lists, 3*60);//缓存3分钟
        }

        foreach ($lists as $k => $v){
            if($v['id'] == $id){
                return $k+1;
            }
        }
    }
    
    /**
     * 给投票对象投票
     */
    public function add_vote(){
        $data = $this->data;
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            $this->return_json(['code' => 0, 'msg' => '请先登陆！']);
        }
        $active_id = (int) $this->input->post('active_id');
        $obj_id = (int) $this->input->post('obj_id');
        $info = $this->cache->file->get('vote_'.$active_id);
        if(!$info){
            $info = $this->Mweixin_active->get_one('*', ['id' => $active_id, 'is_del' => 0, 'type' => C('active_type.tp.id')]);
            if(!$info){
                $this->return_json(['code' => 0, 'msg' => '活动不存在']);
            }else{
                $this->cache->file->save('vote_'.$active_id, $info, 5*60); //缓存5分钟
            }
        }
        
        //判断当前时间是否在活动时间内
        $time = time();
        $start_time = $info['start_time'];
        $no_start_msg = $info['no_start_msg'];
        $end_msg = $info['end_msg'];
        $end_time = $info['end_time'];
        $this->check_active_time($time, $start_time, $end_time, $no_start_msg, $end_msg);
        
        //判断今天是否能够投票
        $openid = $user_info['openid'];
        $this->check_today_and_vote($active_id, $openid, $obj_id, $info['count']);
    }
    
    /**
     * 判断当前时间能否进行投票
     * @param  $time 当前时间
     * @param  $start 活动开始时间
     * @param  $end 活动结束时间
     * @param  $no_start_msg 未开始的提示
     * @param  $end_msg 已结束的提示
     */
    private function check_active_time($time, $start, $end, $no_start_msg, $end_msg){
    
        if($time < strtotime($start)){
            $this->return_json(['code' => 0, 'msg' => $no_start_msg]);
        }else if($time >= strtotime($end)){
            $this->return_json(['code' => 0, 'msg' => $end_msg]);
        }
    }
    
    private function check_today_and_vote( $active_id, $openid, $obj_id, $counts){
        //判断是否投票过今日允许的范围
        $count = $this->Mactive_vote_log->count(['create_time' => date('Y-m-d'), 'active_id' => $active_id, 'openid' => $openid]);
        if($count >= $counts){
            $this->return_json(['code' => 0, 'msg' => '今日投票次数超限！']);
        }
        unset($count);
        //判断今天是否对次对象投票过
        $count = $this->Mactive_vote_log->count(['create_time' => date('Y-m-d'), 'active_id' => $active_id, 'obj_id' => $obj_id, 'openid' => $openid]);
        if($count){
            $this->return_json(['code' => 0, 'msg' => '你已经对此投过票了！']);
        }
        
        //开始添加投票记录
        $add = [
            'active_id' => $active_id,
            'openid' => $openid,
            'obj_id' => $obj_id,
            'score' => 1,
            'create_time' => date('Y-m-d')
        ];
        $res = $this->Mactive_vote_log->create($add);
        if($res){
            //涨分
            $id = $res;
            unset($res);
            $up =[
                'incr' => [
                    '`score`' => 1
                ]
            ];
            $res = $this->Mvote_obj->update_info($up, ['id' => $obj_id, 'active_id' => $active_id]);
            if($res){
                $this->return_json(['code' => 0, 'msg' => '投票成功！']);
            }else{
                $this->Mactive_vote_log->delete(['id' => $id]);
                $this->return_json(['code' => 0, 'msg' => '请重试！']);
            }
        }else{
            $this->return_json(['code' => 0, 'msg' => '请重试！']);
        }
        
    }
    
    private function check_login($id = 0){
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            $this->session->set_userdata('login_back_url', '/public_vote/index?active_id='.$id);
            redirect(C('domain.h5.url').'/weixin_active_login/login');
            exit;
        }
    }
}
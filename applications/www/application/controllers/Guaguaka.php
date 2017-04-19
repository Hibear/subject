<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Guaguaka extends MY_Controller{
    private $app;
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
                'Model_active' => 'Mactive',
                'Model_active_prize' => 'Mactive_prize',
                'Model_prize_log' => 'Mprize_log'
        ));
        //分享用的
        $this->app = C("appid_secret.dashi");
        $this->load->driver('cache');
    }
    
    public function index(){
        $data = $this->data;
        $id = (int) $this->input->get('active_id');
        $info = $this->cache->file->get('guaguaka_'.$id);
        if(!$info){
            //根据id获取本次砸金蛋的数据
            $info = $this->Mactive->get_one('*', ['id' => $id, 'is_del' => 0]);
            if($info){
                $this->cache->file->save('goldegg_'.$id, $info, 5*60);//缓存5分钟
            }else{
                show_404();
            }
        }
        //判断是否登陆
        $this->check_login($info['id']); 

        $user_info = $this->session->userdata('user_info');
        $data['user_info'] = $user_info;
        $openid = $user_info['openid'];
        $data['info'] = $info;
        //查询本次砸金蛋的奖项
        $data['prize'] = $this->Mactive_prize->get_lists('*', ['active_id' => $info['id']]);
        //查询今日抽奖的次数
        $data['num'] = (int) $this->Mprize_log->count(['openid' => $openid, 'create_time' => date('Y-m-d'), 'active_id' => $info['id']]);
        //查询本次活动的中奖记录
        $data['prize_log'] = $this->Mprize_log->get_lists('id, prize_name, prize, create_time', ['openid' => $openid, 'create_time' => date('Y-m-d'), 'active_id' => $info['id']]);
        
        $data['my_prize'] = $this->Mprize_log->get_lists('prize_name, prize, create_time',['active_id' => $info['id'], 'openid' => $openid, 'is_lottery' => 1]);
        
        $data['_this_prize'] = $this->guaguaka($info['id']);
        $this->load->view('guaguaka/index',$data);
    }
    
    /**
     * 砸蛋
     */
    private function guaguaka($id = 0){
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            return (['code' => 0, 'msg' => '请先登陆！']);
        }
        $openid = $user_info['openid'];
        $info = $this->cache->file->get('goldegg_'.$id);
        if(!$info){
            //根据id获取本次砸金蛋的数据
            $info = $this->Mactive->get_one('*', ['id' => $id, 'is_del' => 0]);
            if($info){
                $this->cache->file->save('goldegg_'.$id, $info, 5*60);//缓存5分钟
            }else{
                return (['code' => 0, 'msg' => '活动不存在']);
            }
        }

        //判断当前时间是否在活动时间内
        $time = time();
        $start_time = $info['start_time'];
        $no_start_msg = $info['no_start_msg'];
        $end_msg = $info['end_msg'];
        $end_time = $info['end_time'];
        $this->check_active_time($time, $start_time, $end_time, $no_start_msg, $end_msg);
        
        //判断当前用户是否能够砸蛋
        if($info['is_one'] == 1){
            //如果用户只能有一次中奖， 先判断是否已经中奖过了
            $res = $this->Mprize_log->count(['openid' => $openid, 'active_id' => $id, 'is_lottery' => 1]);
            if(!$res){
                //判断今天抽奖的次数是否已经用完
                $res = $this->Mprize_log->count(['openid' => $openid, 'active_id' => $id, 'create_time' => date('Y-m-d')]);
                if($res >= $info['count']){
                    return (['code' => 0, 'msg' => '您今天已经抽过'.$info['count'].'次奖了！']);
                }
            }
            return (['code' => 0, 'msg' => '您已经中过奖了！']);
        }else{
            //判断今天抽奖的次数是否已经用完
            $res = $this->Mprize_log->count(['openid' => $openid, 'active_id' => $id, 'create_time' => date('Y-m-d')]);
            if($res >= $info['count']){
                return (['code' => 0, 'msg' => '您今天已经抽过'.$info['count'].'次奖了！']);
            }
        }
        
        //开始抽奖
        $this->start_lottery($openid, $id);
        
    }
    
    private function start_lottery($openid, $id){
        //获取本次的奖项信息
        $prize = $this->cache->file->get('prize_'.$id);
        if(!$prize){
            $prize = $this->Mactive_prize->get_lists('*', ['active_id' => $id]);
            if($prize){
                $this->cache->file->save('prize_'.$id, $prize, 5*60);
            }else{
                return (['code' => 0, 'msg' => '请重试！']);
            }
        }
        
        //计算通过奖项信息计算本次的中奖率
        $this->do_lottery($prize, $id, $openid);
    }
    
    /**
     * 处理概率和奖项
     * @param unknown $prize
     * @param unknown $id
     */
    private function do_lottery($prize, $id, $openid){
        foreach ($prize as $key => $val) {
            $arr[$val['id']] = $val['v'];
        }
        //根据概率获取奖项id
        $rid = $this->get_rands($arr);
        $arr_k = '';
        //如果改奖项没有数量限制，即num 为 -1
        foreach ($prize as $k => $v){
            if($v['id'] == $rid){
                $arr_k = $k;
                break;
            }
        }
        if($prize[$arr_k]['num'] == -1){
            //保存到数据库
            $add = [
                'openid' => $openid,
                'prize_id' => $prize[$arr_k]['id'],
                'prize_name' => $prize[$arr_k]['prize_name'],
                'prize' => $prize[$arr_k]['prize'],
                'create_time' => date('Y-m-d'),
                'is_lottery' => $prize[$arr_k]['is_lottery'],
                'active_id' => $id,
            ];
            $res = $this->Mprize_log->create($add);
            if($add['is_lottery'] == 0){
                $code = -1;
            }else{
                $code = $add['is_lottery'];
            }
            return (['code' => $code, 'msg' => $add['prize'] ]);
        }else{
            //查询数据库，当前中奖id的数量是否已经用完， 如果用完，再抽奖一次
            $num = $this->Mactive_prize->count('num', ['id' => $rid]);
            if($num >= $prize[$arr_k]['num']){
                $ar_k = '';//不中奖数据的索引
                //评定为不中奖
                foreach ($prize as $k => $v){
                    if($v['is_lottery'] == 0){
                        $ar_k = $k;
                        break;
                    }
                }
                $add = [
                    'openid' => $openid,
                    'prize_id' => $prize[$ar_k]['id'],
                    'prize_name' => $prize[$ar_k]['prize_name'],
                    'prize' => $prize[$ar_k]['prize'],
                    'create_time' => date('Y-m-d'),
                    'is_lottery' => $prize[$ar_k]['is_lottery'],
                    'active_id' => $id,
                ];
                $res = $this->Mprize_log->create($add);
                if($add['is_lottery'] == 0){
                    $code = -1;
                }else{
                    $code = $add['is_lottery'];
                }
                return (['code' => $code, 'msg' => $add['prize'] ]);
            }else{
                $add = [
                    'openid' => $openid,
                    'prize_id' => $prize[$arr_k]['id'],
                    'prize_name' => $prize[$arr_k]['prize_name'],
                    'prize' => $prize[$arr_k]['prize'],
                    'create_time' => date('Y-m-d'),
                    'is_lottery' => $prize[$arr_k]['is_lottery'],
                    'active_id' => $id,
                ];
                $res = $this->Mprize_log->create($add);
                if($add['is_lottery'] == 0){
                    $code = -1;
                }else{
                    $code = $add['is_lottery'];
                }
                return (['code' => $code, 'msg' => $add['prize'] ]);
            }
        }
    }
    
    /**
     * 判断当前时间能否进行砸蛋
     * @param  $time 当前时间
     * @param  $start 活动开始时间
     * @param  $end 活动结束时间
     * @param  $no_start_msg 未开始的提示
     * @param  $end_msg 已结束的提示
     */
    private function check_active_time($time, $start, $end, $no_start_msg, $end_msg){
        
        if($time < strtotime($start)){
            return (['code' => 0, 'msg' => $no_start_msg]);
        }else if($time >= strtotime($end)){
            return (['code' => 0, 'msg' => $end_msg]);
        }
    }
    
    /**
     * 得到中奖项的id
     * @param unknown $proArr
     * @return Ambigous <string, unknown>
     */
    private function get_rands($proArr){
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
    
        return $result;
    }
    
    private function check_login($id = 0){
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            $this->session->set_userdata('login_back_url', '/guaguaka/index?active_id='.$id);
            redirect(C('domain.h5.url').'/weixin_login/login');
            exit;
        }
    }
    
}
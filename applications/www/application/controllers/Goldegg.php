<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Goldegg extends MY_Controller{
    private $app;
    private $AppID; //应用ID
    private $AppSecret; //应用密匙
    private $openid = "o-_Sft8oKOymmAjaEEWeOzrCdMbM";
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
                'Model_active' => 'Mactive',
                'Model_active_prize' => 'Mactive_prize',
                'Model_goldegg_log' => 'Mgoldegg_log'
        ));
        //分享用的
        $this->app = C("appid_secret.dashi");
        //艾客逊公众号，用户网页授权
        $this->AppID = C('appid_secret.akx.app_id');
        $this->AppSecret = C('appid_secret.akx.app_secret');
        $this->load->driver('cache');
    }
    
    public function index(){
        $data = $this->data;
        $id = (int) $this->input->get('active_id');
        $info = $this->cache->file->get('goldegg_'.$id);
        if(!$info){
            //根据id获取本次砸金蛋的数据
            $info = $this->Mactive->get_one('*', ['id' => $id, 'is_del' => 0]);
            if($info){
                $this->cache->file->save('goldegg_'.$id, $info, 5*60);//缓存5分钟
            }else{
                show_404();
            }
        }
        
        $data['info'] = $info;
        //查询本次砸金蛋的奖项
        $prize = $this->Mactive_prize->get_lists('*', ['active_id' => $id]);

        $this->load->view('goldegg/index', $data);
    }
    
    /**
     * 砸蛋
     */
    public function zadan(){
        $id = (int) $this->input->get('active_id');
        $info = $this->cache->file->get('goldegg_'.$id);
        if(!$info){
            //根据id获取本次砸金蛋的数据
            $info = $this->Mactive->get_one('*', ['id' => $id, 'is_del' => 0]);
            if($info){
                $this->cache->file->save('goldegg_'.$id, $info, 5*60);//缓存5分钟
            }else{
                $this->return_json(['code' => 0, 'msg' => '活动不存在']);
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
            $res = $this->Mgoldegg_log->count(['openid' => $this->openid, 'active_id' => $id, 'is_lottery' => 1]);
            if(!$res){
                //判断今天抽奖的次数是否已经用完
                $res = $this->Mgoldegg_log->count(['openid' => $this->openid, 'active_id' => $id, 'create_time' => data('Y-m-d')]);
                if($res >= $info['count']){
                    $this->return_json(['code' => 0, 'msg' => '您今天已经抽过'.$info['count'].'奖了！']);
                }
            }
            $this->return_json(['code' => 0, 'msg' => '您已经中过奖了！']);
        }else{
            //判断今天抽奖的次数是否已经用完
            $res = $this->Mgoldegg_log->count(['openid' => $this->openid, 'active_id' => $id, 'create_time' => date('Y-m-d')]);
            if($res >= $info['count']){
                $this->return_json(['code' => 0, 'msg' => '您今天已经抽过'.$info['count'].'奖了！']);
            }
        }
        
        //开始抽奖
        $this->start_lottery($this->openid, $id);
        
    }
    
    private function start_lottery($openid, $id){
        //获取本次的奖项信息
        $prize = $this->cache->file->get('prize_'.$id);
        if(!$prize){
            $prize = $this->Mactive_prize->get_lists('*', ['active_id' => $id]);
            if($prize){
                $this->cache->file->save('prize_'.$id, $prize, 5*60);
            }else{
                $this->return_json(['code' => 0, 'msg' => '请重试！']);
            }
        }
        
        //计算通过奖项信息计算本次的中奖率
        var_dump($prize);exit;
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
            $this->return_json(['code' => 0, 'msg' => $no_start_msg]);
        }else if($time >= strtotime($end)){
            $this->return_json(['code' => 0, 'msg' => $end_msg]);
        }
    }
    
}
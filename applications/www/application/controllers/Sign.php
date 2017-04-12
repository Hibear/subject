<?php
/**
 * 中铁魔都签到系统控制器
 * @author 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Sign extends MY_Controller{

    private $openid = 'o-_Sft8oKOymmAjaEEWeOzrCdMbM';
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
             'Model_gifts' => 'Mgifts',
             'Model_exchange_log' => 'Mexchange_log',
             'Model_sign_user' => 'Msign_user',
             'Model_sign_log' => 'Msign_log'
        ));
        $this->load->driver('cache');
    }
    
    /**
     * 系统首页
     */
    public function index(){
        $data = $this->data;
        
        $data['username'] = 'Apollo';
        $data['userImage'] = 'http://img2.woyaogexing.com/2017/04/10/9679559f6c96342c!400x400_big.jpg';
        
        $this->load->view('sign/index', $data);
    }
    
    /**
     * 签到记录列表
     */
    public function log_list(){
        $data = $this->data;
        //todo 登陆
        $openid = $this->openid;
        $field = 'id, sign_time, score, continuous_days';
        $where = [
            'openid' => $openid
        ];
        $data['list'] = $this->Msign_log->get_lists($field, $where, ['create_time' => 'desc'], $limit = 10);
    }
    
    /**
     * 签到
     */
    public function log(){
        //判断是否已经登陆, 并且已经完善了个人信息 TODO
        
        //判断今天是否已经签到
        $openid = $this->openid;
        $where = [
            'openid' => $openid,
            'sign_time'  => date('Y-m-d')
        ];
        $res = $this->Msign_log->count($where);
        if($res){
            $this->return_json(['code' => 0, 'msg' => '您今天已经签到过了！']);
        }
        //判断昨天是否有签到记录
        $where = [
            'openid' => $this->openid,
            'sign_time'  => date('Y-m-d', strtotime('-1 day'))       
        ];
        $field = 'score, continuous_days';
        $res = $this->Msign_log->get_one($field, $where);
        if(!$res){
            $add = [
                'openid' => $openid,
                'sign_time'  => date('Y-m-d'),
                'continuous_days' => 0, 
                'score' => 1,
                'create_time' => date('Y-m-d H:i:s'),
            ];
            $ret = $this->Msign_log->create($add);
            if($ret){
                //更新用户的总积分
                $this->Msign_user->update_info(['incr' => ['`score`' => 1]], ['openid' => $openid]);
                $this->return_json(['code' => 1, 'msg' => '签到成功！', 'score' => 1]);
            }else{
                $this->return_json(['code' => 0, 'msg' => '请重试！']);
            }
        }else{
            //因为单次增加积分不能超过5个积分，积分的递增为1，所以可以设定连续签到的+5积分的条件为5天，
            //判断是否已经签到超过五天
            $limit = 5;
            if($res['continuous_days'] >= ($limit -1)){
                $add = [
                    'openid' => $openid,
                    'sign_time'  => date('Y-m-d'),
                    'continuous_days' => $res['continuous_days']+1,
                    'score' => $limit,
                    'create_time' => date('Y-m-d H:i:s'),
                ];
                $ret = $this->Msign_log->create($add);
                if($ret){
                    //更新用户的总积分
                    $this->Msign_user->update_info(['incr' => ['`score`' => $limit]], ['openid' => $openid]);
                    $this->return_json(['code' => 1, 'msg' => '签到成功！', 'score' => $limit]);
                }else{
                    $this->return_json(['code' => 0, 'msg' => '请重试！']);
                }
            }else{
                $add = [
                    'openid' => $openid,
                    'sign_time'  => date('Y-m-d'),
                    'continuous_days' => $res['continuous_days']+1,
                    'score' => $res['score'] + 1,
                    'create_time' => date('Y-m-d H:i:s'),
                ];
                $ret = $this->Msign_log->create($add);
                if($ret){
                    //更新用户的总积分
                    $score = $res['score'] + 1;
                    $this->Msign_user->update_info(['incr' => ['`score`' => $score]], ['openid' => $openid]);
                    $this->return_json(['code' => 1, 'msg' => '签到成功！', 'score' => $score]);
                }else{
                    $this->return_json(['code' => 0, 'msg' => '请重试！']);
                }
            }
        }
    }
    
    /**
     * 礼品兑换列表
     */
    public function lists(){
        $data = $this->data;
        //todo 登陆
        $openid = $this->openid;
        $field = '*';
        $where = [
            'openid' => $openid
        ];
        $data['list'] = $this->Mexchange_log->get_lists($field, $where, ['create_time' => 'desc'], $limit = 10);
    }
    
    /**
     * 礼品列表
     */
    public function goods(){
        
    }
    
    /**
     * 礼品详情
     */
    public function detail(){
        $id = $this->input->get('id');
        $info = $this->Mgifts->get_one('*', ['id' => $id]);
    }
    
    /**
     *兑换
     */
    public function exchange(){
        $openid = $this->openid;
        //获取当前用户信息
        $user = $this->Msign_user->get_one('score', ['openid' => $openid]);
        $id = $this->input->get('id');
        //查询兑换的礼品信息， 使用悲观锁
        $this->db->query('lock table t_gifts read');
        $info = $this->Mgifts->get_one('id, title, cover_img, score, num', ['id' => $id, 'is_del' => 0]);
        if($info && ($info['num'] >= 1) && ($user['score'] >= $info['score'])){
            //库存-1
            $this->db->query('lock table t_gifts write');
            $res = $this->Mgifts->update_info(['decr' => ['num' => 1 ]], ['id' => $id]);
            $this->db->query('unlock table');
            //减去用户积分
            if($res){
                $score = (int) $info['score'];
                $ret = $this->Msign_user->update_info(['decr' => ['`score`' => $score]], ['openid' => $openid]);
                //添加兑换记录
                if($ret){
                    $add = [
                        'openid' => $openid,
                        'exchange_goods_id' => $info['id'],
                        'title' => $info['title'],
                        'cover_img' => $info['cover_img'],
                        'score' => $info['score'],
                        'create_time' => date('Y-m-d H:i:s')
                    ];
                    $this->Mexchange_log->create($add);
                    $this->return_json(['code' => 1, 'msg' => '兑换成功！']);
                }else{
                    $this->return_json(['code' => 0, 'msg' => '请重试！']);
                }
            }else{
                $this->Mgifts->update_info(['incr' => ['num' => 1 ]], ['id' => $id]);
                $this->return_json(['code' => 0, 'msg' => '请重试！']);
            }
        }else{
            $this->db->query('unlock table');
            $this->return_json(['code' => 0, 'msg' => '不能兑换！']);
        }
    }
    
    /**
     * 领取
     */
    public function get(){
        $id = $this->input->get('id');
        $openid = $this->openid;
        $res = $this->Mexchange_log->update_info(['status' => 2, 'get_time' => date('Y-m-d H:i:s')], ['id' => $id, 'openid' => $openid]);
        if(!$res) {
            $this->return_json(['code' => 0, 'msg' => '请重试！']);
        }
        $this->return_json(['code' => 1, 'msg' => '领取成功！']);
    }
    
    /**
     * 检测是否登陆
     * @param string $methd 当前检测是否登陆的控制器方法， 便于登陆后返回当前的页面
     */
    private function check_login($methd = 'index'){
        
    }
}
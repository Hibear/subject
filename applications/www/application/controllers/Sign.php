<?php
/**
 * 中铁魔都签到系统控制器
 * @author 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Sign extends MY_Controller{

    private $openid = '';
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
             'Model_gifts' => 'Mgifts',
             'Model_exchange_log' => 'Mexchange_log',
             'Model_game_user' => 'Mgame_user',
             'Model_sign_log' => 'Msign_log'
        ));
        $this->load->driver('cache');
        $this->check_login();
        $user_info = $this->session->userdata('user_info');
        $this->openid = $user_info['openid'];
    }
    
    /**
     * 系统首页
     */
    public function index(){
        $data = $this->data;
        $data['user_info'] = $this->session->userdata('user_info');
        $this->load->view('sign/index', $data);
    }
    
    
    /**
     * 签到记录列表
     */
    public function log_list(){
        $data = $this->data;
        $openid = $this->openid;
        $field = 'id, sign_time, score, continuous_days';
        $where = [
            'openid' => $openid
        ];
        //获取当前用户信息
        $data['userscore'] = $this->Mgame_user->get_one('score', ['openid' => $openid]);
        $data['list'] = $this->Msign_log->get_lists($field, $where, ['create_time' => 'desc'], $limit = 15);
        $this->load->view('sign/log_list',$data);
        
        
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
                $this->Mgame_user->update_info(['incr' => ['`score`' => 1]], ['openid' => $openid]);
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
                    $this->Mgame_user->update_info(['incr' => ['`score`' => $limit]], ['openid' => $openid]);
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
                    $this->Mgame_user->update_info(['incr' => ['`score`' => $score]], ['openid' => $openid]);
                    $this->return_json(['code' => 1, 'msg' => '签到成功！', 'score' => $score]);
                }else{
                    $this->return_json(['code' => 0, 'msg' => '请重试！']);
                }
            }
        }
    }
    
    /**
     * 我的礼品
     */
    public function my_goods(){
        $data = $this->data;
        $openid = $this->openid;
        $field = '*';
        $where = [
            'openid' => $openid
        ];
        $where['status'] = 2;
        $data['userscore'] = $this->Mgame_user->get_one('score', ['openid' => $openid]);
        $data['list'] = $this->Mexchange_log->get_lists($field, $where, ['create_time' => 'desc'], $limit = 10);
        
//         print_r($data);
        
        $this->load->view('sign/mygoods',$data);
        
    }
    /**
     * 未领取礼品列表
     */
    public function get_status_lists(){
        $data = $this->data;
        $openid = $this->openid;
        $field = 'id,title,score,cover_img,create_time,get_time,num,status';
        $status = (int) $this->input->post('status');
        
        $where = [];
        if($status == 2){
            $where['status'] = 2;
        }elseif ($status == 1){
            $where['status <='] = $status;
        }
        
        $where['openid']=  $openid;
        
        $info = $this->Mexchange_log->get_lists($field, $where, ['create_time' => 'desc'], $limit = 10);
        if(!$info){
            $this->return_json(['code' => 0, 'msg' => '没有物品']);
        }
        foreach ($info as $k=>$v){
            if($v['cover_img']){
                $info[$k]['cover_img'] = get_img_url($v['cover_img']);
            }
            $info[$k]['get_time'] = date('Y-m-d',strtotime($v['get_time']));
            $info[$k]['create_time'] = date('Y-m-d',strtotime($v['create_time']));
        }
        $this->return_json(['code' => 1, 'score' => $info]);
        
    }
    
    
    /**
     * 礼品列表
     */
    public function goods(){
        $data = $this->data;
        $openid = $this->openid;
        //获取当前用户信息
        $data['userscore'] = $this->Mgame_user->get_one('score', ['openid' => $openid]);
        $data['list'] = $this->Mgifts->get_lists('id, title, cover_img, score, num', ['is_del' => 0], ['create_time' => 'desc'], $limit = 10);
        $this->load->view('sign/goods',$data);
    }
    
    /**
     * 获取更多礼品
     * @author 254274509@qq.com
     *
     */
    public function load_more(){
    
        $page = (int) $this->input->post('p');
        $page = $page+1;
        $info = $this->Mgifts->get_lists('*',['is_del'=>0], ['create_time' => 'desc' ], $limit = 10, ($page-1)*10);
        if($info){
            $list_data = array(
                'p'=>$page,
                'list'=>$info,
                'status'=>0
            );
        }else{
            $list_data = array(
                'list'=>'',
                'status'=>-1
            );
        }
        $this->return_json($list_data);
    }
    
    /**
     * 礼品详情
     */
    public function detail(){
        
        $openid = $this->openid;
        //获取当前用户信息
        $data['userscore'] = $this->Mgame_user->get_one('score', ['openid' => $openid]);
        $id = $this->input->get('id');
        $data['info'] = $this->Mgifts->get_one('*', ['id' => $id]);
        $this->load->view('sign/detail',$data);
        
    }
    
    /**
     *兑换
     */
    public function exchange(){
        $openid = $this->openid;
        //获取当前用户信息
        $user = $this->Mgame_user->get_one('score', ['openid' => $openid]);
        $id = $this->input->post('id');
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
                $ret = $this->Mgame_user->update_info(['decr' => ['`score`' => $score]], ['openid' => $openid]);
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
                    $user_score = $this->Mgame_user->get_one('score', ['openid' => $openid]);
                    $this->return_json(['code' => 1, 'msg' => '兑换成功！','score'=>$user_score]);
                }else{
                    $this->Mgifts->update_info(['incr' => ['num' => 1 ]], ['id' => $id]);
                    $this->return_json(['code' => 0, 'msg' => '请重试！']);
                }
            }else{
                $this->return_json(['code' => 0, 'msg' => '请重试！']);
            }
        }else{
            $this->db->query('unlock table');
            $this->return_json(['code' => 0, 'msg' => '积分不够！或库存不足']);
        }
    }
    
    /**
     * 领取
     */
    public function get(){
        $id = $this->input->post('sign_id');
        $openid = $this->openid;
        $res = $this->Mexchange_log->update_info(['status' => 2, 'get_time' => date('Y-m-d H:i:s')], ['id' => $id, 'openid' => $openid]);
        if(!$res) {
            $this->return_json(['code' => 0, 'msg' => '请重试！']);
        }
        $this->return_json(['code' => 1, 'msg' => '领取成功！']);
    }
    
    /**
     * 认证用户
     * 认证完成后，可以获得+10积分
     */
    public function renzheng(){
        $openid = $this->openid;
        $realname = trim($this->input->post('realname'));
        if(!$realname){
            $this->return_json(['code' => 0, 'msg' => '姓名不能为空！']);
        }
        $tel = trim($this->input->post('tel'));
        if(!$tel){
            $this->return_json(['code' => 0, 'msg' => '手机号不能为空！']);
        }
        $addr = trim($this->input->post('addr'));
        if(!$addr){
            $this->return_json(['code' => 0, 'msg' => '地址不能为空！']);
        }
        if(!preg_match(C('regular_expression.mobile'), $tel)){
            $this->return_json(['code' => 0, 'msg' => '手机号格式不正确！']);
        }
        //判断手机号是否已经被使用
        $info = $this->Mgame_user->count(['tel' => $tel]);
        if($info == 1){
            $this->return_json(['code' => 0, 'msg' => '手机号已经被注册过了！']);
        }
        $add = [
            'realname' => $realname,
            'tel' => $tel,
            'addr' => $addr, 
            'status' => 1, 
            'incr' => [
                '`score`' => 10
            ]
        ];
        $res = $this->Mgame_user->create($add);
        if(!$res){
            $this->return_json(['code' => 0, 'msg' => '请重试！']);
        }
        $this->return_json(['code' => 1, 'msg' => '认证成功']);
    }
    
    /**
     * 检测是否登陆
     * @param string $methd 当前检测是否登陆的控制器方法， 便于登陆后返回当前的页面
     */
    private function check_login(){
        $user_info = $this->session->userdata('user_info');
        if(!$user_info){
            $this->session->set_userdata('login_back_url', '/sign/index');
            redirect(C('domain.h5.url').'/weixin_active_login/login');
            exit;
        }
    }
}
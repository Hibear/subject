<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Weixin extends MY_Controller{
    public $app;
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
                'Model_weixin_lottery_user' => 'Muser',
                'Model_lottery_log' => 'Mlottery_log',
                'Model_vote_log' => 'Mvote_log',
                'Model_performer' => 'Mperformer',
                'Model_weixin_active' => 'Mweixin_active'
        ));
        $this->app = C("appid_secret.dashi");
    }
    
    /**
     * 验证用户open_id的有效性
     */
    private function check_openid($open_id){
        if($this->session->has_userdata($open_id)){
            return true;
        }else{
            $access_token = $this->getAccessToken();
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$open_id.'&lang=zh_CN';
            $res = json_decode($this->httpGet($url));
            if(isset($res->errcode) && $res->errcode == 40001){
                //access_token过期,再执行一次
                $this->cache->file->delete('access_token');
                $access_token = $this->getAccessToken();
                $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$open_id.'&lang=zh_CN';
                $res = json_decode($this->httpGet($url));
                if(isset($res->subscribe) && $res->subscribe == 1){
                    $this->session->set_userdata($open_id, 1);
                    return true;
                }else{
                    return false;
                }
            }else{
                if(isset($res->subscribe) && $res->subscribe == 1){
                $this->session->set_userdata($open_id, 1);
                    return true;
                }else{
                    return false;
                }
            }
            
        }
        
    }


    /**
     * 投票列表页
     * @author 254274509@qq.com
     */
    public function lists(){
        $data = $this->data;
        $open_id = trim($this->input->get('openid'));
        if(!empty($open_id)){
            $this->session->set_userdata('xitai_user', $open_id);
        }
        //获取页面的访问量
        $data['total_visits'] = $this->total_visits();
        //统计投票信息
        $data['total_vote_num'] = $this->Mperformer->get_one('sum(vote_num) as total',['is_del' => 0]);
        //统计参与选手
        $data['performer_num'] = $this->Mperformer->count(['is_del' => 0]);

        $order_by = ['id' => 'asc'];

        $fields = 'id,fullname,title,cover_img,vote_num,desc';
        $info = $this->Mperformer->get_lists($fields ,['is_del' => 0], $order_by, 8);

        $data['p'] = 1;

        $data['info'] = $info;
        //分享
        $data['title'] = "贵阳方舟戏台演员投票";
        $data['link'] = C("domain.www.url")."/weixin/lists";
        $data['imgUrl'] = C("domain.www.url")."/uploads/images/fangzhou/fangzhouheadPic.jpg";
        $data['desc'] = "贵阳方舟戏台演员投票";
        
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
        
        $this->load->view('weixin/index', $data);
    }

    /**
     * 演员详情页
     * @return [type] [description]
     */
    public function detail(){

        $data = $this->data;
        $performer_id = $this->input->get('id');

        $info = $this->Mperformer->get_one('*', ['id' => $performer_id]);
        $data['info'] = $info;

        //获取个人排名
        $list = $this->Mperformer->get_lists('*', ['is_del' => 0],['vote_num' => 'desc', 'create_time' => 'desc']);
        if($list){
            foreach ($list as $key => $value) {
                if($value['id'] == $info['id']){
                    $data['info']['order'] = $key+1;
                }
            }
        }

        $this->Mperformer->update_info(['incr' => ['visits'=>1]], ['id' => $info['id']]);
        $open_id = $this->session->userdata('xitai_user');
        if($open_id){
            $where = ['open_id' => $open_id, "year(create_time)" => date('Y'), "month(create_time)" => date('m'), "day(create_time)" => date('d'), 'is_del' => 0];
            $infos = $this->Mvote_log->count($where);
            if($infos == 3){
                $data['status'] = 1;
            }
        }
        
        //分享
        $data['title'] = $info['id'].'号选手'.$info['fullname']."演员的投票";
        $data['link'] = C("domain.www.url")."/weixin/detail?id=".$info['id'];
        $data['imgUrl'] = C("domain.www.url")."/uploads/images/fangzhou/fangzhouheadPic.jpg";
        $data['desc'] = "贵阳方舟戏台{$info['fullname']}演员的投票";
        
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
        
        $this->load->view('weixin/user',$data);
    }


    /**
     * 搜索
     *
     * */
    public function search_name(){
        $find = $this->input->post('find');//编号或者姓名
        if(empty($find)) {
            $this->return_json('nodata');
        }
        $where['is_del'] = 0;
        $where['or'] = ['id' => $find, 'fullname' => $find];
        $info = $this->Mperformer->get_lists("id,fullname,title,cover_img,desc,vote_num", $where);
        if(!$info){
            $this->return_json('nodata');
        }
        $this->return_json($info[0]);


    }

    /*
     * 获取排行
     *
     * */

    public function ranks(){
        $list = $this->Mperformer->get_lists('*', ['is_del' => 0],['vote_num' => 'desc', 'create_time' => 'desc']);
        $this->return_json($list);
    }

    /**
     * 获取更多投票列表
     * @author 254274509@qq.com
     *
     */
    public function get_more(){

        $page = (int) $this->input->post('p');

        $fields = 'id,fullname,title,cover_img,vote_num,desc';
        $page = $page+1;
        $info = $this->Mperformer->get_lists($fields, array('is_del'=>0), ['id' => 'asc'], 8, ($page-1)*8);
        
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

    private function total_visits(){
        $this->load->driver('cache');
        if($this->cache->file->get('visits') == 100){
            $this->cache->file->save('visits', 0, 24*60*60);
            $this->Mweixin_active->update_info(['incr' => ['visits' => 100]], ['id' => 1]);
        }else{
            $num = $this->cache->file->get('visits');
            $this->cache->file->save('visits', $num+1, 24*60*60);
        }
        $res = $this->Mweixin_active->get_one('visits', ['id' => 1]);
        
        return $res['visits'] +$this->cache->file->get('visits');
    }
    
     // public function vote_shell(){
       // $openid = 'yonghua';
       // $get_openid = trim($this->input->get('openid'));
       // $vote_num = mt_rand(1, 100);
       // if($openid == $get_openid){
       //    $res =  $this->Mperformer->update_info(['incr' => ['vote_num'=>$vote_num]], ['id' => 8]);
       //    if($res){
       //        echo '本次添加：'.$vote_num.' 票';
       //    }
       // }
    //}
    
    /**
     * 给演员投票
     * @author 254274509@qq.com
     * @return bool;
     */
    public function vote_to_performer(){
        $data = $this->data;
        //判断是否已经登录
	    $now_time = strtotime(date('Y-m-d H:i:s'));
        $end_time = strtotime('2017-03-15 23:30:59');
        if($now_time >= $end_time){
            $this->return_json(['code' => -1, 'msg' => '本次投票已经结束，谢谢参与！']);
        }
        $open_id = $this->session->userdata('xitai_user');
        if(empty($open_id)){
            $this->return_json(['code' => -1, 'msg' => '请先关注微信公众号,回复“投票”进入本页面！']);
        }
        if(!$this->check_openid($open_id)){
            $this->return_json(['code' => 0, 'msg' => '凭证过期，请重新刷新！']);
        }
        $performer_id = (int) $this->input->post('token_id');
        $res = $this->check_vote($open_id, $performer_id);
        if($res != 1){
            $this->return_json(['code' => 0, 'msg' => $res]);
        }
        $add['open_id'] = $open_id;
        $add['performer_id'] = $performer_id;
        $add['vote_num'] = 1;
        $add['create_time'] = date('Y-m-d H:i:s');
        $res = $this->Mvote_log->create($add);
        if(!$res){
            $this->return_json(['code' => 0, 'msg' => '投票失败！']);
        }
        //演员的投票数增加1;
        $this->Mperformer->update_info(['incr' => ['vote_num'=>1]], ['id' => $performer_id]);
        if($this->check_lottery()){
            //具备进入抽奖的页面的条件
            $this->return_json(['code' => 1, 'msg' => '投票成功！', 'status' => 1]);
        }

        $this->return_json(['code' => 1, 'msg' => '投票成功！']);
    }

    private function check_lottery(){
        //判断今天是否已经投过三票并且没有抽过奖
        $data = $this->data;
        $open_id = $this->session->userdata('xitai_user');
        $where = ['open_id' => $open_id, "year(create_time)" => date('Y'), "month(create_time)" => date('m'), "day(create_time)" => date('d'), 'is_del' => 0];
        $info = $this->Mvote_log->count($where);
        $res = $this->Mlottery_log->count($where);
        if($info == 3 && $res == 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * [check_vote 判断今天是否能投票]
     * @author 254274509@qq.com
     * @param  [tint] $user_id      [投票者]
     * @param  [type] $performer_id [演员]
     * @return [bool]
     */
    private function check_vote($open_id,$performer_id){
        //判断今天是否已经投过三票
        $where = ['open_id' => $open_id, "year(create_time)" => date('Y'), "month(create_time)" => date('m'), "day(create_time)" => date('d'), 'is_del' => 0];
        $info = $this->Mvote_log->count($where);
        if($info >= 3){
            return '您今天已经投完三票了，请明天再来！';
        }
        $where = ['open_id' => $open_id, 'performer_id' => $performer_id, "year(create_time)" => date('Y'), "month(create_time)" => date('m'), "day(create_time)" => date('d'), 'is_del' => 0];
        $info = $this->Mvote_log->count($where);


        if(!$info){
            return 1;
        }
        return '您今天已经给该演员投过票了，请明天再来！';
    }
    
    private function getAccessToken() {
        $this->load->driver('cache');
        if(!$this->cache->file->get('access_token')){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".C('appid_secret.xitai.app_id')."&secret=".C('appid_secret.xitai.app_secret');
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $this->cache->file->save('access_token', $access_token, 7000);
                return $access_token;
            }
        }else{
            return $this->cache->file->get('access_token');
        }
        
        
    }
    
    private function httpGet($url) {
        $curl = curl_init();
        @curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        @curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        @curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        @curl_setopt($curl, CURLOPT_URL, $url);
    
        $res = curl_exec($curl);
        curl_close($curl);
    
        return $res;
    }
}

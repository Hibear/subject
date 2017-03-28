<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comment extends MY_Controller
{
    private $pid = 7;
    private $AppID; //应用ID
    private $AppSecret; //应用密匙

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Model_user_comment' => 'Muser_comment',
        ));
        //艾客逊公众号，用户网页授权
        $this->AppID = C('appid_secret.akx.app_id');
        $this->AppSecret = C('appid_secret.akx.app_secret');
        $this->load->driver('cache');
        $param = array(
            'app_id' => $this->AppID,
            'app_secret' => $this->AppSecret,
            'per' => 'akx_'    //缓存前缀
        );
        $this->load->library('jssdk', $param);
    }

    public function weixin_login()
    {
        if ($this->check_login()) {
            //已经登录后不再拉取网页授权，直接跳转到游戏页面
            $back_url = C('domain.h5.url') . '/comment';
            redirect($back_url);
            exit;
        }
        $data = $this->data;
        $redirect_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->AppID;
        $redirect_url .= '&redirect_uri=' . urlencode($this->data['domain']['www']['url'] . '/comment/get_access_token');
        $redirect_url .= "&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header('location:' . $redirect_url);
        exit;
    }


    /**
     * 2 setup 非静默授权
     * 通过code换取网页授权获取access_token、openid
     */
    public function get_access_token()
    {
        $code = $this->input->get('code');
        if (empty($code)) {
            $this->return_failed('获取信息失败！');
        }
        $openid_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->AppID}&secret={$this->AppSecret}&code={$code}&grant_type=authorization_code";
        $openid_ch = curl_init();
        curl_setopt($openid_ch, CURLOPT_URL, $openid_url);
        curl_setopt($openid_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($openid_ch, CURLOPT_SSL_VERIFYPEER, 0);
        $openid_data = curl_exec($openid_ch);
        curl_close($openid_ch);
        $openid_arr = json_decode($openid_data, true);
        //如果拉取不到用户openid信息
        if (!isset($openid_arr['openid'])) {
            $this->return_failed('获取信息失败！');
        }
        $openid = $openid_arr['openid'];
        $access_token = $openid_arr['access_token'];
        $refresh_token = $openid_arr['refresh_token'];
        //判断access_token是否过期
        $check_access_token_url = "https://api.weixin.qq.com/sns/auth?access_token={$access_token}&openid={$openid} ";
        $check_data = json_decode($this->httpGet($check_access_token_url), true);
        if (isset($check_data['errcode']) && $check_data['errcode'] == 0) {
            //没有过期
            $res = array(
                'openid' => $openid,
                'access_token' => $access_token
            );
        } else {
            $refresh = $this->refresh_token($refresh_token);
            $res = array(
                'openid' => $refresh['openid'],
                'access_token' => $refresh['access_token']
            );
        }
        $user_info = $this->get_weixin_user_info($res);
        //将用户信息保存到会话
        $this->session->set_userdata('comment_user_info', $user_info);
        $back_url = C('domain.h5.url') . '/comment';
        redirect($back_url);
        exit;

    }

    /**
     * 3 setup 非静默授权
     * 获取用户信息
     * @param [openid access_token] $res
     * @return mixed
     */
    private function get_weixin_user_info($res)
    {
        if (!$res) {
            $this->return_failed('获取授权信息失败！');
        }
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $res['access_token'] . '&openid=' . $res['openid'] . '&lang=zh_CN';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }

    /**
     * 刷新access_token
     * @param unknown $refresh_token
     */
    private function refresh_token($refresh_token)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$this->AppID}&grant_type=refresh_token&refresh_token={$refresh_token}";
        $refresh_data = json_decode($this->httpGet($url), true);
        return $refresh_data;
    }

    //检查登录
    private function check_login()
    {

        $user_info = $this->session->userdata('comment_user_info');
        if ($user_info) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add(){

        $data = $this->data;
        if (!$this->check_login()) {
            //跳转到微信登录
            $this->weixin_login();
            exit();
        }


        
        $this->return_json(['code' => 1, 'info'=>'恭喜你传送成功']);
    }

    public function comit()
    {
        $data = $this->data;
        $data['signPackage'] = $this->jssdk->getSignPackage();
      $inputis->input->post('input_1');
        $this->input->post('input_2');
        $this->input->post('score_all');
        $this->input->post('image_num');
        
        
        $this->load->view('comment/commit_f', $data);
    }
    

    public function contnt()
    {

        $data = $this->data;
        $user_info = $this->session->userdata('comment_user_info');
        
        print_r($user_info);
        
        $this->load->view('comment/content_f');
    }

    public function index_com()
    {

        $this->load->view('comment/index');
    }


//================================================================================================


    /**
     * 获取排行榜 getrank
     * @author 254274509@qq.com
     */
    public function getrank()
    {

        $lists = $this->cache->file->get('lists');
        if (!$lists) {
            $sql = 'SELECT * FROM(select * from (select id,openid,game_time from t_game_log where is_del = 0 order by game_time) a group by a.openid) b ORDER BY b.game_time asc limit 11;';
            $query = $this->db->query($sql);
            $lists = [];
            foreach ($query->result_array() as $row) {
                $lists[] = $row;
            }
            if (!$lists) {
                $this->return_json(['code' => 0, 'info' => 'nodata']);
            } else {
                $this->cache->file->delete('play_num');
                $this->cache->file->save('lists', $lists, 3 * 60);
            }
        }


        //获取用户信息
        $openids = array_column($lists, 'openid');
        $user_list = $this->Mlottery_users->get_lists('openid,name', ['in' => ['openid' => $openids]]);
        if ($user_list) {
            foreach ($lists as $k => $v) {
                foreach ($user_list as $key => $val) {
                    if ($v['openid'] == $val['openid']) {
                        $lists[$k]['name'] = $val['name'];
                    }
                }
            }
        }

        $my_game_info = -1;
        //判断当前用户成绩是否在前十yi
        if ($this->session->has_userdata('game_user_info')) {
            $game_user_info = $this->session->userdata('game_user_info');
            $openid = $game_user_info['openid'];
            foreach ($lists as $key => $val) {
                if ($openid == $val['openid']) {
                    $my_game_info = $key;
                }
            }
        }
        foreach ($lists as $k => $v) {
            unset($lists[$k]['openid']);
        }
        $this->return_json(['code' => 1, 'info' => $lists, 'my_info' => $my_game_info]);
    }

    /**
     * 保存用户电话姓名
     * @return [type] [description]
     */
    public function update_user()
    {
        if (!$this->check_login()) {
            //跳转到微信登录
            $this->weixin_login();
            exit();
        }
        $game_user_info = $this->session->userdata('game_user_info');
        $openid = $game_user_info['openid'];
        $post = $this->input->post();
        $up['name'] = trim($post['name']);
        $up['tel'] = trim($post['tel']);
        if (empty($up['name'])) {
            $this->return_json(['code' => 0, 'msg' => '姓名不能为空！']);
        }
        if (empty($up['tel'])) {
            $this->return_json(['code' => 0, 'msg' => '电话不能为空！']);
        }
        if (!preg_match('/^1[3|4|5|8|7][0-9]\d{8}$/', $up['tel'])) {
            $this->return_json(['code' => 0, 'msg' => '手机号格式不正确！']);
        }
        $res = $this->Mlottery_users->update_info($up, ['openid' => $openid, 'pid' => $this->pid]);
        if (!$res) {
            $this->return_json(['code' => 0, 'msg' => '请重试！']);
        }
        $this->return_json(['code' => 1, 'msg' => '完成']);
    }


    /**
     * 保存游戏成绩
     * @return [type] [description]
     */
    public function game_log()
    {
        //判断活动是否能够进行
        //获取活动详情
        $active = $this->cache->file->get('2049_game');
        if (!$active) {
            $active = $this->Mactive->get_one('start_time, end_time', ['id' => 4]);
            $this->cache->file->save('2049_game', $active, 5 * 60);//缓存5分钟
        }
        if (!$active) {
            $this->return_json(['code' => 0, 'msg' => '活动不存在']);
        }
        $now_time = strtotime(date('Y-m-d H:i:s'));
        $end_time = strtotime($active['end_time']);
        $start_time = strtotime($active['start_time']);
        if ($now_time < $start_time) {
            $this->return_json(['code' => 0, 'msg' => '本次活动还未开始，请等待！']);
        }
        if ($now_time >= $end_time) {
            $this->return_json(['code' => 0, 'msg' => '本次活动已经结束，谢谢参与！']);
        }
        if (!$this->check_login()) {
            //跳转到微信登录
            $this->weixin_login();
            exit();
        }
        $game_user_info = $this->session->userdata('game_user_info');
        $openid = $game_user_info['openid'];

        $post['game_time'] = trim($this->input->post('game_time'));
        if (empty($post['game_time'])) {
            $this->return_json(['code' => 0, 'msg' => '请先玩一把游戏再来提交成绩哦！']);
        }
        if ($post['game_time'] < 15) {
            $this->return_json(['code' => 0, 'msg' => '请不要作弊哦！']);
        }
        $post['openid'] = $openid;
        $post['create_time'] = date('Y-m-d H:i:s');
        $res = $this->Mgame_log->create($post);
        if (!$res) {
            $this->return_json(['code' => 0, 'msg' => '添加记录失败']);
        }
        $count = $this->Mgame_log->count(['openid' => $openid]);
        //如果是第一次添加游戏记录
        $status = -1;
        if ($count == 1) {
            $name = $game_user_info['nickname'];
            $this->Mlottery_users->create(['name' => $name, 'create_time' => date('Y-m-d H:i:s'), 'openid' => $openid, 'pid' => $this->pid]);
            $status = 1;
        }
        $this->return_json(['code' => 1, 'status' => $status]);
    }

    private function getAccessToken() {
        $this->load->driver('cache');
        if(!$this->cache->file->get('access_token')){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".C('appid_secret.akx.app_id')."&secret=".C('appid_secret.akx.app_secret');
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $this->cache->file->save('akx_access_token', $access_token, 7000);
                return $access_token;
            }
        }else{
            return $this->cache->file->get('akx_access_token');
        }  
    }

    private function httpGet($url)
    {
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
    
    public function download(){
        $media_id = trim($this->input->get('media_id'));
        if(empty($media_id)){
            exit();
        }
        
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$this->jssdk->getAccessToken()."&media_id={$media_id}";
        //获取微信“获取临时素材”接口返回来的内容（即刚上传的图片）
        $handle = file_get_contents($url);
        //以读写方式打开一个文件，若没有，则自动创建  
        $resource = fopen("../../uploads/image/weixin/{$media_id}.jpg" , 'w+');
        //将图片内容写入上述新建的文件  
        fwrite($resource, $handle);
        //关闭资源  
        fclose($resource);
        echo 'weixin/'.$media_id.'.jpg';
    }
}


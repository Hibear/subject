<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Game extends MY_Controller{
    public $app;
    private $session_name = 'game_openid';
    private $game_nickname = 'game_nickname';
    private $pid = 6;
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
                'Model_game_log' => 'Mgame_log',
                'Model_lottery_users' => 'Mlottery_users',
                'Model_weixin_active' => 'Mweixin_active'
        ));
        $this->app = C("appid_secret.dashi");
        $this->load->driver('cache');
    }
    
    public function index(){
        $data = $this->data;
        //生成csrf防止篡改成绩
        if($this->session->has_userdata('csrf')){
            unset($_SESSION['csrf']);
        }
        $token = md5(time());
        $data['_csrf'] = $token;
        $this->session->set_userdata('csrf', $token);
        $openid = trim($this->input->get('openid'));
        if(!empty($openid)){
            if($this->check_openid($openid)){
                $this->session->set_userdata($this->session_name, $openid);
                $data['status'] = 0;
            }else{
                $data['status'] = 1;
            }
        }else{
        	//提醒关注微信
        	$data['status'] = 1;
        }
        //统计玩家数量
        $play_num = $this->cache->file->get('play_num');
        if(!$play_num){
            $sql = 'select count(*) as num from t_game_log where is_del = 0 group by openid';
            $query = $this->db->query($sql);
            $list = [];
            foreach ($query->result_array() as $row){
                $list[] = $row;
            }
            $data['game_num'] = count($list);
            $this->cache->file->save('play_num', count($list), 3*60);
        }
        $data['game_num'] = $play_num;

        //分享
        $data['title'] = "2049小游戏";
        $data['link'] = C("domain.www.url")."/game";
        $data['imgUrl'] = C("domain.www.url")."/static/game/images/mofang.png";
        $data['desc'] = "2049小游戏";
        
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);

        $this->load->view('game/index', $data);
    }

    /**
     * 获取排行榜 getrank
     * @author 254274509@qq.com
     */
    public function getrank(){
    	$list = $this->cache->file->get('list');
    	if(!$list){
    	    $sql = 'SELECT * FROM(select * from (select id,openid,game_time from t_game_log where is_del = 0 order by game_time limit 10) a group by a.openid) b ORDER BY b.game_time asc;';
    	    $query = $this->db->query($sql);
    	    $this->db->last_query();
    	    $lists = [];
    	    foreach ($query->result_array() as $row){
    	        $lists[] = $row;
    	    }
    	    if(!$lists){
    	        $this->return_json(['code' => 0, 'info' => 'nodata']);
    	    }
    	    $this->cache->file->save('list', $list, 3*60);//缓存3分钟
    	}
        $user_list = $this->cache->file->get('user_list');
    	if(!$user_list){
    	    //获取用户信息
    	    $openids = array_column($lists, 'openid');
    	    $user_list = $this->Mlottery_users->get_lists('openid,name', ['in' => ['openid' => $openids]]);
    	    if($user_list){
    	        foreach ($lists as $k => $v) {
    	            $lists[$k]['name'] = '匿名用户';
    	            foreach ($user_list as $key => $val) {
    	                if($v['openid'] == $val['openid']){
    	                    $lists[$k]['name'] = $val['name'];
    	                }
    	            }
    	        }
    	    }
    	    $this->cache->file->save('user_list', $user_list, 3*60);//缓存3分钟
        }
    	
    	$my_game_info = null;
    	//判断当前用户成绩是否在前十
    	if($this->session->has_userdata($this->session_name)){
    		$openid = $this->session->userdata($this->session_name);
    		foreach ($lists as $key => $val) {
    			if($openid == $val['openid']){
    				$my_game_info = $key;
    			}
    		}
    	}
    	foreach ($lists as $k => $v){
    	    unset($lists[$k]['openid']);
    	}
    	$this->return_json(['code' => 1, 'info' => $lists, 'my_info' => $my_game_info]);
    }
    
    /**
     * 保存用户电话姓名
     * @return [type] [description]
     */
    public function update_user(){
    	$post = $this->input->post();
    	$up['name'] = trim($post['name']);
    	$up['tel'] = trim($post['tel']);
    	$openid = $this->session->userdata($this->session_name);
    	if(empty($openid)){
            $this->return_json(['code' => 0, 'msg' => '请先关注微信公众号！']);
        }
        if(empty($up['name'])){
            $this->return_json(['code' => 0, 'msg' => '姓名不能为空！']);
        }
        if(empty($up['tel'])){
            $this->return_json(['code' => 0, 'msg' => '电话不能为空！']);
        }
        if(!preg_match('/^1[3|4|5|8|7][0-9]\d{8}$/', $up['tel'])){
            $this->return_json(['code' => 0, 'msg' => '手机号格式不正确！']);
        }
        $res = $this->Mlottery_users->update_info($up, ['openid' => $openid,'create_time' => date('Y-m-d H:i:s'), 'pid' => $this->pid]);
        if(!$res){
            $this->return_json(['code' => 0, 'msg' => '请重试！']);
        }
        $this->return_json(['code' => 1, 'msg' => '完成']);
    }
    
    /**
     * 判断是否来自移动端
     * @return boolean
     */
    private function is_mobile(){
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
            return true;
        
            //此条摘自TPM智能切换模板引擎，适合TPM开发
            if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
                return true;
                //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
                if (isset ($_SERVER['HTTP_VIA']))
                    //找不到为flase,否则为true
                    return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
                    //判断手机发送的客户端标志,兼容性有待提高
                    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
                        $clientkeywords = array(
                            'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
                        );
                        //从HTTP_USER_AGENT中查找手机浏览器的关键字
                        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                            return true;
                        }
                    }
                    //协议法，因为有可能不准确，放到最后判断
                    if (isset ($_SERVER['HTTP_ACCEPT'])) {
                        // 如果只支持wml并且不支持html那一定是移动设备
                        // 如果支持wml和html但是wml在html之前则是移动设备
                        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                            return true;
                        }
                    }
                    return false;
    }
    
    //封禁用户
    private function stop_openid(){
        if($this->cache->file->get($this->session_name)){
            $num = $this->cache->file->get($this->session_name);
            if(num >= 3){
                $num = $this->Mgame_log->count(['is_del' => 0]);
                if($num > 0){
                    //取消所有成绩
                    $this->Mgame_log->update_info(['is_del' => 1, 'update_time' => date('Y-m-d H:i:s')], ['openid' => $this->session_name]);
                }
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }
    
    private function add_error_num(){
        if($this->cache->file->get($this->session_name)){
            $num = $this->cache->file->get($this->session_name);
            $this->cache->file->save($this->session_name, $num+1, 3*24*3600);
        }else{
            $this->cache->file->save($this->session_name, 1, 3*24*3600);
        }
    }


    /**
     * 保存游戏成绩
     * @return [type] [description]
     */
    public function game_log(){
        //判断活动是否能够进行
        $now_time = strtotime(date('Y-m-d H:i:s'));
        $end_time = strtotime('2017-03-19 23:59:59');
        $start_time = strtotime('2017-03-16 00:00:00');
        if($now_time < $start_time){
            $this->return_json(['code' => 0, 'msg' => '本次活动还未开始，请等待！']);
        }
        if($now_time >= $end_time){
            $this->return_json(['code' => 0, 'msg' => '本次活动已经结束，谢谢参与！']);
        }
        //判断是否存在openid
        $openid = $this->session->userdata($this->session_name);
        if(empty($openid)){
            $this->return_json(['code' => 0, 'msg' => '请先关注微信公众号,回复“2049” 参与游戏！']);
        }
        //判断openid的有效性
        if(!$this->check_openid($openid)){
            $this->return_json(['code' => 0, 'msg' => '用户凭证失效，请重试！']);
        }
        //判断用户作弊次数如果达到3次，否则不予参与本次活动
        if($this->stop_openid()){
            $this->return_json(['code' => 0, 'msg' => '您因作弊，所有成绩无效！']);
        }
        //判断请求是否来自移动端
        if(!$this->is_mobile()){
            $this->return_json(['code' => 0, 'msg' => '请不要作弊哦！']);
        }
        //校验token
        $_csrf = trim($this->input->post('_csrf'));
        if(!$_csrf || ($_csrf != $this->session->userdata('csrf'))){
            $this->add_error_num();//增加一次作弊统计
            $this->return_json(['code' => 0, 'msg' => '请不要作弊哦！']);
        }
        unset($_POST['_csrf']);
    	$post['game_time'] = trim($this->input->post('game_time'));
    	if(empty($post['game_time'])){
    	    $this->add_error_num();//增加一次作弊统计
    		$this->return_json(['code' => 0, 'msg' => '请先玩一把游戏再来提交成绩哦！']);
    	}
        if($post['game_time'] < 15){
            $this->add_error_num();//增加一次作弊统计
            $this->return_json(['code' => 0, 'msg' => '请不要作弊哦！']);
        }
    	$post['openid'] = $openid;
    	$post['create_time'] = date('Y-m-d H:i:s');
		$res = $this->Mgame_log->create($post);
		if(!$res){
			$this->return_json(['code' => 0, 'msg' => '添加记录失败']);
		}
		$count = $this->Mgame_log->count(['openid' => $openid]);
		//如果是第一次添加游戏记录
        $status = -1;
		if($count == 1){
			$name = '';
			if($this->session->has_userdata($this->game_nickname)){
				$name = $this->session->userdata($this->game_nickname);
			}
			$this->Mlottery_users->create(['name' => $name,'create_time'=> date('Y-m-d H:i:s'),'openid' => $openid, 'pid' => $this->pid]);
			$status = 1;
		}
		$this->return_json(['code' => 1, 'status' => $status]);
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
                $this->cache->file->delete('akx_access_token');
                $access_token = $this->getAccessToken();
                $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$open_id.'&lang=zh_CN';
                $res = json_decode($this->httpGet($url));
                if(isset($res->subscribe) && $res->subscribe == 1){
                    $this->session->set_userdata($this->game_nickname, $res->nickname);
                    $this->session->set_userdata($open_id, 1);
                    return true;
                }else{
                    return false;
                }
            }else{
                if(isset($res->subscribe) && $res->subscribe == 1){
                $this->session->set_userdata($this->game_nickname, $res->nickanme);
                $this->session->set_userdata($open_id, 1);
                    return true;
                }else{
                    return false;
                }
            }
            
        }
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


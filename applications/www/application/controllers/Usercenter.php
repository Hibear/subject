<?php 
/**
 * 会员中心控制器
 * @author jianming@gz-zc.cn
 */
defined('BASEPATH') or exit('No direct script access allowed');    
class Usercenter extends MY_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model([
                'Model_user' => 'Muser',
                'Model_user_extend' => 'Muser_extend',
                'Model_house_order' => 'Mhouse_order',
                'Model_allowance_log' => 'Mallowance_log',
                'Model_house_assess' => 'Mhouse_assess',
                'Model_message' => 'Mmessage',
                'Model_message_info' => 'Mmessage_info'
        ]);

        //如果用户未登陆跳转到登录页
        $user_id = (int)$this->data['user_info']['user_id'];
        if (! $user_id){
            header('location:' . C('domain.base.url') .'/passport/login');
        }

        //获取用户信息
        $user_info = $this->http_request('user/info', array('user_id' => $this->data['user_info']['user_id']));
        if(isset($user_info['status']) && $user_info['status'] == 0) {
            $user_info = $user_info['data']['user_info'];
        }
        $this->data['info'] = $user_info;

        //未读消息
        $this->data['count_no_read'] = $this->Mmessage_info->count(array('is_read' => 0, 'in' => array('receiver' => array(0, $this->data['info']['user_id']))));

        $this->data['action'] = '';
        $this->avatar_config = C('avatar');
    }
    
    /**
     * 个人资料修改
     */
    public function index() {
        $data = $this->data;
        $data['act'] = 'info';
        $data['education'] = array_column(C('user_center.education'),'name','id');
        $data['occupation'] = array_column(C('user_center.occupation'),'name','id');
        $this->load->view("user/info", $data);
    }


    /**
     * 修改用户头像
     */
    public function set_portrait(){
        $portrait_config = C('upload.portraint');
        $portrait = upload_file('portrait',  $portrait_config);
        if ($portrait['flag']){
            $save_data['portrait'] = $portrait['data']['file_name'];
            list($width, $height) = getimagesize($this->avatar_config['path']. $save_data['portrait']);
            if ($width > $this->avatar_config['resize']['width'] || $height >$this->avatar_config['resize']['height']){
                //压缩到裁剪框制定大小(600x300)
                $this->load->library('image_lib');
                $config['image_library'] = $this->avatar_config['image_library'];
                $config['quality'] = $this->avatar_config['quality'];
                $config['source_image'] = $this->avatar_config['path']. $save_data['portrait'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] =  $this->avatar_config['resize']['width'];
                $config['height'] = $this->avatar_config['resize']['height'];
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
            }
            list($width, $height) = getimagesize($this->avatar_config['path']. $save_data['portrait']);
            $this->return_json(array('status'=>0,'width'=> $width,'height'=>$height,'url'=> $this->data['domain']['img']['url'] .'/portrait/'.$portrait['data']['file_name']));
        }else{
            $this->return_json(array('status'=>1,'width'=> 0,'height'=>0,'url'=>'','msg'=>'图片只能是：'.$portrait_config['allowed_types'].'类型,大小不能超过：'.$portrait_config['max_size'].'kb，宽高不能超过:'.$portrait_config['max_width'].'X'.$portrait_config['max_height']));
        }
    }



    /**
     * 头像裁剪
     */
    public function cut_img(){
        $user_id = (int)$this->data['user_info']['user_id'];

        $x = (int) $this->input->post('x');
        $y = (int) $this->input->post('y');
        $w = (int) $this->input->post('w');
        $h = (int) $this->input->post('h');
        $img_url = $this->input->post('img_url');
        if (empty($img_url) || ! $w){
            $this->return_json("参数错误");
        }

        $this->load->library('image_lib');
        $file_name = substr($img_url, strpos($img_url, "/portrait")+9);
        $source_file = $this->avatar_config['path'].$file_name;

        list($width, $height) = getimagesize($source_file);
        if ($width > $w || $height > $h){
            $config['image_library'] = $this->avatar_config['image_library'];
            $config['quality'] = $this->avatar_config['quality'];
            $config['source_image'] = $source_file;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $w ;
            $config['height'] = $h ;
            $config['x_axis'] = $x;
            $config['y_axis'] = $y;

            $this->image_lib->initialize($config);

            $this->image_lib->crop();
        }

        $this->return_json(array('status'=>0,'url'=> $file_name, 'full_url' => get_portrait_url($file_name), 'msg'=>'保存成功'));
    }


    /** 
     * 保存用户信息
     */
    public function save_info() {
        $user_id = $this->input->post('user_id');

        //更新t_user表
        $user_data['phone_number'] = $this->input->post('phone_number');
        $user_data['portrait'] = $this->input->post('portrait');
        $result = $this->http_request('user/update', ['data' => $user_data, 'id' => $user_id]);
        if(isset($result['status']) && $result['status'] == 0) {
            //更新t_user_extend表
            $user_extend_data['nickname'] = $this->input->post('nickname');
            $user_extend_data['sex'] = $this->input->post('sex');
            $user_extend_data['home_addr'] = $this->input->post('home_addr');
            $user_extend_data['now_addr'] = $this->input->post('now_addr');
            $user_extend_data['email'] = $this->input->post('email');
            $user_extend_data['education'] = $this->input->post('education');
            $user_extend_data['occupation'] = $this->input->post('occupation');
            $extend = $this->http_request('user/update_extend', ['data' => $user_extend_data, 'user_id' => $user_id]);
            if ($extend) {
                $this->return_json(array('msg'=>'保存成功'));
            } else {
                $this->return_json(array('msg'=>'保存失败'));
            }
        } else {
            $this->return_json(array('msg'=>'保存失败'));
        }
        
    }


    /**
     * 修改密码 
     */
    public function modify_pwd() {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->input->post('user_id');
            $user_info = $this->Muser->get_one('*', array('id' => $user_id));
            if (!$user_info) {
                $this->return_json(array('flag' => false,'msg'=>'没有该用户信息'));
            }

            $old_pwd = get_encode_pwd($this->input->post('old_pwd'));
            if ($old_pwd != $user_info['password']) {
                $this->return_json(array('flag' => false,'msg'=>'原密码错误'));
            } 

            $save_data['password'] = get_encode_pwd($this->input->post('confirm_pwd'));
            $result = $this->http_request('user/update', ['data' => $save_data, 'id' => $user_id]);
            if(isset($result['status']) && $result['status'] == 0) {
                $this->return_json(array('flag' => true,'msg'=>'修改密码成功'));
            } else {
                $this->return_json(array('flag' => false,'msg'=>'修改密码失败'));
            }
        } else {
            $data = $this->data;
            $data['act'] = 'resetpwd';
            $this->load->view('user/modify_pwd', $data);
        }
    }


    /**
     * 身份认证
     */
    public function authenticate() {
        if ($this->input->is_ajax_request()) {
            $post_data = $this->input->post();
            $result = $this->http_request('user/update_extend', ['data' => $post_data, 'user_id' => $this->data['info']['user_id']]);
            if ($result) {
                //更新用户表认证状态为审核中
                $this->http_request('user/update', ['data' => array('auth_status' => 1), 'id' => $this->data['info']['user_id']]);
                
                $this->return_json(array('flag' => true,'msg'=>'提交审核成功'));
            } else {
                $this->return_json(array('flag' => false,'msg'=>'提交审核失败'));
            }
        } else {    
            $data = $this->data;
            $data['act'] = 'auth';
            $this->load->view('user/identity', $data);
        }
    }


    /**
     * 立即重新认证
     */
    public function re_auth() {
        //清空审核未通过的身份信息
        $extend_data = array('card_number' => '', 'card_front' => '', 'card_back' => '', 'reason' => '');
        $this->http_request('user/update_extend', ['data' => $extend_data, 'user_id' => $this->data['info']['user_id']]);
        
        //更新用户表认证状态为未认证
        $this->http_request('user/update', ['data' => array('auth_status' => 0), 'id' => $this->data['info']['user_id']]);
        
        header('location:' . C('domain.base.url') .'/usercenter/authenticate');
    }


    /**
     * 购房申请查询
     */
    public function buy_apply() {
        $data = $this->data;
        $data['act'] = 'apply';
        $data['order'] = $this->Mhouse_order->get_order_lists(array('A.user_id' => $data['info']['user_id']));
        $this->load->view('user/buy_apply', $data);
    }


    /**
     * 回执单页面
     */
    public function receipt($id) {
        $data = $this->data;
        $data['info'] = $this->Mhouse_order->get_order_by_where(array('A.id' => $id))[0];
        $this->load->view('user/receipt', $data);
    }


    /**
     * 购房补贴查询
     */
    public function buy_allowance() {
        $data = $this->data;
        $data['act'] = 'allowance';
        $data['order'] = $this->Mallowance_log->get_allowance_log(array('B.user_id' => $data['info']['user_id']));
        $this->load->view('user/buy_allowance', $data);
    }


    /**
     * 我的消息
     */
    public function message($params = '') {
        $data = $this->data;
        $data['act'] = 'message';
        $where = array('is_read' => 0, 'in' => array('receiver' => array(0, $data['info']['user_id'])));

        if ($params == 'all') {
            $where = array('in' => array('receiver' => array(0, $data['info']['user_id'])));
            $data['tag'] = 'all';
        }

        //未读数量
        $data['no_read_count'] = $this->Mmessage_info->count(array('is_read' => 0, 'in' => array('receiver' => array(0, $data['info']['user_id']))));

        //全部消息数量
        $data['all_count'] = $this->Mmessage_info->count(array('in' => array('receiver' => array(0, $data['info']['user_id']))));

        //消息列表
        $user_msg = $this->Mmessage_info->get_lists('*', $where);
        if (!$user_msg) {
            $data['message'] = array();
        } else {
            $message_ids = array_column($user_msg, 'message_id');
            $data['message'] = $this->Mmessage->get_lists('*', array('in' => array('id' => $message_ids), 'is_del' => 0));
            if ($data['message']) {
                foreach ($user_msg as $key => $val) {
                    if (isset($data['message'][$key]) && $data['message'][$key]['id'] == $val['message_id']) {
                        $data['message'][$key]['info_id'] = $val['id'];
                        $data['message'][$key]['receiver'] = $val['receiver'];
                        $data['message'][$key]['is_read'] = $val['is_read'];
                    }
                }
            }
        }
        $this->load->view('user/message', $data);
    }


    /**
     * 标记为已读
     */
    public function mark_read() {
        $ids = $this->input->post("ids");

        if (!$ids) {
            $this->return_json(array('flag' => false,'msg'=>'网络错误！请重试！'));
        }

        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        $result = $this->Mmessage_info->update_info(array('is_read' => 1), array('in' => array('id' => $ids)));
        if ($result) {
            $this->return_json(array('flag' => true,'msg'=>'标记成功！'));
        } else {
            $this->return_json(array('flag' => false,'msg'=>'标记失败！'));
        }
    }


    /**
     * 删除消息
     */
    public function del_msg() {
        $ids = $this->input->post('ids');
        if (!$ids) {
            $this->return_json(array('flag' => false,'msg'=>'网络错误！请重试！'));
        }
        $result = $this->Mmessage_info->delete(array('in' => array('id' => $ids)));
        if ($result) {
            $this->return_json(array('flag' => true,'msg'=>'删除成功！'));
        } else {
            $this->return_json(array('flag' => false,'msg'=>'删除失败！'));
        }
    }



    /**
     * 我的点评
     */
    public function comment() {
        $data = $this->data;
        $data['act'] = 'comment';
        $data['assess'] = $this->Mhouse_assess->get_assess(array('A.user_id' => $data['info']['user_id']));
        $this->load->view('user/comment', $data);
    }
}
?>

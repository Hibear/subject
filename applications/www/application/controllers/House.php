<?php
defined('BASEPATH') or exit('No direct script access allowed');
class House extends MY_Controller{
    public $app;
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
                'Model_weixin_active' => 'Mweixin_active'
        ));
        $this->app = C("appid_secret.txfc");
    }
    
    /**
     * 购房趣味小测试
     * @author yonghua 254274509@qq.com
     */
    public function index(){
        $data = $this->data;
        //设置token, 防止恶意刷新
        $this->session->set_userdata('house_token', time());
        //获取当前参加测试的人数
        $info = $this->Mweixin_active->get_one('visits', ['id' => 2]);
        $data['num']  = $info['visits'];
        
        //分享
        $data['title'] = "315 买房上当傻瓜指数大测试 80%的人都说准！";
        $data['link'] = C("domain.www.url")."/house";
        $data['imgUrl'] = C("domain.www.url")."/static/game/images/house.png";
        $data['desc'] = "“房子延期交房”、“说好的学区房怎么又上不了”、“精装房质量问题多”、“‘电梯惊魂’频上演“……多少人在买房的过程中傻傻的被开发商蒙蔽了眼睛，为此，小编特地制作了“315购房防上当小测试”，快来点击参与吧！";
        
        $data['signPackage'] = $this->share($this->app['app_id'],$this->app['app_secret']);
        $this->load->view('house/house_test', $data);
    }

    public function getresult(){
        //更新参与的人数
        if($this->session->has_userdata('house_token')){
           $this->Mweixin_active->update_info(['incr' => ['visits'=>1]], ['id' => 2]);
           $score = (int) $this->input->post('total');
           if($score >=0 && $score <= 8){
                $this->return_json(['code' => 1, 'type' => '百度全科型', 'msg' => '你是个不服输而行动力强的人，不容易上当受骗的，智商棒棒哒，骗子顶多能骗到你几百块钱']);
           }else if($score >=9 && $score <=13){
                $this->return_json(['code' => 1, 'type' => '正常地球人型', 'msg' => '你有不会被骗的自信，能够准确的判断对方的动机，正常骗子骗不到你，买房时还是带上父母亲人一起吧']);
           }else if($score >=14 && $score <=17){
                $this->return_json(['code' => 1, 'type' => '天真无邪型', 'msg' => '你的钱太好骗了，你经常有被坏人引诱的危险，简直是骗子的最爱，购房应该谨慎']);
           }else{
                $this->return_json(['code' => 1, 'type' => '涉世未深型', 'msg' => '你偶尔会忘记带脑子出门，主要看当天运气，因此凡事需谨慎小心']);
           }
        }else{
            $this->return_json(['code' => 0, 'msg' => '捣乱的请走开']);
        }
        
    }
}

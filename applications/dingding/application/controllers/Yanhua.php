<?php 
/**
* 烟花控制器
* @author 1034487709@qq.com
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Yanhua extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
             'Model_lottery' => 'Mlottery',
        ]);
        $this->data['code'] = 'weixin_manage';
        $this->data['active'] = 'yanhua_list';
    }
    

    /**
     * 烟花
     */
    public function index() {
        $data = $this->data;
        if(IS_POST){
			/*$data = array(
				'name'=>$this->input->post("name"),
				'switch'=>$this->input->post("switch")
			);*/
			$data = $this->input->post();
			$res =  $this->Mlottery->update_info($data,array("pid"=>1));
			 $this->success("添加成功！","/yanhua");
		}
		$data['lottery'] = $this->Mlottery->get_one("*",array("pid"=>1));
		$this->load->view("fireworks/add", $data);
    }

	
	


}


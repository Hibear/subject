<?php 
/**
 * 国宾府业主调查问卷
 * @author shunyu
 */
defined('BASEPATH') or exit('No direct script access allowed');    
class Questionnaire extends MY_Controller{
	
	
    public function __construct() {
        parent::__construct();
        $this->load->model([
                'Model_questionnaire' => 'Mquestionnaire'
        ]);

	}
	
    /**
     * 首页
     */
    public function index() {
        $data = $this->data;
	
		
        $this->load->view("questionnaire/index", $data);
    }
	
	
	//添加问题
	public function add_question(){
		$_POST['create_time'] = time();
		if(empty($_POST['question'])){
			$this->return_json(array('msg'=>"提交成功","code"=>0));
		}
		$res = $this->Mquestionnaire->create($_POST);
		if($res){
			$this->return_json(array('msg'=>"提交成功","code"=>0));
		}
		else
		{
			$this->return_json(array('msg'=>"请不要重复提交","code"=>1));
		}
		
	}

	

}
?>

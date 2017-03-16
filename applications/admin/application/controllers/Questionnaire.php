<?php 
/**
* 国宾府业主调查问卷
* @author 1034487709@qq.com
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Questionnaire extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
             'Model_questionnaire' => 'Mquestionnaire',
        ]);
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'questionnaire_list';
    }
    

    /**
     * 参与人员列表
     */
    public function index() {
        $data = $this->data;
        $pageconfig = C('page.page_lists');
        $this->load->library('pagination');
        $page = $this->input->get_post('per_page') ? : '1';

		$where =  array();
        if ($this->input->get('tel')) $where['tel'] = $this->input->get('tel');
        if ($this->input->get('name')) $where['name'] = $this->input->get('name');

        $data['tel'] = $this->input->get('tel');
        $data['name'] = $this->input->get('name');

        $data['list'] = $this->Mquestionnaire->get_lists("*", $where, array("create_time" => "DESC"), $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        $data_count = $this->Mquestionnaire->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;

        //获取分页
        $pageconfig['base_url'] = "/questionnaire";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息
		$this->load->view("questionnaire/index", $data);
    }

	
	
	    /**
     * 中奖人员
     */
    public function export() {
        //加载phpexcel
        $this->load->library("PHPExcel");

        //设置表头
        $table_header =  array(
            '姓名'=>"name",
            '手机号'=>"tel",
            '问题'=>"question",
            '答案'=>"answer",
        );

        $i = 0;
        foreach($table_header as  $kk=>$v){
            $cell = PHPExcel_Cell::stringFromColumnIndex($i).'1';
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue($cell, $kk);
            $i++;
        }

        $where =  array();
        if ($this->input->get('tel')) $where['tel'] = $this->input->get('tel');
        if ($this->input->get('name')) $where['name'] = $this->input->get('name');
		$list = $this->Mquestionnaire->get_lists($where);
		
        $h = 2;
        foreach($list as $key=>$val){

            $j = 0;
            foreach($table_header as $k => $v){
                $cell = PHPExcel_Cell::stringFromColumnIndex($j++).$h;
				$this->phpexcel->getActiveSheet(0)->setCellValue($cell, $val[$v].' ');
            }
            $h++;
        }

        $this->phpexcel->setActiveSheetIndex(0);
        // 输出
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=问卷人员.xls');
        header('Cache-Control: max-age=0');
		

        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save('php://output');
    }



}


<?php 
/**
* 活动报名人员控制器
* @author 1034487709@qq.com
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Registerusers extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
             'Model_register_uers' => 'Mregister_uers',
         
        ]);
        $this->data['code'] = 'sign_manage';
        $this->data['active'] = 'speak_list';
    }
    

    /**
     * 演说家报名人员列表
     */
    public function index() {
        $data = $this->data;
        $pageconfig = C('page.page_lists');
        $this->load->library('pagination');
        $page = $this->input->get_post('per_page') ? : '1';
		$data['active_name'] = C("active_name");
		
        $where =  array();
        if ($this->input->get('create_time')) $where['like']['create_time'] = $this->input->get('create_time');
        if($this->input->get('name')){
			$where['pid'] = $this->input->get('name');
		}else{
			$where['pid'] = 1;
		}
		
		
		
        $data['name'] = $this->input->get('name');
        $data['create_time'] = $this->input->get('create_time');

        $data['list'] = $this->Mregister_uers->get_lists("*", $where, array("create_time" => "DESC"), $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        $data_count = $this->Mregister_uers->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;

        //获取分页
        $pageconfig['base_url'] = "/registerusers";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息

        $this->load->view("registerusers/index", $data);
    }



    /**
     * 报名人员
     */
    public function export() {
        //加载phpexcel
        $this->load->library("PHPExcel");

        //设置表头
        $table_header =  array(
            '姓名'=>"name",
            '手机号'=>"tel",
			"报名时间"=>'create_time'
        );
        $i = 0;
        foreach($table_header as  $key=>$v){
            $cell = PHPExcel_Cell::stringFromColumnIndex($i).'1';
			
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue($cell, $key);
            $i++;
        }

        $where =  array();
		 if($this->input->get('name')){
			$where['pid'] = $this->input->get('name');
		}else{
			$where['pid'] = 1;
		}
        if ($this->input->get('create_time')) $where['like']['create_time'] = $this->input->get('create_time');
        $list = $this->Mregister_uers->get_lists('name,tel,create_time', $where, array('create_time' => 'DESC'));
		
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
        header('Content-Disposition: attachment;filename=中奖名单.xls');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save('php://output');
    }




}


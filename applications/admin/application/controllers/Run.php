<?php 
/**
* 助力控制器
* @author 1034487709@qq.com
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Run extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
             'Model_run_users' => 'Mrun_users',
             'Model_run_usersupport' => 'Mrun_usersupport',
             'Model_lottery' => 'Mlottery',
        ]);
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'run_list';
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
		$users_lists = $this->Mrun_users->count_users($where,$pageconfig['per_page'],($page-1)*$pageconfig['per_page']);
		
        $data['list'] =$users_lists['lists'];
		
		
        $data['data_count'] = $users_lists['count'];
        $data['page'] = $page;

        //获取分页
        $pageconfig['base_url'] = "/run";
        $pageconfig['total_rows'] = $users_lists['count'];
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息

        $this->load->view("run/index", $data);
    }

	
	
	    /**
     * 中奖人员
     */
    public function export() {
        //加载phpexcel
        $this->load->library("PHPExcel");

        //设置表头
        $table_header =  array(
            '微信号名'=>"wetcaht_name",
            '姓名'=>"name",
            '手机号'=>"tel",
            '助力人数'=>"nums",
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
		$list = $this->Mrun_users->count_users($where);
		
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
        header('Content-Disposition: attachment;filename=助力人员名单.xls');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save('php://output');
    }



}


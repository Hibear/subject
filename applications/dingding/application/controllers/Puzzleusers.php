<?php 
/**
* 调查问卷控制器
* @author jianming@gz-zc.cn
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Puzzleusers extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
             'Model_puzzle_users' => 'Mpuzzle_users',
        ]);
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'puzzle_users_list';
    }
    

    /**
     * 调查参与人员列表
     */
    public function index() {
        $data = $this->data;
        $pageconfig = C('page.page_lists');
        $this->load->library('pagination');
        $page = $this->input->get_post('per_page') ? : '1';

		$where['is_win'] = 1;
        if ($this->input->get('phone_number')) $where['phone_number'] = $this->input->get('phone_number');
        if ($this->input->get('user_name')) $where['like']['user_name'] = $this->input->get('user_name');

        $data['phone_number'] = $this->input->get('phone_number');
        $data['user_name'] = $this->input->get('user_name');
        $data['create_time'] = $this->input->get('create_time');
        $data['is_win'] = $this->input->get('is_win');

        $data['list'] = $this->Mpuzzle_users->get_lists("*", $where, array("create_time" => "DESC"), $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        $data_count = $this->Mpuzzle_users->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;

        //获取分页
        $pageconfig['base_url'] = "/puzzleusers";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息

        $this->load->view("puzzle/index", $data);
    }



    /**
     * 导出调查参与人员
     */
    public function export() {
        //加载phpexcel
        $this->load->library("PHPExcel");

        //设置表头
        $table_header =  array(
            '姓名'=>"user_name",
            '手机号'=>"phone_number",
            '参与时间'=>"create_time"
        );

        $i = 0;
        foreach($table_header as  $k=>$v){
            $cell = PHPExcel_Cell::stringFromColumnIndex($i).'1';
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue($cell, $k);
            $i++;
        }

        $where =  array();
        $where['is_win'] = 1;
        if ($this->input->get('phone_number')) $where['phone_number'] = $this->input->get('phone_number');
        if ($this->input->get('user_name')) $where['like']['user_name'] = $this->input->get('user_name');

        $list = $this->Mpuzzle_users->get_lists('*', $where, array('create_time' => 'DESC'));

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
        header('Content-Disposition: attachment;filename=拼图游戏通关人员.xls');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save('php://output');
    }


}


<?php 
/**
* 演说家报名人员控制器
* @author 1034487709@qq.com
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Fireworks extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
             'Model_lottery_users' => 'Mlottery_users',
        ]);
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'fireworks_list';
    }
    

    /**
     * 中奖人员列表
     */
    public function index() {
        $data = $this->data;
        $pageconfig = C('page.page_lists');
        $this->load->library('pagination');
        $page = $this->input->get_post('per_page') ? : '1';
       
        $where =  array();
		$where['level<>'] = 0; 
		$where['pid'] = $this->input->get('pid') ? $this->input->get('pid') : '1';
        if ($this->input->get('tel')) $where['tel'] = $this->input->get('tel');
        if ($this->input->get('name')) $where['like']['name'] = $this->input->get('name');
        if ($this->input->get('create_time')) $where['like']['create_time'] = $this->input->get('create_time');

        $data['pid'] = $this->input->get('pid');
        $data['tel'] = $this->input->get('tel');
        $data['name'] = $this->input->get('name');
        $data['create_time'] = $this->input->get('create_time');

        $data['list'] = $this->Mlottery_users->get_lists("*", $where, array("create_time" => "DESC"), $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        $data_count = $this->Mlottery_users->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;

        //获取分页
        $pageconfig['base_url'] = "/fireworks";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息
		$data['active_name'] = C("active_name");

        $this->load->view("fireworks/index", $data);
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
            '等级'=>"level",
            '奖品'=>"level_name",
            '兑奖编号'=>"number",
        );

        $i = 0;
        foreach($table_header as  $kk=>$v){
            $cell = PHPExcel_Cell::stringFromColumnIndex($i).'1';
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue($cell, $kk);
            $i++;
        }

        $where =  array();
		$where['pid'] = $this->input->get('pid') ? $this->input->get('pid') : '1';
        if ($this->input->get('tel')) $where['tel'] = $this->input->get('tel');
        if ($this->input->get('tel')) $where['tel'] = $this->input->get('tel');
        if ($this->input->get('name')) $where['like']['name'] = $this->input->get('name');
        $list = $this->Mlottery_users->get_lists('*', $where, array('create_time' => 'DESC'));
		
        $h = 2;
        foreach($list as $key=>$val){

            $j = 0;
            foreach($table_header as $k => $v){
                $cell = PHPExcel_Cell::stringFromColumnIndex($j++).$h;
                if ($v == 'level') {
                    switch ($val['level']) {
                        case '0':
                            $val[$v] = "未中奖";
                            break;
                        case '1':
                            $val[$v] = "一等奖";
                            break;
                        case '2':
                            $val[$v] = "二等奖";
                            break;
                        case '3':
                            $val[$v] = "三等奖";
                            break;
                        case '4':
                            $val[$v] = "四等奖";
                            break;
						 case '5':
                            $val[$v] = "五等奖";
                            break;
                        case '6':
                            $val[$v] = "六等奖";
                            break;
                        case '7':
                            $val[$v] = "七等奖";
                            break;	
						case '8':
                            $val[$v] = "八等奖";
                            break;
                    }
                }
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


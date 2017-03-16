<?php 
/**
* 演说家报名人员控制器
* @author jianming@gz-zc.cn
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Speakusers extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
             'Model_users' => 'Musers',
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

        $where =  array();
        if ($this->input->get('phone_number')) $where['phone_number'] = $this->input->get('phone_number');
        if ($this->input->get('user_name')) $where['like']['user_name'] = $this->input->get('user_name');
        if ($this->input->get('create_time')) $where['like']['create_time'] = $this->input->get('create_time');

        $data['phone_number'] = $this->input->get('phone_number');
        $data['user_name'] = $this->input->get('user_name');
        $data['create_time'] = $this->input->get('create_time');

        $data['list'] = $this->Musers->get_lists("*", $where, array("create_time" => "DESC"), $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        $data_count = $this->Musers->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;

        //获取分页
        $pageconfig['base_url'] = "/questionusers";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息

        $this->load->view("speakusers/index", $data);
    }



    /**
     * 导出演说家报名人员
     */
    public function export() {
        //加载phpexcel
        $this->load->library("PHPExcel");

        //设置表头
        $table_header =  array(
            '姓名'=>"user_name",
            '手机号'=>"phone_number",
            '报名时间'=>"create_time",
        );

        $i = 0;
        foreach($table_header as  $k=>$v){
            $cell = PHPExcel_Cell::stringFromColumnIndex($i).'1';
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue($cell, $k);
            $i++;
        }

        $where =  array();
        if ($this->input->get('phone_number')) $where['phone_number'] = $this->input->get('phone_number');
        if ($this->input->get('user_name')) $where['like']['user_name'] = $this->input->get('user_name');
        if ($this->input->get('create_time')) $where['like']['create_time'] = $this->input->get('create_time');
        $list = $this->Musers->get_lists('*', $where, array('create_time' => 'DESC'));

        $h = 2;
        foreach($list as $key=>$val){

            $j = 0;
            foreach($table_header as $k => $v){
                $cell = PHPExcel_Cell::stringFromColumnIndex($j++).$h;
                if ($v == 'win_level') {
                    switch ($val['win_level']) {
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
                            $val[$v] = "三等奖（公仔一个）";
                            break;
                        case '4':
                            $val[$v] = "三等奖（明星玩偶一个）";
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
        header('Content-Disposition: attachment;filename=演说家报名人员列表.xls');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save('php://output');
    }


}


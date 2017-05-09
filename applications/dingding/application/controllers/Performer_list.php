<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Performer_list extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
                'Model_lottery_log' => 'Mlottery_log',
                'Model_weixin_lottery_user' => 'Mweixin_lottery_user'
        ));
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'performer_list';
    }

    public function index(){
    	$data = $this->data;
    	$pageconfig = C('page.page_lists');
        $this->load->library('pagination');
        $page = $this->input->get_post('per_page') ? : '1';
        $tel = trim($this->input->get('tel'));
        $open_ids= [];
        if($tel){
        	//根据手机号查询openid
        	$data['tel'] = $tel;
        	$info = $this->Mweixin_lottery_user->get_one('openid', ['tel' => $tel]);
        	if($info){
        		$open_ids[] = $info['openid'];
        	}
        }
        $fullname = trim($this->input->get('fullname'));
        if($fullname){
        	//根据姓名查询openid
        	$data['fullname'] = $fullname;
        	$where['like'] = ['fullname' => $fullname];
        	$info = $this->Mweixin_lottery_user->get_lists('openid', $where);
        	if($info){
        		foreach ($info as $key => $value) {
        			$open_ids[] = $value['openid'];
        		}
        	}
        	unset($where['like']);
        }
        $open_ids = array_unique($open_ids);
        if($open_ids){
        	$where['in']['open_id'] = $open_ids;
        }
        $where['in']['level'] = [1,5];
        $data['list'] = $this->Mlottery_log->get_lists("*", $where, array("create_time" => "DESC"), $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
        if($data['list']){
        	//获取本次查询的openid,查询用户的姓名和电话
        	$openids = array_column($data['list'], 'open_id');
        	if($openids){
        		$info_list = $this->Mweixin_lottery_user->get_lists('openid,fullname, tel', ['in' => ['openid' => $openids]]);
        		if($info_list){
        			foreach ($data['list'] as $k => $v) {
        				$data['list'][$k]['fullname'] = '';
        				$data['list'][$k]['tel'] = '';
        				foreach ($info_list as $key => $val) {
        					if($v['open_id'] == $val['openid']){
        						$data['list'][$k]['fullname'] = $val['fullname'];
        						$data['list'][$k]['tel'] = $val['tel'];
        					}
        				}
        			}
        		}
        	}
        	
        }
        $data_count = $this->Mlottery_log->count($where);
        $data['data_count'] = $data_count;
        $data['page'] = $page;

        //获取分页
        $pageconfig['base_url'] = "/performer_list";
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息
		$data['active_name'] = C("active_name");
    	$this->load->view('performer_list/index', $data);
    }

    /**
     * 中奖人员
     */
    public function export() {
        //加载phpexcel
        $this->load->library("PHPExcel");

        //设置表头
        $table_header =  array(
        	'编号'=>"id",
            '姓名'=>"fullname",
            '手机号'=>"tel",
            '微信openid'=>"open_id",
            '奖品'=>"lottery_info",
            '中奖时间' => 'create_time'
        );

        $i = 0;
        foreach($table_header as  $kk=>$v){
            $cell = PHPExcel_Cell::stringFromColumnIndex($i).'1';
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue($cell, $kk);
            $i++;
        }

        $where =  array();
        $where['in']['level'] = [1,5];
        $list = $this->Mlottery_log->get_lists("*", $where, array("create_time" => "DESC"));
        if($list){
        	//获取本次查询的openid,查询用户的姓名和电话
        	$openids = array_column($list, 'open_id');
        	if($openids){
        		$info_list = $this->Mweixin_lottery_user->get_lists('openid,fullname, tel', ['in' => ['openid' => $openids]]);
        		if($info_list){
        			foreach ($list as $k => $v) {
        				$list[$k]['fullname'] = '';
        				$list[$k]['tel'] = '';
        				foreach ($info_list as $key => $val) {
        					if($v['open_id'] == $val['openid']){
        						$list[$k]['fullname'] = $val['fullname'];
        						$list[$k]['tel'] = $val['tel'];
        					}
        				}
        			}
        		}
        	}
        	
        }
		
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
        header('Content-Disposition: attachment;filename=方舟戏曲大转盘中奖名单.xls');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save('php://output');
    }
}
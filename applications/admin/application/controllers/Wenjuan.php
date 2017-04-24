<?php
/**
 * 后台礼品管理
 * @author 254274509@qq.com
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Wenjuan extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
             'Model_wenjuan' => 'Mwenjuan'
        ));
        $this->data['code'] = 'question_manage';
        $this->data['active'] = 'gifts_list';
    }

    public function download(){
        $data = $this->data;
        $lists = $this->Mwenjuan->get_lists('id,info,create_time,class,age,yj,zutuan,sex');
        if($lists){
            foreach ($lists as $k => $v){
                if($v['sex'] == 1){
                    $lists[$k]['sex'] = '男';
                }else{
                    $lists[$k]['sex'] = '女';
                }
                $tmp = (array) json_decode($v['info']);
                //var_dump($tmp);exit;
                foreach ($tmp as $key => $val){
                    $val = (array) $val;
                    $lists[$k]['ty'] = '';
                    if(isset($val['ty']) && $val['ty']){
                        $lists[$k]['ty'] = implode(';', $val['ty']);
                    }
                    $lists[$k]['sh'] = '';
                    if(isset($val['sh']) && $val['sh']){
                        $lists[$k]['sh'] = implode(';', $val['sh']);
                    }
                    $lists[$k]['wy'] = '';
                    if(isset($val['wy']) && $val['wy']){
                        $lists[$k]['wy'] = implode(';', $val['wy']);
                    }
                    $lists[$k]['jz'] = '';
                    if(isset($val['jz']) && $val['jz']){
                        $lists[$k]['jz'] = implode(';', $val['jz']);
                    }
                }
                unset($tmp);
                unset($lists[$k]['info']);
                $lists[$k]['class'] = implode(';', (array) json_decode($v['class']));
                unset($lists[$k]['info']);
            }
            
        }
        
        //导出
        $this->export($lists);
    }
    
    private function export($lists) {
        //加载phpexcel
        $this->load->library("PHPExcel");
    
        //设置表头
        $table_header =  array(
            '编号'=>"id",
            '类型'=>"class",
            '年龄'=>"age",
            '性别' => 'sex',
            '意见'=>"yj",
            '组团'=>"zutuan",
            '体育类' => 'ty',
            '生活类' => 'sh',
            '文艺类' => 'wy',
            '讲座类' => 'jz',
            '时间' => 'create_time'
        );
    
        $i = 0;
        foreach($table_header as  $kk=>$v){
            $cell = PHPExcel_Cell::stringFromColumnIndex($i).'1';
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue($cell, $kk);
            $i++;
        }
    
        $where =  array();
        $where['in']['level'] = [1,5];
        
    
        $h = 2;
        foreach($lists as $key=>$val){
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
        header('Content-Disposition: attachment;filename=中天未来方舟调查问卷'.date("YmdHis").'.xls');
        header('Cache-Control: max-age=0');
    
        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save('php://output');
    }
}
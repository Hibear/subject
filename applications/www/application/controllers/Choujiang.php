<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Choujiang extends MY_Controller{
	
    public function __construct(){
        parent::__construct();
    }
    
    
    /*
    * 
 	* 抽奖设置
    */
    public function index(){
        $data = $this->data;
        $prize_config = C('prize');
        $data['prize_level'] = json_encode($prize_config['set']);
        $data['prize_name'] = json_encode($prize_config['name']);
		$this->load->view("Choujiang/index", $data);
    }

    //进入抽奖
    public function prize() {  
        $level = $this->input->get('level') ? $this->input->get('level') : 5;  
        $num = $this->input->get('num') ? $this->input->get('num') : 1;  
        $min = $this->input->get('min') ? $this->input->get('min') : 1;  
        $max = $this->input->get('max') ? $this->input->get('max') : 1;  

		$prize = '';
        if (file_exists("logs/choujiang/prize.txt")) {
			$prize = implode(',', json_decode(file_get_contents("logs/choujiang/prize.txt"),true));
		}

        $level_arr = array();
        if (file_exists("logs/choujiang/level".$level.".txt")) {
            $level_arr = json_decode(file_get_contents("logs/choujiang/level".$level.".txt"),true);
        }

        $remaincount = C('prize.set')[$level] - count($level_arr);
        $has_own_number = $level_arr ? implode(',', $level_arr) : '';
        $this->load->view('Choujiang/prize',array(  
            'level' => $level,  
            'num' => $num,  
            'min' => $min,  
            'max' => $max,  
            'prize' => $prize,
            'allcount' => count(array_filter(explode(',', $prize))),
            'levelcount' => count($level_arr),
            'allownum' => C('prize.set')[$level],
            'remaincount' => $remaincount,
            'prizename' => C('prize.name')[$level],
            'has_own_number' => $has_own_number
        ));  
    }  


    public function data() {  
        $min=$this->input->post('min');  
        $max=$this->input->post('max');  
        $arr = array();  
        for($i = $min;$i <= $max; $i++){  
            $arr[] = array(  
                'number' =>str_pad($i, 3, 0, STR_PAD_LEFT) ,//控制显示数字固定位四位数  
            );  
        }  
        echo json_encode($arr);  
    }

    public function updateprize() {
        $level = $this->input->post("level");
    	$number_arr = $this->input->post("numberArr");
    	if ($number_arr) {
            $this->create_dir('logs/choujiang'); //如果不存在则自动创建文件夹

            $level_arr = $number_arr;
            if (file_exists("logs/choujiang/level".$level.".txt")) {
                $level_arr = json_decode(file_get_contents("logs/choujiang/level".$level.".txt"),true);
                $level_arr = array_unique(array_merge($level_arr, $number_arr));
            } 
            // sort($level_arr);
            file_put_contents("logs/choujiang/level".$level.".txt", json_encode($level_arr));


            if (file_exists("logs/choujiang/prize.txt")) {
                $prize = json_decode(file_get_contents("logs/choujiang/prize.txt"),true);
                $number_arr = array_unique(array_merge($number_arr, $prize));
            }

            sort($number_arr);
            file_put_contents("logs/choujiang/prize.txt", json_encode($number_arr));

            $json_arr = array(
                'flag' => true, 
                'prize' => implode(',', $number_arr), 
                'allcount' => count($number_arr), 
                'levelcount' => count($level_arr),
                'own_number' => implode(',', $level_arr),
                'current_number' => implode(',', $this->input->post("numberArr")),
                'msg' => '已中奖号码写入成功！'
            );
            $json_arr['remaincount'] = C('prize.set')[$level] - $json_arr['levelcount'];

    		echo json_encode($json_arr);  	
    	}
    }
	
	
	//清空中奖数据
	public function clearprize() {
		$this->delete_all('logs/choujiang');
		header('location:' . C('domain.www.url') .'/choujiang');
	}


     /* 
        * 功能：循环检测并创建文件夹 
        * 参数：$path 文件夹路径 
        * 返回： 
        */ 
    private function create_dir($path) { 
        if (!file_exists($path)){ 
            $this->create_dir(dirname($path)); 
            mkdir($path, 0777); 
        } 
    } 
	
	/* 
        * 功能：删除所有子目录及目录中的文件
        * 参数：$path 文件夹路径 
        * 返回： 
        */ 
	function delete_all($path) {
		$op = dir($path);
		while(false != ($item = $op->read())) {
			if($item == '.' || $item == '..') {
				continue;
			}
			if(is_dir($op->path.'/'.$item)) {
				$this->delete_all($op->path.'/'.$item);
				rmdir($op->path.'/'.$item);
			} else {
				unlink($op->path.'/'.$item);
			}
		
		}   
	}
}
?>

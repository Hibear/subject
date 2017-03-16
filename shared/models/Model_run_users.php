<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_run_users extends MY_Model {

    private $_table = 't_run_users';
    private $_table2 = 't_run_usersupport';

    public function __construct() {
        parent::__construct($this->_table);
    }
	
	//统计当前用户的数据
	public function count_users($where,$size=0,$offset=0){
		$data = array();
		$where_str = "";
		$sql_page = ""; 
		if(isset($where)){
			$where_str = "where ";
			foreach($where as $key=>$val){
				$where_str.=$key.'="'.$val.'" and ';
			}
		}
		//去掉最后一个and
		$where_str =substr($where_str,0,strripos($where_str,"and"));
		$sql = 'SELECT  a.name,a.tel,a.wetcaht_name,a.create_time,a.openid, IFNULL(t1.count1, 0) as nums  FROM '.$this->_table .' a  LEFT JOIN (SELECT  user_openid, COUNT(id) AS count1  FROM '.$this->_table2.'  GROUP BY user_openid) t1  ON a.`openid` = t1.user_openid ';
	    $sql= $sql.$where_str." ORDER BY nums desc ";
		$sql_page = $sql." limit ".$offset.",".$size;
		
		$this->db->cache_on();
	    $query2 = $this->db->query($sql);
		$count =  $query2->result_array();
		if(!$size){
			return $count;
		}
		
	    $query = $this->db->query($sql_page);
		$list = $query->result_array();		
        
		return 	array(
		   'lists' => $list,
		   'count' => count($count)
		);
	
	}

}
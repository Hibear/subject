<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_warehouse_cate extends MY_Model {

    private $_table = 't_warehouse_cate';

    public function __construct() {
        parent::__construct($this->_table);
    }
}
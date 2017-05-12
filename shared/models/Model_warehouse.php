<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_warehouse extends MY_Model {

    private $_table = 't_warehouse';

    public function __construct() {
        parent::__construct($this->_table);
    }
}
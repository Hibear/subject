<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_company_info extends MY_Model {

    private $_table = 't_company_info';

    public function __construct() {
        parent::__construct($this->_table);
    }

}
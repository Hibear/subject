<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_borrow_log extends MY_Model {

    private $_table = 't_borrow_log';

    public function __construct() {
        parent::__construct($this->_table);
    }
}
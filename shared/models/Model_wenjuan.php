<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_wenjuan extends MY_Model {

    private $_table = 't_wenjuan';

    public function __construct() {
        parent::__construct($this->_table);
    }
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_lottery extends MY_Model {

    private $_table = 't_lottery';

    public function __construct() {
        parent::__construct($this->_table);
    }

}
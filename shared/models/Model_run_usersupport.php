<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_run_usersupport extends MY_Model {

    private $_table = 't_run_usersupport';

    public function __construct() {
        parent::__construct($this->_table);
    }

}
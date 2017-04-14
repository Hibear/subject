<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_active_prize extends MY_Model {

    private $_table = 't_active_prize';

    public function __construct() {
        parent::__construct($this->_table);
    }
}
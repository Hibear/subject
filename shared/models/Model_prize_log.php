<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_prize_log extends MY_Model {

    private $_table = 't_prize_log';

    public function __construct() {
        parent::__construct($this->_table);
    }
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_puzzle_users extends MY_Model {

    private $_table = 't_puzzle_users';

    public function __construct() {
        parent::__construct($this->_table);
    }

}
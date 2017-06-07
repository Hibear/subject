<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_say_to_father extends MY_Model {

    private $_table = 't_say_to_father';

    public function __construct() {
        parent::__construct($this->_table);
    }
}
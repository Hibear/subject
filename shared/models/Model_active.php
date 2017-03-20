<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_active extends MY_Model {

    private $_table = 't_weixin_active';

    public function __construct() {
        parent::__construct($this->_table);
    }
}
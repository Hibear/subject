<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_performer extends MY_Model {

    private $_table = 't_performer';

    public function __construct() {
        parent::__construct($this->_table);
    }

}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_questionnaire extends MY_Model {

    private $_table = 't_questionnaire';

    public function __construct() {
        parent::__construct($this->_table);
    }
    
}
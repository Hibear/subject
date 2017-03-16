<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_vote_log extends MY_Model {

    private $_table = 't_vote_log';

    public function __construct() {
        parent::__construct($this->_table);
    }

}
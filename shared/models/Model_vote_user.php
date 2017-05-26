<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_vote_user extends MY_Model {

    private $_table = 't_vote_user';

    public function __construct() {
        parent::__construct($this->_table);
    }
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_game_user extends MY_Model {

    private $_table = 't_game_user';

    public function __construct() {
        parent::__construct($this->_table);
    }

}
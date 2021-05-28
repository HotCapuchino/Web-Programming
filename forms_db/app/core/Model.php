<?php

namespace app\core;
use app\core\DatabaseOperator;
use app\core\Session;

class Model {

    protected $db_operator = null;
    protected $session = null;

    public function __construct() {
        $this->connectToDB();
        $this->session = new Session();
    }

    protected function connectToDB() {
        $this->db_operator = new DatabaseOperator();
        if (!$this->db_operator) {
            echo 'Unable to connect database!';
        } else {
            // echo 'Connection established!';
        }
    }
}
<?php 

const FILE_PATH = '../user_info/user_table.txt';

class DisplayRequest {

    private $file = null;

    public function __construct() {
        $this->file = fopen(FILE_PATH, 'r');
        if (!$this->file) {
            throw new Exception('Unable to open file!');
        }
    }

    public function getAllUsers() {
        $users = array();
        while(!feof($this->file)) {
            $string = fgets($this->file);
            if ($string) {
                $array = explode('|', $string);  
                if ($array[sizeof($array) - 1] < 1) {
                    $users[] = array_slice($array, 0, sizeof($array) - 3);
                }  
            } 
        }
        return $users;
    }

}
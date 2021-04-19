<?php 

const FILE_PATH = '../user_info/user_table.txt';

class DeleteRequest {

    protected $indexes_to_delete = array();

    public function __construct() {
        $this->indexes_to_delete = array_keys($_POST);
    }

    public function delete() {
        if (!sizeof($this->indexes_to_delete)) {
            throw new Exception('Choose at least one user to delete!');
        }
        $last_index = $this->indexes_to_delete[sizeof($this->indexes_to_delete) - 1];
        $indexes_index = 0;
        $current_index = $this->indexes_to_delete[$indexes_index];
        $result = explode("\n", file_get_contents(FILE_PATH));
        for ($i = 0; $i < sizeof($result); $i++) { 
            if ($i === $current_index && strlen($result[$i]) > 0) {
                $indexes_index++;
                $current_string_array = explode('|', $result[$i]);
                $current_string_array[sizeof($current_string_array) - 1] = 1;
                $result[$i] = implode('|', $current_string_array);
                $current_index = $this->indexes_to_delete[$indexes_index];
                if ($i === $last_index) {
                    break;
                }
            }
            $result[$i] .= PHP_EOL;
        }
        file_put_contents(FILE_PATH, $result);
    }

}
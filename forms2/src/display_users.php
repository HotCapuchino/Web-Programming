<?php 
    const FILE_PATH = '../user_info/user_table.txt';
    
    function getAllUsers($file) {
        $users = array();
        while(!feof($file)) {
            $string = fgets($file);
            if ($string) {
                $array = explode('|', $string);  
                if ($array[sizeof($array) - 1] < 1) {
                    $users[] = array_slice($array, 0, sizeof($array) - 3);
                }  
            } 
        }
        return $users;
    }

    $error_message = null;
    $file = fopen(FILE_PATH, 'r');
    if (!$file) {
        $error_message = 'Unable to open file!';
        include_once('../pages/admin_panel.php');
        die();
    }
    $users = getAllUsers($file);
    include_once('../pages/admin_panel.php');
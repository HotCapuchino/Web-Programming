<?php 
    const FILE_PATH = '../user_info/user_table.txt';

    function toDelete() {
        $indexes = array_keys($_POST);
        $last_index = $indexes[sizeof($indexes) - 1];
        $indexes_index = 0;
        $current_index = $indexes[$indexes_index];
        $result = explode("\n", file_get_contents(FILE_PATH));
        for ($i = 0; $i < sizeof($result); $i++) { 
            if ($i === $current_index && strlen($result[$i]) > 0) {
                $indexes_index++;
                $current_string_array = explode('|', $result[$i]);
                $current_string_array[sizeof($current_string_array) - 1] = 1;
                $result[$i] = implode('|', $current_string_array);
                $current_index = $indexes[$indexes_index];
                if ($i === $last_index) {
                    break;
                }
            }
            $result[$i] .= PHP_EOL;
        }
        file_put_contents(FILE_PATH, $result);
    }   

    $error_message = null;
    if (sizeof($_POST) > 0) {
        toDelete();
        include_once('./display_users.php');
        die();
    } else {
        $error_message = 'Choose at least one user!';
        include_once('../pages/admin_panel.php');
        die();
    }

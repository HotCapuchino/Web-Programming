<?php 
    use database_class\connection_to_db\DatabaseOperator;
    include_once '../include/connection_to_database.php';
    include_once '../include/database_data.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    try {
        $db_operator = new DatabaseOperator($HOST, $USER_NAME, $PASSWORD, $DB_NAME);
    } catch (Exception $exp) {
        $exception_info = explode(':', $exp->getMessage());
        $response = [
            'succeed' => false,
        ];
        if ($exception_info[0] == '1045') {
            $response['message'] = 'Unable to connect to database!';
        } else {
            $response['message'] = 'Something unpredictable had happened, we are already working on it!';
        }
        echo json_encode($response);
    }
    $query_result = $db_operator->execute_select_query('SELECT * FROM `conference`', null);
    // print_r($query_result);
    $data = array();
    foreach ($query_result as $row) {
        $data[] = [
            'user_id' => $row[0],
            'user_name' => $row[1],
            'user_surname' => $row[2],
            'user_mail' => $row[3],
            'user_phone' => $row[4],
            'chosen_topic' => $row[5],
            'chosen_payment' => $row[6],
            'mail_subscribe' => $row[7],
        ];
    }
    $response = [
        'succeed' => true,
        'data' => $data
    ];
    echo json_encode($response);
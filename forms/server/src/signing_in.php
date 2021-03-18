<?php
    use database_class\connection_to_db\DatabaseOperator;
    include_once '../include/connection_to_database.php';
    include_once '../include/database_data.php';
    $content = json_decode(file_get_contents('php://input'), true);
    // establishing connection to database
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
    $login = $content['login'];
    $password = $content['password'];
    // echo $login . $password;
    $query_result = $db_operator->execute_select_query('SELECT login, password FROM `conference_admin_panel` WHERE login=? LIMIT 1;', $login);
    if (empty($query_result)) {
        $response = [
            'succeed' => false,
            'data' => array('login'),
            'message' => 'Seems like there is no user with such login!'
        ];
    } else {
        if (md5($password) == $query_result[0][1]) {
            $response = [
                'succeed' => true
            ];
        } else {
            $response = [
                'succeed' => false,
                'data' => array('password'),
                'message' => "Wrong password for user $login!"
            ];
        }
    }
    echo json_encode($response);
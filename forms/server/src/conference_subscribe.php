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
    // checking if user is already registered
    $values = array($content['user_mail'], $content['user_phone']);
    $query_result = $db_operator->execute_select_query('SELECT * from `conference` WHERE email=? OR phone=? LIMIT 1;', $values);
    if (empty($query_result)) {
        try {
            $values = array(
                $content['user_name'], 
                $content['user_surname'], 
                $content['user_mail'], 
                $content['user_phone'], 
                $content['chosen_topic'],
                $content['chosen_payment'],
                $content['mail_subscribe']
            );
            $db_operator->execute_insert_query($values);
            $response = [
                'succeed' => true
            ];
        } catch (Exception $exp) {
            $response = [
                'succeed' => false,
                'message' => 'Something unpredictable had happened, we are already working on it!'
            ];
        } finally {
            echo json_encode($response);
        }
    } else {
        $response = [
            'succeed' => false,
        ];
        $message = array();
        if ($query_result[0][3] == $content['user_mail']) {
            $error_fields[] = 'user_mail';
            $message[] = 'User with this email has been already registered!';
        } 
        if ($query_result[0][4] == $content['user_phone']) {
            $error_fields[] = 'user_phone';
            $message[]  = 'User with this phone number has been already registered!';
        }
        $response['data'] = $error_fields;
        $response['message'] = $message;
        echo json_encode($response);
    }
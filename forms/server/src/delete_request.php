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
    // deleting chosen rows
    $id_to_delete = $content['to_delete'];
    $deleted = array();
    foreach ($id_to_delete as $id) {
        try {
            $query_result = $db_operator->execute_delete_query('DELETE FROM `conference` WHERE id=? LIMIT 1', (int)$id);
            if ($query_result) $deleted[] = $id;
        } catch (Exception $exp) {
            $exception_info = explode(':', $exp->getMessage());
            $response = [
                'succeed' => false,
                'data' => $deleted,
                'message' => $exception_info[1]
            ];
            echo json_encode($response);
            die();
        }
    }
    $response = [
        'succeed' => true,
        'data' => $id_to_delete
    ];
    echo json_encode($response);

<?php 
    include_once('./classes/deleteRequest.php');
    $error_message = null;
    $delete_request = new DeleteRequest();
    try {
        $delete_request->delete();
        include_once('./display_users.php');
        die();
    } catch (Exception $exp) {
        $error_message = $exp->getMessage();
        include_once('./display_users.php');
        die();
    }
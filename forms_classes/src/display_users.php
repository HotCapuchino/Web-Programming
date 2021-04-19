<?php 
    include_once('./classes/displayRequest.php');
    $error_message = null;
    $users = null;
    try {
        $display_request = new DisplayRequest();
        $users = $display_request->getAllUsers();
        include_once('../pages/admin_panel.php');
        die();
    } catch (Exception $exp) {
        $error_message = $exp->getMessage();
        include_once('../pages/admin_panel.php');
        die();
    }
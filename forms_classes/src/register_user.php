<?php 
    include_once('./classes/conferenceRequest.php');
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    $error_message = null;
    $request = null;
    try {
        $request = new ConferenceRequest();
    } catch(Exception $exp) {
        $error_message = $exp->getMessage();
        include_once('../pages/conference_subscription.php');
        die();
    }
    if ($request->checkIfUserIsRegistered()) {
        $error_message = 'Such user has been already registered!';
        include_once('../pages/conference_subscription.php');
        die();
    }
    $request->registerUser();
    include_once('../pages/conference_subscription.php');
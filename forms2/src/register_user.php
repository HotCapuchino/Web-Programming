<?php 
    const FILE_PATH = '../user_info/user_table.txt';
    function validateFields() {
        $error_fields = array();
        foreach ($_POST as $key => $value) {
            if (!$value) {
                $error_fields[$key] = 'This field should not be empty!';
            }
            if (strpos($value, '|') !== false) {
                $error_fields[$key] = 'Sorry, this value is incorrect!';
            }   
        }
        $user_phone = $_POST['user_phone'];
        for ($i = 0; $i < strlen($user_phone); $i++) { 
            if (!is_numeric($user_phone[$i])) {
                $error_fields['user_phone'] = 'Phone number can\'t contain any letters!';
                break;
            }
        }
        return $error_fields;
    }

    function checkIfUserIsRegistered($file, $new_user_email, $new_user_phone) {
        $user_was_found = false;
        while(!feof($file)) {
            $user_info = explode('|', fgets($file));
            if (!$user_info) return $user_was_found;
            if ($user_info[2] === $new_user_email || $user_info[3] === $new_user_phone) {
                $user_was_found = true;
                break;
            }
        }
        return $user_was_found;
    }

    function registerUser($file, $user_info) {
        $result_string = '';
        for ($i = 0; $i < sizeof($user_info); $i++) { 
            $result_string .= $user_info[$i] . '|';
        }
        $result_string .= '0' . PHP_EOL; 
        fwrite($file, $result_string);
        fclose($file);
    }

    $error_fields = validateFields();
    // collecting data
    $user_name = $_POST['user_name'];
    $user_surname = $_POST['user_surname'];
    $user_mail = $_POST['user_mail'];
    $user_phone = $_POST['user_phone'];
    $chosen_topic = $_POST['chosen_topic'];
    $chosen_payment = $_POST['chosen_payment'];
    $mail_subscribe = $_POST['mail_subscribe'];
    $date = date("d/m/Y");
    $ip_adr = $_SERVER['REMOTE_ADDR'];
    if (!$mail_subscribe) $mail_subscribe = 'off';
    // checking if one of the input was incorrect
    if (sizeof($error_fields) > 0) {
        $error_message = 'Correct the wrong fields!';
        include_once('../pages/conference_subscription.php');
        die();
    }
    $error_message = null;
    $file = fopen(FILE_PATH, 'a+');
    if (!$file) {
        $error_message = 'Unable to open file!';
        include_once('../pages/conference_subscription.php');
        die();
    }
    if(checkIfUserIsRegistered($file, $user_mail, $user_phone)) {
        $error_message = 'Such user has been already registered!';
        include_once('../pages/conference_subscription.php');
        die();
    }
    $user_info = [$user_name, $user_surname, $user_mail, $user_phone, $chosen_topic, $chosen_payment, $date, $ip_adr, $mail_subscribe];
    registerUser($file, $user_info);
    include_once('../pages/conference_subscription.php');
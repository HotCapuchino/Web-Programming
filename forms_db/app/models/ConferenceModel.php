<?php 

namespace app\models;

use app\core\Model;

class ConferenceModel extends Model {

    public function validateFields($fields, $fields_params) {
        $error_fields = [];
        $i = 0;
        foreach ($fields as $field => $value) { 
            if (!$value) {
                $error_fields[$field] = 'This field cannot be empty!';
                $i++;
                continue;
            }
            switch($fields_params[$i]) {
                case 'text': {
                    if (preg_match('/[^\w]|[^\D]/', $value)) {
                        $error_fields[$field] = 'This field should contain only letters!';
                    }
                }
                break;
                case 'number': {
                    if (preg_match('/[^\w]|[^\d]/', $value)) {
                        $error_fields[$field] = 'This field should contain only digits!';
                    }
                }
                break;
                case 'mail': {
                    if (!preg_match('/^\w([\w]|[\d]|\.)*@(yandex|gmail|yahoo|mail)\.([\w]*)/', $value)) {
                        $error_fields[$field] = 'Incorrect email!';
                    }
                } 
                break;
            }
            $i++;
        }
        return $error_fields;
    }

    public function registerUser($fields) {
        $sql = "INSERT INTO `participants`(name, lastname, email, phone, subject_id, 
                payment_id, mailing, created_at, updated_at) 
                VALUES(?, ?, ?, ?, ?, ?, ?, now(), now());";
        $user_values = [];
        foreach($fields as $field => $value) {
            $user_values[] = $value;
        } 
        return $this->db_operator->executeQuery($sql, $user_values);
    }

}
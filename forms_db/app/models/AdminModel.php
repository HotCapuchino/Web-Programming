<?php 

namespace app\models;

use app\core\Model;
use Exception;

class AdminModel extends Model {
    
    public function getRequests() {
        $participants_sql = "SELECT * FROM `participants`;";
        $result = $this->db_operator->executeQuery($participants_sql);
        $subject_sql = "SELECT name FROM `subjects` WHERE id=?;";
        $payment_sql = "SELECT name FROM `payments` WHERE id=?;";
        $united_result = array();
        foreach ($result as $res) {
            $subj = $this->db_operator->executeQuery($subject_sql, array($res[5]));
            $paym = $this->db_operator->executeQuery($payment_sql, array($res[6]));
            if ($subj && $paym) {
                $res[5] = $subj[0][0];
                $res[6] = $paym[0][0];
            } else {
                throw new Exception('Unable to get data!');
            }
            $united_result[] = $res;
        }
        return $united_result;
    }

    public function deleteRequest($request_id) {
        $sql = "DELETE FROM `participants` WHERE id=? LIMIT 1;";
        $params = array($request_id);
        return $this->db_operator->executeQuery($sql, $params);
    }

    public function login($login, $password) {
        $sql = "SELECT `password` FROM `admins` WHERE `login`=? LIMIT 1;";
        $params = array($login);
        $result = $this->db_operator->executeQuery($sql, $params)[0];
        if ($result[0] === $password) {
            $this->session->start();
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        $this->session->end();
    }

    public function isLoggedIn() {
        return $this->session->isLogged();
    }

    public function validateFields($fields) {
        $error_fields = [];
        foreach ($fields as $field => $value) {
            if ($field == 'password' && strlen($value) < 5) {
                $error_fields[$field] = 'Too short!';
            } 
            if (!$value) {
                $error_fields[$field] = 'This field cannot be empty!';
            }
        }
        return $error_fields;
    }

}
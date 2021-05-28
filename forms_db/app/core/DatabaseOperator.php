<?php

namespace app\core;

use Exception;
use PDO;

class DatabaseOperator {

    private $connection = null;

    public function __construct() {
        $db_options = require('app/db_config.php');
        extract($db_options);
        try {
            $this->connection = new PDO($dsn, $username, $password, array(
                PDO::ATTR_PERSISTENT => true
            ));
            return true;
        } catch (Exception $exp) {
            return false;
        }
    }

    public function executeQuery($query_string, $params = null) {
        try {
            if (!$params) {
                $query_result = $this->connection->query($query_string);
                return $query_result->fetchAll(PDO::FETCH_NUM);
            } else {
                $stmt = $this->connection->prepare($query_string);
                if (!$stmt) return false;
                $successful = $stmt->execute($params);
                if (!$successful) return false;
                if (preg_match('/^SELECT/i', $query_string)) {
                    return $stmt->fetchAll(PDO::FETCH_NUM);
                } 
                return true;
            }
        } catch (Exception $exception) {
            echo 'oops, error occurred!';
        }
    }

}

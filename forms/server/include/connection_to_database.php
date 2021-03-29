<?php
    namespace database_class\connection_to_db;
    use Exception;
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    class DatabaseOperator {

        protected $host = '';
        protected $user_name = '';
        private $password = '';
        protected $db_name = '';
        protected $connection = null;

        function __construct($host, $user_name, $password, $db_name) {
            $this->host = $host;
            $this->user_name = $user_name;
            $this->password = $password;
            $this->db_name = $db_name;
            $this->connect_to_db();
        }

        private function connect_to_db() {
            $connection = mysqli_connect($this->host, 
                                        $this->user_name, 
                                        $this->password, 
                                        $this->db_name);
            if (mysqli_connect_errno()) {
                throw new Exception(mysqli_connect_errno() . ':' . mysqli_connect_error());
            }
            $this->connection = $connection;
        }

        private function get_var_types($values) {
            $types = '';
            if (is_array($values)) {
                foreach ($values as $value) {
                    switch(gettype($value)) {
                        case 'string': $types .= 's';
                        break;
                        case 'integer': $types .= 'i';
                        break;
                        case 'double': $types .= 'd';
                        break;
                        default: break;
                    } 
                }
            } else {
                switch(gettype($values)) {
                    case 'string': $types .= 's';
                    break;
                    case 'integer': $types .= 'i';
                    break;
                    case 'double': $types .= 'd';
                    break;
                    default: break;
                }
            } 
            return $types;
        }


        function execute_select_query($query, $values = null) {
            if (!$this->connection) {
                throw new Exception(mysqli_connect_errno() . ':' . mysqli_connect_error());
            } 
            $result_array = array();
            $result = null;
            if ($values) {
                $stmt = mysqli_prepare($this->connection, $query);
                if (is_array($values)) {
                    $stmt->bind_param($this->get_var_types($values), ...$values);
                } else {
                    $stmt->bind_param($this->get_var_types($values), $values);
                }
                $stmt->execute();
                $result = $stmt->get_result();
            } elseif (!$values) {
                $result = mysqli_query($this->connection, $query);
            }
            if ($result) {
                while ($row = mysqli_fetch_row($result)) {
                    $result_array[] = $row;
                }
                mysqli_free_result($result);
            }
            return $result_array;
        }

        function execute_insert_query($values) {
            if (!$this->connection) {
                throw new Exception(mysqli_connect_errno() . ':' . mysqli_connect_error());
            }
            $query = 'INSERT INTO `conference`(name, surname, email, phone, topic, payment, subscription)
                    VALUES(?, ?, ?, ?, ?, ?, ?);';
            $stmt = mysqli_prepare($this->connection, $query);
            $stmt->bind_param($this->get_var_types($values), ...$values);
            $stmt->execute();
            if (mysqli_stmt_errno($stmt)) {
                throw new Exception(mysqli_stmt_errno($stmt) . ':' . mysqli_stmt_error($stmt));
            }
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        }

        function execute_delete_query($query, $id) {
            if (!$this->connection) {
                throw new Exception(mysqli_connect_errno() . ':' . mysqli_connect_error());
            }
            if (!$id) {
                return false;
            }
            $stmt = mysqli_prepare($this->connection, $query);
            $stmt->bind_param($this->get_var_types($id), $id);
            $stmt->execute();
            if (mysqli_stmt_errno($stmt)) {
                throw new Exception(mysqli_stmt_errno($stmt) . ':' . mysqli_stmt_error($stmt));
            }
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        }
    }

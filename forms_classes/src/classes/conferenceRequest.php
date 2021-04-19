<?php

const FILE_PATH = '../user_info/user_table.txt';

class ConferenceRequest {

    protected $user_name = '';
    protected $user_surname = '';
    protected $user_mail = '';
    protected $user_phone = '';
    protected $chosen_topic = '';
    protected $chosen_payment = '';
    protected $date = '';
    protected $ip_adr = '';
    protected $mail_subscribe = '';
    protected $error_fields = array();
    private $file = null;

    public function __construct() {
        $this->user_name = $_POST['user_name'];
        $this->user_surname = $_POST['user_surname'];
        $this->user_mail = $_POST['user_mail'];
        $this->user_phone = $_POST['user_phone'];
        $this->chosen_topic = $_POST['chosen_topic'];
        $this->chosen_payment = $_POST['chosen_payment'];
        $this->date = date("d/m/Y");
        $this->ip_adr = $_SERVER['REMOTE_ADDR'];
        $this->mail_subscribe = $_POST['mail_subscribe'] ? 'on' : 'off';
        $this->validateFields();
        $this->file = $this->openFile();
        if (!$this->file) {
            throw new Exception('Unable to open file!');
        }
    }

    public function validateFields() {
        $class_fields_names = array_keys(get_class_vars(get_class($this)));
        foreach ($class_fields_names as $prop_name) {
            if (gettype($this->$prop_name) !== 'string') continue;
            if (!$this->$prop_name) {
                $this->error_fields[$prop_name] = 'This field should not be empty!';
            }
            if (strpos($this->$prop_name, '|') !== false) {
                $this->error_fields[$prop_name] = 'Sorry, this value is incorrect!';
            }
            if ($prop_name === 'user_phone') {
                $user_phone = $this->$prop_name;
                for ($i = 0; $i < strlen($user_phone); $i++) {
                    if (!is_numeric($user_phone[$i])) {
                        $this->error_fields[$prop_name] = 'Phone number can\'t contain any letters!';
                        break;
                    }
                }
            }
        }
    }

    public function checkIfUserIsRegistered() {
        $user_was_found = false;
        while (!feof($this->file)) {
            $user_info = explode('|', fgets($this->file));
            if (!$user_info) return $user_was_found;
            if ($user_info[2] === $this->user_mail || $user_info[3] === $this->user_phone) {
                $user_was_found = true;
                break;
            }
        }
        return $user_was_found;
    }

    public function registerUser() {
        $user_info = array();
        $class_fields_names = array_keys(get_class_vars(get_class($this)));
        foreach ($class_fields_names as $prop_name) {
            if (gettype($this->$prop_name) !== 'string') continue;
            $user_info[] = $this->$prop_name;
        }
        $result_string = '';
        for ($i = 0; $i < sizeof($user_info); $i++) {
            $result_string .= $user_info[$i] . '|';
        }
        $result_string .= '0' . PHP_EOL;
        fwrite($this->file, $result_string);
        fclose($this->file);
    }

    private function openFile() {
        return fopen(FILE_PATH, 'a+');
    }

    public function getWrongFields() {
        return $this->error_fields;
    }
}

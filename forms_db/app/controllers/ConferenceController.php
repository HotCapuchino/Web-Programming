<?php

namespace app\controllers;

use app\core\Controller;

class ConferenceController extends Controller {

    protected $error_fields = [];
    protected $user_values = [];
    protected $error_message = null;

    public function registerAction() {
        if (!sizeof($_POST)) {
            $this->redirect('conference');
        } else {
            $this->user_values = $_POST;
            if (!$_POST['mail_subscribe']) {
                $this->user_values['mail_subscribe'] = 0;
            } else {
                $this->user_values['mail_subscribe'] = 1;
            }
            $this->error_fields = $this->model->validateFields(
                $_POST,
                array('text', 'text', 'mail', 'number', 'number', 'number', 'text')
            );
            if (!sizeof($this->error_fields)) {
                if ($this->model->registerUser($this->user_values)) {
                    $this->user_values = [];
                    $this->error_message = 'Registration successful!';
                } else {
                    $this->error_message = 'Registration failed!';
                }
                $this->displayFormAction();
            } else {
                $this->displayFormAction();
            }
        }
    }

    public function displayFormAction() {
        $this->view->displayTemplate();
        $this->view->displayContent([
            'error_message' => $this->error_message,
            'error_fields' => $this->error_fields,
            'user_values' => $this->user_values
        ]);
    }

}
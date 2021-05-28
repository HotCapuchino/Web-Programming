<?php

namespace app\controllers;
use app\core\Controller;

class AdminController extends Controller {

    protected $error_fields = [];
    protected $login = null;
    protected $error_message = null;
    
    public function loginAction() {
        if (!sizeof($_POST)) {
            $this->redirect('admin-panel');
        }
        $this->error_fields = $this->model->validateFields($_POST);
        $this->login = $_POST['login'];
        if (!sizeof($this->error_fields)) {
            $password = $_POST['password'];
            if ($this->model->login($this->login, md5($password))) {
                $this->redirect('admin-panel/requests');
            } else {
                $this->error_message = 'Wrong login or password!';
                $this->displayLoginAction();
            }
        } else {
            $this->displayLoginAction();
        }
        $this->view->displayTemplate();
        $this->view->displayContent([]);
    }

    public function logoutAction() {
        $this->model->logout();
        $this->redirect('admin-panel');
    }

    public function deleteAction() {
        if (!sizeof($_POST)) {
            $this->error_message = 'Choose at least one participant!';
        }
        foreach (array_keys($_POST) as $key) {
            if (!$this->model->deleteRequest($key)) {
                $this->error_message = "Unable to delete user with id = $key";
                break;
            }
        }
        $this->displayPanelAction();
    }

    public function displayPanelAction() {
        if (!$this->model->isLoggedIn()) {
            $this->redirect('admin-panel');
        } 
        $requests = $this->model->getRequests();
        $this->view->displayTemplate();
        $this->view->displayContent(['users' => 
            array_map(fn($array_elem) => array_slice($array_elem, 0, 8), $requests), 
            'error_message' => $this->error_message]);
    }

    public function displayLoginAction() {
        if ($this->model->isLoggedIn()) {
            $this->redirect('admin-panel/requests');
        }
        $this->view->displayTemplate();
        $this->view->displayContent([
            'login' => $this->login,
            'error_message' => $this->error_message,
            'error_fields' => $this->error_fields 
        ]);
    }

}
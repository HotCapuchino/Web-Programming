<?php

namespace app\core;
use app\core\View;

class Controller {

    protected $route = null;
    protected $action = null;
    protected $view = null;
    protected $model = null;

    public function __construct($route, $action, $view) {
        $this->view = new View($route, $view);
        $this->route = $route;
        $this->action = $action;
        $this->model = $this->getModel();
    }

    private function getModel() {
        $path = 'app\models\\' . ucfirst($this->route) . 'Model';
        if  (class_exists($path)) {
            return new $path();
        } else {
            return null;
        }
    }

    public function redirect($page_path) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . $page_path);
    }
}
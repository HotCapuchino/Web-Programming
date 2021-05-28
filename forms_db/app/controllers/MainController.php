<?php

namespace app\controllers;
use app\core\Controller;

class MainController extends Controller {

    public function displayAction() {
        $this->view->displayTemplate();
        $this->view->displayContent([]);
    }
}
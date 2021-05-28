<?php 

namespace app\core;

class View {

    protected $header_link = null;
    protected $header_title = null;
    protected $view = null;
    protected $route = null;

    public function __construct($route, $view) {
        $this->header_title = ucfirst($route);
        $this->header_link = 'public/styles/views/' . $route . '.css';
        $this->view = $view;
    }

    public function displayContent($array_params) {
        extract($array_params);
        include_once('app/views/' . $this->view . '.php');
    }

    public function displayTemplate() {
        include_once('app/templates/header.php');
        include_once('app/templates/footer.php');
    }
}
<?php

namespace app\core;

class Session {

    public function start() {
        session_start();
        $_SESSION['isLogged'] = true;
    }

    public function isLogged() {
        session_start();
        if (isset($_SESSION['isLogged'])) {
            return $_SESSION['isLogged'];
        } 
        return false;
    }

    public function end() {
        session_start();
        $_SESSION['isLogged'] = false;
    }
}

<?php

$uri = $_SERVER['REQUEST_URI'];
if ($uri == '/') {
    require_once './server/pages/index_page.html';
} elseif ($uri == '/sign_in') {
    require_once './server/pages/sign_in.html';
} else {
    require_once './server/pages/index_page.html';
}
<?php

$uri = $_SERVER['REQUEST_URI'];
if ($uri == '/') {
    include_once './server/pages/index_page.html';
} elseif ($uri == '/sign_in') {
    include_once './server/pages/sign_in.html';
} else {
    include_once './server/pages/index_page.html';
}
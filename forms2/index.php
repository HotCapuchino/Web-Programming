<?php
$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/') {
    include_once('./pages/conference_subscription.php');
} elseif ($uri === '/admin_panel') {
    include_once('./src/display_users.php');
} else {
    include_once('./pages/conference_subscription.php');
}
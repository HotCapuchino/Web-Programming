<?php

return [
    '/' => [
        'controller' => 'main',
        'action' => 'display',
        'view' => 'main'
    ], 
    '/conference' => [
        'controller' => 'conference', 
        'action' => 'displayForm',
        'view' => 'form'
    ],
    '/conference/register' => [
        'controller' => 'conference', 
        'action' => 'register', 
        'view' => 'form'
    ],
    '/admin-panel' => [
        'controller' => 'admin',
        'action' => 'displayLogin',
        'view' => 'admin_login'
    ],
    '/admin-panel/login' => [
        'controller' => 'admin',
        'action' => 'login', 
        'view' => 'admin_login'
    ], 
    '/admin-panel/requests' => [
        'controller' => 'admin',
        'action' => 'displayPanel', 
        'view' => 'admin_panel'
    ], 
    '/admin-panel/delete' => [
        'controller' => 'admin',
        'action' => 'delete',
        'view' => 'admin_panel'
    ],
    '/admin-panel/logout' => [
        'controller' => 'admin',
        'action' => 'logout',
        'view' => 'admin_panel'
    ],
    '/registration-result' => [
        'controller' => 'result', 
        'action' => 'display', 
        'view' => 'results'
    ]
];
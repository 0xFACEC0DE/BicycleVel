<?php
return [
    'db' => [
        'host' => '127.0.01',
        'port' => '3306',
        'dbname' => 'mvc',
        'user' => 'homestead',
        'password' => 'secret',
    ],

    'routes' => [
        '/articles/(\d+)' => ['ArticleController', 'view'],
        '/'                => ['MainController', 'main'],
    ]
];
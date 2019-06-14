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
        'GET' => [
            ''                    => ['MainController', 'main'],
            'articles/(\d+)'      => ['ArticleController', 'view'],
            'articles/(\d+)/edit' => ['ArticleController', 'update'],
            'articles/(\w+)/add' => ['ArticleController', 'create'],
        ],
        'POST' => [

        ]
    ]
];
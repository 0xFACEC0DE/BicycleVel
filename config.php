<?php return [

    'db' => [
        'host' => '127.0.01',
        'port' => '3306',
        'dbname' => 'mvc',
        'user' => 'homestead',
        'password' => 'secret',
    ],

    'mailing' => [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => 'rkhilenksmtp@gmail.com',
        'password' => 'asdQWE123',
        'encryption' => 'tls',
        'sender' => ['john@doe.com' => 'John Doe'],
        'my_url' => 'http://mvc.loc'
    ],

    'routes' => [
        'GET' => [
            ''                    => ['MainController', 'index'],
            'articles/(\d+)'      => ['ArticleController', 'view'],
            'articles/(\d+)/edit' => ['ArticleController', 'update'],
            'articles/(\w+)/add'  => ['ArticleController', 'create'],
            'articles/(\d+)/delete' => ['ArticleController', 'delete'],
            'users/register'         => ['UserController', 'signUp'],
            'users/(\d+)/activate/(.+)' => ['UserController', 'activate'],
            'users/resend'            => ['UserController', 'resend'],
        ],
        'POST' => [
            'register' => ['UserController', 'register'],
        ]
    ]
];?>
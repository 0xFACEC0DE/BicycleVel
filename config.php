<?php return [

    'db' => [
        'host'   => '127.0.01',
        'port'   => '3306',
        'dbname' => 'mvc',
        'user'   => 'homestead',
        'password' => 'secret',
    ],

    'mailing' => [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => 'rkhilenksmtp@gmail.com',
        'password' => 'asdQWE123',
        'encryption' => 'tls',
        'sender' => ['john@doe.com' => 'John Doe'],
    ],

    'routes' => [
        'GET' => [
            ''              => ['ArticleController', 'index'],
            'articles/(\d+)'      => ['ArticleController', 'view'],
            'articles/(\d+)/delete' => ['ArticleController', 'delete'],
            'user'          => ['UserController', 'profile'],
            'user/signup'   => ['UserController', 'signUp'],
            'user/signin'   => ['UserController', 'signIn'],
            'user/logout'   => ['AuthController', 'logout'],
            'user/(\d+)/activate/(.+)' => ['UserController', 'activate'],
            'user/resend'            => ['UserController', 'resend'],
            'user/signup/success'    => ['UserController', 'signUpSuccess'],

        ],
        'POST' => [
            'user/login'    => ['AuthController', 'login'],
            'user/register' => ['AuthController', 'register'],
            'articles/(\w+)/add'  => ['ArticleController', 'create'],
            'articles/(\d+)/edit' => ['ArticleController', 'update'],
        ]
    ]
];?>
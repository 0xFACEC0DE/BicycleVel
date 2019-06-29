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
            'user'          => ['UserController', 'profile'],  //info for signed in user or links to forms
            'user/signup'   => ['UserController', 'signUp'], //show registration form
            'user/signin'   => ['UserController', 'signIn'], //show form for sign in existing users
            'user/logout'   => ['AuthController', 'logout'], //logout action for signed in user
            'user/(\d+)/activate/(.+)' => ['UserController', 'activate'],
            'user/resend'            => ['UserController', 'resend'],
            'user/signup/success'    => ['UserController', 'signUpSuccess'],

        ],
        'POST' => [
            'user/login'    => ['AuthController', 'login'],    //sign in action logic
            'user/register' => ['AuthController', 'register'], //register action logic
            'articles/(\w+)/add'  => ['ArticleController', 'create'],
            'articles/(\d+)/edit' => ['ArticleController', 'update'],
        ]
    ]
];?>
<?php return [

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

];?>

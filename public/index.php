<?php use Bicycle\Services\App;

require __DIR__.'/../vendor/autoload.php';

const CONFIG = [
    'db' => [
        'host' => '127.0.01',
        'port' => '3306',
        'dbname' => 'mvc',
        'user' => 'homestead',
        'password' => 'secret',
    ],

    'routes' => [
        'GET' => [
            ''                    => ['MainController', 'index'],
            'articles/(\d+)'      => ['ArticleController', 'view'],
            'articles/(\d+)/edit' => ['ArticleController', 'update'],
            'articles/(\w+)/add'  => ['ArticleController', 'create'],
            'articles/(\d+)/delete' => ['ArticleController', 'delete'],
        ],
        'POST' => [

        ]
    ],

    'templates_path'  => __DIR__ . '/../templates/'
];

try {
    App::init(CONFIG);
} catch (Exception $e){
    App::response()->setResponseCode(500);
    App::view()->html('errors/500', ['error' => $e->getMessage()]);
}

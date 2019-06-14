<?php

use App\Services\App;

require __DIR__.'/../vendor/autoload.php';

App::init();

$controllerAndAction = App::get('Router')->getActionWithParams();

if (!$controllerAndAction) {
    App::get('View')->renderHtml('errors/404', [], 404);
    exit;
}

$controllerName = $controllerAndAction['controller'];
$actionName = $controllerAndAction['action'];
$params = $controllerAndAction['params'];

$controller = new $controllerName();
$controller->$actionName(...$params);


<?php

require __DIR__.'/../vendor/autoload.php';

$controllerAndAction = getActionWithParams(getRoute());

if (!$controllerAndAction) {
    echo 'Страница не найдена!';
    return;
}

$controllerName = $controllerAndAction['controller'];
$actionName = $controllerAndAction['action'];
$params = $controllerAndAction['params'];

$controller = new $controllerName();
$controller->$actionName(...$params);


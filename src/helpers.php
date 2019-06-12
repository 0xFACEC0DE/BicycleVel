<?php

function getRoute() : string
{
    return $_GET['route'] ?? '';
}

function wrapRegex() : array
{
    $routes = require __DIR__ . '/routes.php';
    $prepared = [];

    foreach ($routes as $route => $controllerAndAction) {
        $regex = '~^' . $route . '$~';
        $prepared[$regex]['controller'] = $controllerAndAction[0];
        $prepared[$regex]['action'] = $controllerAndAction[1];
    }

    return $prepared;
}


function getActionWithParams(string $route) : ?array
{
    $routes = wrapRegex();
    $isRouteFound = false;

    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }
    if(!$isRouteFound) return null;

    array_shift($matches);
    $controllerAndAction['params'] = $matches;

    return $controllerAndAction;
}
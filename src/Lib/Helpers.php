<?php

use \Bicycle\Lib\App;

function url(string $path = ''): string
{
    $url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $url .= $_SERVER['SERVER_NAME'];

    if (!empty($path) && $path[0] != '/') {
        $path = '/' . $path;
    }
    return $url . $path;
}

function db(): \Bicycle\Lib\Db
{
    return App::get('db');
}

function session(): \Bicycle\Lib\Session
{
    return App::get('session');
}

function view(): \Bicycle\Lib\View
{
    return App::get('view');
}

function router(): \Bicycle\Lib\Router
{
    return App::get('router');
}

function response(): \Bicycle\Lib\Response
{
    return App::get('response');
}

function config(): array
{
    return App::config();
}
<?php

namespace App\Services;

class App
{
    private static $container;
    private static $loaded;

    public static function init()
    {
        if (self::$loaded) return;
        self::$container = [];

        self::$container['session'] = new Session();
        self::$container['db'] = new Db();
        self::$container['view'] = new View();
        self::$container['router'] = new Router();

        self::$loaded = true;
    }

    public static function db()
    {
        /**
         * @var \App\Services\Db $db
         */
        $db = self::$container['db'];
        return $db;
    }

    public static function session()
    {
        /**
         * @var \App\Services\Session $session
         */
        $session = self::$container['session'];
        return $session;
    }

    public static function view()
    {
        /**
         * @var \App\Services\View $view
         */
        $view = self::$container['view'];
        return $view;
    }

    public static function router()
    {
        /**
         * @var \App\Services\Router $router
         */
        $router = self::$container['router'];
        return $router;
    }
}
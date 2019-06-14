<?php

namespace App\Services;

class App
{
    private static $container;

    public static function init()
    {
        self::$container = new \stdClass();
        self::$container->Db = new Db();
        self::$container->View = new View();
        self::$container->Router = new Router();
    }
    
    public static function get(string $name)
    {
        return self::$container->$name;
    }
}
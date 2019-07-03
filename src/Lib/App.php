<?php

namespace Bicycle\Lib;

const ONE_WEEK = 604800; //(seconds) 60*60*24*7

class App
{
    private static $config;
    private static $routes;
    private static $container = [];
    private static $postActions = [];

    private static function init()
    {
        self::$config = require(__DIR__ . '/../config.php');
        self::$routes = require(__DIR__ . '/../routes.php');

        self::$container['session'] = new Session(ONE_WEEK);
        self::$container['view'] = new View(__DIR__ . '/../../templates/');
        self::$container['router'] = new Router(self::$routes);
        self::$container['response'] = new Response();
        self::$container['db'] = new Db(self::$config['db']);
    }

    /**
     * Application execution core
     */
    public static function run()
    {
        self::init();

        if (!$data = router()->getAction()) {
            self::abortWithErrorPage();
        }
        $controller = new $data['controller'];
        $action = $data['action'];
        $result = $controller->$action(...$data['params']);

        response()->setOutput($result)->finishOutput();
        self::runPostActions();
    }

    public static function get(string $key)
    {
        return self::$container[$key];
    }

    public static function config()
    {
        return self::$config;
    }

    public static function abortWithErrorPage($message = '', $code = 404)
    {
        $out = view()->layoutHtml('errors/' . $code, compact('message'));
        response()->setResponseCode($code)->setOutput($out)->finishOutput();
        exit;
    }

    public static function addPostAction(callable $callback)
    {
        self::$postActions[] = $callback;
    }

    private static function runPostActions()
    {
        if (!empty(self::$postActions)) {
            foreach (self::$postActions as $postAction) {
                $postAction();
            }
        }
    }
}
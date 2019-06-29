<?php

namespace Bicycle\Lib;

class App
{
    /**
     * @var array Service objects storage
     */
    private static $container = [];

    private static $config;

    /**
     * Application execution core
     * @param $config
     */
    public static function run()
    {
        self::$config = require(__DIR__ . '/../../config.php');
        //set storage bindings
        self::$container['session'] = new Session();
        self::$container['view'] = new View();
        self::$container['router'] = new Router(self::$config['routes']);
        self::$container['response'] = new Response();
        self::$container['db'] = new Db(self::$config['db']);

        // getting action info from routes compared with current path
        if (!$data = self::router()->getAction()) {
            self::abortWithErrorPage();
        }

        $controller = new $data['controller'];
        $action = $data['action'];
        $controllerOutput = $controller->$action();

        self::response()->setOutput($controllerOutput)->sendHeaders()->output();
    }

    /**
     * @param string $message
     * @param int $code
     */
    public static function abortWithErrorPage($message = '', $code = 404)
    {
        $out = self::view()->layoutHtml('errors/' . $code, compact('message'));
        self::response()->setResponseCode($code)->setOutput($out)->output();
        exit;
    }

    /**
     * @return Db
     */
    public static function db()
    {
        /**
         * @var \Bicycle\Lib\Db $db
         */
        $db = self::$container['db'];
        return $db;
    }

    /**
     * @return Session
     */
    public static function session()
    {
        /**
         * @var \Bicycle\Lib\Session $session
         */
        $session = self::$container['session'];
        return $session;
    }

    /**
     * @return View
     */
    public static function view()
    {
        /**
         * @var \Bicycle\Lib\View $view
         */
        $view = self::$container['view'];
        return $view;
    }

    /**
     * @return Router
     */
    public static function router()
    {
        /**
         * @var \Bicycle\Lib\Router $router
         */
        $router = self::$container['router'];
        return $router;
    }

    /**
     * @return Response
     */
    public static function response()
    {
        /**
         * @var \Bicycle\Lib\Response $response
         */
        $response = self::$container['response'];
        return $response;
    }

    public static function config()
    {
        return self::$config;
    }
}
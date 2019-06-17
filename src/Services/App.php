<?php

namespace Bicycle\Services;

class App
{
    /**
     * @var array Service objects storage
     */
    private static $container = [];

    /**
     * Application execution core
     * @param $config
     */
    public static function run($config)
    {
        self::$container['session'] = new Session();
        self::$container['view'] = new View($config['templates_path']);
        self::$container['router'] = new Router($config['routes']);
        self::$container['response'] = new Response();
        self::$container['db'] = new Db($config['db']);

        if (!$data = self::router()->getActionWithParams()) self::abortWithErrorPage();
        $controllerOutput = (new $data['controller'])->{$data['action']}(...($data['params']));
        self::response()->setOutput($controllerOutput)->sendHeaders()->output();
    }

    /**
     * @param string $message
     * @param int $code
     */
    public static function abortWithErrorPage($message = '', $code = 404)
    {
        self::response()->setResponseCode($code);
        $out = self::view()->html('errors/' . $code, compact('message'));
        self::response()->setOutput($out);
        self::response()->output();
        exit;
    }

    /**
     * @return Db
     */
    public static function db()
    {
        /**
         * @var \Bicycle\Services\Db $db
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
         * @var \Bicycle\Services\Session $session
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
         * @var \Bicycle\Services\View $view
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
         * @var \Bicycle\Services\Router $router
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
         * @var \Bicycle\Services\Response $response
         */
        $response = self::$container['response'];
        return $response;
    }
}
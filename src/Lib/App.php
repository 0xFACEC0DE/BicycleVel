<?php

namespace Bicycle\Lib;

class App
{
    /**
     * @var array Service objects storage
     */
    private static $container = [];

    private static $config;

    private static $postActions = [];

    private static function init()
    {
        self::$config = require(__DIR__ . '/../../config.php');
        self::$container['session'] = new Session();
        self::$container['view'] = new View();
        self::$container['router'] = new Router(self::$config['routes']);
        self::$container['response'] = new Response();
        self::$container['db'] = new Db(self::$config['db']);
    }

    /**
     * Application execution core
     * @param $config
     */
    public static function run()
    {
        self::init();

        if (!$data = self::router()->getAction()) {
            self::abortWithErrorPage();
        }
        $controller = new $data['controller'];
        $action = $data['action'];
        $result = $controller->$action(...$data['params']);

        self::response()->setOutput($result)->finishOutput();
        self::runPostActions();
    }

    /**
     * @param string $message
     * @param int $code
     */
    public static function abortWithErrorPage($message = '', $code = 404)
    {
        $out = self::view()->layoutHtml('errors/' . $code, compact('message'));
        self::response()->setResponseCode($code)->setOutput($out)->finishOutput();
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
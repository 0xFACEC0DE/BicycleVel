<?php

namespace Bicycle\Services;

class App
{
    private static $container;
    private static $loaded;
    private static $controllerAndAction;

    public static function init($config)
    {
        if (self::$loaded) return;
        self::$container = [];

        self::$container['session'] = new Session();
        self::$container['view'] = new View($config['templates_path']);
        self::$container['router'] = new Router($config['routes']);
        self::$container['response'] = new Response();
        self::$container['db'] = new Db($config['db']);

        self::$controllerAndAction = self::router()->getActionWithParams();
        self::$loaded = true;
        self::run();
    }

    private static function run()
    {
        if (!self::$controllerAndAction) {
            self::response()->setResponseCode(404);
            $out = self::view()->html('errors/404');
            self::response()->setOutput($out);
            self::response()->output();
            exit;
        }

        $controllerName = self::$controllerAndAction['controller'];
        $actionName = self::$controllerAndAction['action'];
        $params = self::$controllerAndAction['params'];

        $controller = new $controllerName();
        $controllerOutput = $controller->$actionName(...$params);

        self::response()->setOutput($controllerOutput);
        self::response()->sendHeaders();
        self::response()->output();
        exit;
    }

    public static function db()
    {
        /**
         * @var \Bicycle\Services\Db $db
         */
        $db = self::$container['db'];
        return $db;
    }

    public static function session()
    {
        /**
         * @var \Bicycle\Services\Session $session
         */
        $session = self::$container['session'];
        return $session;
    }

    public static function view()
    {
        /**
         * @var \Bicycle\Services\View $view
         */
        $view = self::$container['view'];
        return $view;
    }

    public static function router()
    {
        /**
         * @var \Bicycle\Services\Router $router
         */
        $router = self::$container['router'];
        return $router;
    }

    public static function response()
    {
        /**
         * @var \Bicycle\Services\Response $response
         */
        $response = self::$container['response'];
        return $response;
    }
}
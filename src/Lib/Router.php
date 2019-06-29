<?php

namespace Bicycle\Lib;

/**
 * Class Router
 * @package App\Services
 */
class Router
{
    /**
     * Current path
     * @var string
     */
    private $route;

    /**
     * Routes to actions mapping
     * @var array
     */
    private $routes;

    /**
     * @var string
     */
    private $requestMethod;

    /**
     * Router constructor.
     */
    public function __construct($routes)
    {
        //route path
        $this->route = parse_url($_SERVER['REQUEST_URI'])['path'];
        //request http method
        $this->requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
        //app routes list matching the request http method
        $this->routes = isset($routes[$this->requestMethod]) ? $routes[$this->requestMethod] : [];
    }

    /**
     * Prepare strings from config for pattern substitution
     * @return array
     */
    private function wrapRegex()
    {
        $prepared = [];
        foreach ($this->routes as $route => $controllerAndAction) {

            $regex = '~^/' . $route . '/?$~';
            $prepared[$regex]['controller'] = 'Bicycle\Controllers\\' . $controllerAndAction[0];
            $prepared[$regex]['action'] = $controllerAndAction[1];
        }
        return $prepared;
    }

    /**
     * ['controller' => controller name, 'action' => controller method]
     * @return array|null
     */
    public function getAction()
    {
        $routes = $this->wrapRegex();

        foreach ($routes as $pattern => $controllerAndAction) {
            preg_match($pattern, $this->route, $matches);
            if (!empty($matches)) {
                //route matched path
                //$controllerAndAction contains array with appropriate action data at this iteration
                return $controllerAndAction;
            }
        }
        return null; //no route found for current path
    }
}
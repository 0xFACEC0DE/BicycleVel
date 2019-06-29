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
        $this->route = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
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
                array_shift($matches);
                $controllerAndAction['params'] = $matches;
                return $controllerAndAction;
            }
        }
        return null;
    }
}
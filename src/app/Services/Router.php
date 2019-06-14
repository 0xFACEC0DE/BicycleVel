<?php

namespace App\Services;

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
    public function __construct()
    {
        $this->routes = (require __DIR__ . '/../../config.php')['routes'];
        $this->route = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
        $this->routes = isset($this->routes[$this->requestMethod]) ? $this->routes[$this->requestMethod] : [];
        //$this->query = $_REQUEST ?? '';
    }

    /**
     * Prepare strings from config for pattern substitution
     * @return array
     */
    private function wrapRegex() : array
    {
        $prepared = [];
        foreach ($this->routes as $route => $controllerAndAction) {
            $regex = '~^/' . $route . '/?$~';
            $prepared[$regex]['controller'] = 'App\Controllers\\' . $controllerAndAction[0];
            $prepared[$regex]['action'] = $controllerAndAction[1];
        }
        return $prepared;
    }

    /**
     * ['controller' => controller name, 'action' => controller method, 'params' => variable path part]
     * @return array|null
     */
    public function getActionWithParams() : ?array
    {
        $routes = $this->wrapRegex();
        $isRouteFound = false;

        foreach ($routes as $pattern => $controllerAndAction) {
            preg_match($pattern, $this->route, $matches);
            if (!empty($matches)) {
                $isRouteFound = true;
                break;
            }
        }
        if(!$isRouteFound) return null;

        array_shift($matches);
        $controllerAndAction['params'] = $matches;

        return $controllerAndAction;
    }
}
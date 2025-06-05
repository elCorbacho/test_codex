<?php
namespace App\Core;

class Router
{
    private $routes = [];

    public function __construct()
    {
        // Define some basic RESTful routes
        $this->register('GET', '/tasks', 'App\\Controllers\\TaskController@index');
        $this->register('GET', '/tasks/(?P<id>\d+)', 'App\\Controllers\\TaskController@show');
        $this->register('POST', '/tasks', 'App\\Controllers\\TaskController@store');
        $this->register('PUT', '/tasks/(?P<id>\d+)', 'App\\Controllers\\TaskController@update');
        $this->register('DELETE', '/tasks/(?P<id>\d+)', 'App\\Controllers\\TaskController@destroy');
    }

    public function register($method, $pattern, $handler)
    {
        $this->routes[] = [$method, '#^' . $pattern . '$#', $handler];
    }

    public function dispatch($method, $uri)
    {
        $path = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            list($routeMethod, $pattern, $handler) = $route;
            if ($method === $routeMethod && preg_match($pattern, $path, $params)) {
                list($class, $action) = explode('@', $handler);
                $controller = new $class();
                return $controller->$action($params);
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }
}

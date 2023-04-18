<?php

namespace App\Utils;

/**
 * Class responsible for managing the application routing
 */

class Router
{

    private array $routes = [];

    /**
     * Method responsible for creating the route
     *
     * @param string $method
     * @param string $path
     * @param callable $handler
     * 
     * @return void
     */
    public function addRoute(string $method, string $path, callable $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }
     
    /**
     * Method responsible for dispatching the current route
     *
     * @param string $method
     * @param string $requestUri
     * 
     * @return mixed
     */
    public function dispatch(string $method, string $requestUri): mixed
    {
        $request = parse_url($requestUri);
        $path = $request['path'];
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            return $handler();
        } else {
            http_response_code(404);
            return "Endpoint not found";
        }
    }
}

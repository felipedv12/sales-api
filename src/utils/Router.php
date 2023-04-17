<?php

namespace App\Utils;

/**
 * Class responsible for managing the application routing
 */

class Router
{

    private array $handlers;
    private array $validRoutes = [];

    /**
     * Method responsible for creating the route
     *
     * @param string $method
     * @param string $path
     * @param callable $handler
     * 
     * @return void
     */
    public function request(string $method, string $path, callable $handler): void
    {

        array_push($this->validRoutes, $path);
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
    }


    /**
     * Method responsible for verifying the current route
     *
     * @return void
     */
    public function run(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $path = $requestUri['path'] !== '/' ? ltrim($requestUri['path'], '/') : '/';
        $method = $_SERVER['REQUEST_METHOD'];
        $callback = $this->handlers[$method . $path]['handler'];
        if (in_array($path, $this->validRoutes))
            call_user_func_array($callback, array_merge($_GET, $_POST));
        else 
            header('HTTP/1.0 404 Not Found'); 
    }
}

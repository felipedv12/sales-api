<?php

namespace App\Routes;

use App\Utils\Router;

class ProductRoute
{
    public function __construct()
    {
        $router = new Router();

        $router->addRoute('GET', '/', function () {
            return 'Home';
        });

        $router->addRoute('GET', '/products', function () {
            return 'List of products';
        });

        $router->addRoute('GET', '/products/(\d+)', function ($id) {
            return 'Searching product: ' . $id ;
        });

        $result = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        echo ($result);
    }
}

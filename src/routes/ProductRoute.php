<?php
namespace App\Routes;

use App\Utils\Router;

class ProductRoute
{
    public function __construct()
    {
        $router = new Router();

        $router->addRoute('GET', '/', function() {
            return 'Home';
        });

        $result = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        echo($result);
    }
}
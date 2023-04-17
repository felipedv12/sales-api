<?php

namespace App\Routes;

use App\Utils\Router;

class Web
{

    public function __construct()
    {
        $router = new Router();
        $router->request('GET', '/', function (){
            echo('Home');
        });
        
        $router->run();   
    }

}

<?php

use App\Controllers\ProductTypeController;
use App\Utils\Router;

$router = new Router();

$router->addRoute('GET', '/', function () {
    return 'Home';
});

$router->addRoute('GET', '/product-types', function () {
    $controller = new ProductTypeController();
    return $controller->list();
});

$router->addRoute('POST', '/product-types', function () {
    $controller = new ProductTypeController();
    $body = file_get_contents("php://input");
    return $controller->create($body);
});

$router->addRoute('PUT', '/product-types/(\d+)', function ($id) {
    $controller = new ProductTypeController();
    $body = file_get_contents("php://input");
    return $controller->update($body, $id);
});

$router->addRoute('GET', '/products', function () {
    return 'List of products';
});

$router->addRoute('GET', '/products/(\d+)', function ($id) {
    return 'Searching product: ' . $id;
});
$result = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

header('Content-Type: application/json');
echo (json_encode($result));
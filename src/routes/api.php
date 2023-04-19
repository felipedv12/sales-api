<?php

use App\Controllers\HomeController;
use App\Controllers\ProductTypeController;
use App\Utils\Router;

$router = new Router();

$router->addRoute('GET', '/', function () {
    $controller = new HomeController();
    return $controller->home();
});

/**
 * Product type routes
 */
$router->addRoute('GET', '/product-types', function () {
    $controller = new ProductTypeController();
    return $controller->list();
});

$router->addRoute('GET', '/product-types/(\d+)', function ($id) {
    $controller = new ProductTypeController();
    return $controller->find($id);
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

$router->addRoute('DELETE', '/product-types/(\d+)', function ($id) {
    $controller = new ProductTypeController();
    return $controller->delete($id);
});

/**
 * Product routes
 */

 $router->addRoute('GET', '/product', function () {
    $controller = new ProductTypeController();
    return $controller->list();
});

$router->addRoute('GET', '/product/(\d+)', function ($id) {
    $controller = new ProductTypeController();
    return $controller->find($id);
});

$router->addRoute('POST', '/product', function () {
    $controller = new ProductTypeController();
    $body = file_get_contents("php://input");
    return $controller->create($body);
});

$router->addRoute('PUT', '/product/(\d+)', function ($id) {
    $controller = new ProductTypeController();
    $body = file_get_contents("php://input");
    return $controller->update($body, $id);
});

$router->addRoute('DELETE', '/product/(\d+)', function ($id) {
    $controller = new ProductTypeController();
    return $controller->delete($id);
});


$result = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

echo (json_encode($result));
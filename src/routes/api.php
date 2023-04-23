<?php

use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\ProductTypeController;
use App\Controllers\SaleController;
use App\Utils\Router;

$router = new Router();
/**
 * Home route
 */
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
    return $controller->save($body);
});

$router->addRoute('PUT', '/product-types/(\d+)', function ($id) {
    $controller = new ProductTypeController();
    $body = file_get_contents("php://input");
    return $controller->save($body, $id);
});

$router->addRoute('DELETE', '/product-types/(\d+)', function ($id) {
    $controller = new ProductTypeController();
    return $controller->delete($id);
});

/**
 * Product routes
 */

 $router->addRoute('GET', '/products', function () {
    $controller = new ProductController();
    return $controller->list();
});

$router->addRoute('GET', '/products/(\d+)', function ($id) {
    $controller = new ProductController();
    return $controller->find($id);
});

$router->addRoute('POST', '/products', function () {
    $controller = new ProductController();
    $body = file_get_contents("php://input");
    return $controller->save($body);
});

$router->addRoute('PUT', '/products/(\d+)', function ($id) {
    $controller = new ProductController();
    $body = file_get_contents("php://input");
    return $controller->save($body, $id);
});

$router->addRoute('DELETE', '/products/(\d+)', function ($id) {
    $controller = new ProductController();
    return $controller->delete($id);
});


/**
 * Product routes
 */

 $router->addRoute('GET', '/sales', function () {
    $controller = new SaleController();
    return $controller->list();
});

$router->addRoute('GET', '/sales/(\d+)', function ($id) {
    $controller = new SaleController();
    return $controller->find($id);
});

$router->addRoute('POST', '/sales', function () {
    $controller = new SaleController();
    $body = file_get_contents("php://input");
    return $controller->saveSale($body);
});

$result = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
$json = json_encode($result);
$error = json_last_error_msg();
echo ($json);
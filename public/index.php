<?php
require_once '../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;

$router = new Router();

// Add to Routes array list
$router->add('POST', '/api/register', [AuthController::class, 'register']);
$router->add('POST', '/api/login', [AuthController::class, 'login']);
$router->add('POST', '/api/logout', [AuthController::class, 'logout']);
$router->add('GET', '/api/user', [UserController::class, 'getUser']);

// Add to Routes List
$router->add('GET', '/api/admin', function () {
    AuthMiddleware::requireAdmin();
    echo json_encode(["message" => "Welcome, admin!"]);
});

/**
 * EXECUTE A ROUTE !!!
 *
 * If we have Url http://localhost/api/user and GET method, then:
 * Just an example:
 * $_SERVER['REQUEST_METHOD']   == GET
 * $_SERVER['REQUEST_URI']      ==/api/user
 */
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
<?php
require_once '../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;

$router = new Router();

// Routes
$router->add('POST', '/api/register', [AuthController::class, 'register']);
$router->add('POST', '/api/login', [AuthController::class, 'login']);
$router->add('POST', '/api/logout', [AuthController::class, 'logout']);
$router->add('GET', '/api/user', [UserController::class, 'getUser']);

// Auth Routes
$router->add('GET', '/api/admin', function () {
    AuthMiddleware::requireAdmin();
    echo json_encode(["message" => "Welcome, admin!"]);
});

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
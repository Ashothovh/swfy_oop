<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable|array $handler): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(string $method, string $path): void {
        header('Content-Type: application/json');

        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $route['path'] === $path) {
                if (is_callable($route['handler'])) {
                    call_user_func($route['handler']);
                } elseif (is_array($route['handler'])) {
                    [$class, $method] = $route['handler'];
                    (new $class())->$method();
                }
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }
}

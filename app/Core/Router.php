<?php
namespace App\Core;

class Router {
    private array $routes = [];

    /**
     * Collecting an array
     *
     * @param string $method
     * @param string $path
     * @param callable|array $handler
     * @return void
     */
    public function add(string $method, string $path, callable|array $handler): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    /**
     * Execute a Route
     *
     * @param string $method
     * @param string $path
     * @return void
     */
    public function dispatch(string $method, string $path): void {
        // Ensures that all responses are returned as JSON.
        header('Content-Type: application/json');

        // Search for a Matching Route
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $route['path'] === $path) {
                if (is_callable($route['handler'])) {
                    // If the handler is a callable function, execute it directly.
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

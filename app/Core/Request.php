<?php
namespace App\Core;

class Request {
    public function getMethod(): string {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function getPath(): string {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        return strtok($path, '?'); // Removing the query strings
    }

    public function getInput(): array {
        return json_decode(file_get_contents('php://input'), true) ?? $_POST;
    }
}

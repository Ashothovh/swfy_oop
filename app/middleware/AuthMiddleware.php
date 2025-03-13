<?php
namespace App\Middleware;

class AuthMiddleware {
    public static function requireLogin() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(["error" => "Unauthorized"]);
            exit;
        }
    }

    public static function requireAdmin() {
        session_start();
        if ($_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "Forbidden"]);
            exit;
        }
    }
}

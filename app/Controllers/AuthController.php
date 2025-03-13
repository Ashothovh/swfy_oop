<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function register() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['name'], $data['email'], $data['password'])) {
            http_response_code(400);
            echo json_encode(["error" => "Missing fields"]);
            return;
        }

        if (User::findByEmail($data['email'])) {
            http_response_code(400);
            echo json_encode(["error" => "Email already exists"]);
            return;
        }

        if (User::create($data['name'], $data['email'], $data['password'], $data['role'] ?? 'user')) {
            echo json_encode(["message" => "User registered successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Registration failed"]);
        }
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['email'], $data['password'])) {
            http_response_code(400);
            echo json_encode(["error" => "Missing fields"]);
            return;
        }

        $user = User::findByEmail($data['email']);
        if (!$user || !$user->checkPassword($data['password'])) {
            http_response_code(401);
            echo json_encode(["error" => "Invalid credentials"]);
            return;
        }

        session_start();
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['role'] = $user->getRole();

        echo json_encode([
            "message" => "Login successful",
            "user" => [
                "id" => $user->getId(),
                "name" => $user->getName(),
                "email" => $user->getEmail(),
                "role" => $user->getRole(),
            ]
        ]);
    }

    public function logout() {
        session_start();
        session_destroy();
        echo json_encode(["message" => "Logged out successfully"]);
    }
}

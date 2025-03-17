<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function register() {
        //Reads JSON input from the request.
        // php://input is a PHP input stream that allows us to read raw data from the request body.
        // This is the raw request body sent to the server!!!
        $data = json_decode(file_get_contents("php://input"), true);

        // Validate Input Data
        // If any field is missing, it returns a 400 Bad Request error.
        if (!isset($data['name'], $data['email'], $data['password'])) {
            http_response_code(400);
            echo json_encode(["error" => "Missing fields"]);
            return;
        }

        // Check if Email Already Exists
        if (User::findByEmail($data['email'])) {
            http_response_code(400);
            echo json_encode(["error" => "Email already exists"]);
            return;
        }

        // Create the User
        // By default the user role is "user" // for admin we need to set additionally
        if (User::create($data['name'], $data['email'], $data['password'], $data['role'] ?? 'user')) {
            echo json_encode(["message" => "User registered successfully"]);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(["error" => "Registration failed"]);
        }
    }

    public function login() {
        //Reads JSON input from the request.
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['email'], $data['password'])) {
            http_response_code(400); // Bad request
            echo json_encode(["error" => "Missing fields"]);
            return;
        }

        $user = User::findByEmail($data['email']);
        if (!$user || !$user->checkPassword($data['password'])) {
            http_response_code(401);  // 401 Unauthorized
            echo json_encode(["error" => "Invalid credentials"]);
            return;
        }

        // Start a PHP Session
        session_start();
        // Stores user ID and role in $_SESSION for future authentication.
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['role'] = $user->getRole();

        // Returns a JSON response with user details
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
        session_start();         // resume the session.
        session_destroy();       // delete all session data.
        echo json_encode(["message" => "Logged out successfully"]);
    }
}

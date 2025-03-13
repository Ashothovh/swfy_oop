<?php
namespace App\Core;

use App\Core\Database;
use PDO;

class Auth {
    public static function login(string $email, string $password): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return true;
        }

        return false;
    }

    public static function logout(): void {
        session_destroy();
    }

    public static function check(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function user(): ?array {
        if (!self::check()) return null;
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
